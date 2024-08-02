<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

class CronJobController extends Controller
{
    // public function automatic_release_funds_after_48_hours()
    // {
    //     $bidsWithItemsReceived = BidDetails::where('bid_status','item_received')->where('disputed_bid','no')->get();
    //     foreach($bidsWithItemsReceived as $bidsWithItemReceived)
    //     {
    //         $bid_item_received_time = Carbon::parse($bidsWithItemReceived->update_date_time);
    //         $currentSwizTime = Carbon::now();

    //         $timeDifferenceHours = $bid_item_received_time->diffInHours($currentSwizTime);

    //         if($timeDifferenceHours > 48)
    //         {
    //             $notifications = BidNotifications::where('bid_id',$bidsWithItemReceived->id)->first();
    //             if($notifications->auto_release_48_hours_item_received == 0)
    //             {

    //                 /******release the onhold amount to the seller and mark the bid as completed ******************/
    //                 $sellerWallet = UserWallet::where('user_id',$bidsWithItemReceived->seller_user_id)->first();

    //                 $old_balance  = $sellerWallet->wallet_balance;
    //                 $wallet_new_balance = $old_balance + $bidsWithItemReceived->amount_paid;
    //                 $on_hold_new_amount = $sellerWallet->amount_on_hold - $bidsWithItemReceived->amount_paid;

    //                 $carbonDateTime = Carbon::now();
    //                 $unixTimestamp = $carbonDateTime->timestamp;

    //                 $data = [];
    //                 $data['user_id'] = $sellerWallet->user_id;
    //                 $data['currency'] = 'Fr.';
    //                 $data['wallet_balance'] = $wallet_new_balance;
    //                 $data['amount_on_hold'] = $on_hold_new_amount;
    //                 $data['recharge_date'] = $unixTimestamp;
    //                 $updated = UserWallet::where('id', $user->id)->update($data);
    //                 //wallet_log
    //                 if($updated)
    //                 {
    //                      $bidUpdated = BidDetails::where('id', $bidsWithItemReceived->id)->update(['bid_status'=>'completed','update_date_time'=>now()]);
                    

    //                                     $walletLog =WalletLog::create([
    //                                             "users_wallet_id"=>$sellerWallet->id,
    //                                             "currency"=>'Fr.',
    //                                             "old_balance"=>$old_balance,
    //                                             "amount_added"=>$bidsWithItemReceived->amount_paid,
    //                                             "add_date"=>$unixTimestamp,
    //                                             "payment_type"=>"on_hold_amount_released",
    //                                             "log_type"=>"credit"
    //                                     ]);

    //                     //notify the buyer and seller both
    //                     $buyer_id =   $bidsWithItemReceived->buyer_id;
    //                     $buyerUser = $this->getUser($buyer_id);
    //                     $buyer_user_email = $buyerUser->email;
                
    //                     //send an email
             
    //                     $to = $buyer_user_email;
    //                     $title = __('core__api_bid_auto_complete_title', [], 'en');
    //                     $subject = __('core__api_bid_auto_complete', [], 'en');
    //                     $to_name = $buyerUser->name;
    //                     $body = __('core__api_bid_auto_complete_body',[],'en');
    //                     sendMail($to, $to_name, $title, $subject, $body);

    //                     // for send noti data
    //                     $data['bid_id'] = $bidsWithItemReceived->id;
    //                      $data['user_id'] = $bidsWithItemReceived->buyer_id;
    //                     $data['message'] = __('core__api_bid_auto_complete_body',[],'en');
    //                     $data['flag'] = __('core__api_bid_auto_complete', [], 'en');

                    
    //                     $noti = new BidNoti();
    //                     $noti->bid_id = $bidsWithItemReceived->id;
    //                     $noti->type = 'BID_AUTO_COMPLETE';
    //                     $noti->bid_noti_message = 'core__api_bid_auto_complete_body';
    //                     $noti->is_read = 0;
    //                     $noti->added_date = Carbon::now();
    //                     $noti->save();
    //                     $this->sendBidNoti($data);

    //                     //send an email to seller
    //                     $seller_id =   $bidsWithItemReceived->seller_id;
    //                     $sellerUser = $this->getUser($seller_id);
    //                     $seller_user_email = $sellerUser->email;

