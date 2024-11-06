<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class IssuerBank extends Model
{
    use HasFactory;
    use Uuid,LogsActivity;

    public $table ="issuer_banks";

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($issuer_banks) {
            $issuer_banks->created_by = Auth()->user()?->id;
            $issuer_banks->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($issuer_banks) {
            $issuer_banks->updated_by = Auth()->user()?->id;
        });
    }

    public function operations()
    {
        return $this->hasMany(Operation::class, 'issuer_bank_id');
    }

    public static function getIssuerBank(){
        return self::select('id','name')->get();
    }
}
