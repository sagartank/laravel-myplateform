<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Carbon\Carbon;

class DealsDocuments extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'deals_documents';

    use SoftDeletes;

    protected $guarded = [];

    protected $appends = ['deals_path_url', 'uploaded_date'];

    public function getUploadedDateAttribute()
    {
        return Carbon::createFromDate($this->created_at)->format('jS F Y');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function getDealsPathUrlAttribute()
    {
        if($this->extension == 'pdf') {
            return route('secure-pdf', Crypt::encryptString($this->path));
        } else {
            return route('secure-image', Crypt::encryptString($this->path));
        }
    }
}
