<?php

namespace Modules\Course\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class AddNewQuestionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'question'      =>'required',
           'course_id'      =>'required',
           'lesson_id'      =>'required'
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
