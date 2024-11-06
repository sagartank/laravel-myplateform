<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\UserLevel;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Plan extends Model
{
    use HasFactory,LogsActivity;
    protected $guarded = [];
    /**
     * The features list.
     *
     * @var array
     */
    public static $planFeatures = [
        'buy_sell' => 'Buy & Sell',
        'basic_dashboard' => 'Basic Dashboard',
        'enterprise_dashboard' => 'Enterprise Dashboard',
        'multi_user_account' => 'Multi User Account',
        'exportable_pdf' => 'Exportable PDF',
        'offer_notifications' => 'Offer Notifications',
        'legal_advice' => 'Legal Advice',
        'monthly_reports' => 'Monthly Reports',
        'newsletters' => 'Newsletters',
        'investor_commission' => 'Investor Commission',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function getExpiredDateAttribute($value)
    {
        if($this->duration == "month") {
            $expDate = Carbon::now()->addMonth();
        }else{
            $expDate = Carbon::now()->addYear();
        }
        return $expDate;
    }

    public function userLevel(){
        return $this->belongsTo(UserLevel::class,'user_level_id','id');
    }
}
