<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InviteFriends extends Model
{
    use HasFactory;
    use Uuid,LogsActivity;

    protected $table = 'invite_friends';
    
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($invite_friends) {
            $invite_friends->created_by = Auth()->user()?->id;
            $invite_friends->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($invite_friends) {
            $invite_friends->updated_by = Auth()->user()?->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
