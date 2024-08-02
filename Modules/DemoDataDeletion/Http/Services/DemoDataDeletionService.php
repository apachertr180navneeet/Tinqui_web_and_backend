<?php

namespace Modules\DemoDataDeletion\Http\Services;

use App\Http\Services\PsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Core\Constants\Constants;
use Modules\Core\Entities\CoreImage;
use Modules\Core\Http\Services\ImageService;
use Modules\Core\Http\Services\MenuGroupService;
use Modules\DemoDataDeletion\Entities\DataResetlog;

class DemoDataDeletionService extends PsService
{
    protected $menuGroupService, $superAdminRoleId, $normalUserRoleId, $imageService;

    protected $upload_path = 'storage/uploads/';
    protected $thumb1x_path = 'storage/thumbnail/';
    protected $thumb2x_path = 'storage/thumbnail2x/';
    protected $thumb3x_path = 'storage/thumbnail3x/';

    public function __construct(MenuGroupService $menuGroupService, ImageService $imageService)
    {
        $this->menuGroupService = $menuGroupService;
        $this->imageService = $imageService;

        $this->superAdminRoleId= Constants::superAdminRoleId;
        $this->normalUserRoleId = Constants::normalUserRoleId;
        $this->superAdminRoleId = Constants::superAdminRoleId;
        $this->normalUserRoleId = Constants::normalUserRoleId;
    }

    public function index()
    {
        $relation = ['sub_menu_group'];
        $menus = $this->menuGroupService->getMenuGroups($relation);
        $dataArr = [
            "menus" => $menus,
        ];
        return $dataArr;
    }

    public function destroy(){
//        $systemTables = ['ad_post_types', 'authorizations', 'available_currencies', 'backend_settings', 'core_keys', 'core_field_filter_settings', 'core_reset_codes', 'core_key_types', 'core_data_deletions', 'core_privacy_policies', 'core_menu_groups', 'core_modules', 'core_sub_menu_groups', 'frontend_settings', 'languages', 'language_strings', 'migrations', 'mobile_languages', 'mobile_language_strings', 'mobile_settings', 'modules', 'permissions', 'personal_access_tokens', 'ui_types', 'payments','payment_infos', 'payment_attributes', 'payment_statuses', 'core_key_payment_relations', 'sessions' ];
//        $someRemoveTables = [ 'roles', 'role_permissions', 'users', 'user_permissions', 'core_key_counters', 'core_images' ];

        // System Tables
        $systemTables = ['block_users', 'blogs', 'blue_mark_users', 'categories', 'chat_histories', 'chat_notis', 'contacts', 'currencies', 'customize_ui_details', 'favourites', 'item_discounts', 'follow_users', 'item_infos', 'item_reports', 'items', 'location_cities', 'location_city_infos', 'location_townships', 'package_bought_transactions', 'paid_item_histories', 'push_notification_messages', 'push_notification_tokens', 'push_notification_users', 'ratings', 'search_histories', 'subcat_subscribes', 'subcategories', 'touches', 'user_boughts', 'user_infos'];
        $someRemoveSystemTables = ['core_images', 'user_permissions', 'role_permissions'];

        // default Include Tables
        $defaultIncludeTables = ['team_invitations', 'team_user', 'teams'];
        $someRemoveDefaultIncludeTables = ['users'];

        // Include In Ecommerce Tables
        $ecommerceTables = ['shippings', 'shop_custom_fields', 'shops', 'transaction_counts', 'transaction_details', 'transaction_headers', 'transaction_statuses', 'user_address_information', 'user_shops'];

        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
                foreach ($table as $key => $value) {
                    if(in_array($value, $systemTables)) {

                        DB::table($value)->delete();

                    } else if(in_array($value, $someRemoveSystemTables)) {

                        if($value == 'user_permissions' ){
                            $user_role_conds['user_id'] = $this->superAdminRoleId;
                            $user_role_conds['role_id'] = $this->superAdminRoleId;
                            DB::table($value)->whereNot($user_role_conds)->delete();
                        } else if($value == 'role_permissions' ){
                            $role_permission_conds['role_id'] = $this->superAdminRoleId;
                            DB::table($value)->whereNot($role_permission_conds)->delete();
                        }else if($value == 'core_images'){
                            $img_conds = ['backend-login-image', 'backend-logo', 'fav-icon', 'about'];
                            $images = $this->imageService->getImages(null, null, null, null, $img_conds)->pluck('img_path');

                            // delete file first
                            foreach ($images as $image) {
                                Storage::delete($this->upload_path . $image);
                                Storage::delete($this->thumb1x_path . $image);
                                Storage::delete($this->thumb2x_path . $image);
                                Storage::delete($this->thumb3x_path . $image);
                            }

                            // delete data from db second
                            DB::table($value)->whereNotIn('img_type', $img_conds)->delete();

                        }

                    } else if(in_array($value, $defaultIncludeTables)) {

                        DB::table($value)->delete();

                    } else if(in_array($value, $someRemoveDefaultIncludeTables)) {

                        if($value == 'users'){
                            $user_conds = [$this->superAdminRoleId];
                            DB::table($value)->whereNotIn('role_id', $user_conds)->delete();
                        }

                    } else if(in_array($value, $ecommerceTables)) {
                        DB::table($value)->delete();
                    }
                }
            }

        $dataResetLog = new DataResetlog();
        $dataResetLog->user_id = Auth::id();
        $dataResetLog->date = Carbon::now();
        $dataResetLog->save();

        $activityLogs = [
            __('block_users_tb_del'),
            __('blogs_tb_del'),
            __('blue_mark_users_tb_del'),
            __('categories_tb_del'),
            __('chat_histories_tb_del'),
            __('chat_notis'),
            __('contacts_tb_del'),
            __('currencies_tb_del'),
            __('customize_ui_details_tb_del'),
            __('favourites_tb_del'),
            __('item_discounts_tb_del'),
            __('follow_users_tb_del'),
            __('item_infos_tb_del'),
            __('item_reports_tb_del'),
            __('items_tb_del'),
            __('location_cities_tb_del'),
            __('location_city_infos_tb_del'),
            __('location_townships_tb_del'),
            __('package_bought_transactions_tb_del'),
            __('paid_item_histories_tb_del'),
            __("push_notification_messages_tb_del"),
            __('push_notification_tokens_tb_del'),
            __('push_notification_users_tb_del'),
            __('ratings_tb_del'),
            __('search_histories_tb_del'),
            __('subcat_subscribes_tb_del'),
            __('subcategories_tb_del'),
            __('touches__tb_del'),
            __('user_boughts_tb_del'),
            __('user_infos_tb_del'),
            __('core_images_tb_del'),
            __('user_permissions_tb_del'),
            __('role_permissions_tb_del'),
            __('team_invitations_tb_del'),
            __('team_user_tb_del'),
            __('teams_tb_del'),
            __('users_tb_del'),
            __('shippings_tb_del'),
            __('shop_custom_fields_tb_del'),
            __('shops_tb_del'),
            __('transaction_counts_tb_del'),
            __('transaction_details_tb_del'),
            __('transaction_headers_tb_del'),
            __('transaction_statuses_tb_del'),
            __('user_address_information_tb_del'),
            __('user_shops_tb_del')

        ];

        $dataArr = [
           "activityLogs" => $activityLogs
        ];

        return $dataArr;

    }
}