    //                     $to = $seller_user_email;
    //                     $title = __('core__api_bid_auto_complete_title', [], 'en');
    //                     $subject = __('core__api_bid_auto_release', [], 'en');
    //                     $to_name = $sellerUser->name;
    //                     $body = __('core__api_bid_auto_release_body',[],'en');
    //                     sendMail($to, $to_name, $title, $subject, $body);

    //                      // for send noti data
    //                     $s_data['bid_id'] = $bidsWithItemReceived->id;
    //                      $s_data['user_id'] = $bidsWithItemReceived->seller_id;
    //                     $s_data['message'] = __('core__api_bid_auto_release_body',[],'en');
    //                     $s_data['flag'] = __('core__api_bid_auto_release', [], 'en');

    //                     // save noti to bid_notis
    //                     $noti = new BidNoti();
    //                     $noti->bid_id = $bidsWithItemReceived->id;
    //                     $noti->type = 'BID_AUTO_COMPLETE';
    //                     $noti->bid_noti_message = 'core__api_bid_auto_release_body';
    //                     $noti->is_read = 0;
    //                     $noti->added_date = Carbon::now();
    //                     $noti->save();
    //                      $this->sendBidNoti($s_data);

    //                     BidNotifications::where('bid_id',$bidsWithItemReceived->id)->update(['auto_release_48_hours_item_received'=>1]);

    //                 }
                    
    //             }    
    //         }
    //     }
    // }
    

    // public function reminder_after_7days_item_shipped()
    // {
    //     $bidsWithItemsReceived = BidDetails::where(function ($query) {
    //                                             $query->where('bid_status', 'item_shipped')
    //                                                 ->orWhere('bid_status', 'item_delivered');
    //                                             })
    //                                             ->where('disputed_bid', 'no')
    //                                             ->get();
    //     foreach($bidsWithItemsReceived as $bidsWithItemReceived)
    //     {
    //         $bid_item_received_time = Carbon::parse($bidsWithItemReceived->update_date_time);
    //         $currentSwizTime = Carbon::now();

    //         $timeDifferenceDays = $bid_item_received_time->diffInDays($currentSwizTime);
    //         if($timeDifferenceDays > 7)
    //         {
    //             $notifications = BidNotifications::where('bid_id',$bidsWithItemReceived->id)->first();
    //             if($notifications->reminder_after_7_days_item_shipped == 0)
    //             {
                
    //                     ///send reminder to buyer to confirm the item receiving information
    //                     $buyer_id =   $bidsWithItemReceived->buyer_id;
    //                     $buyerUser = $this->getUser($buyer_id);
    //                     $buyer_user_email = $buyerUser->email;

    //                     $to = $buyer_user_email;
    //                     $to_name = $buyerUser->name;
                
    //                     //send an email
    //                     // for send noti data
    //                     $data['bid_id'] = $bidsWithItemReceived->id;
    //                      $data['user_id'] = $bidsWithItemReceived->buyer_id;

    //                     if($bidsWithItemReceived->bid_status == 'item_shipped')
    //                     {
    //                             $title = __('core__api_bid_7_days_title_s', [], 'en');
    //                             $subject = __('core__api_bid_7_days_s', [], 'en');
    //                             $body = __('core__api_bid_7_days_body_s',[],'en');

    //                             $data['message'] = __('core__api_bid_7_days_body_s',[],'en');
    //                             $data['flag'] = __('core__api_bid_7_days_s', [], 'en');
    //                     }
    //                     if($bidsWithItemReceived->bid_status == 'item_delivered')
    //                     {
    //                             $title = __('core__api_bid_7_days_title_d', [], 'en');
    //                             $subject = __('core__api_bid_7_days_d', [], 'en');
    //                             $body = __('core__api_bid_7_days_body_d',[],'en');

    //                              $data['message'] = __('core__api_bid_7_days_body_d',[],'en');
    //                             $data['flag'] = __('core__api_bid_7_days_d', [], 'en');
    //                     }
                        
    //                     sendMail($to, $to_name, $title, $subject, $body);

    //                     // save noti to bid_notis
    //                     $noti = new BidNoti();
    //                     $noti->bid_id = $bidsWithItemReceived->id;
    //                     $noti->type = 'BID_7DAYS_REMINDER';
    //                     $noti->bid_noti_message = 'core__api_bid_7_days_body_s';
    //                     $noti->is_read = 0;
    //                     $noti->added_date = Carbon::now();
    //                     $noti->save();
    //                      $this->sendBidNoti($data);

