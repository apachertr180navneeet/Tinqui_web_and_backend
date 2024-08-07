<?php
namespace Modules\Core\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Modules\Chat\Entities\UserBought;
use Maatwebsite\Excel\Concerns\WithMapping;

class BuyerReportExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::join('user_boughts', 'users.id', '=', 'user_boughts.buyer_user_id')
            ->select('users.*', DB::raw("count(user_boughts.buyer_user_id) as purchased_item_count"))
            ->with(['roles'])
            ->groupBy('buyer_user_id')
            ->orderBy('purchased_item_count', 'desc')
            ->get();
    }

    public function map($user) : array {
        return [
            $user->name,
            $user->email,
            $user->user_phone,
            $user->purchased_item_count,
            $user->user_address,
            $user->user_about_me,
            $user->roles?$user->roles[0]->name:'Registered User',
            $user->status,
            $user->is_banned?$user->is_banned:'0',
            $user->overall_rating,
            $user->user_lat,
            $user->user_lng,
            $user->added_date->format('d-M-Y') . ' (' . $user->added_date->diffForHumans() . ')',
        ];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Name", "Email", "Phone", "Purchased Item Count", "Address", "About Me","Role", "Status", "Is Banned", "Overall Rating", "Latitude", "Longitude", "Registered Date"];
    }

}
