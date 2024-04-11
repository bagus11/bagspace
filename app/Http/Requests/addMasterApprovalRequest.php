<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class addMasterApprovalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'step' =>['integer','required'],
            'location_id' =>['integer','required','unique:master_approval,location_id'],
        ];
    }
}
