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

class HowToWork extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;
    use HasTranslations,LogsActivity;
    
    protected $table = 'how_to_work';

    protected $guarded = [];

    public $translatable = ['heading_text_buyer', 'sub_heading_text_buyer', 'button_text_buyer', 'heading_text_seller', 'sub_heading_text_seller', 'button_text_seller'];

    
    protected $appends = ['seller_image_url', 'buyer_image_url'];

    public function getSellerImageUrlAttribute()
    {
        if($this->seller_image!='') {
            return route('secure-image', Crypt::encryptString($this->seller_image));
        } else {
            return asset('images/blank.png');
        }
    }

    public function getBuyerImageUrlAttribute()
    {
        if($this->buyer_image!='') {
            return route('secure-image', Crypt::encryptString($this->buyer_image));
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
        static::creating(function ($how_to_work) {            
            $how_to_work->created_by = Auth()->user()?->id;
            $how_to_work->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($how_to_work) {
            $how_to_work->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 1);
    }
}
