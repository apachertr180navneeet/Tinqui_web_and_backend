<?php
namespace Modules\Core\Http\Services;

use App\Http\Services\PsService;
use Illuminate\Support\Facades\DB;
use Modules\Core\Entities\BackendSetting;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Constants\Constants;
use Modules\Core\Entities\CoreMenuGroup;

class VendorSettingService extends PsService
{

    protected $menuGroupService;

    public function __construct(MenuGroupService $menuGroupService)
    {
        $this->menuGroupService = $menuGroupService;

    }


    public function update($id,$request)
    {
        try{
        DB::beginTransaction();

            $backend_setting = BackendSetting::find($id);
            $backend_setting->vendor_setting = $request->vendor_setting;
            $backend_setting->update();

            $vendorMenuConds['group_name'] = 'Vendor';
            $vendorMenuConds['id'] = 5;
            $vendorMenu = $this->menuGroupService->getMenuGroup(null, null, $vendorMenuConds);

            $vendorMenu->is_show_on_menu = $backend_setting->vendor_setting;
            $vendorMenu->update();

            DB::commit();
            }catch (\Throwable $e){
                DB::rollBack();
                return ['error' => $e->getMessage()];
            }
        return $backend_setting;
    }

    public function getBackendSetting(){
        $backend_setting = BackendSetting::select('id','vendor_setting')->first();
        return $backend_setting;
    }

    // --------------
	public function index(){

        $backend_setting = $this->getBackendSetting();
        $checkPermission = $this->checkPermission(Constants::viewAnyAbility, BackendSetting::class, "admin.index");
        $dataArr = [
            'checkPermission' => $checkPermission,
            'backend_setting' => $backend_setting,
        ];
        return $dataArr;
    }


   

}
