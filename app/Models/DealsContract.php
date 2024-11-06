<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class DealsContract extends Model
{
    use HasFactory,LogsActivity;

    public $table = 'deals_contract';

    protected $guarded = [];

    protected $appends = ['seller_file_url', 'buyer_file_url', 'seller_contract_file_url', 'buyer_contract_file_url', 'deals_contract_file_pdf_url'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function getSellerFileUrlAttribute()
    {
        /* $imagePath = storage_path('app/' . $this->seller_file);
        if (file_exists($imagePath)) {
            return asset('images/blank.png');
            // return route('secure-image', Crypt::encryptString($this->seller_file));
        } else {
            return asset('images/blank.png');
        } */
        return route('secure-image', Crypt::encryptString($this->seller_file));
    }

    public function getBuyerFileUrlAttribute()
    {
        // return asset('images/blank.png');
        return route('secure-image', Crypt::encryptString($this->buyer_file));
    }
    
    public function getDealsContractFilePdfUrlAttribute()
    {
        return route('secure-pdf', Crypt::encryptString($this->deals_contract_file));
    }

    protected static function booted()
    {
        static::creating(function ($deals_contract) {
            $deals_contract->created_by = Auth()->user()?->id;
            $deals_contract->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($deals_contract) {
            $deals_contract->updated_by = Auth()->user()?->id;
        });
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id', 'id');
    }
}
