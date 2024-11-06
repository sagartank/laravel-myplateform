<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class HomeText extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;
    use HasTranslations,LogsActivity;

    protected $guarded = [];
    public $translatable = ['heading_text', 'sub_heading_text', 'footer_text'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($homeText) {            
            $homeText->created_by = Auth()->user()?->id;
            $homeText->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($homeText) {
            $homeText->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
}
