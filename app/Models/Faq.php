<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Faq extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;
    use HasTranslations,LogsActivity;

    protected $guarded = [];
    public $translatable = ['question', 'answer'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($faq) {            
            $faq->created_by = Auth()->user()?->id;
            $faq->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($faq) {
            $faq->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function type()
    {
        return $this->belongsTo(FaqType::class, 'faq_type_id');
    }
}
