<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use Modules\Core\Constants\Constants;
use Modules\Payment\Http\Services\PaymentSettingService;
use Modules\Core\Http\Services\AvailableCurrencyService;
use App\Models\UserWallet; 
use App\Models\User;
use App\Models\WalletLog; 
use App\Models\BidDetails;
use App\Models\BidNoti;
use App\Models\BidNotifications;
use App\Models\WalletWithdrawalRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Arr;
use Modules\Core\Entities\AvailableCurrency;  
use Modules\Core\Entities\Item;
use Session;
use Modules\Core\Http\Services\ImageService;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use Mollie\Laravel\Facades\Mollie;
use Carbon\Carbon;
use Modules\Core\Entities\PushNotificationToken;

class AutoExpireLiveAuction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'liveauction:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Live auction expiration after 30 minutes';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

     

          $activeItems = Item::where('is_expired', 0)->whereNull('auction_period')->get();
          $currentDateTime = Carbon::now();
          $currentunix_timestamp = $currentDateTime->timestamp * 1000;
            if(count($activeItems)>0)
            {
                foreach($activeItems as $activeItem)
                {
                   
                    $item_add_date = $activeItem->product_creation_date;
                    if (strlen($item_add_date) == 13) {
                            // Convert milliseconds to seconds
                            $item_add_date_seconds = $item_add_date / 1000;
                        } else {
                            // Assume the timestamp is already in seconds
                            $item_add_date_seconds = $item_add_date;
                        }
                    $creation_date_time = Carbon::createFromTimestamp($item_add_date_seconds)->setTimezone(config('app.timezone'));

                    if (Carbon::now()->diffInMinutes($creation_date_time) >= 31) 
                    {
                        $activeItem->id;
                        /*********************save item as expired **********************/
                            $activeItem->is_expired = 1;
                            $activeItem->auction_status=1;
                            if($activeItem->save());
                            {
                                /**************check bids on product ***************/
                                $product_bids = BidDetails::where('product_id',$activeItem->id)->where('bid_status','pending')->get();
                                if(count($product_bids)>0) 
                                {
                                            $highest_bid = BidDetails::where('product_id',$activeItem->id)->orderBy('bid_price', 'desc')->first();
                                            $buyerWallet = UserWallet::where('user_id',$highest_bid->buyer_id)->first();

                                    
                                    $amount = $highest_bid->bid_price;

                                    $commission = $highest_bid->commission/100;
                                    $commission_amount = $commission * $amount;
                                    $amount_deducted = $amount + $commission_amount;

                                    $current_balance = $buyerWallet->wallet_balance;
                                    if($current_balance < $amount)
                                    {
                                        /******************bid_payment_status will stay as default pending value*************/
                                        BidDetails::where('id',$highest_bid->id)->update(['bid_status'=>'processing']);
                                        ///send notification to buyer to notify seller accepted and recharge the wallet otherwise bid will be pending for 48 hours only 
                                        $buyer_id =   $highest_bid->buyer_id;
                                            $buyerUser = $this->getUser($buyer_id);
                                            $buyer_user_email = $buyerUser->email;

                                                            $to = $buyer_user_email;
                                                            $title = __('core__api_bid_processing_nofunds_title', [], 'en');
                                                            $subject = __('core__api_bid_processing_nofunds', [], 'en');
                                                            $to_name = $buyerUser->name;
                                                            $body = __('core__api_bid_processing_nofunds_body',[],'en');
                                                            sendMail($to, $to_name, $title, $subject, $body);

                                                            // for send noti data
                                                                        $s_data['bid_id'] = $highest_bid->id;
                                                                        $s_data['user_id'] = $highest_bid->buyer_id;
                                                                        $s_data['message'] = __('core__api_bid_processing_nofunds_body',[],'en');
                                                                        $s_data['flag'] = __('core__api_bid_processing_nofunds', [], 'en');

                                                            // save noti to bid_notis
                                                                        $noti = new BidNoti();
                                                                        $noti->bid_id = $highest_bid->id;
                                                                        $noti->type = 'BID_PROCESSING';
                                                                        $noti->bid_noti_message = 'core__api_bid_processing_nofunds_body';
                                                                        $noti->is_read = 0;
                                                                        $noti->added_date = Carbon::now();
                                                                        $noti->save();
                                                                        $this->sendBidNoti($s_data);

                                    }
                                    else
                                    {
                                        /**************sufficient amount in wallet *********/
                                        /***************deduct buyer wallet on bid accepted*****************************/
                                        $remaining_amount = $current_balance - $amount_deducted;
                                        $data = [];
                                        $data['currency'] = 'Fr.';
                                        $data['wallet_balance'] = $remaining_amount;
                                        $data['recharge_date'] = $currentunix_timestamp;
                                        $updated = UserWallet::where('user_id', $highest_bid->buyer_id)->update($data);
                                                $walletLog =WalletLog::create([
                                                                    "users_wallet_id"=>$buyerWallet->id,
                                                                    "amount_added"=>0.00,
                                                                    "amount_deducted"=>$amount_deducted,
                                                                    "currency"=>'Fr.',
                                                                    "old_balance"=>$current_balance,
                                                                    "add_date"=>$currentunix_timestamp,
                                                                    "payment_type"=>"wallet_deduction",
                                                                    "log_type"=>"debit"
                                                            ]);
                                        /**************************************************************************** */

                                        if($updated)
                                        {
                                            /********************notify buyer that their bid has been accepted by the seller ******/
                                            $buyer_id =   $highest_bid->buyer_id;
                                            $buyerUser = $this->getUser($buyer_id);
                                            $buyer_user_email = $buyerUser->email;

                                                    $to = $buyer_user_email;
                                                    $title = __('core__api_bid_accepted_title', [], 'en');
                                                    $subject = __('core__api_bid_accepted', [], 'en');
                                                    $to_name = $buyerUser->name;
                                                    $body = __('core__api_bid_accepted_body',[],'en');
                                                    sendMail($to, $to_name, $title, $subject, $body);

                                                            // for send noti data
                                                                        $s_data['bid_id'] = $highest_bid->id;
                                                                        $s_data['user_id'] = $highest_bid->buyer_id;
                                                                        $s_data['message'] = __('core__api_bid_accepted_body',[],'en');
                                                                        $s_data['flag'] = __('core__api_bid_accepted', [], 'en');

                                                            // save noti to bid_notis
                                                                        $noti = new BidNoti();
                                                                        $noti->bid_id = $highest_bid->id;
                                                                        $noti->type = 'BID_ACCEPTED';
                                                                        $noti->bid_noti_message = 'core__api_bid_accepted_body';
                                                                        $noti->is_read = 0;
                                                                        $noti->added_date = Carbon::now();
                                                                        $noti->save();
                                                                        $this->sendBidNoti($s_data);

                                            /***************seller wallet onhold amount added *****************/
                                            $payable_amount = $highest_bid->amount_paid;
                                            $sellerWallet = UserWallet::where('user_id', $highest_bid->seller_id)->first();

                                                $s_data = [];
                                                $s_data['user_id'] = $sellerWallet->user_id;
                                                $s_data['currency'] = 'Fr.';
                                                $s_data['wallet_balance'] = $sellerWallet->wallet_balance;
                                                $s_data['amount_on_hold'] = $sellerWallet->amount_on_hold+$payable_amount;
                                                $s_data['recharge_date'] = $currentunix_timestamp;
                                                                // $s_data['payment_type'] = "on_hold_amount_added"
                                                $updatedSeller = UserWallet::where('id', $sellerWallet->id)->update($s_data);
                                            //seller wallet_log
                                                if($updatedSeller)
                                                {
                                                    $bidUpdated = BidDetails::where('id', $highest_bid->id)->update(['bid_status'=>'accepted','bid_payment_status'=>'paid']); 
                                                    $sameProductOtherBids = BidDetails::where('seller_id',$highest_bid->seller_id)->where('product_id',$highest_bid->product_id)->whereNotIn('id', [$highest_bid->id])->get();
                                                    foreach($sameProductOtherBids as $bid)
                                                    {

                                                        BidDetails::where('id', $bid->id)->update(['bid_status'=>'declined','dispute_status_notes'=>"Seller accepted another buyer's bid"]);

                                                            $buyer_id =   $bid->buyer_id;
                                                            $buyerUser = $this->getUser($buyer_id);
                                                            $buyer_user_email = $buyerUser->email;

                                                            $to = $buyer_user_email;
                                                            $title = __('core__api_bid_rejected_auto_title', [], 'en');
                                                            $subject = __('core__api_bid_rejected_auto', [], 'en');
                                                            $to_name = $buyerUser->name;
                                                            $body = __('core__api_bid_rejected_auto_body',[],'en');
                                                            sendMail($to, $to_name, $title, $subject, $body);

                                                            // for send noti data
                                                                        $data['bid_id'] = $bid->id;
                                                                        $data['user_id'] = $bid->buyer_id;
                                                                        $data['message'] = __('core__api_bid_rejected_auto_body',[],'en');
                                                                        $data['flag'] = __('core__api_bid_rejected_auto', [], 'en');

                                                            // save noti to bid_notis
                                                                        $noti = new BidNoti();
                                                                        $noti->bid_id = $bid->id;
                                                                        $noti->type = 'BID_AUTO_REJECTED';
                                                                        $noti->bid_noti_message = 'core__api_bid_rejected_auto_body';
                                                                        $noti->is_read = 0;
                                                                        $noti->added_date = Carbon::now();
                                                                        $noti->save();
                                                                        $this->sendBidNoti($data);
                                                        
                                                    }
                                                    

                                                    $updatedSellerWallet = UserWallet::where('id', $sellerWallet->id)->first();
                                                                        // print_r($updatedSellerWallet);die;
                                                    $updatedSellerwalletLog =WalletLog::create([
                                                                                "users_wallet_id"=>$updatedSellerWallet->id,
                                                                                "on_hold_amount"=>$payable_amount,
                                                                                "currency"=>'Fr.',
                                                                                "old_balance"=>$updatedSellerWallet->wallet_balance,
                                                                                "add_date"=>$currentunix_timestamp,
                                                                                "payment_type"=>"on_hold_amount_added",
                                                                                "log_type"=>"onhold_credit"
                                                                                ]);
                                                    
                                            
                                                }
                                                        
                                        } 
                                    }
                                }
                            }
                        /***************************************************************/
                    }
                }

                return Command::SUCCESS;
            }


        return Command::SUCCESS;
    }


    

     private function getUser($id = null, $conds = null, $relation = null)
    {

        $user = User::when($id, function ($q, $id) {
            $q->where('id', $id);
        })
            ->when($conds, function ($q, $conds) {
                $q->where($conds);
            })
            ->when($relation, function ($q, $relation) {
                $q->with($relation);
            })
            ->first();
        return $user;
    }

     private function sendBidNoti($chat_data)
    {
        // start noti send to sender user
        $token_conds['user_id'] = $chat_data['user_id'];
        $notiTokens = $this->getNotiTokens(null, $token_conds);
        $device_ids = [];
        $platform_names = [];
        foreach ($notiTokens as $token) {
            $device_ids[] = $token->device_token;
            $platform_names[] = $token->platform_name;
        }

        // get reveiver data
        $receiver = $this->getUser($chat_data['user_id']);

        $data['message'] = $chat_data['message'];
        $data['user_name'] = $receiver->name;
        $data['bid_id'] = $chat_data['bid_id'];
        $data['user_profile_photo'] = $receiver->user_cover_photo; 
        $data['flag'] = 'bid';
        $data['chat_flag'] = $chat_data['flag'];
        send_android_fcm_bid($device_ids, $data, $platform_names);
        // end noti send to sender user

    }

    private function getNotiTokens($relation = null, $conds = null, $limit = null, $offset = null)
    {
        $notiTokens = PushNotificationToken::when($relation, function ($q, $relation) {
            $q->with($relation);
        })
            ->when($conds, function ($q, $conds) {
                $q->where($conds);
            })
            ->when($limit, function ($query, $limit) {
                $query->limit($limit);
            })
            ->when($offset, function ($query, $offset) {
                $query->offset($offset);
            })->get();
        return $notiTokens;
    }
}
