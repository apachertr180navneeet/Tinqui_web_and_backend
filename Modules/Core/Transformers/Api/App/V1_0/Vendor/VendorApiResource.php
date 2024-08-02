<?php

namespace Modules\Core\Transformers\Api\App\V1_0\Vendor;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Core\Transformers\Api\App\V1_0\Vendor\VendorInfoApiResource;
use Modules\Core\Transformers\Api\App\V1_0\CoreImage\CoreImageApiResource;
use Modules\Core\Transformers\Api\App\V1_0\Vendor\VendorApplicationApiResource;

class VendorApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */

    public function toArray($request)
    {
        $product_count = 0;
        if(isset($this->id)){
            $product_count = productCountByVendorId($this->id);
        }
        return [
            'id' => isset($this->id)?(string)$this->id:'',
            'owner_user_id' => isset($this->owner_user_id)?(string)$this->owner_user_id:'',
            'status' => isset($this->status)?(string)$this->status:'',
            'name' => isset($this->name)?(string)$this->name:'',
            "phone" => isset($this->phone)?(string)$this->phone:'',
            "email" => isset($this->email)?(string)$this->email:'',
            'address' => isset($this->address)?(string)$this->address:'',
            'description' => isset($this->description)?(string)$this->description:'',
            'website' => isset($this->website)?(string)$this->website:'',
            'facebook' => isset($this->facebook)?(string)$this->facebook:'',
            'instagram' => isset($this->instagram)?(string)$this->instagram:'',
            'product_count' => (string)$product_count,
            'added_date' => isset($this->added_date)?(string)$this->added_date:'',
            "logo" => new CoreImageApiResource(isset($this->logo) && $this->logo ? $this->whenLoaded('logo'): []),
            "banner_1" => new CoreImageApiResource(isset($this->banner_1) && $this->banner_1 ? $this->whenLoaded('banner_1'): []),
            "banner_2" => new CoreImageApiResource(isset($this->banner_2) && $this->banner_2 ? $this->whenLoaded('banner_2'): []),
            "vendor_application" => new VendorApplicationApiResource(isset($request->owner_user_id) && isset($this->vendor_application) && $this->vendor_application ? $this->whenLoaded('vendor_application'): []),
            "added_date_str" => isset($this->added_date)?(string)$this->added_date->diffForHumans():'',
            "is_empty_object" => $this->when(!isset($this->id),1),
            'updated_flag' => isset($this->updated_flag)?(string)$this->updated_flag:'',
            "vendorRelation" => VendorInfoApiResource::collection(isset($this->vendorInfo) && count($this->vendorInfo)>0 ? $this->whenLoaded('vendorInfo'): ['xxx']),
        ];
    }
}
