<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Issuer extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes,LogsActivity;

    protected $table = 'issuers';

    protected $guarded = [];

    protected $appends = ['age', 'company_image_url', 'ruc_code'];

    public function getRucCodeAttribute()
    {
        if(!empty($this->ruc_code_optional) && !is_null($this->ruc_code_optional)) {
            return $this->ruc_text_id .'-'.$this->ruc_code_optional;
        } else {
            return $this->ruc_text_id;
        }
    }

    public function getCompanyImageUrlAttribute()
    {
        if($this->issuers_image!='') {
            return route('secure-image', Crypt::encryptString($this->issuers_image));
        } else {
            return asset("images/mipo/no-image-company.svg");
        }
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    public function getAgeAttribute()
    {
        if(!empty($this->registered_at) && !is_null($this->registered_at)) {
            return Carbon::parse($this->registered_at)->age;
        }
    }

    protected static function booted()
    {
        static::creating(function ($issuer) {            
            $issuer->created_by = Auth()->user()?->id;
            $issuer->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($issuer) {
            $issuer->updated_by = Auth()->user()?->id;
        });
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function issuers_attach_images()
    {
        return $this->hasMany(IssuersattachImage::class, 'issuers_id', 'id');
    }
}
