<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OperationsAdminStaffFile extends Model
{
    use HasFactory,LogsActivity;

    public $table = "operations_admin_staff_file";

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function operation()
    {
        $this->belongsTo(Operation::class);
    }
}
