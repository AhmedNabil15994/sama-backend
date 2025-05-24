<?php

namespace Modules\Trainer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Modules\Core\Traits\HasTranslations;
use Modules\Core\Traits\ScopesTrait;

class TrainerProfile extends Model
{
    use HasTranslations ;
    use ScopesTrait;

    protected $table = 'trainer_profile';
    protected $fillable = [
        'facebook' ,
        'linkedin' ,
        'twitter' ,
        'instagram' ,
        'youtube',
        'status' ,
        'trainer_id',
        'about',
        'job_title',
        'country',
    ];

    public $translatable 	= [ 'about' , 'job_title' , 'country'];

    public function user()
    {
        return $this->belongsTo(User::class,'trainer_id','id');
    }
}
