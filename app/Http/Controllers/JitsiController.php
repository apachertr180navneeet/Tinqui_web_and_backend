<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Translation\Translator;
use Modules\Core\Constants\Constants;
use Session;
use Modules\Core\Http\Services\ImageService;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Firebase\JWT\JWT;


class JitsiController extends Controller
{
    protected $createdStatusCode,$successStatus,$internalServerErrorStatusCode,$badRequestStatusCode,$translator,$okStatusCode,$errorStatus,$imageService,$img_folder_path,$storage_key_path;

    public function __construct(Translator $translator,ImageService $imageService)
    {
        $this->translator = $translator;
        $this->createdStatusCode = Constants::createdStatusCode;
        $this->internalServerErrorStatusCode = Constants::internalServerErrorStatusCode;
        $this->badRequestStatusCode = Constants::badRequestStatusCode;
        $this->successStatus = Constants::successStatus;
        $this->okStatusCode = Constants::okStatusCode;
        $this->errorStatus = Constants::errorStatus;
        $this->imageService = $imageService;
        $this->img_folder_path = Constants::folderPath;
        $this->storage_key_path = '/storage/' . $this->getFolderFilePath() . '/JitsiPrivateKey/';

    }

         public function getFolderFilePath()
            {
                return $this->img_folder_path;
            }
    public function createJitsiToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if($request->language_symbol){
            $this->translator->setLocale($request->language_symbol);
            $validator->setTranslator($this->translator);
        }

        if ($validator->fails()) {
            return responseMsgApi(implode("\n", Arr::flatten($validator->getMessageBag()->getMessages())), $this->badRequestStatusCode);
        }


        $user = User::where('id', $request->user_id)->first();

        $appId = "vpaas-magic-cookie-bf2e6df6ca2949bfa006a61ddfbc0247";
        $apiKey = "vpaas-magic-cookie-bf2e6df6ca2949bfa006a61ddfbc0247/0ae139";
       
        $privateKey = file_get_contents(env('APP_URL').$this->storage_key_path.'jitsi_private_key.pk');

        $header = [
                "alg" => "RS256",
                "kid" => $apiKey,
                "typ" => "JWT"
            ];

        $payload = [
            "context" => [
                "user" => [
                    "avatar"=>"https://tinqui.ch/storage/uploads/".$user->user_cover_photo,
                    "name" => $user->name, 
                    "email"=>$user->email,
                    "id"=>$user->id,
                    "moderator"=> "true"
                ],
                'features' => [
                    'recording' => "true",
                    'livestreaming' => "true",
                    'transcription' => "true",
                    'outbound-call' => "true"
                ],
                 "room"=> [
                        "regex"=> false
                 ]
            ],
            "iss" => "chat", 
            "aud" => "jitsi", 
            "exp" => time() + 1800,
            "nbf"=> time() - 1800,
            "sub" => $appId, 
            "room" => "*",
        ];

        $token = JWT::encode($payload, $privateKey, 'RS256', null, $header);
        $tokenData['token'] = $token;

        return responseDataApi($tokenData, $this->createdStatusCode, $this->successStatus);
    }
}
