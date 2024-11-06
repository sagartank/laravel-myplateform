<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Rating extends Model
{
    use HasFactory,LogsActivity;
    
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function rating_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function ratingable()
    {
        return $this->morphTo();
    }

    protected static function booted()
    {
        static::creating(function ($rating) {
            $rating->user_id = Auth()->user()?->id;
            $rating->created_by = Auth()->user()?->id;
            $rating->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($rating) {
            $rating->user_id = Auth()->user()?->id;
            $rating->updated_by = Auth()->user()?->id;
        });
    }
}
