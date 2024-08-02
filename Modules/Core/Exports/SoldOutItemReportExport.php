<?php


namespace Modules\Core\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Modules\Core\Entities\BackendSetting;
use Modules\Core\Entities\Item;
use Modules\Core\Constants\Constants;
use Maatwebsite\Excel\Concerns\WithMapping;
use Modules\Core\Entities\CustomizeUi;

class SoldOutItemReportExport implements FromCollection, WithHeadings, WithMapping
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $itemRelation =[
            'category',
            'subcategory',
            'city',
            'township',
            'currency',
            'itemRelation.uiType',
            'itemRelation.customizeUi',
            'owner',
            'itemRelation'
        ];
        $items = Item::with($itemRelation)
        ->selectRaw($this->getSqlForCustomField())
        ->leftJoin('item_infos', 'item_infos.item_id','=', 'items.id')
        ->leftJoin('customize_ui_details','item_infos.value','=','customize_ui_details.id')
        ->join('user_boughts','user_boughts.item_id','=','items.id')
        ->groupBy('items.id')
        ->latest('items.added_date');

        $soldOutItems = Item::with($itemRelation)
        ->selectRaw($this->getSqlForCustomField())
        ->leftJoin('item_infos', 'item_infos.item_id','=', 'items.id')
        ->leftJoin('customize_ui_details','item_infos.value','=','customize_ui_details.id')
        ->where('is_sold_out', 1)
        ->groupBy('items.id')
        ->latest('items.added_date');

        return $items->union($soldOutItems)->get();
    }

    public function map($item) : array {
        return [
            $item->title,
            $item->owner?$item->owner->name:'',
            $item->owner?$item->owner->email:'',
            $item->category?$item->category->name:'',
            $item->price,
            $item[Constants::itmPurchasedOption . '@@name'],
            $item[Constants::itmItemType . '@@name'],
            $item[Constants::itmDealOption . '@@name'],
            $item->added_date->format('Y/m/d'),
        ];
    }

    public function getSqlForCustomField(){
        $sql = "items.*, ";
        $customizeUis = CustomizeUi::where('module_name', 'itm')->latest()->get();

        $customizeuideatil_array = [];

        foreach ($customizeUis as $CustomizeUiDetail) {
            if ($CustomizeUiDetail->ui_type_id == Constants::dropDownUi || $CustomizeUiDetail->ui_type_id == Constants::radioUi || $CustomizeUiDetail->ui_type_id == Constants::multiSelectUi) {
                $customizeuideatil_array[$CustomizeUiDetail->core_keys_id . '@@name'] = $CustomizeUiDetail->core_keys_id;
            }
        }

        foreach (array_unique($customizeuideatil_array) as $key => $customizeuideatil) {
            $sql .= "max(case when item_infos.core_keys_id = '$customizeuideatil' then customize_ui_details.name end) as '$key',";
        }
        foreach ($customizeUis as $key => $customizeUi) {
            if ($key + 1 == count($customizeUis)) {
                $sql .= "max(case when item_infos.core_keys_id = '$customizeUi->core_keys_id' then item_infos.value end) as '$customizeUi->core_keys_id'";
            } else {
                $sql .= "max(case when item_infos.core_keys_id = '$customizeUi->core_keys_id' then item_infos.value end) as '$customizeUi->core_keys_id' ,";
            }
        }
        return $sql;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ["Item Name", "Seller Name", "Email", "Categories", "Price", "Purchased Option", "Item Type", "Deal Option", "Sold Out Date"];
    }
}
