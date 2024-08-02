<?php

namespace Modules\Core\Http\Services;

use App\Config\ps_config;
use App\Config\ps_constant;
use App\Http\Services\PsService;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\WalletLog;  
use App\Models\BidDetails; 
use App\Models\TrackItem;
use App\Models\DisputeRefundTracking;
use App\Models\WalletWithdrawalRequest;
use App\Models\BidStripeTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Schema;
use Intervention\Image\Facades\Image; 
use Modules\Core\Constants\Constants;
use Modules\Core\Entities\CoreFieldFilterSetting;
use Modules\Core\Entities\CustomizeUi;
use Modules\Core\Entities\CustomizeUiDetail;
use Modules\Core\Entities\Role;
use Modules\BlueMarkUser\Entities\BlueMarkUser;
use Modules\Core\Entities\CoreImage;
use Modules\Core\Entities\ScreenDisplayUiSetting;
use Modules\Core\Entities\UserAccessApiToken;
use Modules\Core\Entities\UserInfo;
use Modules\Core\Entities\UserPermission;
use Modules\Core\Exports\BuyerReportExport;
use Modules\Core\Exports\DailyActiveUserReportExport;
use Modules\Core\Exports\SellerReportExport;
use Modules\Core\Exports\UserReportExport;
use Modules\Core\Http\Services\ImageService;
use Modules\Core\Transformers\Backend\Model\User\UserWithKeyResource;
use Modules\Core\Http\Services\CoreKeyService;
use Modules\Core\Http\Services\CoreKeyUserRelationService; 
use Modules\Core\Transformers\Api\App\V1_0\User\UserApiResource;
use Modules\Core\Transformers\Backend\NoModel\BannedUser\BannedUserWithKeyResource;
use Modules\Core\Transformers\Backend\NoModel\BuyerReport\BuyerReportWithKeyResource;
use Modules\Core\Transformers\Backend\NoModel\DailyActiveUserReport\DailyActiveUserReportWithKeyResource;
use Modules\Core\Transformers\Backend\NoModel\SellerReport\SellerReportWithKeyResource;
use Modules\Core\Transformers\Backend\NoModel\UserReport\UserReportWithKeyResource;

class DisputesService extends PsService
{
    protected  $customUiDetailCoreKeysIdCol, $userUserIdCol, $dailyActiveUserReportCsvFileName, $userAddedUserIdCol, $userReportCsvFileName, $imageService, $show, $hide, $enable, $disable, $delete, $unDelete, $uploadPathForDel, $thumb1xPathForDel, $thumb2xPathForDel, $thumb3xPathForDel, $viewAnyAbility, $createAbility, $editAbility, $deleteAbility, $originPath, $thumbnail1xPath, $thumbnail2xPath, $thumbnail3xPath, $usrTableName, $userNameCol, $userRoleIdCol, $userEmailCol, $userPhoneCol, $screenDisplayUiIdCol, $screenDisplayUiIsShowCol, $componentName, $coreFieldFilterModuleNameCol, $coreFieldFilterIdCol, $coreFieldFilterForRelation, $paginationPerPage, $screenDisplayUiKeyCol, $usrInfoTableName, $usrInfoCoreKeysIdCol, $usrInfoUserIdCol, $getImgPath, $parentPath, $customUiMandatoryCol, $customUiIsDelCol, $customUiEnableCol, $customUiCoreKeysIdCol, $customUiIdCol, $code, $corekeyRelationService, $successStatus, $userAddedDateCol, $searchHistoryUserType, $searchHistoryService, $userAccessApiTokenService, $coreKeyService, $unBan, $ban, $dangerFlag, $userIdCol, $usrIsVerifyBlueMark, $usrBlueMarkNote, $userStatusCol, $userIsBannedCol, $internalServerErrorStatusCode, $noContentStatusCode, $createdStatusCode, $notFoundStatusCode, $okStatusCode, $badRequestStatusCode, $pushNotificationTokenService, $backendSettingService, $dropDownUi, $textUi, $radioUi, $checkBoxUi, $dateTimeUi, $numberUi, $textAreaUi, $multiSelectUi, $imageUi, $timeOnlyUi, $dateOnlyUi, $normalUserRoleId, $superAdminRoleId, $roleService, $customUiModuleName, $userApiRelations, $publish, $pending, $emailVerify,  $deviceTokenParaApi, $loginUserIdParaApi, $forbiddenStatusCode, $buyerReportCsvFileName, $sellerReportCsvFileName;

