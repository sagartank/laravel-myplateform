<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class BankDetails extends Model
{
    use HasFactory;
    use SoftDeletes,LogsActivity;

    protected $table = 'bank_details';
    
    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($bank_details) {
            $bank_details->created_by = Auth()->user()?->id;
            $bank_details->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($bank_details) {
            $bank_details->updated_by = Auth()->user()?->id;
        });
    }

    public function issuer_bank()
    {
        return $this->belongsTo(IssuerBank::class, 'bank_id','id');
    }

}
?>
