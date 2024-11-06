<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class FaqType extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;
    use HasTranslations,LogsActivity;

    protected $guarded = [];
    public $translatable = ['name'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($faqType) {            
            $faqType->created_by = Auth()->user()?->id;
            $faqType->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($faqType) {
            $faqType->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }
}
