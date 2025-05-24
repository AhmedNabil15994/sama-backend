<?php

namespace Modules\Course\Http\Requests\Trainer;

use Illuminate\Foundation\Http\FormRequest;

class ReviewQuestionAnswerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
//            'review_question_id'           => 'required',
            'user_id'           => 'required',
            'answer'           => 'required',
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
