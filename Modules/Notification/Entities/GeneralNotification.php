<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\HasTranslations;
use Modules\User\Entities\User;
use Modules\Core\Traits\ScopesTrait;

class GeneralNotification extends Model
{
    use SoftDeletes;
    use ScopesTrait;
    use HasTranslations;

    protected $table = 'general_notifications';
    protected $guarded = ['id'];
    protected $appends = ['morph_model'];

    public $translatable = ['title','body'];

    public function getMorphModelAttribute()
    {
        return !is_null($this->notifiable) ? (new \ReflectionClass($this->notifiable))->getShortName() : null;
    }

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