    public function __construct(SearchHistoryService $searchHistoryService, CoreKeyUserRelationService $corekeyRelationService, CoreKeyService $coreKeyService, PushNotificationTokenService $pushNotificationTokenService, BackendSettingService $backendSettingService, ImageService $imageService, RoleService $roleService, UserAccessApiTokenService $userAccessApiTokenService)
    {
        $this->userAccessApiTokenService = $userAccessApiTokenService;
        $this->dangerFlag = Constants::danger;
        $this->ban = Constants::Ban;
        $this->unBan = Constants::unBan;
        $this->usrIsVerifyBlueMark = Constants::usrIsVerifyBlueMark;
        $this->usrBlueMarkNote = Constants::usrBlueMarkNote;
        $this->internalServerErrorStatusCode = Constants::internalServerErrorStatusCode;
        $this->createdStatusCode = Constants::createdStatusCode;
        $this->badRequestStatusCode = Constants::badRequestStatusCode;
        $this->okStatusCode = Constants::okStatusCode;
        $this->successStatus = Constants::successStatus; 
        $this->notFoundStatusCode = Constants::notFoundStatusCode;
        $this->noContentStatusCode = Constants::noContentStatusCode;

        $this->pushNotificationTokenService = $pushNotificationTokenService;
        $this->backendSettingService = $backendSettingService;
        $this->corekeyRelationService = $corekeyRelationService;
        $this->searchHistoryService = $searchHistoryService;

        $this->searchHistoryUserType = Constants::searchHistoryUserType;

        $this->code = Constants::user;

        $this->customUiIdCol = CustomizeUi::id;
        $this->customUiCoreKeysIdCol = CustomizeUi::coreKeysId;
        $this->customUiEnableCol = CustomizeUi::enable;
        $this->customUiUiTypeIdCol = CustomizeUi::uiTypeId;
        $this->customUiIsDelCol = CustomizeUi::isDelete;
        $this->customUiMandatoryCol = CustomizeUi::mandatory;
        $this->customUiModuleName = CustomizeUi::moduleName;

        $this->customUiDetailTableName = CustomizeUiDetail::tableName;
        $this->customUiDetailCoreKeysIdCol = CustomizeUiDetail::coreKeysId;
        $this->customUiDetailIdCol = CustomizeUiDetail::id;

        $this->parentPath = Constants::parentPath;
        $this->getImgPath = Constants::imgPath;

        $this->usrInfoTableName = UserInfo::tableName;
        $this->usrInfoUserIdCol = UserInfo::userId;
        $this->usrInfoValueCol = UserInfo::value;
        $this->usrInfoCoreKeysIdCol = UserInfo::coreKeysId;
        $this->usrInfoUserIdCol = UserInfo::userId;

        $this->coreFieldFilterModuleNameCol = CoreFieldFilterSetting::moduleName;
        $this->coreFieldFilterIdCol = CoreFieldFilterSetting::id;
        $this->coreFieldFilterForRelation = ps_config::coreFieldFilterForRelation;
        $this->paginationPerPage = ps_config::pagPerPage;

        $this->screenDisplayUiKeyCol = ScreenDisplayUiSetting::key;
        $this->screenDisplayUiIdCol = ScreenDisplayUiSetting::id;
        $this->screenDisplayUiIsShowCol = ScreenDisplayUiSetting::isShow;

        $this->componentName = "user";

        $this->usrTableName = User::tableName;
        $this->userNameCol = User::name;
        $this->userStatusCol = User::status;
        $this->userIsBannedCol = User::isBanned;
        $this->userRoleIdCol = User::roleId;
        $this->userIdCol = User::id;
        $this->userAddedDateCol = User::addedDate;
        $this->userEmailCol = User::email;
        $this->userPhoneCol = User::userPhone;
        $this->userAddedUserIdCol = User::addedUser;
        $this->userUserIdCol = User::id;

        $this->viewAnyAbility = Constants::viewAnyAbility;
        $this->createAbility = Constants::createAbility;
        $this->editAbility = Constants::editAbility;
        $this->deleteAbility = Constants::deleteAbility;

        $this->originPath = Constants::originPath;
        $this->thumbnail1xPath = Constants::thumbnail1xPath;
        $this->thumbnail2xPath = Constants::thumbnail2xPath;
        $this->thumbnail3xPath = Constants::thumbnail3xPath;

        $this->uploadPathForDel = Constants::uploadPathForDel;
        $this->thumb1xPathForDel = Constants::thumb1xPathForDel;
        $this->thumb2xPathForDel = Constants::thumb2xPathForDel;
        $this->thumb3xPathForDel = Constants::thumb3xPathForDel;

        $this->show = Constants::show;
        $this->hide = Constants::hide;
        $this->enable = Constants::enable;
        $this->disable = Constants::disable;
        $this->delete = Constants::delete;
        $this->unDelete = Constants::unDelete;
        $this->superAdminRoleId = Constants::superAdminRoleId;
        $this->normalUserRoleId = Constants::normalUserRoleId;

        $this->dropDownUi = Constants::dropDownUi;
        $this->textUi = Constants::textUi;
        $this->radioUi = Constants::radioUi;
        $this->checkBoxUi = Constants::checkBoxUi;
        $this->dateTimeUi = Constants::dateTimeUi;
        $this->textAreaUi = Constants::textAreaUi;
        $this->numberUi = Constants::numberUi;
        $this->multiSelectUi = Constants::multiSelectUi;
        $this->imageUi = Constants::imageUi;
        $this->timeOnlyUi = Constants::timeOnlyUi;
        $this->dateOnlyUi = Constants::dateOnlyUi;
        $this->imageService = $imageService;
        $this->roleService = $roleService;
        $this->coreKeyService = $coreKeyService;

        $this->userApiRelations = ['userRelation'];

        $this->publish = Constants::publishUser;
        $this->pending = Constants::pendingUser;
        $this->emailVerify = Constants::emailVerify;

        $this->loginUserIdParaApi = ps_constant::loginUserIdParaFromApi;
        $this->deviceTokenParaApi = ps_constant::deviceTokenKeyFromApi;
        $this->forbiddenStatusCode = Constants::forbiddenStatusCode;

        $this->buyerReportCsvFileName = "buyer_report";
        $this->sellerReportCsvFileName = "seller_report";
        $this->userReportCsvFileName = "user_report";
        $this->dailyActiveUserReportCsvFileName = "daily_active_user_report";

        $this->userPermissionUserIdCol = UserPermission::userId;

        $this->roleTableName = Role::tableName;
        $this->roleIdCol = Role::id;
        $this->roleNameCol = Role::name;
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

    public function indexDisputes($request)
    {
        $disputed_bids = BidDetails::where('disputed_bid', 'yes')
                                        ->join('users as buyers', 'buyers.id', '=', 'bid_details.buyer_id')
                                        ->join('users as sellers', 'sellers.id', '=', 'bid_details.seller_id')
                                        ->select('bid_details.*', 'buyers.name as buyer_name','buyers.email as buyer_email', 'sellers.name as seller_name','sellers.email as seller_email')
                                        ->orderBy('created_at', 'desc')->get();
        $data['disputedBids'] = $disputed_bids;
        return $data;
    }
  

    public function editDispute($id)
    {
         $disputed_bid = BidDetails::where('bid_details.id',$id) ->join('users as buyers', 'buyers.id', '=', 'bid_details.buyer_id')
                                        ->join('users as sellers', 'sellers.id', '=', 'bid_details.seller_id')
                                         ->select('bid_details.*', 'buyers.name as buyer_name','buyers.email as buyer_email', 'sellers.name as seller_name','sellers.email as seller_email')
                                        ->orderBy('created_at', 'desc')->get();
        $data['disputedBid'] = $disputed_bid;
        return $data;
    }

    public function update($id, $request)
    {
        DB::beginTransaction();

        try {
            
            $bid_details = $this->updateDispute($request,$id);

            DB::commit();
            return $bid_details;
        } catch (\Throwable $e) {
            DB::rollBack();
            echo json_encode($e->getMessage());
            exit;
            return ['error' => $e->getMessage()];
        }
       
        
    }

    public function destroyBannedUser($id)
    {
        $user = $this->getUser($id);
        $name = $user->name;
        $user->delete();

        $status = [
            'flag' => $this->dangerFlag,
            'msg' => 'The ' . $name . ' row has been deleted successfully.'
        ];

        return $status;
    }

    
    public function updateDispute($request,$id)
    {
       // print_r($request->dispute_status);print_r($request->dispute_refund); print_r($request->dispute_status_notes);die;
        if (isset($id) && !empty($id))
            $bid_details = BidDetails::where('id',$id)->first();

            if (isset($request->dispute_status) && !empty($request->dispute_status))
            $bid_details->dispute_status = $request->dispute_status;


            if (isset($request->dispute_status_notes) && !empty($request->dispute_status_notes))
            $bid_details->dispute_status_notes = $request->dispute_status_notes;

             if (isset($request->dispute_refund) && !empty($request->dispute_refund))
            $bid_details->dispute_refund = $request->dispute_refund;

            $bid_details->update();
            return $bid_details;

    }


}
