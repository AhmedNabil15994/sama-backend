<?php

namespace Modules\Course\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class AddAnswerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'answer' => 'required|string',
            //'question_id' => 'required|integer|exists:review_questions,id'
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
