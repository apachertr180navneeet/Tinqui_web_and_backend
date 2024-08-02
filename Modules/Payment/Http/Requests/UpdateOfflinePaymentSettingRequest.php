<?php

namespace Modules\Payment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOfflinePaymentSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|unique:core_keys,name,' . request()->core_keys_id . ',core_keys_id',
            'description' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
