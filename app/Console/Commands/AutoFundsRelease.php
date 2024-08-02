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
use Session;
use Modules\Core\Http\Services\ImageService;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use Mollie\Laravel\Facades\Mollie;
use Carbon\Carbon;
use Modules\Core\Entities\PushNotificationToken;

class AutoFundsRelease extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "This command will automatically release the funds to seller if the buyer doesn't confirm the item satisfaction status within 48 hours of item received";

    /**
     * Execute the console command.
     *
     * @return int 
     */
    public function handle()
    {

        $bidsWithItemsReceived = BidDetails::where('bid_status','item_received')->where('disputed_bid','no')->get();
        foreach($bidsWithItemsReceived as $bidsWithItemReceived)
        {
            $bid_item_received_time = Carbon::parse($bidsWithItemReceived->update_date_time);
            $currentSwizTime = Carbon::now();

            $timeDifferenceHours = $bid_item_received_time->diffInHours($currentSwizTime);

            if($timeDifferenceHours > 48)
            {
                $notifications = BidNotifications::where('bid_id',$bidsWithItemReceived->id)->first();
                if(isset($notifications) && $notifications->auto_release_48_hours_item_received == 0)
                {
                    $carbonDateTime = Carbon::now();
                    $unixTimestamp = $carbonDateTime->timestamp;
                    /******release the onhold amount to the seller and mark the bid as completed ******************/
                    $sellerWallet = UserWallet::where('user_id',$bidsWithItemReceived->seller_id)->first();
                    if($sellerWallet)
                    {
                            
                        $old_balance  = $sellerWallet->wallet_balance;
                        $wallet_new_balance = $old_balance + $bidsWithItemReceived->amount_paid;
                        $on_hold_new_amount = $sellerWallet->amount_on_hold - $bidsWithItemReceived->amount_paid;

                      

                        $data = [];
                        $data['user_id'] = $sellerWallet->user_id;
                        $data['currency'] = 'Fr.';
                        $data['wallet_balance'] = $wallet_new_balance;
                        $data['amount_on_hold'] = $on_hold_new_amount;
                        $data['recharge_date'] = $unixTimestamp;
                       $updated = UserWallet::where('id', $sellerWallet->id)->update($data);
                        //wallet_log
                    }
                    else
                    {
                        $data = [];
                        $data['user_id'] = $bidsWithItemReceived->seller_id;
                        $data['currency'] = 'Fr.';
                        $data['wallet_balance'] = $bidsWithItemReceived->amount_paid;
                        $data['recharge_date'] = $unixTimestamp;
                        $updated = UserWallet::create($data);
                    }

                    if($updated)
                    {
                         $bidUpdated = BidDetails::where('id', $bidsWithItemReceived->id)->update(['bid_status'=>'completed','update_date_time'=>now()]);
                    

                                        $walletLog =WalletLog::create([
                                                "users_wallet_id"=>$sellerWallet->id,
                                                "currency"=>'Fr.',
                                                "old_balance"=>$old_balance,
                                                "amount_added"=>$bidsWithItemReceived->amount_paid,
                                                "add_date"=>$unixTimestamp,
                                                "payment_type"=>"on_hold_amount_released",
                                                "log_type"=>"credit"
                                        ]);

                        //notify the buyer and seller both
                        $buyer_id =   $bidsWithItemReceived->buyer_id;
                        $buyerUser = $this->getUser($buyer_id);
                        $buyer_user_email = $buyerUser->email;
                
                        //send an email
             
                        $to = $buyer_user_email;
                        $title = __('core__api_bid_auto_complete_title', [], 'en');
                        $subject = __('core__api_bid_auto_complete', [], 'en');
                        $to_name = $buyerUser->name;
                        $body = __('core__api_bid_auto_complete_body',[],'en');
                        sendMail($to, $to_name, $title, $subject, $body);

                        // for send noti data
                        $data['bid_id'] = $bidsWithItemReceived->id;
                         $data['user_id'] = $bidsWithItemReceived->buyer_id;
                        $data['message'] = __('core__api_bid_auto_complete_body',[],'en');
                        $data['flag'] = __('core__api_bid_auto_complete', [], 'en');

                    
                        $noti = new BidNoti();
                        $noti->bid_id = $bidsWithItemReceived->id;
                        $noti->type = 'BID_AUTO_COMPLETE';
                        $noti->bid_noti_message = 'core__api_bid_auto_complete_body';
                        $noti->is_read = 0;
                        $noti->added_date = Carbon::now();
                        $noti->save();
                        $this->sendBidNoti($data);

                        //send an email to seller
                        $seller_id =   $bidsWithItemReceived->seller_id;
                        $sellerUser = $this->getUser($seller_id);
                        $seller_user_email = $sellerUser->email;

                        $to = $seller_user_email;
                        $title = __('core__api_bid_auto_complete_title', [], 'en');
                        $subject = __('core__api_bid_auto_release', [], 'en');
                        $to_name = $sellerUser->name;
                        $body = __('core__api_bid_auto_release_body',[],'en');
                        sendMail($to, $to_name, $title, $subject, $body);

                         // for send noti data
                        $s_data['bid_id'] = $bidsWithItemReceived->id;
                         $s_data['user_id'] = $bidsWithItemReceived->seller_id;
                        $s_data['message'] = __('core__api_bid_auto_release_body',[],'en');
                        $s_data['flag'] = __('core__api_bid_auto_release', [], 'en');

                        // save noti to bid_notis
                        $noti = new BidNoti();
                        $noti->bid_id = $bidsWithItemReceived->id;
                        $noti->type = 'BID_AUTO_COMPLETE';
                        $noti->bid_noti_message = 'core__api_bid_auto_release_body';
                        $noti->is_read = 0;
                        $noti->added_date = Carbon::now();
                        $noti->save();
                         $this->sendBidNoti($s_data);

                        BidNotifications::where('bid_id',$bidsWithItemReceived->id)->update(['auto_release_48_hours_item_received'=>1]);

                    }
                    
                }    
            }
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