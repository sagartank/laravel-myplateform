<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class OperationProgress extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid,LogsActivity;

    protected $table = 'operation_progress';

    public $incrementing = true;

    protected $guarded = [];
    
    public $timestamps = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($operationProgress) {

            if($operationProgress->step_type == 'Buyer') {
                $operationProgress->order_position = ($max = OperationProgress::where('step_type', 'Buyer')->max('id')) ? $max + 1 : 1;
            }

            if($operationProgress->step_type == 'Seller') {
                $operationProgress->order_position = ($max = OperationProgress::where('step_type', 'Seller')->max('id')) ? $max + 1 : 1;
            }

            $operationProgress->created_by = Auth()->user()?->id;
            $operationProgress->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($operationProgress) {
            $operationProgress->updated_by = Auth()->user()?->id;
        });
    }

    protected static function buyerSteps()
    {
        return self::where('step_type', 'Buyer')->get();
    }

    protected static function SellerSteps()
    {
        return self::where('step_type', 'Seller')->get();
    }
}