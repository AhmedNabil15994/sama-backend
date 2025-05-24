<?php

namespace Modules\Exam\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserExamAnswer extends Model
{
    protected $fillable = ['user_exam_id', 'question_answer_id', 'degree','question_id', 'is_correct'];


    /**
     * Get the userExam that owns the UserExamAnswer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userExam(): BelongsTo
    {
        return $this->belongsTo(UserExam::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function questionAnswer(): BelongsTo
    {
        return $this->belongsTo(QuestionAnswer::class);
    }
}
