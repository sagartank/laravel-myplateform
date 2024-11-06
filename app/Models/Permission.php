<?php

namespace App\Models;

use Laratrust\Models\LaratrustPermission;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Permission extends LaratrustPermission
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
        static::creating(function ($permission) {
            $permission->created_by = Auth()->user()?->id;
            $permission->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($permission) {
            $permission->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', true);
    }

    public function roles(){
        return $this->belongsTomany(Role::class,'roles_permissions');
    }

    public function users(){
        return $this->belongsTomany(User::class,'permission_user');
    }
    public function permissions()
    {
        return $this->hasMany(Permission::class,'parent_id');
    }
    public function childrenPermissions()
    {
        return $this->hasMany(Permission::class,'parent_id')->with('permissions');
    }
}
