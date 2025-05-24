<?php

namespace Modules\Exam\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Question extends Model implements HasMedia
{
    use HasTranslations ;
    use SoftDeletes ;
    use ScopesTrait;
    use InteractsWithMedia;
    protected $fillable  = ['question','exam_id','type'];
    protected $appends = ['correct_answer', 'image', 'audio'];
    public $translatable  = ['question'];

    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images') != "" ? $this->getFirstMediaUrl('images') : null;
    }

    public function getAudioAttribute()
    {
        return $this->getFirstMediaUrl('audio') != "" ? $this->getFirstMediaUrl('audio') : null;
    }

    public function getCorrectAnswerAttribute(){
        return $this->answers()->orderBy('degree','desc')->first();
    }
}
