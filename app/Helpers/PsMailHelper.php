<?php

use Illuminate\Support\Facades\Mail;
use Modules\Core\Entities\BackendSetting;
use Modules\Core\Emails\PsMail;
use Modules\Core\Emails\ContactMail;

if(!function_exists('sendMail')){
    function sendMail($to, $to_name, $subject = null, $title = null, $body = null, $subbody = null, $flag= null){

        $backendSetting = BackendSetting::first();
        $from_name = $backendSetting ? $backendSetting->sender_name : '';

        $mail = [
            'from_name' => $from_name, // required from db
            'to_name' => $to_name,
            'subject' => $subject,
            'title' => $title,
            'body' => $body,
            'subbody' => $subbody,
            'salutation' => __('mail__salutation'),
            'closing' => __('mail__closing')
        ];
        
        try{
            Mail::to($to)->send(new PsMail($mail));
            return true;
        }catch(Throwable $e){
            return false;
        }
    }
}

if(!function_exists('sendContactMail')){
    function sendContactMail($contact_name, $contact_email, $contact_phone, $contact_msg,$contactNameStr,$contactEmailStr,$contactPhoneStr,$contactMessageStr){

        $backendSetting = BackendSetting::first();
        $to_emai = $backendSetting ? $backendSetting->receive_email : '';

        $mail = [
            'from_name' => $contact_name, // required from db
            'to_name' => 'Admin',
            'subject' => Null,
            'contact_phone' => $contact_phone,
            'contact_email' => $contact_email,
            'body' => $contact_msg,
            'contactNameStr' => $contactNameStr,
            'contactEmailStr' => $contactEmailStr,
            'contactPhoneStr' => $contactPhoneStr,
            'contactMessageStr' => $contactMessageStr,
            'subbody' => Null,
            'salutation' => __('mail__salutation'),
            'closing' => __('mail__closing')
        ];

        try{
            Mail::to($to_emai)->send(new ContactMail($mail));
            return true;
        }catch(Throwable $e){
            return false;

        }
    }
}

?>
