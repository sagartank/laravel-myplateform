<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Carbon\Carbon;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OffersHistory extends Model
{
    use LogsActivity;
    protected $table = 'offers_history';

    protected $guarded = [];

    protected $appends = ['offer_expire', 'offer_expire_hour', 'offer_expire_date_iso', 'offer_create_date_iso'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    public function getOfferExpireAttribute()
    {
        $get_value = Carbon::createFromDate($this->expires_at)->diffForHumans();
        return str_replace('from now', '',  $get_value);
    }

    public function getOfferExpireDateIsoAttribute()
    {
        return Carbon::createFromDate($this->expires_at)->format('jS F Y');
    }

    public function getOfferCreateDateIsoAttribute()
    {
        if(!empty($this->created_at)) {
            if(app()->getLocale() == 'es') {
                return Carbon::createFromDate($this->created_at)->format('j') .' de '. config('constants.MONTHS_NAME')[Carbon::createFromDate($this->created_at)->format('m')] .' de '. Carbon::createFromDate($this->created_at)->format('Y H:i A');
            } else {
                return  Carbon::createFromDate($this->created_at)->format('F') .' '. Carbon::createFromDate($this->created_at)->format('j') .', '. Carbon::createFromDate($this->created_at)->format('Y H:i A');
            }
        } else {
            return  '-';
        }
        // return Carbon::createFromDate($this->created_at)->format('jS F, Y H:i A');
    }

    public function getOfferExpireHourAttribute()
    {
        $datework = Carbon::createFromDate($this->expires_at);
        $now = Carbon::now();
        return $datework->diffInHours($now);
    }

    protected static function booted()
    {
        static::creating(function ($offers_history) {
            $offers_history->created_by = Auth()->user()?->id;
            $offers_history->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($rating) {
            $offers_history->updated_by = Auth()->user()?->id;
        });
    }

    public function offer_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    protected static function create_offers_history($offers_obj, $counter_offer_amount = null) {
        if(isset($offers_obj) && $offers_obj->id > 0) {
                $amount = $offers_obj->amount;
            if(isset($counter_offer_amount) && $offers_obj->offer_status == 'Counter') {
                $amount = $counter_offer_amount;
            }
            $save_offers_history = new OffersHistory;
            $save_offers_history->offer_id  = $offers_obj->id;
            $save_offers_history->preferred_payment_method = $offers_obj->preferred_payment_method;
            $save_offers_history->amount =  $amount;
            $save_offers_history->retention = $offers_obj->retention;
            $save_offers_history->mipo_commission = $offers_obj->mipo_commission;
            $save_offers_history->mipo_plus_commission = $offers_obj->mipo_plus_commission;
            $save_offers_history->net_profit = $offers_obj->net_profit;
            $save_offers_history->is_mipo_plus = $offers_obj->is_mipo_plus;
            $save_offers_history->offer_status = $offers_obj->offer_status;
            $save_offers_history->offer_type = $offers_obj->offer_type;
            $save_offers_history->expires_at = $offers_obj->expires_at;
            $save_offers_history->save();
        }
    }

    protected static function offers_id_by_list($param, $pagination = false) {
        return OffersHistory::where('offer_id', $param['offer_id'])->with(['offer_by:id,name'])
            /* ->when($param, function($qry) use ($param) {
                if(isset($param['buyer_id'])) {
                    $qry->where('created_by', $param['buyer_id']);
                }
            }) */
            ->orderBy('id', 'desc')->get();
    }
}
?>
