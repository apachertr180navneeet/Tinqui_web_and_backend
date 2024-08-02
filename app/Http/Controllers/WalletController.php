<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Modules\Core\Constants\Constants;
use Modules\Payment\Http\Services\PaymentSettingService;
use Modules\Core\Http\Services\AvailableCurrencyService; 
use App\Models\TrackItem;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\WalletLog; 
use App\Models\BidDetails;  
use App\Models\DisputeRefundTracking; 
use App\Models\BidNoti;
use App\Models\BidNotifications;
use App\Models\BidStripeTransaction;
use App\Models\WalletWithdrawalRequest; 
use App\Models\StripeConnectDetails;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Arr;
use Modules\Core\Entities\AvailableCurrency;
use Session;
use Modules\Core\Http\Services\ImageService;
use Modules\Core\Http\Services\PushNotificationTokenService;
use Modules\Core\Http\Services\UserService;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Modules\Core\Entities\Item;
use Modules\Core\Entities\Category;

use Mollie\Laravel\Facades\Mollie;

class WalletController extends Controller
{

    //D:\xampp\htdocs\Tinqui-Market-Place\Modules\Core\Http\Services\AvailableCurrencyService.php
    ///  $this->currencyIdCol = AvailableCurrency::id;
    protected $paystackPaymentMethod, $razorPaymentMethod, $paypalPaymentMethod, $stripePaymentMethod, $iapPaymentMethod, $paymentSettingService,
        $stripeSecretKey, $paypalPrivateKey, $paypalPublicKey, $paypalClientId, $paypalSecretKey, $paypalEnvironment,$paypalMerchantId,$createdStatusCode,$successStatus,$internalServerErrorStatusCode,$badRequestStatusCode,$translator,$okStatusCode,$errorStatus,$stripePublishableKey,$currencyIdCol,$imageService,$storage_upload_path,$img_folder_path,$pushNotificationTokenService,$userService;

    public function __construct(Translator $translator,PaymentSettingService $paymentSettingService,ImageService $imageService,PushNotificationTokenService $pushNotificationTokenService,UserService $userService)
    {

         Mollie::api()->setApiKey('test_ndABcng3ASdH2x2pDH2A7SfuthHwUc'); 
        $this->pushNotificationTokenService = $pushNotificationTokenService;
        $this->userService = $userService;

        $this->translator = $translator;
         $this->paypalPrivateKey = Constants::paypalPrivateKey;
        $this->paypalPublicKey = Constants::paypalPublicKey;
        $this->paypalClientId = Constants::paypalClientId;
        $this->paypalMerchantId = Constants::paypalMerchantId;
        $this->paypalSecretKey = Constants::paypalSecretKey;
        $this->paypalEnvironment = Constants::paypalEnvironment;
       

         $this->stripeSecretKey = Constants::stripeSecretKey;
         $this->stripePublishableKey = Constants::stripePublishableKey;

         $this->paystackPaymentMethod = Constants::paystackPaymentMethod; 
        $this->razorPaymentMethod = Constants::razorPaymentMethod;
        $this->paypalPaymentMethod = Constants::paypalPaymentMethod;
        $this->stripePaymentMethod = Constants::stripePaymentMethod;

        $this->createdStatusCode = Constants::createdStatusCode;
        $this->internalServerErrorStatusCode = Constants::internalServerErrorStatusCode;
        $this->badRequestStatusCode = Constants::badRequestStatusCode;
        $this->successStatus = Constants::successStatus;
         $this->paymentSettingService = $paymentSettingService;


          $this->okStatusCode = Constants::okStatusCode;

        $this->errorStatus = Constants::errorStatus;
        $this->imageService = $imageService;

        $this->img_folder_path = Constants::folderPath;
        $this->storage_upload_path = '/storage/' . $this->getFolderImagePath() . '/disputes/';
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
        $notiTokens = $this->pushNotificationTokenService->getNotiTokens(null, $token_conds);
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

    }

    public function getFolderImagePath()
    {
        return $this->img_folder_path;
    }

    /**************************wallet recharge website side ****************************/
    public function store(Request $request)
    {
        
        
            $validator = Validator::make($request->all(), [
            'login_user_id' => 'required|exists:users,id',
            'amount' => 'required',
            'recharge_timestamp' => 'required',
        ]);

        if($request->language_symbol){
            $this->translator->setLocale($request->language_symbol);
            $validator->setTranslator($this->translator);
        }

        if ($validator->fails()) {
            return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
        }

        if($request->amount > 2000)
        {
            return responseMsgApi(__('core__api_recharge_amount_greater',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
        }
        $stripe_result = 0;
     
        if ($request->payment_method == 'stripe') {
            
                $payment_method = $this->stripePaymentMethod;
                //User using Stripe to submit the transaction
                $payment_method_nonce = explode('_', $request->payment_method_nonce);
               
                if ($payment_method_nonce[0] == 'tok') {
                    
                    try {
                        # set stripe test key
                        \Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
                        
                        $charge = \Stripe\Charge::create(array(
                            "amount"       => intval(round($request->amount*100)), 
                            "currency"    => trim('CHF'),
                            "source"      => $request->payment_method_nonce,
                            "description" => __('itemPromotion__api_order_desc',[],$request->language_symbol) . ' '
                        ));
                       
                        if ($charge->status == "succeeded") {
                            $stripe_result = 1;
                        } else {
                            return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                        }
                    } catch (\Throwable $e) {
                        return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                    }
                } else if ($payment_method_nonce[0] == 'pm') {
                    try {
                        \Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));

                        $paymentIntent = \Stripe\PaymentIntent::create([
                            'payment_method' => $request->payment_method_nonce,
                            'amount' => intval(round($request->amount*100)), 
                            'currency' => trim('CHF'),
                            'confirmation_method' => 'manual',
                            'confirm' => true,
                             'return_url' => env('APP_URL').'/wallet'
                        ]);
                        if ($paymentIntent->status == "succeeded") {
                            $stripe_result = 1;
                            
                        } else {
                            return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                        }
                    } catch (\Throwable $e) {
                        return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                    }
                }

            }
            /******************* save data after the payment ************************/
            if ($stripe_result == 1) 
            {
               $final_data = [];
                /*********insert into users_wallet table */
                $user = UserWallet::where('user_id',$request->login_user_id)->first();


                if (!$user) {
                                        //New wallet
                                            $data = [];
                                            $data['user_id'] = $request->login_user_id;
                                            $data['currency'] = 'Fr.';
                                            $data['wallet_balance'] = intval(round($request->amount));
                                            $data['recharge_date'] = $request->recharge_timestamp;
                                            $userWalletCreate = UserWallet::create($data);
                                            if($userWalletCreate)
                                            {
                                                $walletLog =  WalletLog::create([
                                                    "users_wallet_id"=>$userWalletCreate->id,
                                                    "amount_added"=>intval(round($request->amount)),
                                                    "amount_deducted"=>0.00,
                                                    "currency"=>'Fr.',
                                                    "old_balance"=>0,
                                                    "payment_type"=>$request->payment_method,
                                                    "payment_status"=>'paid',
                                                    "txn_id"=>$charge->id,
                                                    "paid_at"=>$charge->created,
                                                    "log_type"=>"credit"
                                                ]);
                                                $userWallet = UserWallet::where('id', $userWalletCreate->id)->first();
                                                 $userWallet->walletLogData = WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                                                // $walletLog->status = 1;
                                                array_push($final_data,$userWallet);
                                            }
                                        
                } 
                else 
                {

                                        //old wallet
                                        $amount = intval(round($request->amount));
                                        $old_amount = $user->wallet_balance;
                                        $new_amount = $old_amount+$amount;
                                        $data = [];
                                        $data['currency'] = 'Fr.';
                                        $data['wallet_balance'] = $new_amount;
                                        $data['recharge_date'] = $request->recharge_timestamp;
                                        $updated = UserWallet::where('id', $user->id)->update($data);
                                        //wallet_log
                                        if($updated)
                                            {
                                                $userWallet = UserWallet::where('id', $user->id)->first();
                                                $walletLog =WalletLog::create([
                                                                    "users_wallet_id"=>$userWallet->id,
                                                                    "amount_added"=>$amount,
                                                                    "amount_deducted"=>0.00,
                                                                    "currency"=>'Fr.',
                                                                    "old_balance"=>$old_amount,
                                                                    "payment_type"=>$request->payment_method,
                                                                    "payment_status"=>'paid',
                                                                    "txn_id"=>$charge->id,
                                                                    "paid_at"=>$charge->created,
                                                                    "log_type"=>"credit"
                                                            ]);
                                                            
                                                  $userWallet->walletLogData =WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                                                    // $walletLog->status = 1;
                                                    array_push($final_data,$userWallet);
                                        
                                            }
              
                }

                $under_process_bids = BidDetails::where('buyer_id',$request->login_user_id)->where('bid_status','processing')->get();
                if ($under_process_bids->count() > 0) {
                    foreach ($under_process_bids as $bid) {
                        $seller = $bid->seller_id;
                        $user_wallet = UserWallet::where('user_id',$request->login_user_id)->first();
                        if($user_wallet->wallet_balance >= $bid->bid_price)
                        {
                            $current_balance = $user_wallet->wallet_balance;
                                $new_balance =  $current_balance - $bid->bid_price;
                                $currentDateTime = Carbon::now(); 
                                $currentTimestamp = $currentDateTime->timestamp; 
                                $deducted_wallet = UserWallet::where('user_id',$request->login_user_id)->update(['wallet_balance',$new_balance,'recharge_timestamp'=>$currentTimestamp]);
                                             WalletLog::create([
                                                                    "users_wallet_id"=>$user_wallet->id,
                                                                    "amount_added"=>0.00,
                                                                    "amount_deducted"=>$bid->bid_price,
                                                                    "currency"=>'Fr.',
                                                                    "old_balance"=>$current_balance,
                                                                    "add_date"=>$request->recharge_timestamp,
                                                                    "payment_type"=>'wallet_deduction',
                                                                    "log_type"=>"debit"
                                                            ]);
                                if($deducted_wallet)
                                {
                                    
                                    $status_updated = BidDetails::where('id',$bid->id)->update(['bid_status'=>'accepted','bid_payment_status'=>'paid']);
                                    if($status_updated)
                                    {
                                        TrackItem::create(['bid_id'=>$bid->id,'item_status'=>'accepted','updated_by_id'=>0,'updated_by'=>'admin',"update_date"=>date('Y-m-d'),"status_notes"=>"Bid auto accepted"]);
                                    }
                                    
                                     
                                    $seller_wallet = UserWallet::where('user_id',$seller)->get();
                                    $payable_amount = $bid->amount_paid;
                                    UserWallet::where('user_id',$seller)->update(['amount_on_hold'=>$seller_wallet->amount_on_hold+$payable_amount]);
                                    
                                    WalletLog::create([
                                                            "users_wallet_id"=>$seller_wallet->id,
                                                            "on_hold_amount"=>$payable_amount,
                                                            "currency"=>'Fr.',
                                                            "old_balance"=>$seller_wallet->wallet_balance,
                                                            "add_date"=>$request->recharge_timestamp,
                                                            "payment_type"=>"on_hold_amount_added",
                                                            "log_type"=>"onhold_credit"
                                                            ]);

                                               //notify seller about the bid accepted status
                                                    $seller_id =   $bid->seller_id;
                                                    $sellerUser = $this->getUser($seller_id);
                                                    $seller_user_email = $sellerUser->email;

                                                    $to = $seller_user_email;
                                                    $title = __('core__api_bid_accepted_title', [], $request->language_symbol);
                                                    $subject = __('core__api_bid_accepted', [], $request->language_symbol);
                                                    $to_name = $sellerUser->name;
                                                    $body = __('core__api_bid_accepted_body',[],$request->language_symbol);
                                                    sendMail($to, $to_name, $title, $subject, $body);

                                                    // for send noti data
                                                    $s_data['bid_id'] = $bid->id;
                                                    $s_data['user_id'] = $bid->seller_id;
                                                    $s_data['message'] = __('core__api_bid_accepted_body',[],$request->language_symbol);
                                                    $s_data['flag'] = __('core__api_bid_accepted', [], $request->language_symbol);

                                                    // save noti to bid_notis
                                                    $noti = new BidNoti();
                                                    $noti->bid_id = $bid->id;
                                                    $noti->type = 'BID_ACCEPTED';
                                                    $noti->bid_noti_message = 'core__api_bid_accepted_body';
                                                    $noti->is_read = 0;
                                                    $noti->added_date = Carbon::now();
                                                    $noti->save();
                                                    $this->sendBidNoti($s_data);
                                }
                            
                        }

                    }
                }

            }
      /*******************ends save data after the payment ************************/       
       return responseDataApi($final_data, $this->createdStatusCode, $this->successStatus);     
                
    }
    /*************************************************************************************** */

