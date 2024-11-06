<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class CounterOffer extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'counter_offers';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $appends = ['counter_offer_expire_days', 'counter_offer_expire_date_iso', 'counter_offer_expire_hour'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function getCounterOfferExpireDaysAttribute()
    {
        $datework = Carbon::createFromDate($this->expires_at);
        $now = Carbon::now();
        return $datework->diffInDays($now);
    }

    public function getCounterOfferExpireHourAttribute()
    {
        $datework = Carbon::createFromDate($this->expires_at);
        $now = Carbon::now();
        return $datework->diffInHours($now);
    }

    public function getCounterOfferExpireDateIsoAttribute()
    {
        return Carbon::createFromDate($this->expires_at)->format('jS F Y');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($counterOffer) {
            $counterOffer->created_by = Auth()->user()?->id;
            $counterOffer->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($counterOffer) {
            $counterOffer->updated_by = Auth()->user()?->id;
        });
    }
}
