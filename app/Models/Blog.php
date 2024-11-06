<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Spatie\Translatable\HasTranslations;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;
    use HasTranslations,LogsActivity;

    protected $guarded = [];

    public $translatable = ['title', 'excerpt', 'body'];

    protected $appends = ['blog_image_url'];
    
    public function getBlogImageUrlAttribute()
    {
        if($this->thumbnail!='') {
            return route('secure-image', Crypt::encryptString($this->thumbnail));
        } else {
            return asset('images/blank.png');
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($blog) {            
            $blog->created_by = Auth()->user()?->id;
            $blog->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($blog) {
            $blog->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function blog_users()
    {
        return $this->hasMany(BlogUsersLink::class, 'blog_id', 'id');
    }
}
