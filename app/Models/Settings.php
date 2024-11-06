<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Settings extends Model
{
    use HasFactory;
    use Uuid,LogsActivity;

    public $table = 'settings';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($setting) {            
            $setting->created_by = Auth()->user()?->id;
            $setting->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($setting) {
            $setting->updated_by = Auth()->user()?->id;
        });
    }
}
