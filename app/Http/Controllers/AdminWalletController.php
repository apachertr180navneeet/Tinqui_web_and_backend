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

class AdminWalletController extends Controller
{
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

    

    public function get_all_disputes(Request $request)
    {
        $disputes = BidDetails::where('disputed_bid', 'yes')
                                    ->get();
        if(count($disputes)>0)
            {
                    return responseDataApi($disputes, $this->createdStatusCode, $this->successStatus);
            }
            else
            {
                    return responseMsgApi('No disputes found', $this->okStatusCode, $this->errorStatus);
            }

    }

    public function admin_dispute_status_update(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
                'bid_details_id' => 'required|exists:bid_details,id',
                'dispute_status' => 'required|in:in_process,rejected,resolved',
                'dispute_status_notes' => 'nullable',
        ]);

        if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }

            $data = [];
            $data['dispute_status'] = $request->dispute_status;

            if(!empty($request->dispute_status_notes))
            {
                 $data['dispute_status_notes'] = $request->dispute_status_notes;
            }
            

            $updated = BidDetails::where('id',$request->bid_details_id)->update($data);
            if($updated)
            {
                return responseMsgApi('Bid details updated successfully', $this->okStatusCode, $this->successStatus);
            }
            else
            {
                return responseMsgApi('Bid status not updated', $this->okStatusCode, $this->errorStatus);
            }
    }

    public function admin_wallet_withdrawal_requests(Request $request)
    {
         $wallet_withdrawal_requests = WalletWithdrawalRequest::get();

        if(count($wallet_withdrawal_requests)>0)
            {
                    return responseDataApi($wallet_withdrawal_requests, $this->createdStatusCode, $this->successStatus);
            }
            else
            {
                    return responseMsgApi('No withdrawal requests found', $this->okStatusCode, $this->errorStatus);
            }
    }

    public function update_withdrawal_request_status(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
                'withdrawal_id' => 'required|exists:wallet_withdrawal_requests,id',
                'withdraw_status' => 'required|in:inprocess,accepted,declined',
                'notes' => 'nullable',
                'processing_date' => 'required',
                'decline_reason' => 'nullable|required_if:withdraw_status,declined',
        ]);

        if($request->language_symbol){
                $this->translator->setLocale($request->language_symbol);
                $validator->setTranslator($this->translator);
            }

            if ($validator->fails()) {
                return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
            }

           
            if($request->withdraw_status == 'accepted')
            {
                /********************add money to the user's account bank account **************/


                /*******************************************************************************/
            }
            
            $data = [];
            $data['withdraw_status'] = $request->withdraw_status;
            
            if(!empty($request->notes))
            {
                 $data['notes'] = $request->notes;
            }
            $data['processing_date'] = $request->processing_date;

            if(!empty($request->decline_reason))
            {
                 $data['decline_reason'] = $request->decline_reason;
            }
            

            $updated = WalletWithdrawalRequest::where('id',$request->withdrawal_id)->update($data);
            if($updated)
            {
                return responseMsgApi("Withdrawal status updated to $request->withdraw_status successfully", $this->okStatusCode, $this->successStatus);
            }
            else
            {
                return responseMsgApi('Withdrawal details not updated', $this->okStatusCode, $this->errorStatus);
            }
    }
}
 