<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Crypt;

class HomePartner extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid,LogsActivity;
    // use HasTranslations;

    protected $guarded = [];
    // public $translatable = ['title', 'text'];

    protected $appends = ['partner_image_url'];

    public function getPartnerImageUrlAttribute()
    {
        if($this->image!='') {
            return route('secure-image', Crypt::encryptString($this->image));
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
        static::creating(function ($homePartner) {            
            $homePartner->created_by = Auth()->user()?->id;
            $homePartner->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($homePartner) {
            $homePartner->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
}
