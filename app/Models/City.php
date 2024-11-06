<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'city';
    
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function ($city) {
            $city->created_by = Auth()->user()?->id;
            $city->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($city) {
            $city->updated_by = Auth()->user()?->id;
        });
    }


    public static function getAllCities()
    {
        return self::select('id', 'name')->where('is_active', '1')->orderBy('name', 'asc')->get();
    }
}
