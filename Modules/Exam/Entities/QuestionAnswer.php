<?php

namespace Modules\Exam\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class QuestionAnswer extends Model implements HasMedia
{
    use HasTranslations ;
    use SoftDeletes ;
    use ScopesTrait, InteractsWithMedia;

    protected $fillable   = ['question_id','degree','answer', 'is_correct'];
    protected $appends = ['image'];
    public $translatable  = ['answer'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('answers_images') != "" ? $this->getFirstMediaUrl('answers_images') : null;
    }
}
