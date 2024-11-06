<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DealsDisputes extends Model
{
    use HasFactory,LogsActivity;

    public $table = 'deals_disputes';

    protected $guarded = [];

    protected $appends = ['dispute_file_url'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($deals_disputes) {
            $deals_disputes->created_by = Auth()->user()?->id;
            $deals_disputes->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($operation) {
            $deals_disputes->updated_by = Auth()->user()?->id;
        });
    }

    public function getDisputeFileUrlAttribute()
    {
        return route('secure-image', Crypt::encryptString($this->file_path));
    }

    public function disputed_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function resolved_user()
    {
        return $this->belongsTo(User::class, 'resolved_by', 'id');
    }

}
