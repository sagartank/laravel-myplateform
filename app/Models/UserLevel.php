<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserLevel extends Model
{
    use HasFactory;
    use Uuid,LogsActivity;

    protected $table = 'user_level';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($userLevel) {
            $userLevel->created_by = Auth()->user()?->id;
            $userLevel->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($userLevel) {
            $userLevel->updated_by = Auth()->user()?->id;
        });
    }

    public static function getUserLevel()
    {
        return self::get();
    }

}
