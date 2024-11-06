<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuid;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Document extends Model
{
    use HasFactory;
    use Uuid;
    use SoftDeletes,LogsActivity;

    protected $guarded = [];

    protected $appends = ['document_url'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function getDocumentUrlAttribute()
    {
        return route('secure-image', Crypt::encryptString($this->path));
    }

    public function operation()
    {
        $this->belongsTo(Operation::class);
    }
}
