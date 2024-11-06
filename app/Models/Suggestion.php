<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Suggestion extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'suggestion';
    
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($suggestion) {
            $suggestion->user_id = Auth()->user()?->id;
            $suggestion->created_by = Auth()->user()?->id;
            $suggestion->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($rating) {
            $suggestion->user_id = Auth()->user()?->id;
            $suggestion->updated_by = Auth()->user()?->id;
        });
    }
}
