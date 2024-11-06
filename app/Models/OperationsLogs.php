<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\DealsTracking;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OperationsLogs extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'operations_logs';

    protected $guarded = [];

    protected $appends = ['log_date', 'log_date_time_iso'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function getLogDateAttribute()
    {
        return Carbon::createFromDate($this->completed_at)->format('d-m-Y H:i A');
    }

    public function getLogDateTimeIsoAttribute()
    {
        if(!empty($this->completed_at)) {
            if(app()->getLocale() == 'es') {
                return Carbon::createFromDate($this->completed_at)->format('j') .' de '. config('constants.MONTHS_NAME')[Carbon::createFromDate($this->completed_at)->format('m')] .' de '. Carbon::createFromDate($this->completed_at)->format('Y');
            } else {
                return  Carbon::createFromDate($this->completed_at)->format('F') .' '. Carbon::createFromDate($this->completed_at)->format('j') .', '. Carbon::createFromDate($this->completed_at)->format('Y');
            }
        } else {
            return  '-';
        }
        // return Carbon::createFromDate($this->completed_at)->format('jS F Y H:i A');
    }

    protected static function operationsAddLogs($step_id, $is_current = '0', $log_type = "Seller", $offer_id = null)
    {
        $deals_tracking = DealsTracking::where('offer_id', $offer_id)->first();    
        
        if(is_null($deals_tracking)){
            DealsTracking::TrackingAdd($offer_id);
            $deals_tracking = DealsTracking::where('offer_id', $offer_id)->first();   
        }
    
        if($log_type == 'Seller') {
            $log_title = collect(json_decode($deals_tracking->tracking_seller))->where('step_id', $step_id)->first()->title_en ?? null;
        } else if($log_type == 'Buyer') {
            $log_title = collect(json_decode($deals_tracking->tracking_buyer))->where('step_id', $step_id)->first()->title_en ?? null;
        }
        if(isset($log_title) && !is_null($log_title) && !empty($log_type))
        {
            if($offer_id > 0) {
                $save_update = OperationsLogs::where('offer_id', $offer_id)->where('title', $log_title)->first();
            } else {
                $save_update = OperationsLogs::where('offer_id', $offer_id)->where('title', $log_title)->first();
            }
        
            if(is_null($save_update)){
                $save_update = new OperationsLogs;
            }
            
            $save_update->is_completed = '1';
            $save_update->is_current = $is_current;
            $save_update->title = $log_title;
            $save_update->log_types = $log_type;
            $save_update->offer_id = $offer_id;
            $save_update->completed_at = Carbon::now();
            $save_update->user_ip_address = app('common')->getUserIP();
            $save_update->user_device = app('common')->getUserDevice();
            $save_update->user_id = Auth()->user()?->id;
            return $save_update->save();
        }
    }
    
    protected static function operationsAddLogsTitle($operation_id = null, $title, $offer_id = null)
    {
        $save_update = new OperationsLogs;
        $save_update->is_completed = 0;
        $save_update->is_current = 0;
        $save_update->operation_id = $operation_id;
        $save_update->offer_id = $offer_id;
        $save_update->title = $title;
        $save_update->log_types = 'All';
        $save_update->completed_at = Carbon::now();
        $save_update->user_ip_address = app('common')->getUserIP();
        $save_update->user_device = app('common')->getUserDevice();
        $save_update->user_id = Auth()->user()?->id;
        return $save_update->save();
    }

    protected static function booted()
    {
        static::creating(function ($OperationsLogs) {
            $OperationsLogs->created_by = Auth()->user()?->id;
            $OperationsLogs->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($OperationsLogs) {
            $OperationsLogs->updated_by = Auth()->user()?->id;
        });
    }
}
