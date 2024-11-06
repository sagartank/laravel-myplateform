<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class IdProofDocuments extends Model
{
    use HasFactory,LogsActivity;

    public $table = "id_proof_documents";

    protected $guarded = [];

    protected $appends = ['id_proof_image_url'];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function getIdProofImageUrlAttribute()
    {
        if($this->id_proof_image!='') {
            return route('secure-image', Crypt::encryptString($this->id_proof_image));
        } else {
            return asset('images/blank.png');
        }
    }

    protected static function booted()
    {
        static::creating(function ($id_proof_documents) {
            $id_proof_documents->created_by = Auth()->user()?->id;
            $id_proof_documents->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($id_proof_documents) {
            $id_proof_documents->updated_by = Auth()->user()?->id;
        });
    }
}
