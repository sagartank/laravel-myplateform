<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class UserContractSing extends Model
{
    use HasFactory;

    use SoftDeletes,LogsActivity;

    public $table ='user_contract_sings';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($user_contract_sing) {
            $user_contract_sing->created_by = Auth()->user()?->id;
            $user_contract_sing->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($user_contract_sing) {
            $user_contract_sing->updated_by = Auth()->user()?->id;
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
