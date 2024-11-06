<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DealsPrivateNote extends Model
{
    use HasFactory,LogsActivity;

    public $table = 'deals_private_note';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($deals_private_note) {
            $deals_private_note->created_by = Auth()->user()?->id;
            $deals_private_note->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($deals_private_note) {
            $deals_private_note->updated_by = Auth()->user()?->id;
        });
    }
}
