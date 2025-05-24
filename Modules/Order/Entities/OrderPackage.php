<?php

namespace Modules\Order\Entities;

use Modules\Course\Entities\Note;
use Illuminate\Database\Eloquent\Model;
use Modules\Package\Entities\Package;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;
use Illuminate\Database\Eloquent\Builder;
use Modules\Category\Entities\Category;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Modules\Course\Entities\Course;

class OrderPackage extends Model
{

    use HasJsonRelationships {
        HasJsonRelationships::getAttributeValue as getAttributeValueJson;
    }
    protected $table = "order_package";
    protected $fillable = [
        'has_offer',
        'offer_price',
        'total',
        'expired_date',
        'period',
        'settings',
        'package_id',
        'order_id',
        'user_id',
    ];

    protected $appends = ['expired_date_format'];
    public $casts = [
        'settings' => SchemalessAttributes::class,
    ];

    public function getExpiredDateFormatAttribute()
    {
        return $this->expired_date ? date('d-m-Y', strtotime($this->expired_date)) : '';
    }
    public function scopeWithSettings(): Builder
    {
        return $this->settings->modelScope();
    }

    public function package()
    {
        return $this->belongsTo(Package::class)->withTrashed();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function courses()
    {
        return $this->belongsToJson(Course::class, 'settings->courses');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'settings->category_id');
    }
    public function notes()
    {
        return $this->belongsToJson(Note::class, 'settings->notes');
    }
}
