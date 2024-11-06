<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Crypt;

class UserProfileAttach extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;

    protected $table = 'user_profile_attaches';
    
    protected $guarded = [];

    protected $appends = ['user_attach_image_url'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($issuers_attach_images) {
            $issuers_attach_images->created_by = Auth()->user()?->id;
            $issuers_attach_images->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($issuers_attach_images) {
            $issuers_attach_images->updated_by = Auth()->user()?->id;
        });
    }

    public function getUserAttachImageUrlAttribute()
    {
        if($this->path!='') {
            return route('secure-image', Crypt::encryptString($this->path));
        } else {
            return asset('images/blank.png');
        }
    }

}
?>