    //                     BidNotifications::where('bid_id',$bidsWithItemReceived->id)->update(['reminder_after_7_days_item_shipped'=>1]);

    //             }
                        
                      
    //         }
    //     }
    // }

    
    // public function reminder_after_10days_item_shipped()
    // {
    //         $currentDateTime = Carbon::now(); 
    //         $currentTimestamp = $currentDateTime->timestamp; 
    //     $bidsWithItemsReceived = BidDetails::where('bid_status','item_shipped')->where('disputed_bid','no')->get();
    //     foreach($bidsWithItemsReceived as $bidsWithItemReceived)
    //     {
    //         $bid_item_received_time = Carbon::parse($bidsWithItemReceived->update_date_time);
    //         $currentSwizTime = Carbon::now();

    //         $timeDifferenceDays = $bid_item_received_time->diffInDays($currentSwizTime);
    //         if($timeDifferenceDays > 10)
    //         {
    //             $notifications = BidNotifications::where('bid_id',$bidsWithItemReceived->id)->first();
    //             if($notifications->autocomplete_bid_after_10_days == 0)
    //             {

    //                 //the, held amount is automatically released to the seller, assuming the product was delivered correctly.       

    //                 $bid_details = BidDetails::where('id', $bidsWithItemReceived->id)->first();

    //                     $userWallet = UserWallet::where('user_id',$bidsWithItemReceived->seller_id)->first();
    //                     $old_balance  = $userWallet->wallet_balance;
    //                     $wallet_new_balance = $old_balance + $bidsWithItemReceived->amount_paid;
    //                     $on_hold_new_amount = $userWallet->amount_on_hold - $bidsWithItemReceived->amount_paid;
    //                         $data = [];
    //                         $data['user_id'] = $bidsWithItemReceived->seller_id;
    //                         $data['currency'] = 'Fr.';
    //                         $data['wallet_balance'] = $wallet_new_balance;
    //                         $data['amount_on_hold'] = $on_hold_new_amount;
    //                         $data['recharge_date'] = $currentTimestamp;
    //                         $updated = UserWallet::where('id', $userWallet->id)->update($data);
    //                         //wallet_log
    //                         if($updated)
    //                             {   
    //                                 $bidUpdated = BidDetails::where('id', $bidsWithItemReceived->id)->update(['bid_status'=>'completed','update_date_time'=>now()]); 

    //                                 //update buyer about the same
    //                                 $buyer_id =   $bidsWithItemReceived->buyer_id;
    //                                 $buyerUser = $this->getUser($buyer_id);
    //                                 $buyer_user_email = $buyerUser->email;
                            
    //                                 //send an email
                    
    //                                 $to = $buyer_user_email;
    //                                 $title = __('core__api_bid_auto_complete_title', [], 'en');
    //                                 $subject = __('core__api_bid_auto_complete', [], 'en');
    //                                 $to_name = $buyerUser->name;
    //                                 $body = __('core__api_bid_10_days_body',[],'en');
    //                                 sendMail($to, $to_name, $title, $subject, $body);

    //                                 // for send noti data
    //                                 $s_data['bid_id'] = $bidsWithItemReceived->id;
    //                                 $s_data['user_id'] = $bidsWithItemReceived->buyer_id;
    //                                 $s_data['message'] = __('core__api_bid_10_days_body',[],'en');
    //                                 $s_data['flag'] = __('core__api_bid_auto_complete', [], 'en');

    //                                 // save noti to bid_notis
    //                                 $noti = new BidNoti();
    //                                 $noti->bid_id = $bidsWithItemReceived->id;
    //                                 $noti->type = 'BID_10DAYS_REMINDER';
    //                                 $noti->bid_noti_message = 'core__api_bid_10_days_body';
    //                                 $noti->is_read = 0;
    //                                 $noti->added_date = Carbon::now();
    //                                 $noti->save();
    //                                 $this->sendBidNoti($s_data);

    //                                 BidNotifications::where('bid_id',$bidsWithItemReceived->id)->update(['autocomplete_bid_after_10_days'=>1]);

    //                                 /***************************** */
    //                                 $walletLog =WalletLog::create([
    //                                                     "users_wallet_id"=>$userWallet->id,
    //                                                     "currency"=>'Fr.',
    //                                                     "old_balance"=>$old_balance,
    //                                                     "amount_added"=>$bid_details->amount_paid,
    //                                                     "add_date"=>$currentTimestamp,
    //                                                     "payment_type"=>"on_hold_amount_released",
    //                                                     "log_type"=>"credit"
    //                                             ]);
                                    
                            
    //                             }

                        

