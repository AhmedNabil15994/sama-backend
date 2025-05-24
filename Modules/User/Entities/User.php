<?php

namespace Modules\User\Entities;

use Illuminate\Support\Carbon;
use Modules\Course\Entities\Course;
use Modules\Course\Entities\Note;
use Modules\Exam\Entities\UserExam;
use Modules\Order\Entities\Address;
use Modules\Order\Entities\NoteOrder;
use Modules\Order\Entities\Order;
use Modules\Package\Entities\Package;
use Modules\Trainer\Entities\Trainer;
use Modules\Trainer\Entities\TrainerProfile;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Hash;
use Modules\Core\Traits\ScopesTrait;
use Spatie\Permission\Traits\HasRoles;
use Modules\Order\Entities\OrderCourse;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\InteractsWithMedia;
use Modules\Core\Traits\Dashboard\CrudModel;
use Modules\DeviceToken\Traits\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Staudenmeir\EloquentJsonRelations\Relations\Postgres\HasOne;

class User extends Authenticatable implements HasMedia
{
    use CrudModel{
        __construct as private CrudConstruct;
    }

    use Notifiable , HasRoles , InteractsWithMedia,HasApiTokens;

    use SoftDeletes {
      restore as private restoreB;
    }
    protected $guard_name = 'web';
    protected $appends = ['image_file'];
    protected $dates = [
      'deleted_at'
    ];

    protected $fillable = [
        'name', 'email', 'password', 'mobile' , 'image','academic_year_id','first_login','logged'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setLogAttributes(['name', 'email', 'password', 'mobile' , 'image']);

    }

    public function setImageAttribute($value)
    {
        if (!$value) {
            $this->attributes['image'] = '/uploads/users/user.png';
        }
        $this->attributes['image'] = $value;
    }

    public function getImageFileAttribute()
    {
        return $this->image ? $this->image :  '/uploads/users/user.png';
    }

      public function setPasswordAttribute($value)
    {
        if ($value === null || !is_string($value)) {
            return;
        }
        $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
    }



    public function restore()
    {
        $this->restoreB();
    }


    public function favouriteCourses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function trainer()
    {
        return $this->hasOne(TrainerProfile::class,'id','trainer_id');
    }


    public function orderCourses(): HasManyThrough
    {
        return $this->hasManyThrough(OrderCourse::class, Order::class);
    }

    public function orderNotes(): HasManyThrough
    {
        return $this->hasManyThrough(NoteOrder::class, Order::class);
    }


    public function address()
    {
        return $this->hasOne(Address::class, 'user_id');
    }


    public function userExams()
    {
        return $this->hasMany(UserExam::class, 'user_id');
    }

    public function fcmTokens()
    {
        return $this->hasMany(FirebaseToken::class);
    }

    public function getMyCoursesAttribute()
    {
        if($this->email == 'admin@tocaan.com'){
            return Course::with(['categories']);
        }

        $packageCourses = [];
        $packages = Package::where(fn($q) => $q->whereHas('orders', fn($q) => $q->UserAccess($this->id, 'order_package')))->pluck('settings')->toArray();
        $nestedPackagesIds = array_map(function($element){
            if(isset($element['courses']) && count($element['courses'])){
                return $element['courses'];
            }
        }, $packages);

        foreach($nestedPackagesIds as $ids){
            $packageCourses = array_merge($packageCourses,$ids);
        }
        if(auth()->check() && auth()->user()->can('trainer_access')){
            return Course::with(['categories'])->where('trainer_id',auth()->id());
        }else if(auth()->check() && auth()->user()->can('dashboard_access')){
            return Course::with(['categories']);
        }
        return Course::with(['categories'])
        ->where(fn ($q) => $q->whereHas('orders', fn ($q) => $q->UserAccess($this->id)))
        ->orWhereIn('id', $packageCourses);
    }

    public function getMyNotesAttribute()
    {
        if($this->email == 'developer@tocaan.com'){
            return Note::with(['category']);
        }

        $packageNotes = [];
        $packages = Package::where(fn($q) => $q->whereHas('orders', fn($q) => $q->UserAccess($this->id, 'order_package')))->pluck('settings')->toArray();

        $nestedPackagesIds = array_map(function($element){
            if(isset($element['notes']) && count($element['notes'])){
                return $element['notes'];
            }
        }, $packages);

        foreach($nestedPackagesIds as $ids){
            if($ids)
                $packageNotes = array_merge($packageNotes,$ids);
        }

        return Note::where(fn ($q) => $q->whereHas('orders', fn ($q) => $q->UserAccess($this->id, 'note_order')))
        ->orWhereIn('id', $packageNotes);
    }

    public function getMyPackagesAttribute()
    {
        if($this->email == 'developer@tocaan.com'){
            return Package::with(['prices']);
        }

        return Package::where(fn($q) => $q->whereHas('orders', fn($q) => $q->UserAccess($this->id, 'order_package')));
    }

}
