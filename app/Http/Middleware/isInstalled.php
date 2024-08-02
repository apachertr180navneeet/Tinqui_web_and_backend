<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Core\Entities\Installer;
use Modules\Core\Entities\DomainChange;

class isInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {


        $installedFile = file_exists(storage_path('installed'));
        $current_domain = config("app.base_domain");
        $current_subFolder = config("app.dir");

        $installerTable = Schema::hasTable('installer');
        $domainTable = Schema::hasTable('domain_changes');
        $previous_domain = '';
        if($domainTable){
            $previous_domain = DomainChange::first();
        }

        if ($installerTable){

            $isInstalled = Installer::first() ? Installer::first()->is_installed : '';
            if (!$installedFile && empty($isInstalled)){
                // dd("here");


                return redirect()->route('LaravelInstaller::welcome');
            }else{
                if(!empty($previous_domain)){
                    if($current_subFolder != ''){
                        if($current_subFolder != $previous_domain->sub_folder){
                            return redirect()->route('LaravelInstaller::welcome');
                        }
                        if($current_domain != $previous_domain->domain_name){
                            return redirect()->route('LaravelInstaller::welcome');
                        }
                    }
                    else{
                        if($current_subFolder != $previous_domain->sub_folder){
                            return redirect()->route('LaravelInstaller::welcome');
                        }
                        if($current_domain != $previous_domain->domain_name){
                            return redirect()->route('LaravelInstaller::welcome');
                        }
                    }
                }
            }
        }

        return $next($request);
    }
}
