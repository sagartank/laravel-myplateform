<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Favorite extends Model
{
    use HasFactory,LogsActivity;

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoriteable()
    {
        return $this->morphTo();
    }

    protected static function booted()
    {
        static::creating(function ($favorite) {
            $favorite->user_id = Auth()->user()?->id;
            $favorite->created_by = Auth()->user()?->id;
            $favorite->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($rating) {
            $favorite->user_id = Auth()->user()?->id;
            $favorite->updated_by = Auth()->user()?->id;
        });
    }
    
    public function issuer()
    {
        return $this->belongsTo(Issuer::class, 'issuer_id');
    }
}
