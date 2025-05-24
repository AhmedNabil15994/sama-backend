<?php

namespace Modules\Course\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class UserVideoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'totalPlayed'      =>'required',
           'lesson_content_id'=>'required',
           'percent'=>'required',
           'video_duration'=>'required',
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
