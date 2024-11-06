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

class HomeSlide extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;
    use HasTranslations,LogsActivity;

    protected $guarded = [];
    public $translatable = ['title', 'text'];


    protected $appends = ['gif_image_url'];

    public function getGifImageUrlAttribute()
    {
        if($this->svg_image!='') {
            return route('secure-image', Crypt::encryptString($this->svg_image));
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
        static::creating(function ($homeSlide) {            
            $homeSlide->created_by = Auth()->user()?->id;
            $homeSlide->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($homeSlide) {
            $homeSlide->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
}
