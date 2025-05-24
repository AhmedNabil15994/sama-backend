<?php

namespace Modules\Course\Entities;

use Modules\Core\Traits\ScopesTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\Exam\Entities\Exam;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\MediaLibrary\HasMedia;

class LessonContent extends Model implements HasMedia
{
    use HasTranslations;
    use ScopesTrait;
    use InteractsWithMedia;

    public $fillable = ['title', 'order', 'type', 'lesson_id', 'video_id', 'video_link','is_free', 'exam_id','status'];
    public $translatable  = ['title'];

    // public function scopeActive($query)
    // {
    //     return $query->where('status', true)->where(function ($q) {
    //         $q->where('loading_status', 'loaded');
    //     });
    // }


    /**
     * Get the user that owns the LessonContent
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function video()
    {
        return $this->morphOne(Video::class, 'videoable');
    }


    public function userCompletes()
    {
        return $this->hasMany(UserComplation::class, 'lesson_content_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class,'exam_id','id');
    }

    /**
     * Get the user that owns the LessonContent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }


    public function availableTypes(): array
    {
        return __('course::dashboard.lessoncontents.form.types');
    }


    public function getIsCompletedAttribute()
    {
        return auth()->check() && $this->userCompletes()->where('user_id', auth()->id())->first() ? true : false;
    }

    public function getResourceFileAttribute()
    {
        return $this->getFirstMediaUrl('resources') != "" ? $this->getFirstMediaUrl('resources') : '';
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeTypeVideo($query)
    {
        return $query->where('type','video');
    }

    public function scopeTypeResource($query)
    {
        return $query->where('type','resource');
    }

    public function scopeTypeExam($query)
    {
        return $query->where('type','exam');
    }
}
