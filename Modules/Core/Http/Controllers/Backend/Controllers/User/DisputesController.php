<?php

namespace Modules\Core\Http\Controllers\Backend\Controllers\User;

use App\Config\ps_constant;
use App\Models\User;
use Modules\Core\Constants\Constants;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Http\Services\ImageService;
use Modules\Core\Http\Services\CustomFieldService;
use Modules\Core\Http\Services\UserService;
use Modules\Core\Http\Services\WalletService;use Modules\Core\Http\Services\DisputesService;
use Modules\Core\Http\Requests\UpdateUserRequest;

class DisputesController extends Controller
{
 
    const parentPath = "core/disputes/"; 
    const indexPath = self::parentPath."Index";
    const createPath = self::parentPath."Create";
    const editPath = self::parentPath."Edit";
    const viewPath = self::parentPath."View";
    const indexRoute = "disputes.index";
    const createRoute = "disputes.create";
    const editRoute = "disputes.edit";
    const updateRoute = "disputes.update";

    protected $dangerFlag, $userService, $imageService, $customFieldService;

    public function __construct(UserService $userService, WalletService $walletService,ImageService $imageService, CustomFieldService $customFieldService,DisputesService $disputesService)
    {
        $this->userService = $userService;
        $this->disputesService = $disputesService;
        $this->imageService = $imageService;
        $this->customFieldService = $customFieldService;
        $this->dangerFlag = Constants::danger;
    }

    public function index(Request $request)
    {
        $dataArr = $this->disputesService->indexDisputes($request);
       
        if (!permissionControl(Constants::disputesModule,ps_constant::readPermission)){
            return redirect()->route('admin.index');
        }
        // echo "<pre>";print_r($dataArr);die;
        return renderView(self::indexPath, $dataArr);
    }

    public function edit($id)
    {
          $dataArr = $this->disputesService->editDispute($id);
        if (!permissionControl(Constants::disputesModule,ps_constant::updatePermission)){
            return redirect()->route('admin.index');
        }
      // echo "<pre>";print_r($dataArr);die;

        return renderView(self::editPath, $dataArr);
    }
    

    public function update(Request $request,$id)
    {

        if (!permissionControl(Constants::disputesModule,ps_constant::updatePermission)){
            return redirect()->route('admin.index');
        }
        $bidDetails = $this->disputesService->update($id, $request);

        // if have error
        if (isset($bidDetails['error'])){
            $msg = $bidDetails['error'];
            return redirectView(self::indexRoute, $msg, $this->dangerFlag);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        if (!permissionControl(Constants::disputesModule,ps_constant::deletePermission)){
            return redirect()->route('admin.index');
        }
        $dataArr = $this->userService->destroyBannedUser($id);
        return renderView(self::indexRoute, $dataArr);
    }

    public function ban($id){

        $this->userService->ban($id);
        return redirect()->back();
    }

    public function statusChange(User $user){

        if($user->status == 1){
            $user->status = 0;
        }else{
            $user->status = 1;
        }
        $user->updated_user_id = Auth::user()->id;
        $user->update();


        $status = [
            'flag' => 'success',
            // 'msg' => 'The status of '.$user->name.' row has been updated successfully.',
            'msg' => __('core__be_status_attribute_updated',['attribute'=>$user->name]),
        ];

        return redirect()->route('banned_user.index')->with('status', $status);
    }
}
