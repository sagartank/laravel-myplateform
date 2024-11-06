<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BlogUsersLink extends Model
{
    use HasFactory;
    use SoftDeletes,LogsActivity;

    protected $table = 'blog_users_link';
    
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($blog_users_link) {
            $blog_users_link->created_by = Auth()->user()?->id;
            $blog_users_link->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($blog_users_link) {
            $blog_users_link->updated_by = Auth()->user()?->id;
        });
    }

}
