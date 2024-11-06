<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class userContractSingOtp extends Model
{
    use HasFactory;

    use LogsActivity;

    public $table ='user_contract_sing_otps';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($user_contract_sing_otp) {
            $user_contract_sing_otp->created_by = Auth()->user()?->id;
            $user_contract_sing_otp->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($user_contract_sing_otp) {
            $user_contract_sing_otp->updated_by = Auth()->user()?->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function user_contract_sing()
    {
        return $this->belongsTo(UserContractSing::class, 'user_contract_sing_id', 'id');
    }

}
