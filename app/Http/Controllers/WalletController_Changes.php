<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Modules\Core\Constants\Constants;
use Modules\Payment\Http\Services\PaymentSettingService;
use Modules\Core\Http\Services\AvailableCurrencyService;
use App\Models\UserWallet;
use App\Models\WalletLog; 
use App\Models\BidDetails;
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

class WalletController extends Controller
{

    //D:\xampp\htdocs\Tinqui-Market-Place\Modules\Core\Http\Services\AvailableCurrencyService.php
    ///  $this->currencyIdCol = AvailableCurrency::id;
    protected $paystackPaymentMethod, $razorPaymentMethod, $paypalPaymentMethod, $stripePaymentMethod, $iapPaymentMethod, $paymentSettingService,
        $stripeSecretKey, $paypalPrivateKey, $paypalPublicKey, $paypalClientId, $paypalSecretKey, $paypalEnvironment,$paypalMerchantId,$createdStatusCode,$successStatus,$internalServerErrorStatusCode,$badRequestStatusCode,$translator,$okStatusCode,$errorStatus,$stripePublishableKey,$currencyIdCol,$imageService,$storage_upload_path,$img_folder_path;

    public function __construct(Translator $translator,PaymentSettingService $paymentSettingService,ImageService $imageService)
    {

         Mollie::api()->setApiKey('test_ndABcng3ASdH2x2pDH2A7SfuthHwUc'); 


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


    public function getFolderImagePath()
    {
        return $this->img_folder_path;
    }


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
            return responseMsgApi('core__api_recharge_amount_greater', $this->okStatusCode, $this->errorStatus);
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
                            "amount"       => intval(round($request->amount)), 
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
                            'amount' => intval(round($request->amount)*100), 
                            'currency' => trim('CHF'),
                            'confirmation_method' => 'manual',
                            'confirm' => true,
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
               $final_data = [];
                /*********insert into users_wallet table */
                $user = UserWallet::where('user_id',$request->login_user_id)->first();
                if (!$user) {
                                        //New wallet
                                            $data = [];
                                            $data['user_id'] = $request->login_user_id;
                                            $data['currency'] = 'Fr.';
                                            $data['wallet_balance'] = $charge->amount;
                                            $data['recharge_date'] = $request->recharge_timestamp;
                                            $userWalletCreate = UserWallet::create($data);
                                            if($userWalletCreate)
                                            {
                                                $walletLog =  WalletLog::create([
                                                    "users_wallet_id"=>$userWalletCreate->id,
                                                    "amount_added"=>$charge->amount,
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
                                        $amount = $charge->amount;
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

            }
      /*******************ends save data after the payment ************************/       
       return responseDataApi($final_data, $this->createdStatusCode, $this->successStatus);     
      // return $walletLog;
        //return responseDataApi($walletLog, $this->createdStatusCode, $this->successStatus);
         
                    // $payment = Mollie::api()->payments()->create([
                    //     'amount' => [
                    //         'currency' => 'CHF', 
                    //         'value' => $request->amount, 
                    //     ],
                    //     'description' => 'Tinqui Wallet Recharge', 
                    //     'redirectUrl' => \URL::route('payment.success'), 
                         
                    //     ]);
                         
                    //     $payment = Mollie::api()->payments()->get($payment->id);
                    //     // return redirect(, 303);
                    //   Session::put('payment_id',$payment->id);
                    //   Session::put('user_payment_id',$request->login_user_id);
                    //     $url['url'] = $payment->getCheckoutUrl();
                    //     return responseDataApi($url, $this->createdStatusCode, $this->successStatus);
                
    }


   
    
     public function paymentSuccess() {
     
         
        $payment_id = Session::get('payment_id');
        $user_id = Session::get('user_payment_id');
            $payment = Mollie::api()->payments->get($payment_id);

            if ($payment->isPaid())
            {
                /*******************save data after the payment ************************/

                                    /*********insert into users_wallet table */
                $user = UserWallet::where('user_id',$user_id)->first();
                if (!$user) {
                                        //New wallet
                                            $data = [];
                                            $data['user_id'] = $user_id;
                                            $data['currency'] = $payment->amount->currency;
                                            $data['wallet_balance'] = $payment->amount->value;
                                            $data['recharge_date'] = strtotime($payment->createdAt);
                                            $userWalletCreate = UserWallet::create($data);
                                            if($userWalletCreate)
                                            {
                                                $walletLog =  WalletLog::create([
                                                    "users_wallet_id"=>$userWalletCreate->id,
                                                    "amount_added"=>$payment->amount->value,
                                                    "amount_deducted"=>0.00,
                                                    "currency"=>'Fr.',
                                                    "old_balance"=>0,
                                                    "payment_type"=>$payment->method,
                                                    "payment_status"=>$payment->status,
                                                    "txn_id"=>$payment->id,
                                                    "paid_at"=>$payment->createdAt,
                                                    "log_type"=>"credit"
                                                ]);
                                                $userWallet = UserWallet::where('id', $userWalletCreate->id)->first();
                                                // $userWallet->walletLogData = WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                                                // $walletLog->status = 1;
                                            }
                                        
                } 
                else 
                {
                                        //old wallet
                                        $amount = $payment->amount->value;
                                        $old_amount = $user->wallet_balance;
                                        $new_amount = $old_amount+$amount;
                                        $data = [];
                                        $data['currency'] = $payment->amount->currency;
                                        $data['wallet_balance'] = $new_amount;
                                        $data['recharge_date'] = strtotime($payment->createdAt);
                                        $updated = UserWallet::where('id', $user->id)->update($data);
                                        //wallet_log
                                        if($updated)
                                            {
                                                $userWallet = UserWallet::where('id', $user->id)->first();
                                                $walletLog =WalletLog::create([
                                                                    "users_wallet_id"=>$userWallet->id,
                                                                    "amount_added"=>$payment->amount->value,
                                                                    "amount_deducted"=>0.00,
                                                                    "currency"=>$payment->amount->currency,
                                                                    "old_balance"=>$old_amount,
                                                                    "payment_type"=>$payment->method,
                                                                    "payment_status"=>$payment->status,
                                                                    "txn_id"=>$payment->id,
                                                                    "paid_at"=>$payment->createdAt,
                                                                    "log_type"=>"credit"
                                                            ]);
                                                //  $userWallet->walletLogData =WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                                                    // $walletLog->status = 1;
                                        
                                            }
                }

                 /*******************ends save data after the payment ************************/       
              //  return responseDataApi($userWallet, $this->createdStatusCode, $this->successStatus); 

              Session::forget('payment_id');
              Session::forget('user_payment_id');
              return redirect()->route('fe_payment_done');   

            }
            else if($payment->isFailed() || $payment->isExpired() || $payment->isCanceled())
            {
                Session::forget('payment_id');
                Session::forget('user_id');
                return redirect()->route('fe_payment_failed');   
                // return responseMsgApi('Payment Failed', $this->okStatusCode, $this->errorStatus);
            }
        
    }

    public function webHookUrl(Request $request, $user_id)
    {
       
        if (! $request->has('id')) {
           return redirect()->route('fe_payment_failed');
        }
    
         $payment = Mollie::api()->payments->get($request->id);
        
          if ($payment->isPaid())
            {
                 /*******************save data after the payment************************/

                                    /*********insert into users_wallet table */
                $user = UserWallet::where('user_id',$user_id)->first();
                if (!$user) {
                                        //New wallet
                                            $data = [];
                                            $data['user_id'] = $user_id;
                                            $data['currency'] = $payment->amount->currency;
                                            $data['wallet_balance'] = $payment->amount->value;
                                            $data['recharge_date'] = strtotime($payment->createdAt);
                                            $userWalletCreate = UserWallet::create($data);
                                            if($userWalletCreate)
                                            {
                                                $walletLog =  WalletLog::create([
                                                    "users_wallet_id"=>$userWalletCreate->id,
                                                    "amount_added"=>$payment->amount->value,
                                                    "amount_deducted"=>0.00,
                                                    "currency"=>'Fr.',
                                                    "old_balance"=>0,
                                                    "payment_type"=>$payment->method,
                                                    "payment_status"=>$payment->status,
                                                    "txn_id"=>$payment->id,
                                                    "paid_at"=>$payment->createdAt,
                                                    "log_type"=>"credit"
                                                ]);
                                             //   $userWallet = UserWallet::where('id', $userWalletCreate->id)->first();
                                              //   $userWallet->walletLogData = WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                                                // $walletLog->status = 1;
                                            }
                                        
                } 
                else 
                {
                                        //old wallet
                                        $amount = $payment->amount->value;
                                        $old_amount = $user->wallet_balance;
                                        $new_amount = $old_amount+$amount;
                                        $data = [];
                                        $data['currency'] = $payment->amount->currency;
                                        $data['wallet_balance'] = $new_amount;
                                        $data['recharge_date'] = strtotime($payment->createdAt);
                                        $updated = UserWallet::where('id', $user->id)->update($data);
                                        //wallet_log
                                        if($updated)
                                            {
                                                $userWallet = UserWallet::where('id', $user->id)->first();
                                                $walletLog =WalletLog::create([
                                                                    "users_wallet_id"=>$userWallet->id,
                                                                    "amount_added"=>$payment->amount->value,
                                                                    "amount_deducted"=>0.00,
                                                                    "currency"=>$payment->amount->currency,
                                                                    "old_balance"=>$old_amount,
                                                                    "payment_type"=>$payment->method,
                                                                    "payment_status"=>$payment->status,
                                                                    "txn_id"=>$payment->id,
                                                                    "paid_at"=>$payment->createdAt,
                                                                    "log_type"=>"credit"
                                                            ]);
                                                  //$userWallet->walletLogData =WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                                                    // $walletLog->status = 1;
                                        
                                            }
              
            }
            
               // Session::put('payment_status',)
            }
            else
            {
                // return redirect()->route('fe_payment_failed');
            }
       //$this->check_mollie_status($payment->status,$userWallet);
    }
    
    public function paymentSuccessMobile(Request $request)
    {
        
        return redirect()->route('fe_payment_done');  
        
    }

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
            return responseMsgApi('core__api_recharge_amount_greater', $this->okStatusCode, $this->errorStatus);
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
                                            $data['wallet_balance'] = $paymentIntent->amount;
                                            $data['recharge_date'] = $request->recharge_timestamp;
                                            $userWalletCreate = UserWallet::create($data);
                                            if($userWalletCreate)
                                            {
                                                $walletLog =  WalletLog::create([
                                                    "users_wallet_id"=>$userWalletCreate->id,
                                                    "amount_added"=>$paymentIntent->amount,
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
                                            $userWallet->message = "Recharge Successfull";
                                            }
                                        
                } 
                else 
                {
                                        //old wallet
                                        $amount = $paymentIntent->amount;
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
                                            $userWallet->message = "Recharge Successfull";

                                                    // $walletLog->status = 1;
                                        
                                            }
              
                }

            }
      /*******************ends save data after the payment ************************/       
       return responseDataApi($userWallet, $this->createdStatusCode, $this->successStatus);

        //    try
        //    {
        //             $payment = Mollie::api()->payments()->create([
        //                 'amount' => [
        //                     'currency' => 'CHF', 
        //                     'value' => $request->amount, 
        //                 ],
        //                 'description' => 'Tinqui Wallet Recharge', 
        //                 'redirectUrl' => \URL::route('payment.success.mobile'), 
        //                 'webhookUrl' => \URL::route('mollie.webhook', ['user_id' => $request->login_user_id])
        //                 ]);
                    
        //                 $payment = Mollie::api()->payments()->get($payment->id);
        //                 // return redirect(, 303);
                      
                  
        //                 $url['url'] = $payment->getCheckoutUrl();
        //                 return responseDataApi($url, $this->createdStatusCode, $this->successStatus);
        //     }
        //     catch(\Exception $e)
        //     {
        //         $msg = $e->getMessage();
        //          return responseMsgApi($msg , $this->okStatusCode, $this->errorStatus);
               
        //     }
    }
    
    public function check_mollie_status($payment_status = "",$wallet_details = null)
    {
           if($payment_status != '')
           {
               $data = [
                        'message' => 'Payment is successfull',
                        'status' => 'success',
                        'payment_status'=>$payment_status,
                        'data'=>$wallet_details ? $wallet_details:"",
                    ];
              
              return responseDataApi($data, $this->createdStatusCode, $this->successStatus);
           }
           else
           {
               $data = [
                        'message' => 'No Data',
                        'status' => 'error',
                        'payment_status'=>"",
                        'data'=>[],
                    ];
                    
                return responseDataApi($data, $this->okStatusCode, $this->errorStatus);
           }
           
          // return response()->json($data);
       
    }

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

                    $bidAlreadyThere = BidDetails::where('buyer_id',$request->login_user_id)->where('seller_id',$request->seller_user_id)->where('product_id',$request->product_id)->first();
                    if($bidAlreadyThere)
                    {
                        return responseMsgApi('core__api_recharge_bid_already_exists', $this->okStatusCode, $this->errorStatus);
                    }

            $commission = 0.08;
            $commission_amount = $commission * $request->bid_price;
            $amount_paid = $request->bid_price - $commission_amount;
             $bid_data =[
                                                "buyer_id"=>$request->login_user_id,
                                                "seller_id"=>$request->seller_user_id,
                                                "bid_price"=>$request->bid_price,
                                                "product_id"=>$request->product_id,
                                                "product_price"=>$request->product_price,
                                                "product_title"=>$request->product_title,
                                                "bid_status"=>"pending",
                                                "amount_paid"=>$amount_paid,
                        ];
                            $bidCreate = BidDetails::create($bid_data);


                        return responseDataApi($bidCreate, $this->createdStatusCode, $this->successStatus); 

        
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
                    return responseMsgApi('core__api_recharge_no_wallet', $this->okStatusCode, $this->errorStatus);
                     
                } else {
                    //old wallet
                    $bidAlreadyThere = BidDetails::where('buyer_id',$request->login_user_id)->where('seller_id',$request->seller_user_id)->where('product_id',$request->product_id)->first();
                    if($bidAlreadyThere)
                    {
                        return responseMsgApi('core__api_recharge_bid_already_exists', $this->okStatusCode, $this->errorStatus);
                    }

                    $amount = $request->bid_price;
                    $current_balance = $buyerWallet->wallet_balance;
                    if($current_balance < $amount)
                    {
                        return responseMsgApi('core__api_recharge_not_enough_wallet', $this->okStatusCode, $this->errorStatus);
                    }
                           
                    $remaining_amount = $current_balance-$amount;
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
                                                "amount_deducted"=>$request->bid_price,
                                                "currency"=>'Fr.',
                                                "old_balance"=>$current_balance,
                                                "add_date"=>$request->recharge_timestamp,
                                                "payment_type"=>"wallet_deduction",
                                                "log_type"=>"debit"
                                        ]);

                $commission = 0.08;
                $commission_amount = $commission * $request->bid_price;
                $amount_paid = $request->bid_price - $commission_amount;
                $bid_data =[
                                                "buyer_id"=>$request->login_user_id,
                                                "seller_id"=>$request->seller_user_id,
                                                "bid_price"=>$request->bid_price,
                                                "product_id"=>$request->product_id,
                                                "product_price"=>$request->product_price,
                                                "product_title"=>$request->product_title,
                                                "bid_status"=>"accepted",
                                                "amount_paid"=>$amount_paid,
                        ];
                            $bidCreate = BidDetails::create($bid_data);
                            
                            $userWallet->walletLog = WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();

                            $userWallet->bidDetails = BidDetails::where('id', $bidCreate->id)->orderBy('id','desc')->first();
                             
                        }


                        return responseDataApi($userWallet, $this->createdStatusCode, $this->successStatus); 
                }

    }

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
                    return responseMsgApi('core__api_recharge_no_wallet', $this->okStatusCode, $this->errorStatus);
                     
                } else {
                    //old wallet
                    $bidAlreadyThere = BidDetails::where('buyer_id',$request->login_user_id)->where('seller_id',$request->seller_user_id)->where('product_id',$request->product_id)->first();
                    if($bidAlreadyThere)
                    {
                        return responseMsgApi('core__api_recharge_bid_already_exists', $this->okStatusCode, $this->errorStatus);
                    }

                    $amount = $request->bid_price;
                    $current_balance = $buyerWallet->wallet_balance;
                    if($current_balance < $amount)
                    {
                        return responseMsgApi('core__api_recharge_not_enough_wallet', $this->okStatusCode, $this->errorStatus);
                    }
                           
                    $remaining_amount = $current_balance-$amount;
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
                                                "amount_deducted"=>$request->bid_price,
                                                "currency"=>'Fr.',
                                                "old_balance"=>$current_balance,
                                                "add_date"=>$request->recharge_timestamp,
                                                "payment_type"=>"wallet_deduction",
                                                "log_type"=>"debit"
                                        ]);

                $commission = 0.08;
                $commission_amount = $commission * $request->bid_price;
                $amount_paid = $request->bid_price - $commission_amount;
                $bid_data =[
                                                "buyer_id"=>$request->login_user_id,
                                                "seller_id"=>$request->seller_user_id,
                                                "bid_price"=>$request->bid_price,
                                                "product_id"=>$request->product_id,
                                                "product_price"=>$request->product_price,
                                                "product_title"=>$request->product_title,
                                                "bid_status"=>"pending",
                                                "amount_paid"=>$amount_paid,
                        ];
                            $bidCreate = BidDetails::create($bid_data);
                            
                            $userWallet->walletLog = WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();

                            $userWallet->bidDetails = BidDetails::where('id', $bidCreate->id)->orderBy('id','desc')->first();
                             
                        }


                        return responseDataApi($userWallet, $this->createdStatusCode, $this->successStatus); 
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

             
            $bidUpdated = BidDetails::where('id', $request->bid_details_id)->update(['bid_status'=>'accepted']);   
            if($bidUpdated)
            {
                    
                $bidDetails = BidDetails::where('id', $request->bid_details_id)->first();
                $payable_amount = $bidDetails->amount_paid;

                $sellerWallet = UserWallet::where('user_id', $request->login_user_id)->first();

                                            $s_data = [];
                                            $s_data['user_id'] = $request->login_user_id;
                                            $s_data['currency'] = 'Fr.';
                                            $s_data['wallet_balance'] = $sellerWallet->wallet_balance;
                                            $s_data['amount_on_hold'] = $sellerWallet->amount_on_hold+$payable_amount;
                                            $s_data['recharge_date'] = $request->recharge_timestamp;
                                            // $s_data['payment_type'] = "on_hold_amount_added"
                                            $updatedSeller = UserWallet::where('id', $sellerWallet->id)->update($s_data);
                                            //wallet_log
                                            if($updatedSeller)
                                                {
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
                                                
                                                $sellerWallet->walletLog = WalletLog::where('users_wallet_id', $sellerWallet->id)->orderBy('id','desc')->get();

                                                $sellerWallet->bidDetails = BidDetails::where('id', $request->bid_details_id)->orderBy('id','desc')->get();
                                            
                                                }

                    return responseDataApi($sellerWallet, $this->createdStatusCode, $this->successStatus); 
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

             
            $bidUpdated = BidDetails::where('id', $request->bid_details_id)->update(['bid_status'=>'declined']);   
            if($bidUpdated)
            {
                $bid_details = BidDetails::where('id', $request->bid_details_id)->first();
                $refund_amount = $bid_details->bid_price;


                $buyerWallet = UserWallet::where('user_id', $bid_details->buyer_id)->first();

                                            $b_data = [];
                                            $b_data['currency'] = 'Fr.';
                                            $b_data['wallet_balance'] = $buyerWallet->wallet_balance+$refund_amount;
                                            $b_data['recharge_date'] = $request->recharge_timestamp;

                $updatedBuyer = UserWallet::where('id', $buyerWallet->id)->update($b_data);
                if($updatedBuyer)
                {


                    $updatedBuyerwalletLog =WalletLog::create([
                                                                "users_wallet_id"=>$buyerWallet->id,
                                                                "amount_added"=>$refund_amount,
                                                                "currency"=>'Fr.',
                                                                "old_balance"=>$buyerWallet->wallet_balance,
                                                                "add_date"=>$request->recharge_timestamp,
                                                                "payment_type"=>"refund_added",
                                                                "log_type"=>"credit"
                                                                ]);
                                                
                        $buyerWallet->walletLog = WalletLog::where('users_wallet_id', $buyerWallet->id)->orderBy('id','desc')->get();

                        $buyerWallet->bidDetails = BidDetails::where('id', $request->bid_details_id)->orderBy('id','desc')->get();

                        
                }

                    return responseDataApi($buyerWallet, $this->createdStatusCode, $this->successStatus); 

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
               return responseMsgApi('core__api_recharge_user_not_found', $this->okStatusCode, $this->errorStatus);
          }

           $bidUpdated = BidDetails::where('id', $request->bid_details_id)->update(['bid_status'=>'completed','update_date_time'=>now()]); 

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
                            $userWallet->walletLog = WalletLog::where('users_wallet_id', $userWallet->id)->orderBy('id','desc')->get();
                             
                            $userWallet->bidDetails = BidDetails::where('id', $request->bid_details_id)->orderBy('id','desc')->first();
                    
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
                'bank_name'=> 'required',
                'bank_code'=> 'required',
                'branch_name'=> 'required',
                'account_number'=> 'required',
                'account_name'=> 'required',
                'address'=> 'nullable',
                'country'=> 'nullable',
                "request_date"=>'required|date_format:Y-m-d H:i:s',
                "timestamp"=>'required'
            ]);

            if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }

             
            $requestAlreadyExists = WalletWithdrawalRequest::where('user_id', $request->login_user_id)->whereNotIn('withdraw_status', ['completed', 'declined'])->first();   
            // if($requestAlreadyExists)
            // {
            //     return responseMsgApi('You already have a withdrawal request under process', $this->badRequestStatusCode, $this->errorStatus);
            // }
            // else
            // {
                 $userWallet = UserWallet::where('user_id', $request->login_user_id)->first();
                 if(!$userWallet)
                {
                     return responseMsgApi('core__api_recharge_no_wallet', $this->okStatusCode, $this->errorStatus);
                }
                                            $data = [];
                                            $data['user_id'] = $request->login_user_id;
                                            $data['currency'] = 'Fr.';
                                            $data['withdraw_amount'] = $request->withdraw_amount;
                                            $data['bank_name'] = $request->bank_name;
                                            $data['bank_code'] = $request->bank_code;
                                            $data['branch_name'] = $request->branch_name;
                                            $data['account_number'] = $request->account_number;
                                            $data['account_name'] = $request->account_name;
                                            $data['address'] = $request->address;
                                            $data['country'] = $request->country;
                                            $data['request_date'] = $request->request_date;
                                        


                                    if($request->withdraw_amount <= 2000)
                                    {
                                        $data['withdraw_status'] = 'accepted';

                                        /*****add money to user account using Mollie */
                                        $stripe = new \Stripe\StripeClient(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
                                                  $account = $stripe->accounts->create();
                                                $account_link = $stripe->accountLinks->create([
                                                                'account' => $account->id,
                                                                'return_url' => sprintf("https://tinqui.ch/withdraw", $account->id),
                                                                'refresh_url' => sprintf("https://tinqui.ch/withdraw", $account->id),
                                                                'type' => 'account_onboarding',
                                                            ]);

                                                            
                                                 
                                        
                                        /*************add money ends here */

                                    }
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
                                                "log_type"=>"debit"
                                        ]);
                                    $request = WalletWithdrawalRequest::where('id',$createdRequest->id)->first();
                                //     $request->url = $account_link->url;
                                //     array_push($final_data,$request);
                                $final_data['url'] = $account_link->url;
                                    return responseDataApi($final_data, $this->createdStatusCode, $this->successStatus); 
                                }        
           // }
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
                 return responseDataApi($allRequests, $this->createdStatusCode, $this->successStatus); 
           }
           else
           {
                return responseMsgApi('core__api_recharge_no_withdrawals', $this->okStatusCode, $this->errorStatus);
           }
           

    }
    
    /****************************withdrawal API ends here**********************/


    /****************************refund amount API March8********************/
    public function refund_amount(Request $request)
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

                
                $bidUpdated = BidDetails::where('id', $request->bid_details_id)->update(['bid_status'=>'refunded']);   
                if($bidUpdated)
                {
                    $bid_details = BidDetails::where('id', $request->bid_details_id)->first();
                    $refund_amount = $bid_details->bid_price;
                    $onhold_amount = $bid_details->amount_paid;


                    $buyerWallet = UserWallet::where('user_id', $bid_details->buyer_id)->first();
                

                        $b_data = [];
                        $b_data['currency'] = 'Fr.';
                        $b_data['wallet_balance'] = $buyerWallet->wallet_balance+$refund_amount;
                        $b_data['recharge_date'] = $request->recharge_timestamp;

                    $updatedBuyer = UserWallet::where('id', $buyerWallet->id)->update($b_data);
                    if($updatedBuyer)
                    {

                        $sellerWallet = UserWallet::where('user_id', $bid_details->seller_id)->first();
                        $s_data = [];
                        $s_data['currency'] = 'Fr.';
                        $s_data['amount_on_hold'] = $sellerWallet->amount_on_hold - $onhold_amount;
                        $s_data['recharge_date'] = $request->recharge_timestamp;
                        $updatedSeller = UserWallet::where('id', $sellerWallet->id)->update($s_data);
                        if($updatedSeller)
                        {
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
                                                    
                            $buyerWallet->walletLog = WalletLog::where('users_wallet_id', $buyerWallet->id)->orderBy('id','desc')->get();

                            $buyerWallet->bidDetails = BidDetails::where('id', $request->bid_details_id)->orderBy('id','desc')->get();

                            
                    }

                        return responseDataApi($buyerWallet, $this->createdStatusCode, $this->successStatus); 

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
                   return responseMsgApi('core__api_recharge_no_bids', $this->okStatusCode, $this->errorStatus);
            }

            $bidDetails = BidDetails::where('seller_id',$request->login_user_id)->orderBy('id','desc')->get();
                foreach($bidDetails as $bidDetail)
                {
                   $bidDetail->amount_paid = number_format($bidDetail->amount_paid,2);
                }
            return responseDataApi($bidDetails, $this->createdStatusCode, $this->successStatus);   
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
                   return responseMsgApi('core__api_recharge_no_bids', $this->okStatusCode, $this->errorStatus);
            }

            // $bidDetails = BidDetails::where('buyer_id',$request->login_user_id)->orWhere('seller_id',$request->login_user_id)->where('bid_status','completed')->orderBy('id','desc')->get();
            $bidDetails = BidDetails::where(function ($query) use ($request) {
                    $query->where('buyer_id', $request->login_user_id)
                          ->orWhere('seller_id', $request->login_user_id);
                })
                ->whereIn('bid_status', ['completed', 'item_shipped', 'item_received','refunded','cancelled'])
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
                    
                
                }
            return responseDataApi($bidDetails, $this->createdStatusCode, $this->successStatus);   
    }

    public function get_seller_bid_details(Request $request)
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
                   return responseMsgApi('core__api_recharge_no_bids', $this->okStatusCode, $this->errorStatus);
            }

            $bidDetails = BidDetails::where('buyer_id',$request->login_user_id)->orderBy('id','desc')->get();

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
                    return responseMsgApi('core__api_recharge_no_bids', $this->okStatusCode, $this->errorStatus);
            }

                    return responseDataApi($bid_details, $this->createdStatusCode, $this->successStatus);

          
    }


    public function update_bid_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
                    'bid_details_id'=> 'required|exists:bid_details,id',
                ]);

                if($request->language_symbol){
                    $this->translator->setLocale($request->language_symbol);
                    $validator->setTranslator($this->translator);
                }

                if ($validator->fails()) {
                    return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
                }

                
                $bidUpdated = BidDetails::where('id', $request->bid_details_id)->update(['bid_status'=>'item_received','update_date_time'=>now()]);
                if($bidUpdated)
                {
                     return responseMsgApi('core__api_recharge_bid_updated', $this->okStatusCode, $this->successStatus);

                }  
                else
                {
                    return responseMsgApi('core__api_recharge_bid_status_not_updated', $this->okStatusCode,$this->errorStatus);
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
                    return responseMsgApi('core__api_recharge_no_bids', $this->okStatusCode, $this->errorStatus);
            }
            if($bid_details->disputed_bid == 'yes')
            {
                    return responseMsgApi('core__api_recharge_bid_already_disputed', $this->okStatusCode, $this->errorStatus);
            }

            $update_data = [];

            $update_data['dispute_type'] = $request->dispute_type;
            $update_data['dispute_reason'] = $request->dispute_reason;
            $update_data['disputed_bid'] = 'yes';
            $update_data['dispute_status'] = 'received';
            
            
             $images_object =  new \stdClass();
           
            // if($request->hasFile('dispute_images'))
            // {
            //     $files = $request->file('dispute_images');
            //     foreach ($files as $index =>$file) {
            //         $org_image = Image::make($file);
            //             $fileName = newFileName($file);
            //             if (!File::isDirectory(public_path() . $this->storage_upload_path)) {
            //                   File::makeDirectory(public_path() . $this->storage_upload_path, 0777, true, true);
            //               }
            //         // $org_image = getimagesize($file);
            //         $org_image->save(public_path() . $this->storage_upload_path . $fileName, 50);
            //         $images_object->$index = $fileName;
                        
            //     }
            // }
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
               
                return responseMsgApi('core__api_recharge_internal_server', $this->okStatusCode, $this->errorStatus);
            }

    }

  

}
