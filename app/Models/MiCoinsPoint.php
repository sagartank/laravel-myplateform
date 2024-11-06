<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MiCoinsPoint extends Model
{
    use HasFactory,LogsActivity;

    public $table = 'mi_coins_points';

    protected $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    protected static function booted()
    {
        static::creating(function ($mi_coins_points) {
            $mi_coins_points->created_by = Auth()->user()?->id;
            $mi_coins_points->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($mi_coins_points) {
            $mi_coins_points->updated_by = Auth()->user()?->id;
        });
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function user_by1()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function user_by_total_micoin_credit($user_id)
    {
        return self::where('user_id', $user_id)->where('credit','Yes')->where('withdraw', 'No')->sum('points');
    }

    public static function user_by_total_micoin_withdraw($user_id)
    {
        return self::where('user_id', $user_id)->where('credit','No')->where('withdraw', 'Yes')->sum('points');
    }

    public static function user_by_total_micoin($user_id = null)
    {
        return (self::user_by_total_micoin_credit($user_id) - self::user_by_total_micoin_withdraw($user_id));
    }
}
