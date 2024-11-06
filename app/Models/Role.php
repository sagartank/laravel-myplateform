<?php

namespace App\Models;

use Laratrust\Models\LaratrustRole;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Role extends LaratrustRole
{
    use Uuid;
    use SoftDeletes,LogsActivity;

    public $guarded = [];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }
    
    protected static function booted()
    {
        static::creating(function ($role) {
            $role->created_by = Auth()->user()?->id;
            $role->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($role) {
            $role->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    

    /* public function users()
    {
        return $this->belongsToMany(User::class)->using(RoleUser::class);
    } */

    /*  public function users(){
        return $this->belongsTomany(User::class,'users_roles');
    } */

    /* public function permissions(){
        return $this->belongsTomany(Permission::class,'roles_permissions');
    } */

}


