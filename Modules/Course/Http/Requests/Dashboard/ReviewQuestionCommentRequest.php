<?php

namespace Modules\Course\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ReviewQuestionCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lesson_content_id'           => 'required',
            'question'           => 'required',
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

    public function messages()
    {
        $v = [
            'question.required'   => __('course::dashboard.reviewquestions.question'),
        ];

        return $v;
    }
}
