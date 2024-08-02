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
use App\Models\WalletWithdrawalRequest; 
use App\Models\StripeConnectDetails;
use App\Models\BidStripeTransaction;
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


use Stripe\Exception\SignatureVerificationException;
use Illuminate\Support\Facades\Log;

class StripeConnectController extends Controller
{
     protected $paystackPaymentMethod, $razorPaymentMethod, $paypalPaymentMethod, $stripePaymentMethod, $iapPaymentMethod, $paymentSettingService,
        $stripeSecretKey, $paypalPrivateKey, $paypalPublicKey, $paypalClientId, $paypalSecretKey, $paypalEnvironment,$paypalMerchantId,$createdStatusCode,$successStatus,$internalServerErrorStatusCode,$badRequestStatusCode,$translator,$okStatusCode,$errorStatus,$stripePublishableKey,$currencyIdCol,$imageService,$storage_upload_path,$img_folder_path,$pushNotificationTokenService,$userService;
    public function __construct(Translator $translator,PaymentSettingService $paymentSettingService,ImageService $imageService,PushNotificationTokenService $pushNotificationTokenService,UserService $userService)
    {
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
        
    }
    
    public function stripe_connect_payments(Request $request)
    {
         $logged_in_user = $request->login_user_id;
         $stripe_account_details =  StripeConnectDetails::where('user_id',$logged_in_user)->first();
         $stripe = new \Stripe\StripeClient(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
          //\Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
          try {

                        $account_session =  $stripe->accountSessions->create([
                            'account' => $stripe_account_details->stripe_connect_account_id,
                            'components' => [
                                    'payments' => [
                                        'enabled' => true,
                                        'features' => [
                                        'refund_management' => false,
                                       // 'dispute_management' => true,
                                        'capture_payments' => true,
                                        'destination_on_behalf_of_charge_management' => false,
                                        ],
                                      ],
                            ],
                        ]);  

                    //    print_r($account_session); tinqui.ch/stripe_connect_webhook
                        $data['account_id'] =$stripe_account_details->stripe_connect_account_id;
                        $data['client_secret'] =$account_session->client_secret;
                        $data['onboarding_status'] =$stripe_account_details->onboarding_status;
                        $data['charges_enabled'] =$stripe_account_details->charges_enabled;
                        $data['payouts_enabled'] =$stripe_account_details->payouts_enabled;
                        $data['transfers_enabled'] =$stripe_account_details->transfers_enabled;
                        // $loginLink = \Stripe\Account::createLoginLink($stripe_account_details->stripe_connect_account_id);
                        // $data['client_secret'] = $loginLink->url;

                        return responseDataApi($data, $this->createdStatusCode, $this->successStatus);

                        } catch (Exception $e) {

                            //echo json_encode(['error' => $e->getMessage()]);
                               return responseMsgApi(__('api_stripe_create_session_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                        }

    }
    public function stripe_connect_dashboard(Request $request)
    { 
         $logged_in_user = $request->login_user_id;
        
         $stripe = new \Stripe\StripeClient(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
          //\Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
         
                     $stripe_account_details =  StripeConnectDetails::where('user_id',$logged_in_user)->first();
                            if($stripe_account_details)
                            {
                                $accountId = $stripe_account_details->stripe_connect_account_id;
                            }
                            else
                            {
                                /***********no stripe connect account created for the user yet**************/
                                $user = User::find($request->login_user_id);
                                    $username = explode(' ',$user->name);
                                    if(count($username) > 1)
                                    {
                                        $user_lastname = $username[1];
                                    }
                                    else
                                    {
                                        $user_lastname = 'Doe';
                                    }
                                                
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
                                                        ]);
                                                        $accountId = $account->id;
                                                        //store the account id in database
                                                        StripeConnectDetails::create(['user_id'=>$request->login_user_id,'stripe_connect_account_id'=>$accountId]);
                                    }
                                    catch (\Exception $e) {
                                        return responseMsgApi($e->getMessage(), $this->internalServerErrorStatusCode);
                                    }
                            }
                     
                        if($accountId)
                        {
                            try {
                        
                                        $account_session =  $stripe->accountSessions->create([
                                            'account' => $accountId,
                                            'components' => [
                                            'account_management' => [
                                                    'enabled' => true,
                                                    'features' => ['external_account_collection' => true],
                                                ],
                                                'payments' => [
                                                        'enabled' => true,
                                                        'features' => [
                                                        'refund_management' => false,
                                                        'dispute_management' => false,
                                                        'capture_payments' => true,
                                                        'destination_on_behalf_of_charge_management' => false,
                                                        ],
                                                ],
                                                'payouts' => [
                                                    'enabled' => true,
                                                    'features' => [
                                                        'instant_payouts' => false,
                                                        'standard_payouts' => true,
                                                        'edit_payout_schedule' => false,
                                                        'external_account_collection' => true,
                                                    ],
                                                ],
                                            ],
                                        ]);
                                    $stripe_account = StripeConnectDetails::where('user_id',$logged_in_user)->first();
                                        $data['account_id'] =$accountId;
                                        $data['client_secret'] =$account_session->client_secret;
                                        $data['onboarding_status'] =$stripe_account->onboarding_status;
                                        $data['charges_enabled'] =$stripe_account->charges_enabled;
                                        $data['payouts_enabled'] =$stripe_account_details->payouts_enabled;
                                        $data['transfers_enabled'] =$stripe_account_details->transfers_enabled;
                                        // $loginLink = \Stripe\Account::createLoginLink($stripe_account_details->stripe_connect_account_id);
                                        // $data['client_secret'] = $loginLink->url;

                                        return responseDataApi($data, $this->createdStatusCode, $this->successStatus);

                                } 
                                catch (Exception $e) 
                                {

                                    //echo json_encode(['error' => $e->getMessage()]);
                                    return responseMsgApi(__('api_stripe_create_session_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                                }
                        }
                        else
                        {
                                 return responseMsgApi(__('api_stripe_create_session_failed',[],$request->language_symbol), $this->internalServerErrorStatusCode);
                        }

    }


    public function stripe_connect_webhook(Request $request)
    {
         \Log::info('stripe webhook');
         Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            \Log::info($e->getMessage());
        }

        // try {
        //     $event = Webhook::constructEvent(
        //         $payload, $sig_header, $endpoint_secret
        //     );
        // } catch (SignatureVerificationException $e) {
        //     // Invalid signature
        //     \Log::info('invalid sign');
        //     \Log::info($e->getMessage());
        // }

        // Handle the event
        switch ($event->type) {
            case 'account.updated':
                $account = $event->data->object; 
                \Log::info('account was successful!', ['account' =>$account]);
                $userStripeConnect = StripeConnectDetails::where('stripe_connect_account_id',$account->id)->first();
                if($userStripeConnect)
                {
                    $data =[];
                    if($account->details_submitted == true)
                    {
                         $data['onboarding_status']= 1;
                    }
                    else if($account->details_submitted == false)
                    {
                         $data['onboarding_status']= 0;
                    }
                    if($account->payouts_enabled == true)
                    {
                         $data['payouts_enabled']= 1;
                    }
                    else if($account->payouts_enabled == false)
                    {
                         $data['payouts_enabled']= 0;
                    }
                    if($account->charges_enabled == true)
                    {
                         $data['charges_enabled']= 1;
                    }
                    else if($account->charges_enabled == false)
                    {
                         $data['charges_enabled']= 0;
                    }
                     if($account->capabilities->transfers == 'inactive')
                    {
                         $data['transfers_enabled']= 0;
                    }
                    else if($account->capabilities->transfers == 'active')
                    {
                         $data['transfers_enabled']= 1;
                    }
                    if(count($data)>0) {
                            $userStripeConnect->update($data);
                    }
                    if(count($data)>0) {
                            $userStripeConnect->update($data);
                    }
                }
                break; 
            case 'account.external_account.created':
                 $account = $event->data->object; 
                 $userStripeConnect = StripeConnectDetails::where('stripe_connect_account_id',$account->id)->first();
                if($userStripeConnect)
                {
                    $data =[];
                     if($account->details_submitted == true)
                    {
                         $data['onboarding_status']= 1;
                    }
                    else if($account->details_submitted == false)
                    {
                         $data['onboarding_status']= 0;
                    }
                    if($account->payouts_enabled == true)
                    {
                         $data['payouts_enabled']= 1;
                    }
                    else if($account->payouts_enabled == false)
                    {
                         $data['payouts_enabled']= 0;
                    }
                    if($account->charges_enabled == true)
                    {
                         $data['charges_enabled']= 1;
                    }
                    else if($account->charges_enabled == false)
                    {
                         $data['charges_enabled']= 0;
                    } 
                    if($account->capabilities->transfers == 'inactive')
                    {
                         $data['transfers_enabled']= 0;
                    }
                    else if($account->capabilities->transfers == 'active')
                    {
                         $data['transfers_enabled']= 1;
                    }
                    if(count($data)>0) {
                            $userStripeConnect->update($data);
                    }
                }
                break;
            case 'payout.created':
                 $account = $event->data->object; 
                  $userStripeConnect = StripeConnectDetails::where('stripe_connect_account_id',$account->id)->first();
                if($userStripeConnect)
                {
                    $data =[];
                     if($account->details_submitted == true)
                    {
                         $data['onboarding_status']= 1;
                    }
                    else if($account->details_submitted == false)
                    {
                         $data['onboarding_status']= 0;
                    }
                    if($account->payouts_enabled == true)
                    {
                         $data['payouts_enabled']= 1;
                    }
                    else if($account->payouts_enabled == false)
                    {
                         $data['payouts_enabled']= 0;
                    }
                    if($account->charges_enabled == true)
                    {
                         $data['charges_enabled']= 1;
                    }
                    else if($account->charges_enabled == false)
                    {
                         $data['payouts_enabled']= 0;
                    }
                     if($account->capabilities->transfers == 'inactive')
                    {
                         $data['transfers_enabled']= 0;
                    }
                    else if($account->capabilities->transfers == 'active')
                    {
                         $data['transfers_enabled']= 1;
                    }
                    if(count($data)>0) {
                            $userStripeConnect->update($data);
                    }
                    if(count($data)>0) {
                            $userStripeConnect->update($data);
                    }
                }
            break; 
             case 'transfer.created':
                  $payout = $event->data->object; 
                 \Log::info('transfer.created');
                  \Log::info($payout);
            break;
             case 'transfer.updated':
                  $payout = $event->data->object; 
                 \Log::info('transfer.updated');
                  \Log::info($payout);
            break;
            case 'payout.paid':
                  $payout = $event->data->object; 
                 \Log::info('payout.paid');
                  \Log::info($payout);
            break; 
            case 'payout.updated':
                 $payout = $event->data->object; 
                 \Log::info('payout.updated');
                  \Log::info($payout);
            break; 
            case 'capability.updated':
                 $account = $event->data->object; 
                  $userStripeConnect = StripeConnectDetails::where('stripe_connect_account_id',$account->id)->first();
                if($userStripeConnect)
                {
                    $data =[];
                    if($account->details_submitted == true)
                    {
                         $data['onboarding_status']= 1;
                    }
                    else if($account->details_submitted == false)
                    {
                         $data['onboarding_status']= 0;
                    }
                    if($account->payouts_enabled == true)
                    {
                         $data['payouts_enabled']= 1;
                    }
                    else if($account->payouts_enabled == false)
                    {
                         $data['payouts_enabled']= 0;
                    }
                    if($account->charges_enabled == true)
                    {
                         $data['charges_enabled']= 1;
                    }
                    else if($account->charges_enabled == false)
                    {
                         $data['payouts_enabled']= 0;
                    }
                    if(count($data)>0) {
                            $userStripeConnect->update($data);
                    }
                }
            break; 

            // Add more cases here based on your needs
            default:
                \Log::info('Received unknown event type ' . $event->type);
        }

        return response()->json(['status' => 'success'], 200);
    
    }

    public function stripe_main_webhook(Request $request)
    {
        \Log::info('stripe mail webhook');
         Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));

        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $event = null;

         $current_date = Carbon::now()->toDateString();

        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            \Log::info($e->getMessage());
        }

        switch ($event->type) {
            case 'charge.refunded':
                $charge = $event->data->object; 
                \Log::info('charge.refunded', ['charge' =>$charge->id]);
                if($charge->status == 'succeeded')
                {
                        $stripe_payment_details  = BidStripeTransaction::where('txn_id',$charge->id)->first();
                        $bid_id = $stripe_payment_details->bid_details_id;
                        $initial_details  = DisputeRefundTracking::where('bid_id',$bid_id)->where('refund_status','requested')->first();
                        $refundId = $initial_details->refund_id;
                        DisputeRefundTracking::create(['bid_id'=>$bid_id,'refund_id'=>$refundId,'refund_status'=>'processing','update_date'=>$current_date]);
                }
         
                
                break; 
               case 'charge.refund.updated':
                $charge = $event->data->object; 
                \Log::info('charge.refund.updated', ['charge' =>$charge->charge]);
       
                 if($charge->status == 'succeeded')
                {
                           $stripe_payment_details  = BidStripeTransaction::where('txn_id',$charge->charge)->first();
                            $bid_id = $stripe_payment_details->bid_details_id;
                            $refundId = $charge->id;
                             
                            DisputeRefundTracking::create(['bid_id'=>$bid_id,'refund_id'=>$refundId,'refund_status'=>'completed','update_date'=>$current_date]);
                }
                
                break;
            case 'payment_intent.partially_funded':
                  $charge = $event->data->object; 
                \Log::info('payment_intent.partially_funded', ['charge' =>$charge]);
                 // $stripe_payment  = BidStripeTransaction::where('txn_id',$charge->id)->first();
            break; 
          

            // Add more cases here based on your needs
            default:
                \Log::info('Received unknown event type ' . $event->type);
        }

        return response()->json(['status' => 'success'], 200);
    }

    
    public function onboard_users_on_connect(Request $request)
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

            /*get user stripe account id*/ 
             $stripe_connect_account = StripeConnectDetails::where('user_id',$request->login_user_id)->first();
                
                if($stripe_connect_account)
                {
                                      
                    $accountId = $stripe_connect_account->stripe_connect_account_id;
                }
                else
                {
                    $user = User::find($request->login_user_id);
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
                                                    ]);
                        $accountId = $account->id;
                        //store the account id in database
                        StripeConnectDetails::create(['user_id'=>$request->login_user_id,'stripe_connect_account_id'=>$accountId]);

                }

            if($accountId)
            {

                $stripe = new \Stripe\StripeClient(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
                $account = $stripe->accounts->retrieve($accountId);
                                                    
                $refreshUrl = env('APP_URL') . 'stripe-connect';
                $returnUrl = env('APP_URL') . 'stripe-connect';
                $accountLink = $stripe->accountLinks->create([
                                                            'account' => $accountId,
                                                            'refresh_url' => $refreshUrl,
                                                            'return_url' => $returnUrl,
                                                            'type' => 'account_onboarding',
                                                        ]);
                $onboarding_url = $accountLink->url;
                //Please complete your onboarding to enable payments and transfers.
                $response_data['url'] = $accountLink->url;

                return responseDataApi($response_data, $this->okStatusCode, $this->successStatus);
                
            }
           else
           {
                 return responseMsgApi('Internal Server Error', $this->internalServerErrorStatusCode);
           }
    }


    

    /***************************stripe refund API ****************************/
    public function refund_stripe_amount(Request $request)
    {
          $validator = Validator::make($request->all(), [
                    'recharge_timestamp' => 'required',
                    'bid_id'=> 'required|exists:bid_details,id',
                ]);

                if($request->language_symbol){
                    $this->translator->setLocale($request->language_symbol);
                    $validator->setTranslator($this->translator);
                }

                if ($validator->fails()) {
                    return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
                }
                  $bid_details = BidDetails::where('id', $request->bid_id)->first();
                    $refund_amount = $bid_details->bid_price;
                    $onhold_amount = $bid_details->amount_paid;

                    $stripe_payment  = BidStripeTransaction::where('bid_details_id',$request->bid_id)->first();
                    if($stripe_payment)
                    {
                        /******************stripe payment ****************/
                        $transaction_id = $stripe_payment->txn_id;
                        $current_date = Carbon::now()->toDateString();
                        if($stripe_payment->payment_type == 'payment_indent')
                        {
                        
                            try {
                                \Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
                                
                                // Create a refund for a PaymentIntent
                                $refund = \Stripe\Refund::create([
                                    'payment_intent' => $transaction_id, 
                                ]);
                                $refundId = $refund->id;
                                $refundStatus = $refund->status;


                                if ($refundStatus == "succeeded") {
                                    DisputeRefundTracking::create(['bid_id'=>$request->bid_id,'refund_id'=>$refundId,'refund_status'=>'requested','update_date'=>$current_date]);
                                     BidDetails::where('id', $request->bid_id)->update(['bid_status'=>'refunded']);

                                      $bidDetails = BidDetails::where('id', $request->bid_id)->orderBy('id','desc')->get();
                                     $bidDetails->trackStatus = TrackItem::where('bid_id', $request->bid_id)->orderBy('id','desc')->get();

                                     return responseDataApi($bidDetails, $this->createdStatusCode, $this->successStatus); 

                                    
                                } else {
                                    return responseMsgApi(__('itemPromotion__api_stripe_refund_failed', [], $request->language_symbol), $this->internalServerErrorStatusCode);
                                }
                            } catch (\Throwable $e) {
                                return responseMsgApi(__('itemPromotion__api_stripe_refund_failed', [], $request->language_symbol), $this->internalServerErrorStatusCode);
                            }
                            
                        }
                        if($stripe_payment->payment_type == 'charge')
                        {
                            try {
                                    \Stripe\Stripe::setApiKey(trim($this->paymentSettingService->getPaymentInfo(null, null, $this->stripeSecretKey)->value));
                                    
                                    $refund = \Stripe\Refund::create([
                                        'charge' => $transaction_id, 
                                    ]);
                                    
                                    $refundId = $refund->id;
                                    $refundStatus = $refund->status;

                                    if ($refundStatus == "succeeded") {
                                         DisputeRefundTracking::create(['bid_id'=>$request->bid_id,'refund_id'=>$refundId,'refund_status'=>'requested','update_date'=>$current_date]);
                                          BidDetails::where('id', $request->bid_id)->update(['bid_status'=>'refunded']);
                                         $bidDetails = BidDetails::where('id', $request->bid_id)->orderBy('id','desc')->get();
                                        $bidDetails->trackStatus = TrackItem::where('bid_id', $request->bid_id)->orderBy('id','desc')->get();

                                        return responseDataApi($bidDetails, $this->createdStatusCode, $this->successStatus); 
                                    } else {
                                        return responseMsgApi(__('itemPromotion__api_stripe_refund_failed', [], $request->language_symbol), $this->internalServerErrorStatusCode);
                                    }
                                } catch (\Throwable $e) {
                                    return responseMsgApi(__('itemPromotion__api_stripe_refund_failed', [], $request->language_symbol), $this->internalServerErrorStatusCode);
                                }
                        }
                    }
                    else
                    {

                    }
                    // else
                    // {
                    //     /******************wallet payment ****************/
                           

                    //             $sellerWallet = UserWallet::where('user_id', $bid_details->seller_id)->first();
                    //             $s_data = [];
                    //             $s_data['currency'] = 'Fr.';
                    //             $s_data['amount_on_hold'] = $sellerWallet->amount_on_hold - $onhold_amount;
                    //             $s_data['recharge_date'] = $request->recharge_timestamp;
                    //             $updatedSeller = UserWallet::where('id', $sellerWallet->id)->update($s_data);
                    //             if($updatedSeller)
                    //             {
                                  
                    //                 WalletLog::create([
                    //                                 "users_wallet_id"=>$sellerWallet->id,
                    //                                 "amount_deducted"=>$refund_amount,
                    //                                 "currency"=>'Fr.',
                    //                                 "old_balance"=>$sellerWallet->wallet_balance,
                    //                                 "add_date"=>$request->recharge_timestamp,
                    //                                 "payment_type"=>"onhold_amount_deducted",
                    //                                 "log_type"=>"onhold_debit"
                    //                                 ]);
                    //                 /*********************buyer refund ***********************/
                    //                 $buyerWallet = UserWallet::where('user_id', $bid_details->buyer_id)->first();

                    //                     $b_data = [];
                    //                     $b_data['currency'] = 'Fr.';
                    //                     $b_data['wallet_balance'] = $buyerWallet->wallet_balance+$refund_amount;
                    //                     $b_data['recharge_date'] = $request->recharge_timestamp;

                    //                     $updatedBuyer = UserWallet::where('id', $buyerWallet->id)->update($b_data);
                    //                     if($updatedBuyer)
                    //                     {
                    //                         TrackItem::create(['bid_id'=>$request->bid_id,'item_status'=>'refunded','updated_by_id'=>$bid_details->buyer_id,'updated_by'=>'buyer',"update_date"=>date('Y-m-d'),"status_notes"=>$request->dispute_status_notes]);

                    //                         DisputeRefundTracking::create(['bid_id'=>$request->bid_id,'refund_status'=>'completed','update_date'=>$current_date]);

                    //                         WalletLog::create([
                    //                                 "users_wallet_id"=>$buyerWallet->id,
                    //                                                         "amount_added"=>$refund_amount,
                    //                                                         "currency"=>'Fr.',
                    //                                                         "old_balance"=>$buyerWallet->wallet_balance,
                    //                                                         "add_date"=>$request->recharge_timestamp,
                    //                                                         "payment_type"=>"refund_added",
                    //                                                         "log_type"=>"credit"
                    //                                                         ]);
                    //                     }
                    //                         $bid_details->update();
                    //                          return $bid_details;
                    //             }

                                    
                    // }


            
            
    }
}
