<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid,LogsActivity;

    protected $table = 'companies';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($company) {            
            $company->created_by = Auth()->user()?->id;
            $company->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($company) {
            $company->updated_by = Auth()->user()?->id;
        });
    }

    public static function getActiveCompany(){
        return self::select('id','name')->where('is_active','1')->get();
    }
}