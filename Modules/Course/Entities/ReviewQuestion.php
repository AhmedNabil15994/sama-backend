<?php

namespace Modules\Course\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;
use Modules\User\Entities\User;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class ReviewQuestion extends Model implements HasMedia
{
    use HasTranslations;
    use ScopesTrait;
    use SoftDeletes;
    use InteractsWithMedia;

    protected $fillable = ['title', 'status','course_id', 'lesson_content_id','user_id','question'];

    public $translatable  = ['title'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(ReviewQuestionAnswer::class);
    }

    public function getImageAttribute()
    {
        return $this->getFirstMediaUrl('images') ?? null;
    }
}
