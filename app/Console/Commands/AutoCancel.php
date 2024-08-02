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

class AutoCancel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
      
         $currentDateTime = Carbon::now(); 
        $currentTimestamp = $currentDateTime->timestamp; 
        $bidsWithItemsReceived = BidDetails::where('bid_status','processing')->where('disputed_bid','no')->get();
        foreach($bidsWithItemsReceived as $bidsWithItemReceived)
        {
            $bid_item_received_time = Carbon::parse($bidsWithItemReceived->update_date_time);
            $currentSwizTime = Carbon::now();

            $timeDifferenceHours = $bid_item_received_time->diffInHours($currentSwizTime);
            if($timeDifferenceHours > 48)
            {
 
                $notifications = BidNotifications::where('bid_id',$bidsWithItemReceived->id)->first();
                if(isset($notifications) && $notifications->auto_cancel_after_48_hours == 0)
                {
               
                    $bidUpdated = BidDetails::where('id', $bidsWithItemReceived->id)->update(['bid_status'=>'cancelled']); 

                        // The buyer will be notified about the cancellation.
                        $buyer_id =   $bidsWithItemReceived->buyer_id;
                        $buyerUser = $this->getUser($buyer_id);
                        $buyer_user_email = $buyerUser->email;
                
                        //send an email
                    
                                $to = $buyer_user_email;
                                $title = __('core__api_bid_cancelled_title', [], 'en');
                                $subject = __('core__api_bid_cancelled', [], 'en');
                                $to_name = $buyerUser->name;
                                $body = __('core__api_bid_cancelled_body',[],'en');
                                sendMail($to, $to_name, $title, $subject, $body);

                        // for send noti data
                        $data['bid_id'] = $bidsWithItemReceived->id;
                        $data['user_id'] = $bidsWithItemReceived->buyer_id;
                        $data['message'] = __('core__api_bid_cancelled_body',[],'en');
                        $data['flag'] = __('core__api_bid_cancelled', [], 'en');

                        // save noti to bid_notis
                        $noti = new BidNoti();
                        $noti->bid_id = $bidsWithItemReceived->id;
                        $noti->type = 'BID_AUTO_CANCEL';
                        $noti->bid_noti_message = 'core__api_bid_cancelled_body';
                        $noti->is_read = 0;
                        $noti->added_date = Carbon::now();
                        $noti->save();

                        $this->sendBidNoti($data);

                             BidNotifications::where('bid_id',$bidsWithItemReceived->id)->update(['auto_cancel_after_48_hours'=>1]);
                            /***************************** */
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
