<?php
namespace Modules\Core\Http\Services;

use App\Http\Services\PsService;
use Illuminate\Support\Facades\DB;
use Modules\Core\Entities\Project;

class BuilderSettingService extends PsService
{
    public function getProject(){
        $project = Project::first();

        return $project;
    }

    public function index() {
        $project = $this->getProject();

        $dataArr = [
            'builder_setting' => $project
        ];

        return $dataArr;
    }

    public function update($request, $id) {
        try{
            DB::beginTransaction();
            $builder_setting = Project::find($id);
            $builder_setting->project_url = $request->project_url;
            $builder_setting->token = $request->token;
            $builder_setting->update();
            DB::commit();
        }catch (\Throwable $e){
            DB::rollBack();
            return ['error' => $e->getMessage()];
        }

        return $builder_setting;
    }
}
