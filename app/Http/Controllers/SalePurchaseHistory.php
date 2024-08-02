<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Modules\Core\Transformers\Api\App\V1_0\Product\ProductApiResource;
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

class SalePurchaseHistory extends Controller
{

    //D:\xampp\htdocs\Tinqui-Market-Place\Modules\Core\Http\Services\AvailableCurrencyService.php
    ///  $this->currencyIdCol = AvailableCurrency::id;
    protected $paystackPaymentMethod, $razorPaymentMethod, $paypalPaymentMethod, $stripePaymentMethod, $iapPaymentMethod, $paymentSettingService,
        $stripeSecretKey, $paypalPrivateKey, $paypalPublicKey, $paypalClientId, $paypalSecretKey, $paypalEnvironment,$paypalMerchantId,$createdStatusCode,$successStatus,$internalServerErrorStatusCode,$badRequestStatusCode,$translator,$okStatusCode,$errorStatus,$stripePublishableKey,$currencyIdCol,$imageService,$img_folder_path,$pushNotificationTokenService,$userService;

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

    }


    public function sale_purchase_history(Request $request)
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

          if((BidDetails::where('buyer_id',$request->login_user_id)->whereNotIn('bid_status',['pending'])->count())==0)
            {
                   return responseMsgApi(__('core__api_purchase_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }
            if((BidDetails::where('seller_id',$request->login_user_id)->whereNotIn('bid_status',['pending'])->count())==0)
            {
                   return responseMsgApi(__('core__api_sale_no_bids',[],$request->language_symbol), $this->okStatusCode, $this->errorStatus);
            }

            // $bidDetails = BidDetails::where('buyer_id',$request->login_user_id)->orWhere('seller_id',$request->login_user_id)->where('bid_status','completed')->orderBy('id','desc')->get();

          $itemApiRelation =  ['vendor', 'category', 'subcategory', 'city', 'township', 'currency', 'owner', 'itemRelation', 'cover', 'video', 'icon'];
            $purchasedItemDetails = BidDetails::where(function ($query) use ($request) {
                    $query->where('buyer_id', $request->login_user_id);
                        //   ->orWhere('seller_id', $request->login_user_id);
                })
                ->whereNotIn('bid_status', ['pending'])
                ->orderBy('id', 'desc')
                ->get();

            $final_data = [];
            foreach($purchasedItemDetails as $purchasedItemDetail)
                {
                   $purchasedItemDetail->amount_paid = number_format($purchasedItemDetail->amount_paid,2);
                   $purchasedItemDetail->buyerData = User::where('id', $purchasedItemDetail->buyer_id)
                                                ->select('name as user_name', 'email as user_email', 'user_phone')
                                                ->get();
                   $purchasedItemDetail->sellerData =User::where('id', $purchasedItemDetail->seller_id)
                                                ->select('name as user_name', 'email as user_email', 'user_phone')
                                                ->get();
                                            

                  $item = Item::when($itemApiRelation, function ($query, $itemApiRelation) {
                                                                                $query->with($itemApiRelation);
                                                        })
                                                        ->where('id', $purchasedItemDetail->product_id)->first();

                $purchasedItemDetail->productData = new ProductApiResource($item);

                  $purchasedItemDetail->trackStatus = TrackItem::where('bid_id',  $purchasedItemDetail->id)->orderBy('id','desc')->get();
                }
           $final_data['purchaseData'] = $purchasedItemDetails;
            $soldItemDetails = BidDetails::where(function ($query) use ($request) {
                    $query->where('seller_id', $request->login_user_id);
                        //   ->orWhere('seller_id', $request->login_user_id);
                })
                ->whereNotIn('bid_status', ['pending'])
                ->orderBy('id', 'desc')
                ->get();
            foreach($soldItemDetails as $soldItemDetail)
            {
                  $soldItemDetail->amount_paid = number_format($soldItemDetail->amount_paid,2);
                   $soldItemDetail->buyerData = User::where('id', $soldItemDetail->buyer_id)
                                                ->select('name as user_name', 'email as user_email', 'user_phone')
                                                ->get();
                   $soldItemDetail->sellerData =User::where('id', $soldItemDetail->seller_id)
                                                ->select('name as user_name', 'email as user_email', 'user_phone')
                                                ->get();
                   $item = Item::when($itemApiRelation, function ($query, $itemApiRelation) {
                                                                                $query->with($itemApiRelation);
                                                                            })
                                                                        ->where('id', $soldItemDetail->product_id)->first();

                    $soldItemDetail->productData = new ProductApiResource($item);

                  $soldItemDetail->trackStatus = TrackItem::where('bid_id',  $soldItemDetail->id)->orderBy('id','desc')->get();
            }
           $final_data['saleData'] = $soldItemDetails;
            return responseDataApi($final_data, $this->okStatusCode, $this->successStatus);
    }
    

}
