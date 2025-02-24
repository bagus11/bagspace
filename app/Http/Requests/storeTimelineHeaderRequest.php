<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class storeTimelineHeaderRequest extends FormRequest
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
            'name'=>'required',
            'description'=>'required',
            'team_id'=>'required',
            'office_id'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            // 'type_id'=>'required',
            
        ];
    }
}
