<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OperationProgressStatusFile extends Model
{
    use HasFactory,LogsActivity;

    public $table = 'operations_process_status_file';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($operations_process_status_file) {            
            $operations_process_status_file->created_by = Auth()->user()?->id;
            $operations_process_status_file->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($operations_process_status_file) {
            $operations_process_status_file->updated_by = Auth()->user()?->id;
        });
    }
}
