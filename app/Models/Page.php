<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Page extends Model
{
    use HasFactory;
    use Uuid,LogsActivity;

    public $table ="pages";

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($page) {
            $page->created_by = Auth()->user()?->id;
            $page->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($page) {
            $page->updated_by = Auth()->user()?->id;
        });
    }
}
