<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Claims extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'claims';
    
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($claims) {
            $claims->user_id = Auth()->user()?->id;
            $claims->created_by = Auth()->user()?->id;
            $claims->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($rating) {
            $claims->user_id = Auth()->user()?->id;
            $claims->updated_by = Auth()->user()?->id;
        });
    }
}
?>