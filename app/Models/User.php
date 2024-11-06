<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laratrust\Traits\LaratrustUserTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\UserPlanSubscription;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\City;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;
    use Uuid;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'referrer_id',
        'referral_code',
        'name',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'password',
        'password_changed_at',
        'is_admin',
        'otp',
        'is_otp_verified',
        'birth_date',
        'gender',
        'profile_image',
        'address',
        'city_id',
        'state',
        'postal_code',
        'country_id',
        'ruc_tax_id',
        'id_proof_doc',
        'ipv_image',
        'is_ipv_verified',
        'occupation',
        'bio',
        'preferred_payment_method',
        'estimated_budget',
        'as_borrower',
        'as_investor',
        'account_type',
        'ent_no_of_users',
        'ent_no_of_deals_per_day',
        'ent_business_type',
        'enterprise_id',
        'registration_step',
        'preferred_language',
        'preferred_contact_method',
        'preferred_dashboard',
        'preferred_currency',
        'is_registered',
        'registered_at',
        'is_active',
        'last_login_ip',
        'last_login_at',
        'created_by',
        'updated_by',
        'issuer_id',
        'address_verify',
        'address_verify_at',
        'address_verify_otp',
        'address_authorise_name',
        'address_qr_code',
        'is_user_company',
        'ruc_code',
        'marital_status',
        'registration_step_number',
        'latitude',
        'longitude',
        'address_google_map'
    ];

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'ipv_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['profile_image_url', 'security_level_url', 'user_age', 'user_registered_at', 'address_verify_img'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function getProfileImageUrlAttribute()
    {
        if($this->profile_image!='') {
            return route('secure-image', Crypt::encryptString($this->profile_image));
        } else {
            return asset('images/mipo/user-profile.png');
        }
    }

    public function getSecurityLevelUrlAttribute()
    {
        if($this->security_level == 'Secure') {
            return asset('images/mipo/Secure.svg');
        } else if($this->security_level == 'Medium') {
            return asset('images/mipo/Medium.svg');
        } else if($this->security_level == 'Risky') {
            return asset('images/mipo/Risky.svg');
        }
    }

    public function getAddressVerifyImgAttribute()
    {
        if($this->address_verify == 'Yes') {
            return asset('images/mipo/address-verified.svg');
        }
    }

    public function getUserAgeAttribute(){
        if(!empty($this->birth_date)) {
            return Carbon::parse($this->birth_date)->age;
        } else {
            return  '-';
        }
    }

    public function getUserRegisteredAtAttribute(){
       /*  if(!empty($this->registered_at)) {
            if(app()->getLocale() == 'es') {
                return config('constants.MONTHS_NAME')[Carbon::createFromDate($this->registered_at)->format('m')]. ' '. Carbon::createFromDate($this->registered_at)->format('jS, Y');
            } else {
                return Carbon::createFromDate($this->registered_at)->format('F jS, Y');
            }
        } else {
            return  '-';
        } */

        if(!empty($this->registered_at)) {
            if(app()->getLocale() == 'es') {
                return Carbon::createFromDate($this->registered_at)->format('j') .' de '. config('constants.MONTHS_NAME')[Carbon::createFromDate($this->registered_at)->format('m')] .' de '. Carbon::createFromDate($this->registered_at)->format('Y');
            } else {
                return  Carbon::createFromDate($this->registered_at)->format('F') .' '. Carbon::createFromDate($this->registered_at)->format('j') .', '. Carbon::createFromDate($this->registered_at)->format('Y');
            }
        } else {
            return  '-';
        }
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->name = $user->first_name . " " . $user->last_name;
            $user->referral_code = app('common')->getReferrerCode();
            $user->created_by = Auth()->user()?->id;
            $user->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($user) {
            $user->name = $user->first_name . " " . $user->last_name;
            $user->updated_by = Auth()->user()?->id;
        });
    }

    public function scopeActive($query)
    {
        $query->where('is_active', 'yes');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function operations()
    {
        return $this->hasMany(Operation::class, 'seller_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    public function ratings()
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function bank_details()
    {
        return $this->hasOne(BankDetails::class, 'user_id')->whereIn('payment_options', ['eWallet', 'Bank'])->where('is_active', 'Yes');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function id_proof_documents()
    {
        return $this->hasMany(IdProofDocuments::class, 'user_id');
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function subscriptionPlans()
    {
        return $this->hasMany(UserPlanSubscription::class);
    }
    
    public function invite_friend()
    {
        return $this->belongsTo(InviteFriends::class, 'invite_friend_id', 'id');
    }
    
    public function ref_by()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    public function mi_coins_poinst()
    {
        return $this->hasMany(MiCoinsPoint::class, 'user_id', 'id')->orderBy('id', 'desc');
    }

    public function subUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }

    public function issuer()
    {
        return $this->belongsTo(Issuer::class, 'issuer_id', 'id');
    }

    public function user_company()
    {
        return $this->hasMany(UserCompany::class, 'user_id', 'id');
    }
    
    public function offerOperations(): HasManyThrough
    {
        return $this->hasManyThrough(OfferOperation::class, Environment::class);
    }
    
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function parentUser()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }
    
    public function user_profile_attache()
    {
        return $this->hasMany(UserProfileAttach::class, 'user_id', 'id');
    }
    public function companies()
    {
        return $this->hasMany(self::class, 'parent_id', 'id')->where('is_user_company',1);
    }

    public function bank_details_all()
    {
        return $this->hasMany(BankDetails::class, 'user_id')->whereIn('payment_options', ['eWallet', 'Bank'])->where('is_active', 'Yes');
    }
}