    /**********************wallet recharge mobile side ****************************************/
    public function wallet_recharge_mobile(Request $request)
    {
     
            $validator = Validator::make($request->all(), [
            'login_user_id' => 'required|exists:users,id',
            'amount' => 'required',
            'recharge_timestamp' => 'required',
            'payment_method'=>'required',
            'payment_method_nonce'=>'required'
        ]);

        if($request->language_symbol){
            $this->translator->setLocale($request->language_symbol);
            $validator->setTranslator($this->translator);
        }

        if ($validator->fails()) {
            return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
        }

        if($request->amount > 2000)
        {
            return responseMsgApi(__('core__api_recharge_amount_greater',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
        }

         $stripe_result = 0;
     
        if ($request->payment_method == 'stripe') {
            
                $payment_method = $this->stripePaymentMethod;
                //User using Stripe to submit the transaction
                $payment_method_nonce = explode('_', $request->payment_method_nonce);
               
                if ($payment_method_nonce[0] == 'pm') {
                    try {
                        \Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));

                        $paymentIntent = \Stripe\PaymentIntent::create([
                            'payment_method' => $request->payment_method_nonce,
                            'amount' => intval(round($request->amount*100)), 
                            'currency' => trim('CHF'),
                            'confirmation_method' => 'manual',
                            'confirm' => true,
                            'return_url' => env('APP_URL').'/wallet'
                        ]);
                        if ($paymentIntent->status == "succeeded") {
                            $stripe_result = 1;
                            
                        } else {
                            return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                        }
                    } catch (\Throwable $e) {
                        return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                    }
                }

            }
            /*******************save data after the payment ************************/
            if ($stripe_result == 1) 
            {
               
                /*********insert into users_wallet table */
                $user = UserWallet::where('user_id',$request->login_user_id)->first();
                if (!$user) {
                                        //New wallet
                                            $data = [];
                                            $data['user_id'] = $request->login_user_id;
                                            $data['currency'] = 'Fr.';
                                            $data['wallet_balance'] = intval(round($request->amount));
                                            $data['recharge_date'] = $request->recharge_timestamp;
                                            $userWalletCreate = UserWallet::create($data);
                                            if($userWalletCreate)
                                            {
                                                $walletLog =  WalletLog::create([
                                                    "users_wallet_id"=>$userWalletCreate->id,
                                                    "amount_added"=>intval(round($request->amount)),
                                                    "amount_deducted"=>0.00,
                                                    "currency"=>'Fr.',
                                                    "old_balance"=>0,
                                                    "payment_type"=>$request->payment_method,
                                                    "payment_status"=>'paid',
                                                    "txn_id"=>$paymentIntent->id,
                                                    "paid_at"=>$paymentIntent->created,
                                                    "log_type"=>"credit"
                                                ]);
                                        $userWallet = UserWallet::where('id', $userWalletCreate->id)->first();
                                        $userWallet->walletLogData = WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                                                // $walletLog->status = 1;
                                            $userWallet->message = __('ps_error_dialog__recharge_success',[],$request->language_symbol); 
                                            }
                                        
                } 
                else 
                {
                                        //old wallet
                                        $amount = intval(round($request->amount));
                                        $old_amount = $user->wallet_balance;
                                        $new_amount = $old_amount+$amount;
                                        $data = [];
                                        $data['currency'] = 'Fr.';
                                        $data['wallet_balance'] = $new_amount;
                                        $data['recharge_date'] = $request->recharge_timestamp;
                                        $updated = UserWallet::where('id', $user->id)->update($data);
                                        //wallet_log
                                        if($updated)
                                            {
                                                $userWallet = UserWallet::where('id', $user->id)->first();
                                                $walletLog =WalletLog::create([
                                                                    "users_wallet_id"=>$userWallet->id,
                                                                    "amount_added"=>$amount,
                                                                    "amount_deducted"=>0.00,
                                                                    "currency"=>'Fr.',
                                                                    "old_balance"=>$old_amount,
                                                                    "payment_type"=>$request->payment_method,
                                                                    "payment_status"=>'paid',
                                                                    "txn_id"=>$paymentIntent->id,
                                                                    "paid_at"=>$paymentIntent->created,
                                                                    "log_type"=>"credit"
                                                            ]);
                                                            
                                            $userWallet->walletLogData =WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                                            $userWallet->message = __('ps_error_dialog__recharge_success',[],$request->language_symbol); 

                                                    // $walletLog->status = 1;
                                        
                                            }
              
                }

                $under_process_bids = BidDetails::where('buyer_id',$request->login_user_id)->where('bid_status','processing')->get();
                if ($under_process_bids->count() > 0) {
                    foreach ($under_process_bids as $bid) {
                        $seller = $bid->seller_id;
                        $user_wallet = UserWallet::where('user_id',$request->login_user_id)->first();
                        if($user_wallet->wallet_balance >= $bid->bid_price)
                        {
                            $current_balance = $user_wallet->wallet_balance;
                                $new_balance =  $current_balance - $bid->bid_price;
                                $currentDateTime = Carbon::now(); 
                                $currentTimestamp = $currentDateTime->timestamp; 
                                $deducted_wallet = UserWallet::where('user_id',$request->login_user_id)->update(['wallet_balance',$new_balance,'recharge_timestamp'=>$currentTimestamp]);
                                             WalletLog::create([
                                                                    "users_wallet_id"=>$user_wallet->id,
                                                                    "amount_added"=>0.00,
                                                                    "amount_deducted"=>$bid->bid_price,
                                                                    "currency"=>'Fr.',
                                                                    "old_balance"=>$current_balance,
                                                                    "add_date"=>$request->recharge_timestamp,
                                                                    "payment_type"=>'wallet_deduction',
                                                                    "log_type"=>"debit"
                                                            ]);
                                if($deducted_wallet)
                                {
                                    $status_updated = BidDetails::where('id',$bid->id)->update(['bid_status'=>'accepted','bid_payment_status'=>'paid']);
                                    if($status_updated)
                                    {
                                        TrackItem::create(['bid_id'=>$bid->id,'item_status'=>'accepted','updated_by_id'=>0,'updated_by'=>'admin',"update_date"=>date('Y-m-d'),"status_notes"=>"Bid auto accepted"]);
                                    }
                                    //notify seller about the bid accepted status
                                     //notify seller about the bid accepted status
                                                    $seller_id =   $bid->seller_id;
                                                    $sellerUser = $this->getUser($seller_id);
                                                    $seller_user_email = $sellerUser->email;

                                                    $to = $seller_user_email;
                                                    $title = __('core__api_bid_accepted_title', [], $request->language_symbol);
                                                    $subject = __('core__api_bid_accepted', [], $request->language_symbol);
                                                    $to_name = $sellerUser->name;
                                                    $body = __('core__api_bid_accepted_body',[],$request->language_symbol);
                                                    sendMail($to, $to_name, $title, $subject, $body);

                                                    // for send noti data
                                                    $s_data['bid_id'] = $bid->id;
                                                    $s_data['user_id'] = $bid->seller_id;
                                                    $s_data['message'] = __('core__api_bid_accepted_body',[],$request->language_symbol);
                                                    $s_data['flag'] = __('core__api_bid_accepted', [], $request->language_symbol);

                                                    // save noti to bid_notis
                                                    $noti = new BidNoti();
                                                    $noti->bid_id = $bid->id;
                                                    $noti->type = 'BID_ACCEPTED';
                                                    $noti->bid_noti_message = 'core__api_bid_accepted_body';
                                                    $noti->is_read = 0;
                                                    $noti->added_date = Carbon::now();
                                                    $noti->save();
                                                    $this->sendBidNoti($s_data);
                                     
                                    $seller_wallet = UserWallet::where('user_id',$seller)->get();
                                    $payable_amount = $bid->amount_paid;
                                    UserWallet::where('user_id',$seller)->update(['amount_on_hold'=>$seller_wallet->amount_on_hold+$payable_amount]);
                                    WalletLog::create([
                                                            "users_wallet_id"=>$seller_wallet->id,
                                                            "on_hold_amount"=>$payable_amount,
                                                            "currency"=>'Fr.',
                                                            "old_balance"=>$seller_wallet->wallet_balance,
                                                            "add_date"=>$request->recharge_timestamp,
                                                            "payment_type"=>"on_hold_amount_added",
                                                            "log_type"=>"onhold_credit"
                                                            ]);
                                }
                            
                        }

                    }
                }

            }
      /*******************ends save data after the payment ************************/       
       return responseDataApi($userWallet, $this->createdStatusCode, $this->successStatus);

    }
    /*****************************************************************************************/

   
    public function bid_placed_wallet_payment(Request $request)
    {      
        $validator = Validator::make($request->all(), [
            'login_user_id' => 'required|exists:users,id',
            // 'amount' => 'required',
            'recharge_timestamp' => 'required',
            'seller_user_id' => 'required|exists:users,id',
            'bid_price'=> 'required',
            'product_price' =>'required',
            'product_id'=>'required|exists:items,id',
            'product_title'=>'required'

        ]);

        if($request->language_symbol){
            $this->translator->setLocale($request->language_symbol);
            $validator->setTranslator($this->translator);
        }

        if ($validator->fails()) {
            return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
        }


        /*************************** Insert into users_wallet table **********************************/
                $buyerWallet = UserWallet::where('user_id',$request->login_user_id)->first();
                if (!$buyerWallet) {
                    //No wallet
                    return responseMsgApi(__('core__api_recharge_no_wallet',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                     
                } else {
                    //old wallet
                    $bidAlreadyThere = BidDetails::where('buyer_id',$request->login_user_id)->where('seller_id',$request->seller_user_id)->where('product_id',$request->product_id)->first();
                    if($bidAlreadyThere)
                    {
                        return responseMsgApi(__('core__api_recharge_bid_already_exists',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                    }

                    $bid_price = $request->bid_price;
                    $current_balance = $buyerWallet->wallet_balance;

                    /************************************************************************/
                        $category_commission_of_product = Category::join('items','items.category_id','=','categories.id')->where('items.id',$request->product_id)->first('categories.commission'); 

                        $commission = $category_commission_of_product['commission']/100;
                        $commission_amount = $commission * $request->bid_price;
                        $amount_paid = $request->bid_price - $commission_amount;
                        $amount_deducted = $request->bid_price + $commission_amount;
                         
                       // $deduct_amount = $bid_price 
                    /************************************************************************/

                    if($current_balance < $amount)
                    {
                        return responseMsgApi(__('core__api_recharge_not_enough_wallet',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                    }
                           
                    $remaining_amount = $current_balance - $amount_deducted;
                    $data = [];
                    $data['currency'] = 'Fr.';
                    $data['wallet_balance'] = $remaining_amount;
                    $data['recharge_date'] = $request->recharge_timestamp;
                    $updated = UserWallet::where('user_id', $request->login_user_id)->update($data);
                    
                    //wallet_log
                    if($updated)
                        {
                          
                            $userWallet = UserWallet::where('user_id',$request->login_user_id)->first();
                            $walletLog =WalletLog::create([
                                                "users_wallet_id"=>$userWallet->id,
                                                "amount_added"=>0.00,
                                                "amount_deducted"=>$amount_deducted,
                                                "currency"=>'Fr.',
                                                "old_balance"=>$current_balance,
                                                "add_date"=>$request->recharge_timestamp,
                                                "payment_type"=>"wallet_deduction",
                                                "log_type"=>"debit"
                                        ]);
            
                                    $bid_data =[
                                                "buyer_id"=>$request->login_user_id,
                                                "seller_id"=>$request->seller_user_id,
                                                "bid_price"=>$request->bid_price,
                                                "product_id"=>$request->product_id,
                                                "product_price"=>$request->product_price,
                                                "product_title"=>$request->product_title,
                                                "bid_status"=>"pending",
                                                "bid_commission"=>$category_commission_of_product['commission'],
                                                "amount_paid"=>$amount_paid,
                                                "bid_created_at" =>Carbon::now()
                                        ];
              
                            $bidCreate = BidDetails::create($bid_data);
                             if($bidCreate)
                                    {
                                        TrackItem::create(['bid_id'=>$bidCreate->id,'item_status'=>'pending','updated_by_id'=>0,'updated_by'=>'admin',"update_date"=>date('Y-m-d'),"status_notes"=>"Bid received"]);
                                    }
                            BidNotifications::create(['bid_id'=>$bidCreate->id]);
                            
                            $userWallet->walletLog = WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();

                            $userWallet->bidDetails = BidDetails::where('id', $bidCreate->id)->orderBy('id','desc')->first();
                            $userWallet->bidDetails->trackStatus = TrackItem::where('bid_id', $bidCreate->id)->orderBy('id','desc')->get();
                            //$userWallet->trackStatus = TrackItem::where('bid_id', $bidCreate->id)->orderBy('id','desc')->first();
                             
                        }


                        return responseDataApi($userWallet, $this->createdStatusCode, $this->successStatus); 
                }

    }


    /****************************release seller onhold amount into wallet after comission deduction********************/
    public function release_seller_hold_amount(Request $request)
    {
        
        // echo 'here';die;
        $validator = Validator::make($request->all(), [
            'seller_user_id' => 'required|exists:users,id',
            'recharge_timestamp' => 'required',
            'bid_details_id'=>'required',
            ]);

        if($request->language_symbol){
            $this->translator->setLocale($request->language_symbol);
            $validator->setTranslator($this->translator);
        }

        if ($validator->fails()) {
            return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
        }


          $user = UserWallet::where('user_id',$request->seller_user_id)->first();
          if(!$user)
          {
               return responseMsgApi(__('core__api_recharge_user_not_found',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
          }

           $bidUpdated = BidDetails::where('id', $request->bid_details_id)->update(['bid_status'=>'completed','update_date_time'=>now()]); 
           if($bidUpdated)
                {
                        TrackItem::create(['bid_id'=>$request->bid_details_id,'item_status'=>'completed','updated_by_id'=>$request->login_user_id,'updated_by'=>'buyer',"update_date"=>date('Y-m-d'),"status_notes"=>"Buyer is satisfied with the item. Funds released into the seller's wallet."]);
              

           $bid_details = BidDetails::where('id', $request->bid_details_id)->first();

           $old_balance  = $user->wallet_balance;
                    $wallet_new_balance = $old_balance + $bid_details->amount_paid;
                    $on_hold_new_amount = $user->amount_on_hold - $bid_details->amount_paid;
                    $data = [];
                    $data['user_id'] = $request->seller_user_id;
                    $data['currency'] = 'Fr.';
                    $data['wallet_balance'] = $wallet_new_balance;
                     $data['amount_on_hold'] = $on_hold_new_amount;
                     $data['recharge_date'] = $request->recharge_timestamp;
                    $updated = UserWallet::where('id', $user->id)->update($data);
                    //wallet_log
                    if($updated)
                        {   
                            $userWallet = UserWallet::where('id', $user->id)->first();
                            $walletLog =WalletLog::create([
                                                "users_wallet_id"=>$userWallet->id,
                                                "currency"=>'Fr.',
                                                "old_balance"=>$old_balance,
                                                "amount_added"=>$bid_details->amount_paid,
                                                "add_date"=>$request->recharge_timestamp,
                                                "payment_type"=>"on_hold_amount_released",
                                                "log_type"=>"credit"
                                        ]);
                          //  $userWallet->walletLog = WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                             
                            $userWallet->bidDetails = BidDetails::where('id', $request->bid_details_id)->orderBy('id','desc')->first();
                             $userWallet->bidDetails->trackStatus = TrackItem::where('bid_id', $request->bid_details_id)->orderBy('id','desc')->get();
                    
                        }


            }

            return responseDataApi($userWallet, $this->createdStatusCode, $this->successStatus);  



    }
    /****************************release seller onhold amount into wallet after comission deduction ends here*******************/



    /****************************withdrawal API March8********************/
        public function withdraw_wallet_request(Request $request)
        {
        
            $validator = Validator::make($request->all(), [
                    'login_user_id' => 'required|exists:users,id',
                    'withdraw_amount'=> 'required',
                    'bank_name'=> 'nullable',
                    'bank_code'=> 'nullable',
                    'branch_name'=> 'nullable',
                    'account_number'=> 'nullable',
                    'account_name'=> 'nullable',
                    'address'=> 'nullable',
                    'city'=> 'nullable',
                    'state'=> 'nullable',
                    'postal_code'=> 'nullable',
                    'country'=> 'nullable',
                    "request_date"=>'required|date_format:Y-m-d H:i:s',
                    "timestamp"=>'nullable'
                ]);

                if($request->language_symbol){
                    $this->translator->setLocale($request->language_symbol);
                    $validator->setTranslator($this->translator);
                }

                if ($validator->fails()) {
                    return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
                }

                
                $requestAlreadyExists = WalletWithdrawalRequest::where('user_id', $request->login_user_id)->whereIn('withdraw_status', ['received', 'inprocess'])->first();   
                if($requestAlreadyExists)
                {
                    return responseMsgApi(__('core__api_withdraw_exists',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                }
                
                    $userWallet = UserWallet::join('users','users.id','=','users_wallet.user_id')->where('users_wallet.user_id', $request->login_user_id)->first();
                 
                    if(!$userWallet)
                    {
                        return responseMsgApi(__('core__api_recharge_no_wallet',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                    }
                                                $data = [];
                                                $data['user_id'] = $request->login_user_id;
                                                $data['currency'] = 'Fr.';
                                                $data['withdraw_amount'] = $request->withdraw_amount;
                                                // $data['bank_name'] = $request->bank_name;
                                                // $data['bank_code'] = $request->bank_code;
                                                // $data['branch_name'] = $request->branch_name;
                                                // $data['account_number'] = $request->account_number;
                                                // $data['account_name'] = $request->account_name;
                                                // $data['address'] = $request->address;
                                                // $data['country'] = $request->country;
                                                // $data['city'] = $request->city;
                                                // $data['state'] = $request->state;
                                                // $data['postal_code'] = $request->postal_code;
                                                $data['request_date'] = $request->request_date;
             
                             \Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
                                      
                       

                        /*****create connected account for transfer ********** */
                                            $stripe_connect_account = StripeConnectDetails::where('user_id',$request->login_user_id)->first();
                                            $user = User::find($request->login_user_id);
                                            if($stripe_connect_account)
                                            {
                                      
                                                     $accountId = $stripe_connect_account->stripe_connect_account_id;
                                            }
                                            else
                                            {

                                        
                                                $stripe = new \Stripe\StripeClient(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
                                              
                                                    $username = explode(' ',$user->name);
                                                    if(count($username) > 1)
                                                    {
                                                        $user_lastname = $username[1];
                                                    }
                                                    else
                                                    {
                                                        $user_lastname = 'Doe';
                                                    }
                                                // $account = $stripe->accounts->create
                                                //         ([
                                                //             'type' => 'express',
                                                //             'country' => 'CH',
                                                //             'email' => $user->email,
                                                //             'business_type' => 'individual',
                                                //             'individual' => [
                                                //                 'first_name' => $username[0],
                                                //                 'last_name' => $user_lastname,
                                                //                 'id_number' => '1234567890', // Example Swiss ID number
                                                //                 'dob' => [
                                                //                     'day' => 1,
                                                //                     'month' => 1,
                                                //                     'year' => 1990,
                                                //                 ],
                                                //                 'address' => [
                                                //                     'line1' => $request->address, //'123 Hauptstrasse'  CH9300762011623852957
                                                //                     'city' => $request->city,  //'Zürich',
                                                //                     'state' => $request->state, //'ZH',
                                                //                     'postal_code' => $request->postal_code, //'8001',
                                                //                     'country' => 'CH',
                                                //                 ],
                                                //             ],
                                                //                 'capabilities' => [
                                                //                     'card_payments' => ['requested' => true],
                                                //                     'transfers' => ['requested' => true],
                                                //                 ],
                                                //                 'tos_acceptance' => [
                                                //                     'date' => time(),
                                                //                     'ip' => $_SERVER['REMOTE_ADDR'], // Use a dummy IP for testing
                                                //                 ],
                                                //         ]);
                                                try{
                                                        $account = $stripe->accounts->create([
                                                                'type' => 'express',
                                                                'country' => 'CH',
                                                                'email' => $user->email,
                                                                'business_type' => 'individual',
                                                                'individual' => [
                                                                    'first_name' => $username[0],
                                                                    'last_name' => $user_lastname,
                                                                ],
                                                                'capabilities' => [
                                                                    'card_payments' => ['requested' => true],
                                                                    'transfers' => ['requested' => true],
                                                                ],
                                                                // 'controller' => [
                                                                //     'stripe_dashboard' => [
                                                                //         'type' => 'express',
                                                                //     ],
                                                                    // 'fees' => [
                                                                    //     'payer' => 'application'
                                                                    // ],
                                                                    // 'losses' => [
                                                                    //     'payments' => 'application'
                                                                    // ],
                                                                //],
                                                            ]);
                                                            $accountId = $account->id;
                                                            //store the account id in database
                                                            StripeConnectDetails::create(['user_id'=>$request->login_user_id,'stripe_connect_account_id'=>$accountId]);
                                                    }
                                                catch (\Exception $e) {
                                                    return responseMsgApi($e->getMessage(), $this->internalServerErrorStatusCode);
                                                    // return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                                                }
                                                 
                                            }
                                       
                                     
                                        if($accountId)
                                        {
                                                
                                            if($request->withdraw_amount <= 2000)
                                            {
                                                  /**************check if the account id has payments enabled ********* inactive is the key  */
                                                  $stripe = new \Stripe\StripeClient(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
                                                    $account = $stripe->accounts->retrieve($accountId);
                                                // print_r($account);die;
                                                    if ($account->capabilities->transfers == 'inactive') 
                                                    {
                                                      /*******************inactive accounts send back to the pafe of stripe-connect********************/  
                                                        StripeConnectDetails::where('user_id',$request->login_user_id)->update(['transfers_enabled'=>0]);
                                                       return responseMsgApi(__('core__api_withdrawal_missing_info',[],$request->language_symbol), 422);
                                                       
                                                    }
                                                    else if ($account->capabilities->transfers == 'active') 
                                                    {
                                                         StripeConnectDetails::where('user_id',$request->login_user_id)->update(['transfers_enabled'=>1]);
                                                         /*******************create transfer request if payments are active***************/
                                                                try
                                                                {   
                                                                    
                                                                    $transfer = \Stripe\Transfer::create([
                                                                                    'amount' => $request->withdraw_amount*100, 
                                                                                    'currency' => trim('CHF'),
                                                                                    'destination' => $accountId,
                                                                                    //'source_transaction' => $tokenId, 
                                                                                ]);
                                                                }
                                                                catch(\Exception $e)
                                                                {
                                                                         return responseMsgApi($e->getMessage(), $this->internalServerErrorStatusCode);
                                                                }

                                                                 $transfer_id = $transfer->id;
                                                        if($transfer_id)
                                                        {
                                                           
                                                            if($account->payouts_enabled == 1)
                                                            {
                                                                     $this->createPayout($accountId,$request->withdraw_amount);
                                                           
                                                              
                                                                $data['withdraw_status'] = 'accepted';
                                                                $createdRequest = WalletWithdrawalRequest::create($data);
                                                                $final_data = [];
                                                                /****deduct money from wallet */
                                                                $userWallet = UserWallet::where('user_id', $request->login_user_id)->first();
                                                                $new_balance = ($userWallet->wallet_balance)-($request->withdraw_amount);
                                                                $s_data = [];
                                                                $s_data['currency'] = 'Fr.';
                                                                $s_data['wallet_balance'] = $new_balance;
                                                                $s_data['recharge_date'] = $request->timestamp;
                                                                $updatedWallet = UserWallet::where('id', $userWallet->id)->update($s_data);
                                                            /***********deduct money ends here **********/

                                                            WalletLog::create([
                                                                    "users_wallet_id"=>$userWallet->id,
                                                                    "currency"=>'Fr.',
                                                                    "old_balance"=>$userWallet->wallet_balance,
                                                                    "amount_deducted"=>$request->withdraw_amount,
                                                                    "add_date"=>$request->timestamp,
                                                                    "payment_type"=>"wallet_withdrawal",
                                                                    'txn_id'=>$transfer_id,
                                                                    "log_type"=>"debit"
                                                            ]);
                                                            
                                                        
                                                            return responseMsgApi(__('core__api_withdrawal_submitted_successfully',[],$request->language_symbol), $this->okStatusCode, $this->successStatus);
                                                            //return responseMsgApi('Done', $this->createdStatusCode, $this->successStatus); 

                                                             }
                                                            else if($account->payouts_enabled == 0)
                                                            {
                                                                StripeConnectDetails::where('user_id',$request->login_user_id)->update(['payouts_enabled'=>0]);
                                                                 return responseMsgApi(__('core__api_withdrawal_missing_info',[],$request->language_symbol), 422);
                                                            }

                                                        }   
                                                        else
                                                        {
                                                            $data['withdraw_status'] = 'declined';
                                                            $createdRequest = WalletWithdrawalRequest::create($data);

                                                                    return responseMsgApi(__('core__api_withdrawal_request_error',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                                                        }  
                                                    }     
                                              /**********************************************************/
                                            }
                                              /*************add money ends here */
                                            else
                                            {
                                                /****amount greater than 2000 CHF ***/
                                                $data['withdraw_status'] = 'received';
                                                $createdRequest = WalletWithdrawalRequest::create($data);
                                                            if($createdRequest)
                                                            {
                                                                $final_data = [];
                                                                /****deduct money from wallet */
                                                                $userWallet = UserWallet::where('user_id', $request->login_user_id)->first();
                                                                $new_balance = ($userWallet->wallet_balance)-($request->withdraw_amount);
                                                                $s_data = [];
                                                                $s_data['currency'] = 'Fr.';
                                                                $s_data['wallet_balance'] = $new_balance;
                                                                $s_data['recharge_date'] = $request->timestamp;
                                                                $updatedWallet = UserWallet::where('id', $userWallet->id)->update($s_data);
                                                                /***********deduct money ends here **********/

                                                                WalletLog::create([
                                                                        "users_wallet_id"=>$userWallet->id,
                                                                        "currency"=>'Fr.',
                                                                        "old_balance"=>$userWallet->wallet_balance,
                                                                        "amount_deducted"=>$request->withdraw_amount,
                                                                        "add_date"=>$request->timestamp,
                                                                        "payment_type"=>"wallet_withdrawal",
                                                                        'txn_id'=>$transfer_id,
                                                                        "log_type"=>"debit"
                                                                ]);
                                                            
                                                                return responseMsgApi(__('core__api_withdrawal_submitted_successfully',[],$request->language_symbol), $this->okStatusCode, $this->successStatus);
                                                                //return responseMsgApi('Done', $this->createdStatusCode, $this->successStatus); 

                                                            }
                                                            else
                                                            {
                                                                return responseMsgApi(__('core__api_withdrawal_request_error',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                                                            }
                                            }  

                                        }
                                            
        }
    

        private function createPayout($connectedAccountId, $amount)
        {
            try {
                $payout = \Stripe\Payout::create([
                    'amount' => $amount*100,
                    'currency' => trim('CHF'),
                ], [
                    'stripe_account' => $connectedAccountId, 
                ]);
                \Log::info('pay external account inside withdrawal');
                \Log::info($payout);

            } catch (\Exception $e) {
                 return responseMsgApi($e->getMessage(), $this->internalServerErrorStatusCode);
            }
        }

        public function get_all_withdrawal_requests(Request $request)
        {
        
            $validator = Validator::make($request->all(), [
                    'login_user_id' => 'required|exists:users,id',
            ]);

            if($request->language_symbol){
                    $this->translator->setLocale($request->language_symbol);
                    $validator->setTranslator($this->translator);
                }

                if ($validator->fails()) {
                    return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
                }

            $allRequests = WalletWithdrawalRequest::where('user_id', $request->login_user_id)->orderBy('id','desc')->get();
            if(count($allRequests)>0)
            {
                    return responseDataApi($allRequests, $this->okStatusCode, $this->successStatus); 
            }
            else
            {
                    return responseMsgApi(__('core__api_recharge_no_withdrawals',[],$request->language_symbol), $this->internalServerErrorStatusCode);
            }
            

        }
    
    /****************************withdrawal API ends here**********************/


    /****************************refund amount API March8********************/
        public function refund_amount(Request $request)
        {
        
            $validator = Validator::make($request->all(), [
                    'recharge_timestamp' => 'required',
                    'bid_id'=> 'required|exists:bid_details,id',
                    'update_date'=>'required|date_format:Y-m-d',
                ]);

                if($request->language_symbol){
                    $this->translator->setLocale($request->language_symbol);
                    $validator->setTranslator($this->translator);
                }

                if ($validator->fails()) {
                    return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
                }
                //  print_r($request->bid_id); echo '---------------';print_r($request->update_date);
                // echo '---------------';print_r($request->recharge_timestamp);echo '---------------';die;
                    $bid_details = BidDetails::where('id', $request->bid_id)->first();

                     
                    $refund_amount = $bid_details->bid_price;
                    $onhold_amount = $bid_details->amount_paid;
                     $current_date = Carbon::now();

                    $buyerWallet = UserWallet::where('user_id', $bid_details->buyer_id)->first();
                

                        $b_data = [];
                        $b_data['currency'] = 'Fr.';
                        $b_data['wallet_balance'] = $buyerWallet->wallet_balance+$refund_amount;
                        $b_data['recharge_date'] = $request->recharge_timestamp;

                    $updatedBuyer = UserWallet::where('id', $buyerWallet->id)->update($b_data);
                    if($updatedBuyer)
                    {
                        DisputeRefundTracking::create(['bid_id'=>$request->bid_id,'refund_status'=>'requested','update_date'=>$current_date]);
                        $sellerWallet = UserWallet::where('user_id', $bid_details->seller_id)->first();
                        $s_data = [];
                        $s_data['currency'] = 'Fr.';
                        $s_data['amount_on_hold'] = $sellerWallet->amount_on_hold - $onhold_amount;
                        $s_data['recharge_date'] = $request->recharge_timestamp;
                        $updatedSeller = UserWallet::where('id', $sellerWallet->id)->update($s_data);
                        if($updatedSeller)
                        {
                            DisputeRefundTracking::create(['bid_id'=>$request->bid_id,'refund_status'=>'processing','update_date'=>$current_date]);
                            TrackItem::create(['bid_id'=>$request->bid_id,'item_status'=>'refunded','updated_by_id'=>$bid_details->buyer_id,'updated_by'=>'buyer',"update_date"=>date('Y-m-d'),"status_notes"=>"Dispute Resolved for Refund"]);

                            WalletLog::create([
                                            "users_wallet_id"=>$sellerWallet->id,
                                            "amount_deducted"=>$refund_amount,
                                            "currency"=>'Fr.',
                                            "old_balance"=>$sellerWallet->wallet_balance,
                                            "add_date"=>$request->recharge_timestamp,
                                            "payment_type"=>"onhold_amount_deducted",
                                            "log_type"=>"onhold_debit"
                                            ]);

                        }


                        $updatedBuyerwalletLog =WalletLog::create([
                                                                    "users_wallet_id"=>$buyerWallet->id,
                                                                    "amount_added"=>$refund_amount,
                                                                    "currency"=>'Fr.',
                                                                    "old_balance"=>$buyerWallet->wallet_balance,
                                                                    "add_date"=>$request->recharge_timestamp,
                                                                    "payment_type"=>"refund_added",
                                                                    "log_type"=>"credit"
                                                                    ]);
                                                    

                            BidDetails::where('id', $request->bid_id)->update(['bid_status'=>'refunded']); 
                            DisputeRefundTracking::create(['bid_id'=>$request->bid_id,'refund_status'=>'completed','update_date'=>$current_date]);

                            $bidDetails = BidDetails::where('id', $request->bid_id)->orderBy('id','desc')->get();
                            $bidDetails->trackStatus = TrackItem::where('bid_id', $request->bid_id)->orderBy('id','desc')->get();

                            return responseDataApi($bidDetails, $this->createdStatusCode, $this->successStatus); 
                    }
                   

        }
    /****************************refund amount API ends here*******************/

 

    public function get_bid_details(Request $request)
    {
       
       $validator = Validator::make($request->all(), [
                'login_user_id' => 'required|exists:users,id',
                
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }
            
            
            if((BidDetails::where('seller_id',$request->login_user_id)->count())==0)
            {
                   return responseMsgApi(__('core__api_recharge_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }

            $bidDetails = BidDetails::where('seller_id',$request->login_user_id)->orderBy('id','desc')->get();
                foreach($bidDetails as $bidDetail)
                {
                   $bidDetail->amount_paid = number_format($bidDetail->amount_paid,2);
                   $bidDetail->trackStatus = TrackItem::where('bid_id', $bidDetail->id)->orderBy('id','desc')->get();
                }
            
            return responseDataApi($bidDetails, $this->createdStatusCode, $this->successStatus);   
    }

    public function get_buyer_bid_details(Request $request)
    {
       
       $validator = Validator::make($request->all(), [
                'login_user_id' => 'required|exists:users,id',
                
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }
            
            
            if((BidDetails::where('buyer_id',$request->login_user_id)->count())==0)
            {
                   return responseMsgApi(__('core__api_recharge_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }

            $bidDetails = BidDetails::where('buyer_id',$request->login_user_id)->orderBy('id','desc')->get();
            foreach($bidDetails as $bidDetail)
            {
                $bidDetail->trackStatus = TrackItem::where('bid_id', $bidDetail->id)->orderBy('id','desc')->get();
            }
            

            return responseDataApi($bidDetails, $this->createdStatusCode, $this->successStatus);   
    }


      
     public function get_chat_bid_details(Request $request)
    {
     
       $validator = Validator::make($request->all(), [
                'login_user_id' => 'required|exists:users,id',
                'buyer_user_id' => 'required|exists:users,id',
                'seller_user_id' => 'required|exists:users,id',
                'item_id' => 'required|exists:items,id',
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }
            

            $bid_details = BidDetails::where('buyer_id', $request->buyer_user_id)
                                    ->where('seller_id', $request->seller_user_id)
                                    ->where('product_id', $request->item_id)
                                    ->first();
            
            if (!$bid_details) {
                    return responseMsgApi(__('core__api_recharge_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }

            foreach($bid_details as $bidDetail)
            {
                $bidDetail->trackStatus = TrackItem::where('bid_id', $bidDetail->id)->orderBy('id','desc')->get();
            }

            return responseDataApi($bid_details, $this->createdStatusCode, $this->successStatus);

          
    }

     /**********************May 21****************************/ 
    public function get_product_bids(Request $request)
    {
         $validator = Validator::make($request->all(), [
                'login_user_id' => 'required|exists:users,id',
                'product_id' => 'required|exists:items,id',
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }
             
            $itemApiRelation = ['category', 'cover', 'video', 'icon'];
           // $productIds = BidDetails::where('buyer_id',$request->login_user_id)->orderBy('id','desc')->pluck('product_id')->unique();
            $item_details =  Item::when($itemApiRelation, function ($query, $itemApiRelation) {
                                    $query->with($itemApiRelation);
                                })
                            ->where('id', $request->product_id)->first();

            $bid_details = BidDetails::where('bid_details.product_id', $request->product_id)
                                    ->join('users','users.id','=','bid_details.buyer_id')->orderBy('id','desc')->get(['bid_details.*','users.name as fullname','users.username']);
     
            if (!isset($bid_details) || empty($bid_details) || count($bid_details)==0) {
                  $response = [
                        'product_id'=> $item_details->id,
                        'product_title'=> $item_details->title,
                        'product_image'=> $item_details->cover,
                        'total_bids' => 0,
                        'highest_bid' => null,
                        'all_bids' => [],
                        
                    ];
                 //   return responseMsgApi(__('core__api_recharge_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                 return responseDataApi($response, $this->okStatusCode, $this->successStatus);
            }
          
            $highest_bid = BidDetails::where('bid_details.product_id', $request->product_id)->join('users','users.id','=','bid_details.buyer_id')->orderBy('bid_details.bid_price', 'desc')->get(['bid_details.*','users.name as fullname','users.username as username'])->first();


            $highest_bid->trackStatus = TrackItem::where('bid_id', $highest_bid->id)->orderBy('id','desc')->get();

            $response = [
                        'product_id'=> $item_details->id,
                        'product_title'=> $item_details->title,
                        'product_image'=> $item_details->cover,
                        'total_bids' => $bid_details->count(),
                        'highest_bid' => $highest_bid,
                        'all_bids' => $bid_details,
                        
                    ];
          
                    return responseDataApi($response, $this->okStatusCode, $this->successStatus);

          
    }
  /********************************May 08 updtaed APIs arranged ******************************************/

    public function bid_placed_by_user(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'login_user_id' => 'required|exists:users,id',
            'recharge_timestamp' => 'required',
            'seller_user_id' => 'required|exists:users,id',
            'bid_price'=> 'required',
            'product_price' =>'required',
            'product_id'=>'required|exists:items,id',
            'product_title'=>'required'
        ]);

        if($request->language_symbol){
            $this->translator->setLocale($request->language_symbol);
            $validator->setTranslator($this->translator);
        }

        if ($validator->fails()) {
            return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
        } 


                 $category_commission_of_product = Category::join('items','items.category_id','=','categories.id')->where('items.id',$request->product_id)->first('categories.commission'); 

                        $commission = $category_commission_of_product['commission']/100;
                        $commission_amount = $commission * $request->bid_price;
                        $amount_paid = $request->bid_price - $commission_amount;
                        $amount_deducted = $request->bid_price + $commission_amount;
                        $bid_data =[
                                    "buyer_id"=>$request->login_user_id,
                                    "seller_id"=>$request->seller_user_id,
                                    "bid_price"=>$request->bid_price,
                                    "product_id"=>$request->product_id,
                                    "product_price"=>$request->product_price,
                                    "product_title"=>$request->product_title,
                                    "bid_status"=>"pending",
                                    "bid_commission"=>$category_commission_of_product['commission'],
                                    "amount_paid"=>$amount_paid,
                                    "bid_created_at" =>Carbon::now()
                            ];


                    $bidAlreadyThere = BidDetails::where('buyer_id',$request->login_user_id)->where('seller_id',$request->seller_user_id)->where('product_id',$request->product_id)->orderBy('created_at', 'desc')
                             ->first();

                    if($bidAlreadyThere)
                    {
                       $already_bid_price = $bidAlreadyThere->bid_price;
                       $current_bid_price = $request->bid_price;
                        if($current_bid_price <= $already_bid_price)
                        {
                            return responseMsgApi(__('core__api_recharge_increase_bid_amount',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                        }

                        if($current_bid_price > $already_bid_price)
                        {
  
                            $bidCreate = BidDetails::create($bid_data);
                            if($bidCreate)
                            {
                                 TrackItem::create(['bid_id'=>$bidCreate->id,'item_status'=>'pending','updated_by_id'=>$request->login_user_id,'updated_by'=>'buyer',"update_date"=>date('Y-m-d'),"status_notes"=>"New bid placed by buyer on same product."]);
                            }
                            BidNotifications::create(['bid_id'=>$bidCreate->id]);
                            //notify seller about the bid accepted status
                            $bid = BidDetails::where('id',$bidCreate->id)->first();
                            $seller_id =   $bid->seller_id;
                            $sellerUser = $this->getUser($seller_id);
                            $seller_user_email = $sellerUser->email;

                                                    $to = $seller_user_email;
                                                    $title = __('core__api_bid_placed_title', [], $request->language_symbol);
                                                    $subject = __('core__api_bid_placed', [], $request->language_symbol);
                                                    $to_name = $sellerUser->name;
                                                    $body = __('core__api_bid_placed_email_body',[],$request->language_symbol);
                                                    sendMail($to, $to_name, $title, $subject, $body);

                                                    // for send noti data
                                                    $s_data['bid_id'] = $bid->id;
                                                    $s_data['user_id'] = $bid->seller_id;
                                                    $s_data['message'] = __('core__api_bid_placed_body',[],$request->language_symbol);
                                                    $s_data['flag'] = __('core__api_bid_placed', [], $request->language_symbol);

                                                    // save noti to bid_notis
                                                    $noti = new BidNoti();
                                                    $noti->bid_id = $bid->id;
                                                    $noti->type = 'BID_PLACED';
                                                    $noti->bid_noti_message = 'core__api_bid_placed';
                                                    $noti->is_read = 0;
                                                    $noti->added_date = Carbon::now();
                                                    $noti->save();
                                                    $this->sendBidNoti($s_data);
                            $bid->trackStatus = TrackItem::where('bid_id', $bid->id)->orderBy('id','desc')->get();
                            return responseDataApi($bid, $this->createdStatusCode, $this->successStatus); 

                        }

                       // return responseMsgApi(__('core__api_recharge_bid_already_exists',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                    }

                    else
                    {
                            $bidCreate = BidDetails::create($bid_data);
                             if($bidCreate)
                            {
                                 TrackItem::create(['bid_id'=>$bidCreate->id,'item_status'=>'pending','updated_by_id'=>$request->login_user_id,'updated_by'=>'buyer',"update_date"=>date('Y-m-d'),"status_notes"=>"Bid placed by buyer."]);
                            }
                            BidNotifications::create(['bid_id'=>$bidCreate->id]);
                            //notify seller about the bid accepted status
                            $bid = BidDetails::where('id',$bidCreate->id)->first();
                            $seller_id =   $bid->seller_id;
                            $sellerUser = $this->getUser($seller_id);
                            $seller_user_email = $sellerUser->email;

                                                    $to = $seller_user_email;
                                                    $title = __('core__api_bid_placed_title', [], $request->language_symbol);
                                                    $subject = __('core__api_bid_placed', [], $request->language_symbol);
                                                    $to_name = $sellerUser->name;
                                                    $body = __('core__api_bid_placed_body',[],$request->language_symbol);
                                                    sendMail($to, $to_name, $title, $subject, $body);

                                                    // for send noti data
                                                    $s_data['bid_id'] = $bid->id;
                                                    $s_data['user_id'] = $bid->seller_id;
                                                    $s_data['message'] = __('core__api_bid_placed_body',[],$request->language_symbol);
                                                    $s_data['flag'] = __('core__api_bid_placed', [], $request->language_symbol);

                                                    // save noti to bid_notis
                                                    $noti = new BidNoti();
                                                    $noti->bid_id = $bid->id;
                                                    $noti->type = 'BID_PLACED';
                                                    $noti->bid_noti_message = 'core__api_bid_placed';
                                                    $noti->is_read = 0;
                                                    $noti->added_date = Carbon::now();
                                                    $noti->save();
                                                    $this->sendBidNoti($s_data);
                        $bid->trackStatus = TrackItem::where('bid_id', $bid->id)->orderBy('id','desc')->get();
                        return responseDataApi($bid, $this->createdStatusCode, $this->successStatus); 
                    }
        
    }
   
    public function buy_it_now(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login_user_id' => 'required|exists:users,id',
            'recharge_timestamp' => 'required',
            'seller_user_id' => 'required|exists:users,id',
            'bid_price'=> 'required',
            'product_price' =>'required',
            'product_id'=>'required|exists:items,id',
            'product_title'=>'required'

        ]);

        if($request->language_symbol){
            $this->translator->setLocale($request->language_symbol);
            $validator->setTranslator($this->translator);
        }

        if ($validator->fails()) {
            return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
        }

          $buyerWallet = UserWallet::where('user_id',$request->login_user_id)->first();
                if (!$buyerWallet) {
                    //No wallet
                    $data = [];
                    $data['user_id'] = $request->login_user_id;
                    $data['currency'] = 'Fr.';
                    $data['wallet_balance'] = 0.00;
                    $data['recharge_date'] = $request->recharge_timestamp;
                    $userWalletCreate = UserWallet::create($data);
                     return responseMsgApi(__('core__api_recharge_not_enough_wallet',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                   // return responseMsgApi(__('core__api_recharge_no_wallet',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                     
                } else {


                    $category_commission_of_product = Category::join('items','items.category_id','=','categories.id')->where('items.id',$request->product_id)->first('categories.commission'); 

                        $commission = $category_commission_of_product['commission']/100;
                        $commission_amount = $commission * $request->bid_price;
                        $amount_paid = $request->bid_price - $commission_amount;
                        $amount_deducted = $request->bid_price + $commission_amount;

                    //old wallet 
                     $amount = $request->bid_price;
                    $current_balance = $buyerWallet->wallet_balance;
                    if($current_balance < $amount)
                    {
                        return responseMsgApi(__('core__api_recharge_not_enough_wallet',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                    }


                    $bidAlreadyThere = BidDetails::where('buyer_id',$request->login_user_id)->where('seller_id',$request->seller_user_id)->where('product_id',$request->product_id)->first();
                    if($bidAlreadyThere)
                    {
                        return responseMsgApi(__('core__api_recharge_bid_already_exists',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                    }

                    $bidAlreadyTherebyAnotherUser = BidDetails::where('product_id',$request->product_id)->where('seller_id',$request->seller_user_id)->first();
                    if($bidAlreadyTherebyAnotherUser && $bidAlreadyTherebyAnotherUser->bid_status == 'accepted')
                    {
                        return responseMsgApi(__('chatting__api_already_sold_out',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                    }
                   
                           
                    $remaining_amount = $current_balance - $amount_deducted;
                    $data = [];
                    $data['currency'] = 'Fr.';
                    $data['wallet_balance'] = $remaining_amount;
                    $data['recharge_date'] = $request->recharge_timestamp;
                    $updated = UserWallet::where('user_id', $request->login_user_id)->update($data);
                    
                    //wallet_log
                    if($updated)
                        {
                          
                            $userBuyerWallet = UserWallet::where('user_id',$request->login_user_id)->first();
                            $walletLog =WalletLog::create([
                                                "users_wallet_id"=>$userBuyerWallet->id,
                                                "amount_added"=>0.00,
                                                "amount_deducted"=>$amount_deducted,
                                                "currency"=>'Fr.',
                                                "old_balance"=>$current_balance,
                                                "add_date"=>$request->recharge_timestamp,
                                                "payment_type"=>"wallet_deduction",
                                                "log_type"=>"debit"
                                        ]);

                                // $category_commission_of_product = Category::join('items','items.category_id','=','categories.id')->where('items.id',$request->product_id)->first('categories.commission'); 

                                // $commission = $category_commission_of_product['commission']/100;
                                // $commission_amount = $commission * $request->bid_price;
                                // $amount_paid = $request->bid_price - $commission_amount;

                                $sellerWallet = UserWallet::where('user_id',$request->seller_user_id)->first();
                                if(!$sellerWallet)
                                {
                                    $data = [];
                                    $data['user_id'] = $request->seller_user_id;
                                    $data['currency'] = 'Fr.';
                                    $data['wallet_balance'] = $amount_paid;
                                    $data['recharge_date'] = $request->recharge_timestamp;
                                    $sellerWalletCreate = UserWallet::create($data);
                                }
                                else
                                {
                                    $s_data = [];
                                    $s_data['currency'] = 'Fr.';
                                    $s_data['wallet_balance'] = $sellerWallet->wallet_balance+$amount_paid;
                                    $s_data['recharge_date'] = $request->recharge_timestamp;
                                    $updatedSeller = UserWallet::where('id', $sellerWallet->id)->update($s_data);
                                }
                                


                            $bid_data =[
                                "buyer_id"=>$request->login_user_id,
                                "seller_id"=>$request->seller_user_id,
                                "bid_price"=>$amount,
                                "product_id"=>$request->product_id,
                                "product_price"=>$request->product_price,
                                "product_title"=>$request->product_title,
                                "bid_status"=>"accepted",
                                "bid_commission"=>$category_commission_of_product['commission'],
                                "amount_paid"=>$amount_paid,
                                "bid_created_at" =>Carbon::now()
                            ];
                            $bidCreate = BidDetails::create($bid_data);
                             if($bidCreate)
                            {
                                 TrackItem::create(['bid_id'=>$bidCreate->id,'item_status'=>'accepted','updated_by_id'=>$request->login_user_id,'updated_by'=>'buyer',"update_date"=>date('Y-m-d'),"status_notes"=>"But it now."]);
                                  $item_id = $request->product_id;
                                    $item = Item::find($item_id);
                                    $item->is_sold_out = 1;
                                    $item->updated_user_id = $request->seller_user_id;
                                    $item->update();
                            }
                             BidNotifications::create(['bid_id'=>$bidCreate->id]);
                            
                           // $userBuyerWallet->walletLog = WalletLog::where('users_wallet_id', $userBuyerWallet->id)->orderBy('id','desc')->get();

                            $userBuyerWallet->currentbidDetails = BidDetails::where('id', $bidCreate->id)->orderBy('id','desc')->first();
                            $userBuyerWallet->currentbidDetails->trackStatus = TrackItem::where('bid_id', $bidCreate->id)->orderBy('id','desc')->get();
                        }


                        return responseDataApi($userBuyerWallet, $this->createdStatusCode, $this->successStatus); 
                }

    }
    public function buy_it_now_stripe(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'login_user_id' => 'required|exists:users,id',
            'recharge_timestamp' => 'required',
            'seller_user_id' => 'required|exists:users,id',
            'bid_price'=> 'required',
            'product_price' =>'required',
            'product_id'=>'required|exists:items,id',
            'product_title'=>'required'

        ]);

        if($request->language_symbol){
            $this->translator->setLocale($request->language_symbol);
            $validator->setTranslator($this->translator);
        }

        if ($validator->fails()) {
            return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
        }

                    $bidAlreadyThere = BidDetails::where('buyer_id',$request->login_user_id)->where('seller_id',$request->seller_user_id)->where('product_id',$request->product_id)->first();
                    if($bidAlreadyThere)
                    {
                        return responseMsgApi(__('core__api_recharge_bid_already_exists',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                    }

                    $bidAlreadyTherebyAnotherUser = BidDetails::where('product_id',$request->product_id)->where('seller_id',$request->seller_user_id)->first();
                    if($bidAlreadyTherebyAnotherUser && $bidAlreadyTherebyAnotherUser->bid_status == 'accepted')
                    {
                        return responseMsgApi(__('chatting__api_already_sold_out',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                    }

                     $category_commission_of_product = Category::join('items','items.category_id','=','categories.id')->where('items.id',$request->product_id)->first('categories.commission'); 

                    $commission = $category_commission_of_product['commission']/100;
                    $commission_amount = $commission * $request->bid_price;
                    $amount_deducted= $request->bid_price + $commission_amount;
                    $amount_paid = $request->bid_price - $commission_amount;

                $payment_method = $this->stripePaymentMethod;
                $payment_method_nonce = explode('_', $request->payment_method_nonce);
                
                if ($payment_method_nonce[0] == 'tok') {
                    
                    try {
                        # set stripe test key
                        \Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
                        
                        $charge = \Stripe\Charge::create(array(
                            "amount"       => intval(round($amount_deducted*100)), 
                            "currency"    => trim('CHF'),
                            "source"      => $request->payment_method_nonce,
                            "description" => __('itemPromotion__api_order_desc',[],$request->language_symbol) . ' '
                        ));
                       
                        if ($charge->status == "succeeded") {
                            $stripe_result = 1;
                            $stripe_data = [];
                            $stripe_data['payment_type'] = 'charge';
                            $stripe_data['txn_id'] = $charge->id;
                            $stripe_data['payment_status'] = $charge->status;
                           
                        } else {
                            return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                        }
                    } catch (\Throwable $e) {
                        return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                    }
                } else if ($payment_method_nonce[0] == 'pm') {
                    try {
                        \Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));

                        $paymentIntent = \Stripe\PaymentIntent::create([
                            'payment_method' => $request->payment_method_nonce,
                            'amount' => intval(round($amount_deducted*100)), 
                            'currency' => trim('CHF'),
                            'confirmation_method' => 'manual',
                            'confirm' => true,
                             'return_url' => env('APP_URL')
                        ]);
                        if ($paymentIntent->status == "succeeded") {
                            $stripe_result = 1;
                            $stripe_data = [];
                            $stripe_data['payment_type'] = 'payment_indent';
                            $stripe_data['txn_id'] = $paymentIntent->id;
                            $stripe_data['payment_status'] = $paymentIntent->status; 
                            
                        } else {
                              \Log::info('not succedded');
                            return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                        }
                    } catch (\Throwable $e) {
                        \Log::info($e->getMessage());
                        return responseMsgApi(__('itemPromotion__api_stripe_transaction_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                    }
                }

                if ($stripe_result == 1) 
                {
                
                    
                                

                                $sellerWallet = UserWallet::where('user_id',$request->seller_user_id)->first();
                                if(!$sellerWallet)
                                {
                                    $data = [];
                                    $data['user_id'] = $request->seller_user_id;
                                    $data['currency'] = 'Fr.';
                                    $data['wallet_balance'] = $amount_paid;
                                    $data['recharge_date'] = $request->recharge_timestamp;
                                    $sellerWalletCreate = UserWallet::create($data);
                                }
                                else
                                {
                                    $s_data = [];
                                    $s_data['currency'] = 'Fr.';
                                    $s_data['wallet_balance'] = $sellerWallet->wallet_balance+$amount_paid;
                                    $s_data['recharge_date'] = $request->recharge_timestamp;
                                    $updatedSeller = UserWallet::where('id', $sellerWallet->id)->update($s_data);
                                }
                                
 

                            $bid_data =
                                        [
                                        "buyer_id"=>$request->login_user_id,
                                        "seller_id"=>$request->seller_user_id,
                                        "bid_price"=>$request->bid_price,
                                        "product_id"=>$request->product_id,
                                        "product_price"=>$request->product_price,
                                        "product_title"=>$request->product_title,
                                        "bid_status"=>"accepted",
                                        "bid_commission"=>$category_commission_of_product['commission'],
                                        "amount_paid"=>$amount_paid,
                                        "payment_type"=>'stripe',
                                        "bid_created_at" =>Carbon::now()
                                        ];

                           // \Log::info($bid_data);
                            $bidCreate = BidDetails::create($bid_data);
                            if($bidCreate)
                            {

                                $stripe_data['bid_details_id'] = $bidCreate->id;
                                BidStripeTransaction::create($stripe_data);
                                TrackItem::create(['bid_id'=>$bidCreate->id,'item_status'=>'accepted','updated_by_id'=>$request->login_user_id,'updated_by'=>'buyer',"update_date"=>date('Y-m-d'),"status_notes"=>"But it now."]);
                                    $item_id = $request->product_id;
                                    $item = Item::find($item_id);
                                    $item->is_sold_out = 1;
                                    $item->updated_user_id = $request->seller_user_id;
                                    $item->update();
                            }
                            BidNotifications::create(['bid_id'=>$bidCreate->id]);
                            
                           // $userBuyerWallet->walletLog = WalletLog::where('users_wallet_id', $userBuyerWallet->id)->orderBy('id','desc')->get();

                            $currentbidDetails = BidDetails::where('id', $bidCreate->id)->orderBy('id','desc')->first();
                            $currentbidDetails->trackStatus = TrackItem::where('bid_id', $bidCreate->id)->orderBy('id','desc')->get();
                    
                        return responseMsgApi(__('core__api_item_buy_message',[],$request->language_symbol), $this->okStatusCode, $this->successStatus); 
                       
                } 
               
    }
    
    public function seller_bid_accepted(Request $request)
    {
            $validator = Validator::make($request->all(), [
                // 'seller_user_id' => 'required|exists:users_wallet,user_id',
                'recharge_timestamp' => 'required',
                'bid_details_id'=> 'required|exists:bid_details,id',
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }

            $bidDetails = BidDetails::where('id', $request->bid_details_id)->first();

            $otherBidDetails = BidDetails::where('seller_id',$bidDetails->seller_id)->where('product_id',$bidDetails->product_id)->get();
            foreach($otherBidDetails as $otherBidDetail)
            {
                if($otherBidDetail->bid_status == 'accepted' || $otherBidDetail->bid_status == 'processing')
                {
                    return responseMsgApi(__('core__api_already_accepted_bid',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                }
            
            }
           
            $buyerWallet = UserWallet::where('user_id',$bidDetails->buyer_id)->first();
            if (!$buyerWallet) {
                    //No wallet
                    return responseMsgApi(__('core__api_recharge_no_wallet',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                     
            } else {
                
                $amount = $bidDetails->bid_price;
                $current_balance = $buyerWallet->wallet_balance;
                if($current_balance < $amount)
                {
                    /******************bid_payment_status will stay as default pending value*************/
                    $status_updated = BidDetails::where('id',$request->bid_details_id)->update(['bid_status'=>'processing']);
                      if($status_updated)
                            {
                                 TrackItem::create(['bid_id'=>$request->bid_details_id,'item_status'=>'processing','updated_by_id'=>$bidDetails->seller_id,'updated_by'=>'seller',"update_date"=>date('Y-m-d'),"status_notes"=>"Bid accepted but the payment is under processing as buyer has insufficient funds in wallet."]);
                            }
                    ///send notification to buyer to notify seller accepted and recharge the wallet otherwise bid will be pending for 48 hours only 
                      $buyer_id =   $bidDetails->buyer_id;
                        $buyerUser = $this->getUser($buyer_id);
                        $buyer_user_email = $buyerUser->email;

                                        $to = $buyer_user_email;
                                        $title = __('core__api_bid_processing_nofunds_title', [], $request->language_symbol);
                                        $subject = __('core__api_bid_processing_nofunds', [], $request->language_symbol);
                                        $to_name = $buyerUser->name;
                                        $body = __('core__api_bid_processing_nofunds_body',[],$request->language_symbol);
                                        sendMail($to, $to_name, $title, $subject, $body);

                                        // for send noti data
                                                    $s_data['bid_id'] = $bidDetails->id;
                                                    $s_data['user_id'] = $bidDetails->buyer_id;
                                                    $s_data['message'] = __('core__api_bid_processing_nofunds_body',[],$request->language_symbol);
                                                    $s_data['flag'] = __('core__api_bid_processing_nofunds', [], $request->language_symbol);

                                        // save noti to bid_notis
                                                    $noti = new BidNoti();
                                                    $noti->bid_id = $bidDetails->id;
                                                    $noti->type = 'BID_PROCESSING';
                                                    $noti->bid_noti_message = 'core__api_bid_processing_nofunds_body';
                                                    $noti->is_read = 0;
                                                    $noti->added_date = Carbon::now();
                                                    $noti->save();
                                                    $this->sendBidNoti($s_data);

                        
                        return responseMsgApi(__('core__api_recharge_not_enough_wallet_buyer',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
                }
                else
                {
                    /***************deduct buyer wallet on bid accepted*****************************/

                    $commission = $bidDetails->commission;
                    $commission_amount = $commission * $amount;
                    $amount_deducted= $amount + $commission_amount;
                    // $amount_paid = $request->bid_price - $commission_amount;

                    $remaining_amount = $current_balance - $amount_deducted;
                    $data = [];
                    $data['currency'] = 'Fr.';
                    $data['wallet_balance'] = $remaining_amount;
                    $data['recharge_date'] = $request->recharge_timestamp;
                    $updated = UserWallet::where('user_id', $bidDetails->buyer_id)->update($data);
                            $walletLog =WalletLog::create([
                                                "users_wallet_id"=>$buyerWallet->id,
                                                "amount_added"=>0.00,
                                                "amount_deducted"=>$amount_deducted,
                                                "currency"=>'Fr.',
                                                "old_balance"=>$current_balance,
                                                "add_date"=>$request->recharge_timestamp,
                                                "payment_type"=>"wallet_deduction",
                                                "log_type"=>"debit"
                                        ]);
                    /**************************************************************************** */

                    if($updated)
                    {
                        /********************notify buyer that their bid has been accepted by the seller ******/
                        $buyer_id =   $bidDetails->buyer_id;
                        $buyerUser = $this->getUser($buyer_id);
                        $buyer_user_email = $buyerUser->email;

                                $to = $buyer_user_email;
                                $title = __('core__api_bid_accepted_title', [], $request->language_symbol);
                                $subject = __('core__api_bid_accepted', [], $request->language_symbol);
                                $to_name = $buyerUser->name;
                                $body = __('core__api_bid_accepted_body',[],$request->language_symbol);
                                sendMail($to, $to_name, $title, $subject, $body);

                                        // for send noti data
                                                    $s_data['bid_id'] = $bidDetails->id;
                                                    $s_data['user_id'] = $bidDetails->buyer_id;
                                                    $s_data['message'] = __('core__api_bid_accepted_body',[],$request->language_symbol);
                                                    $s_data['flag'] = __('core__api_bid_accepted', [], $request->language_symbol);

                                        // save noti to bid_notis
                                                    $noti = new BidNoti();
                                                    $noti->bid_id = $bidDetails->id;
                                                    $noti->type = 'BID_ACCEPTED';
                                                    $noti->bid_noti_message = 'core__api_bid_accepted_body';
                                                    $noti->is_read = 0;
                                                    $noti->added_date = Carbon::now();
                                                    $noti->save();
                                                    $this->sendBidNoti($s_data);

                        /***************seller wallet onhold amount added *****************/
                        $payable_amount = $bidDetails->amount_paid;
                        $sellerWallet = UserWallet::where('user_id', $request->login_user_id)->first();

                            $s_data = [];
                            $s_data['user_id'] = $sellerWallet->user_id;
                            $s_data['currency'] = 'Fr.';
                            $s_data['wallet_balance'] = $sellerWallet->wallet_balance;
                            $s_data['amount_on_hold'] = $sellerWallet->amount_on_hold+$payable_amount;
                            $s_data['recharge_date'] = $request->recharge_timestamp;
                                            // $s_data['payment_type'] = "on_hold_amount_added"
                            $updatedSeller = UserWallet::where('id', $sellerWallet->id)->update($s_data);
                        //seller wallet_log
                            if($updatedSeller)
                            {
                                 $bidUpdated = BidDetails::where('id', $request->bid_details_id)->update(['bid_status'=>'accepted','bid_payment_status'=>'paid']); 
                                  if($bidUpdated)
                                    {
                                        TrackItem::create(['bid_id'=>$request->bid_details_id,'item_status'=>'accepted','updated_by_id'=>$bidDetails->seller_id,'updated_by'=>'seller',"update_date"=>date('Y-m-d'),"status_notes"=>"Bid accepted by seller , payment done."]);
                                    }
                                 $sameProductOtherBids = BidDetails::where('seller_id',$bidDetails->seller_id)->where('product_id',$bidDetails->product_id)->whereNotIn('id', [$request->bid_details_id])->get();
                                 foreach($sameProductOtherBids as $bid)
                                 {

                                    $s_updated  = BidDetails::where('id', $bid->id)->update(['bid_status'=>'declined','dispute_status_notes'=>"Seller accepted another buyer's bid"]);
                                    if($s_updated)
                                    {
                                        TrackItem::create(['bid_id'=>$bid->id,'item_status'=>'declined','updated_by_id'=>0,'updated_by'=>'admin',"update_date"=>date('Y-m-d'),"status_notes"=>"Bid auto declined as seller accepted another buyer's bid."]);
                                    }

                                        $buyer_id =   $bid->buyer_id;
                                        $buyerUser = $this->getUser($buyer_id);
                                        $buyer_user_email = $buyerUser->email;

                                        $to = $buyer_user_email;
                                        $title = __('core__api_bid_rejected_auto_title', [], $request->language_symbol);
                                        $subject = __('core__api_bid_rejected_auto', [], $request->language_symbol);
                                        $to_name = $buyerUser->name;
                                        $body = __('core__api_bid_rejected_auto_body',[],$request->language_symbol);
                                        sendMail($to, $to_name, $title, $subject, $body);

                                        // for send noti data
                                                    $data['bid_id'] = $bid->id;
                                                    $data['user_id'] = $bid->buyer_id;
                                                    $data['message'] = __('core__api_bid_rejected_auto_body',[],$request->language_symbol);
                                                    $data['flag'] = __('core__api_bid_rejected_auto', [], $request->language_symbol);

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
                                                            "add_date"=>$request->recharge_timestamp,
                                                            "payment_type"=>"on_hold_amount_added",
                                                            "log_type"=>"onhold_credit"
                                                            ]);
                                
                                                
                               // $sellerWallet->walletLog = WalletLog::where('users_wallet_id', $sellerWallet->id)->orderBy('id','desc')->get();

                                $sellerWallet->bidDetails = BidDetails::where('id', $request->bid_details_id)->orderBy('id','desc')->get();
                                $sellerWallet->bidDetails->trackStatus = TrackItem::where('bid_id',  $request->bid_details_id)->orderBy('id','desc')->get();

                                 return responseDataApi($sellerWallet, $this->createdStatusCode, $this->successStatus); 
                            }
                                     
                    } 
                }
            }
           
    }

     public function seller_rejects_bid(Request $request)
    {
         
            $validator = Validator::make($request->all(), [
                'recharge_timestamp' => 'required',
                'bid_details_id'=> 'required|exists:bid_details,id',
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }

             $bid_details = BidDetails::where('id', $request->bid_details_id)->first();
             if($bid_details->bid_status == 'accepted')
             {

                 return responseMsgApi(__('core__api_already_accepted_bid',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
           
             }
            $bidUpdated = BidDetails::where('id', $request->bid_details_id)->update(['bid_status'=>'declined']);   
            if($bidUpdated)
            {
                $bid = BidDetails::where('id', $request->bid_details_id)->first();

                    TrackItem::create(['bid_id'=>$request->bid_details_id,'item_status'=>'declined','updated_by_id'=>$bid->seller_id,'updated_by'=>'seller',"update_date"=>date('Y-m-d'),"status_notes"=>"Bid declined by the seller."]);

                //send notification to buyer from seller that the bid is rejected by the seller
                $buyer_id =   $bid->buyer_id;
                $buyerUser = $this->getUser($buyer_id);
                $buyer_user_email = $buyerUser->email;

                        $to = $buyer_user_email;
                        $title = __('core__api_bid_rejected_title', [], $request->language_symbol);
                        $subject = __('core__api_bid_rejected', [], $request->language_symbol);
                        $to_name = $buyerUser->name;
                        $body = __('core__api_bid_rejected_body',[],$request->language_symbol);
                        sendMail($to, $to_name, $title, $subject, $body);

                                        // for send noti data
                                                    $s_data['bid_id'] = $bid->id;
                                                    $s_data['user_id'] = $bid->buyer_id;
                                                    $s_data['message'] = __('core__api_bid_rejected_body',[],$request->language_symbol);
                                                    $s_data['flag'] = __('core__api_bid_rejected', [], $request->language_symbol);

                                        // save noti to bid_notis
                                                    $noti = new BidNoti();
                                                    $noti->bid_id = $bid->id;
                                                    $noti->type = 'BID_REJECTED';
                                                    $noti->bid_noti_message = 'core__api_bid_rejected_body';
                                                    $noti->is_read = 0;
                                                    $noti->added_date = Carbon::now();
                                                    $noti->save();
                                                    $this->sendBidNoti($s_data);


                $bidDetails = BidDetails::where('id', $request->bid_details_id)->first();
                 $bidDetails->trackStatus = TrackItem::where('bid_id',  $request->bid_details_id)->orderBy('id','desc')->get();
                return responseDataApi($bidDetails, $this->createdStatusCode, $this->successStatus); 

            }

        
    }

    public function raise_bid_dispute(Request $request)
    {
         $validator = Validator::make($request->all(), [
                'bid_details_id' => 'required|exists:bid_details,id',
                'dispute_type' => 'required|in:refund,exchange',
                'dispute_reason' => 'required',
                'dispute_images'=>'nullable|array'
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }
           
            $bid_details = BidDetails::where('id', $request->bid_details_id)
                                    ->first();

            if (!$bid_details) {
                    return responseMsgApi(__('core__api_recharge_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }
            if($bid_details->disputed_bid == 'yes')
            {
                    return responseMsgApi(__('core__api_recharge_bid_already_disputed',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }

            $update_data = [];

            $update_data['dispute_type'] = $request->dispute_type;
            $update_data['dispute_reason'] = $request->dispute_reason;
            $update_data['disputed_bid'] = 'yes';
            $update_data['dispute_status'] = 'received';
            
            
             $images_object =  new \stdClass();

            if($request->dispute_images)
            {
                if($request->hasFile('dispute_images'))
                {
                    foreach ($request->file('dispute_images') as $index => $file) {
                        $org_image = Image::make($file);
                            $fileName = newFileName($file);
                            if (!File::isDirectory(public_path() . $this->storage_upload_path)) {
                                   File::makeDirectory(public_path() . $this->storage_upload_path, 0777, true, true);
                               }
                        // $org_image = getimagesize($file);
                        $org_image->save(public_path() . $this->storage_upload_path . $fileName, 50);
                        $images_object->$index = $fileName;
                    }
                
                  $update_data['dispute_images'] = json_encode($images_object);
                }
                
            }

            

            $updated = BidDetails::where('id',$request->bid_details_id)->update($update_data);
 
            if($updated)
            {

                /*********** notify seller about the dispute raised by the buyer *************/
                $bid = BidDetails::where('id',$request->bid_details_id)->first();
                            $seller_id =   $bid->seller_id;
                            $sellerUser = $this->getUser($seller_id);
                            $seller_user_email = $sellerUser->email;

                                                    $to = $seller_user_email;
                                                    $title = __('core__api_bid_dispute_title', [], $request->language_symbol);
                                                    $subject = __('core__api_bid_dispute', [], $request->language_symbol);
                                                    $to_name = $sellerUser->name;
                                                    $body = __('core__api_bid_dispute_email_body',[],$request->language_symbol);
                                                    sendMail($to, $to_name, $title, $subject, $body);

                                                    // for send noti data
                                                    $s_data['bid_id'] = $request->bid_details_id;
                                                    $s_data['user_id'] = $seller_id;
                                                    $s_data['message'] = __('core__api_bid_dispute_body',[],$request->language_symbol);
                                                    $s_data['flag'] = __('core__api_bid_dispute', [], $request->language_symbol);

                                                    // save noti to bid_notis
                                                    $noti = new BidNoti();
                                                    $noti->bid_id = $request->bid_details_id;
                                                    $noti->type = 'DISPUTE_RAISED';
                                                    $noti->bid_noti_message = 'core__api_bid_dispute';
                                                    $noti->is_read = 0;
                                                    $noti->added_date = Carbon::now();
                                                    \Log::info('Dispute raised seller');
                                                    $noti->save();
                                                    \Log::info('Dispute data'); 
                                                    \Log::info($s_data);
                                                    $this->sendBidNoti($s_data);
                                                    
                $bid = [];
                
                $bid['message'] ="Claim request submitted successfully";
                 $bid['status'] = 'success';
                $bid_det = BidDetails::where('id',$request->bid_details_id)->first();
                $bid_det->dispute_images = json_decode($bid_det->dispute_images,true);
                $bid['bid_details'] = $bid_det;
                return responseDataApi($bid, $this->createdStatusCode, $this->successStatus);
            }
            else
            {
               
                return responseMsgApi(__('core__api_recharge_internal_server',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }

    }


    public function get_all_bid_details(Request $request)
    {
       
       $validator = Validator::make($request->all(), [
                'login_user_id' => 'required|exists:users,id',
                
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }
            
            
            if((BidDetails::where('buyer_id',$request->login_user_id)->orWhere('seller_id',$request->login_user_id)->count())==0)
            {
                   return responseMsgApi(__('core__api_recharge_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }

            // $bidDetails = BidDetails::where('buyer_id',$request->login_user_id)->orWhere('seller_id',$request->login_user_id)->where('bid_status','completed')->orderBy('id','desc')->get();
            $bidDetails = BidDetails::where(function ($query) use ($request) {
                    $query->where('buyer_id', $request->login_user_id)
                          ->orWhere('seller_id', $request->login_user_id);
                })
                ->whereIn('bid_status', ['completed', 'item_shipped', 'item_received','item_delivered','refunded','cancelled'])
                ->orderBy('id', 'desc')
                ->get();
             foreach($bidDetails as $bidDetail)
                {
                   $bidDetail->amount_paid = number_format($bidDetail->amount_paid,2);
                    if($bidDetail->dispute_images)
                    {
                        
                        if(count(json_decode($bidDetail->dispute_images,true))>0)
                        {
                            
                            $bidDetail->dispute_images = json_decode($bidDetail->dispute_images,true);
                        }
                    }
                    
                  $bidDetails->trackStatus = TrackItem::where('bid_id',  $bidDetail->id)->orderBy('id','desc')->get();
                }
            return responseDataApi($bidDetails, $this->createdStatusCode, $this->successStatus);   
    }


    public function disputed_refund_bid_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
                 'bid_id' => 'required|exists:bid_details,id',
                
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }
            
            $bid_details = BidDetails::where('id', $request->bid_id)
                                    ->first();
            if($bid_details)
            {                      
                if($bid_details->dispute_refund == 'yes')
                {
                    /*********************refund initiated ***********************/
                    $refund_tracking =   DisputeRefundTracking::where('bid_id',$request->bid_id)->get();
                    if($refund_tracking)
                    {
                        $bid_details->trackRefund = $refund_tracking;
                    }
                    else
                    {
                         $bid_details->trackRefund = [];
                    }
                    
                }
                else
                    {
                         $bid_details->trackRefund = [];
                    }
     
                 return responseDataApi($bid_details, $this->createdStatusCode, $this->successStatus); 
            }
            else
            {
                  return responseMsgApi(__('followUser__api_db_error',[],$request->language_symbol), $this->internalServerErrorStatusCode);
            }
    }

     public function update_bid_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'bid_details_id'=> 'required|exists:bid_details,id',
                    'bid_status'=>'required|in:item_received,item_shipped,item_delivered',
                    'updated_by'=>'required|in:buyer,seller'
                ]);

                if($request->language_symbol){
                    $this->translator->setLocale($request->language_symbol);
                    $validator->setTranslator($this->translator);
                }

                if ($validator->fails()) {
                    return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
                }

                //  $bid_details = BidDetails::where('id', $request->bid_details_id)->first();
                //  if($bid_details->bid_status)
                $bidUpdated = BidDetails::where('id', $request->bid_details_id)->update(['bid_status'=>$request->bid_status,'update_date_time'=>now()]);
                if($bidUpdated)
                {
                   // When the seller marks the item as "Shipped or Delivered," the buyer receives a notification that the product is on its way.
                    $bid = BidDetails::where('id', $request->bid_details_id)->first();
                     $get_id = $request->updated_by.'_id'; 
                     TrackItem::create(['bid_id'=>$request->bid_details_id,'item_status'=>$request->bid_status,'updated_by_id'=>$bid->$get_id,'updated_by'=>$request->updated_by,"update_date"=>date('Y-m-d'),"status_notes"=>"Bid status updated"]);
                     $buyer_id =   $bid->buyer_id;
                    $buyerUser = $this->getUser($buyer_id);
                    $buyer_user_email = $buyerUser->email;

                    $to = $buyer_user_email;
                    $to_name = $buyerUser->name;

                    // for send noti data
                       

                    if($bid->bid_status == 'item_shipped')
                    {
                         $s_data['bid_id'] = $bid->id;
                        $s_data['user_id'] = $bid->buyer_id;

                        $title = __('core__api_bid_item_shipped_title', [], $request->language_symbol);
                        $subject = __('core__api_bid_item_shipped', [], $request->language_symbol);
                        $body = __('core__api_bid_item_shipped_body',[],$request->language_symbol);

                        $s_data['message'] = __('core__api_bid_item_shipped_body',[],$request->language_symbol);
                        $s_data['flag'] = __('core__api_bid_item_shipped', [], $request->language_symbol);
                    }
                     if($bid->bid_status == 'item_delivered')
                    {
                         $s_data['bid_id'] = $bid->id;
                        $s_data['user_id'] = $bid->buyer_id;

                            $title = __('core__api_bid_item_delivered_title', [], $request->language_symbol);
                        $subject = __('core__api_bid_item_delivered', [], $request->language_symbol);
                        $body = __('core__api_bid_item_delivered_body',[],$request->language_symbol);

                        $s_data['message'] = __('core__api_bid_item_delivered_body',[],$request->language_symbol);
                        $s_data['flag'] = __('core__api_bid_item_delivered', [], $request->language_symbol);
                    }
                    if($bid->bid_status == 'item_received')
                    {
                         $s_data['bid_id'] = $bid->id;
                        $s_data['user_id'] = $bid->seller_id;

                            $title = __('core__api_bid_item_received_title', [], $request->language_symbol);
                        $subject = __('core__api_bid_item_received', [], $request->language_symbol);
                        $body = __('core__api_bid_item_received_body',[],$request->language_symbol);

                        $s_data['message'] = __('core__api_bid_item_received_body',[],$request->language_symbol);
                        $s_data['flag'] = __('core__api_bid_item_received', [], $request->language_symbol);
                    }
                    
                  
                        sendMail($to, $to_name, $title, $subject, $body);

                                        // save noti to bid_notis
                                                    $noti = new BidNoti();
                                                    $noti->bid_id = $bid->id;
                                                    $noti->type = 'BID_REJECTED';
                                                    $noti->bid_noti_message = 'core__api_bid_rejected_body';
                                                    $noti->is_read = 0;
                                                    $noti->added_date = Carbon::now();
                                                    $noti->save();
                                                    $this->sendBidNoti($s_data); 

                     return responseMsgApi(__('core__api_recharge_bid_updated',[],$request->language_symbol), $this->okStatusCode, $this->successStatus);

                }  
                else
                {
                    return responseMsgApi(__('core__api_recharge_bid_status_not_updated',[],$request->language_symbol), $this->okStatusCode,$this->errorStatus);
                }
    }

    /**************************************************************May 23 2024 ****************************************************************/

    public function get_buyer_bids_and_history(Request $request)
    {
         $validator = Validator::make($request->all(), [
                'login_user_id' => 'required|exists:users,id',   
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }
            
           // print_r(BidDetails::where('buyer_id',$request->login_user_id)->count());die;
            if((BidDetails::where('buyer_id',$request->login_user_id)->count())==0)
            {
                   return responseMsgApi(__('core__api_recharge_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }
            $itemApiRelation = ['category', 'cover', 'video', 'icon'];
           // $productIds = BidDetails::where('buyer_id',$request->login_user_id)->orderBy('id','desc')->pluck('product_id')->unique();
            $bidItems =  Item::when($itemApiRelation, function ($query, $itemApiRelation) {
                                    $query->with($itemApiRelation);
                                })
                                ->join('bid_details', 'items.id', '=', 'bid_details.product_id')
                                // ->join('track_items', 'track_items.id', '=', 'bid_details.id')
                                ->where('bid_details.buyer_id', $request->login_user_id)
                                ->groupBy('items.id')
                                ->selectRaw('items.*, COUNT(bid_details.id) as total_bids_on_product, MAX(bid_details.bid_price) as highest_bid_price')
                                ->get();
                 //bid_details.id as bid_id

            if(count($bidItems) == 0)
            {
                   return responseMsgApi(__('core__api_recharge_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }
            // $trackItems = \DB::table('track_items')->whereIn('id', $bidItems->pluck('bid_id'))->get();
            //     $trackItemsMap = $trackItems->keyBy('id');

            //     $bidItems->each(function ($item) use ($trackItemsMap) {
            //         $item->trackStatus = $trackItemsMap->get($item->bid_id);
            //     });
           
            return responseDataApi($bidItems, $this->createdStatusCode, $this->successStatus);  
    }
    /******************************************************************************************************************************************/



}
