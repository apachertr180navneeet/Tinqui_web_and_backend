<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;

class MollieController extends Controller
{
     public function  __construct() {
        Mollie::api()->setApiKey('test_ndABcng3ASdH2x2pDH2A7SfuthHwUc'); 
    }

    /**
     * Redirect the user to the Payment Gateway.
     *
     * @return Response
     */
    public function preparePayment()
    {   
       
        // $validator = Validator::make($request->all(), [
        //     'login_user_id' => 'required|exists:users,id',
        //     'amount' => 'required',
        //     'recharge_timestamp' => 'required',
        // ]);

        // if($request->language_symbol){
        //     $this->translator->setLocale($request->language_symbol);
        //     $validator->setTranslator($this->translator);
        // }

        // if ($validator->fails()) {
        //     return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
        // }

        try{
             $payment = Mollie::api()->payments()->create([
                'amount' => [
                    'currency' => 'CHF', 
                    'value' => '10.00', 
                ],
                'description' => 'Payment By codehunger', 
                'redirectUrl' => "http://127.0.0.1:8000/api/v1.0/payment_success", 
                ]);
                echo $payment->id;
        $payment = Mollie::api()->payments()->get($payment->id);
        return redirect($payment->getCheckoutUrl(), 303);
        }
       catch(\Exception $e)
       {
         print_r($e->getMessage());
       }

        
    }

    /**
     * Page redirection after the successfull payment
     *
     * @return Response
     */
    public function paymentSuccess() {
        echo 'payment has been received';

    }
}
