<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class DealsSeog extends Model
{
    use HasFactory;

    protected $table = 'deals_seog';

    protected $guarded = [];

    protected $appends = ['deals_seog_path_url', 'uploaded_date'];

    public function getUploadedDateAttribute()
    {
        return Carbon::createFromDate($this->created_at)->format('jS F Y');
    }

    public function getDealsSeogPathUrlAttribute()
    {
        if($this->extension == 'pdf') {
            return route('secure-pdf', Crypt::encryptString($this->path));
        } else {
            return route('secure-image', Crypt::encryptString($this->path));
        }
    }

}
