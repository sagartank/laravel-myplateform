<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OperationProgress;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DealsTracking extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'deals_tracking';

    public $timestamps = false;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public static function TrackingAdd($offer_id)
    {
        $logs = OperationProgress::select('id', 'step_type', 'step_links', 'title_en', 'title_es', 'cashed', 'rate', 'file_upload', 'is_active', 'qr_code', 'payment', 'mipo_commission_payment', 'order_position', 'order_position as step_id', 'manual_trigger', 'description as attention_mote')
            ->where('is_active', 'Yes')->orderBy('order_position', 'asc')
            ->get();
            
        $tracking_buyer = $logs->where('step_type', 'Buyer')->values()->toJson();

        $tracking_seller = $logs->where('step_type', 'Seller')->values()->toJson();

        $all_tracking_steps = $logs->toJson();

        $save_update = self::where('offer_id', $offer_id)->first();
        
        if(is_null($save_update)){
            $save_update = new DealsTracking;
        }

        $save_update->offer_id = $offer_id;
        $save_update->tracking_buyer = $tracking_buyer;
        $save_update->tracking_seller = $tracking_seller;
        $save_update->all_tracking_steps = $all_tracking_steps;

        return $save_update->save();
    }
}
