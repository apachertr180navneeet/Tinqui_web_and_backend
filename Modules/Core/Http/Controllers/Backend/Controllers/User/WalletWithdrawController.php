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
use Modules\Core\Http\Services\WalletService;
use Modules\Core\Http\Requests\UpdateWalletWithdrawRequest; 

class WalletWithdrawController extends Controller
{
 
    const parentPath = "core/withdraw_request/";
    const indexPath = self::parentPath."Index";
    const createPath = self::parentPath."Create";
    const editPath = self::parentPath."Edit";
    const indexRoute = "withdraw_request.index";
    const createRoute = "withdraw_request.create";
    const editRoute = "withdraw_request.edit";


    protected $dangerFlag, $userService, $imageService, $customFieldService;

    public function __construct(UserService $userService, WalletService $walletService,ImageService $imageService, CustomFieldService $customFieldService)
    {
        $this->userService = $userService;
        $this->walletService = $walletService; 
        $this->imageService = $imageService;
        $this->customFieldService = $customFieldService;
        $this->dangerFlag = Constants::danger;
    }

    public function index(Request $request)
    {
        $dataArr = $this->walletService->indexWalletWithdraw($request);
      
        if (!permissionControl(Constants::walletWithdrawModule,ps_constant::readPermission)){
            return redirect()->route('admin.index');
        }
        
        return renderView(self::indexPath, $dataArr);
    }

    public function edit($id)
    {
        $dataArr = $this->walletService->editWalletWithdraw($id);
        if (!permissionControl(Constants::walletWithdrawModule,ps_constant::updatePermission)){
            return redirect()->route('admin.index');
        }
        
        return renderView(self::editPath, $dataArr);

    }

    public function update(Request $request, $id)
    {
        if (!permissionControl(Constants::walletWithdrawModule,ps_constant::updatePermission)){
            return redirect()->route('admin.index');
        }
        $wallet_request = $this->walletService->update($id, $request);

        // if have error
        if (isset($wallet_request['error'])){
            $msg = $wallet_request['error'];
            return redirectView(self::indexRoute, $msg, $this->dangerFlag);
        }

        return redirect()->back();
    }

    public function destroy($id)
    {
        if (!permissionControl(Constants::walletWithdrawModule,ps_constant::deletePermission)){
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
