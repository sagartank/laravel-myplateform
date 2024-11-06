<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class SocialMedia extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;
    use LogsActivity;

    protected $table = 'social_media';

    protected $guarded = [];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($socialMedia) {            
            $socialMedia->created_by = Auth()->user()?->id;
            $socialMedia->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($socialMedia) {
            $socialMedia->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
}