    //             }
    //         }
    //     }
    // }

    
    // private function getUser($id = null, $conds = null, $relation = null)
    // {

    //     $user = User::when($id, function ($q, $id) {
    //         $q->where('id', $id);
    //     })
    //         ->when($conds, function ($q, $conds) {
    //             $q->where($conds);
    //         })
    //         ->when($relation, function ($q, $relation) {
    //             $q->with($relation);
    //         })
    //         ->first();
    //     return $user;
    // }

    //  private function sendBidNoti($chat_data)
    // {
    //     // start noti send to sender user
    //     $token_conds['user_id'] = $chat_data['user_id'];
    //     $notiTokens = $this->pushNotificationTokenService->getNotiTokens(null, $token_conds);
    //     $device_ids = [];
    //     $platform_names = [];
    //     foreach ($notiTokens as $token) {
    //         $device_ids[] = $token->device_token;
    //         $platform_names[] = $token->platform_name;
    //     }

    //     // get reveiver data
    //     $receiver = $this->getUser($chat_data['user_id']);

    //     $data['message'] = $chat_data['message'];
    //     $data['user_name'] = $receiver->name;
    //     $data['bid_id'] = $chat_data['bid_id'];
    //     $data['user_profile_photo'] = $receiver->user_cover_photo; 
    //     $data['flag'] = 'bid';
    //     $data['chat_flag'] = $chat_data['flag'];
    //     send_android_fcm_bid($device_ids, $data, $platform_names);
    //     // end noti send to sender user

    // }

    // public function auto_cancel_processing_bid_after_48_hours()
    // {
    //     $currentDateTime = Carbon::now(); 
    //     $currentTimestamp = $currentDateTime->timestamp; 
    //     $bidsWithItemsReceived = BidDetails::where('bid_status','processing')->where('disputed_bid','no')->get();
    //     foreach($bidsWithItemsReceived as $bidsWithItemReceived)
    //     {
    //         $bid_item_received_time = Carbon::parse($bidsWithItemReceived->update_date_time);
    //         $currentSwizTime = Carbon::now();

    //         $timeDifferenceHours = $bid_item_received_time->diffInHours($currentSwizTime);
    //         if($timeDifferenceHours > 48)
    //         {
 
    //             $notifications = BidNotifications::where('bid_id',$bidsWithItemReceived->id)->first();
    //             if($notifications->auto_cancel_after_48_hours == 0)
    //             {
               
    //                 $bidUpdated = BidDetails::where('id', $bidsWithItemReceived->id)->update(['bid_status'=>'cancelled']); 

    //                     // The buyer will be notified about the cancellation.
    //                     $buyer_id =   $bidsWithItemReceived->buyer_id;
    //                     $buyerUser = $this->getUser($buyer_id);
    //                     $buyer_user_email = $buyerUser->email;
                
    //                     //send an email
                    
    //                             $to = $buyer_user_email;
    //                             $title = __('core__api_bid_cancelled_title', [], 'en');
    //                             $subject = __('core__api_bid_cancelled', [], 'en');
    //                             $to_name = $buyerUser->name;
    //                             $body = __('core__api_bid_cancelled_body',[],'en');
    //                             sendMail($to, $to_name, $title, $subject, $body);

    //                     // for send noti data
    //                     $data['bid_id'] = $bidsWithItemReceived->id;
    //                     $data['user_id'] = $bidsWithItemReceived->buyer_id;
    //                     $data['message'] = __('core__api_bid_cancelled_body',[],'en');
    //                     $data['flag'] = __('core__api_bid_cancelled', [], 'en');

    //                     // save noti to bid_notis
    //                     $noti = new BidNoti();
    //                     $noti->bid_id = $bidsWithItemReceived->id;
    //                     $noti->type = 'BID_AUTO_CANCEL';
    //                     $noti->bid_noti_message = 'core__api_bid_cancelled_body';
    //                     $noti->is_read = 0;
    //                     $noti->added_date = Carbon::now();
    //                     $noti->save();

    //                     $this->sendBidNoti($data);

    //                          BidNotifications::where('bid_id',$bidsWithItemReceived->id)->update(['auto_cancel_after_48_hours'=>1]);
    //                         /***************************** */
    //             }
    //         }
           
    //     }
    // }
   
}
 