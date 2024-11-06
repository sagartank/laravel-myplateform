<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserAlertNotify extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'users_alert_notify';
    
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($user_alert_notify) {
            $user_alert_notify->created_by = Auth()->user()?->id;
            $user_alert_notify->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($user_alert_notify) {
            $user_alert_notify->updated_by = Auth()->user()?->id;
        });
    }
}
