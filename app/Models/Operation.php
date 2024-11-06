<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use App\Models\OperationsLogs;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OperationStatusNotification as NotificationsOperationStatus;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Operation extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;
    use HasTags,LogsActivity;

    protected $guarded = [];

    protected $appends = ['expire_at', 'expire_days', 'expire_date_iso', 'expire_hour', 'issuance_date_iso', 'operation_type_number', 'stamp_expiration_iso'];
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['*'])->logOnlyDirty()->dontSubmitEmptyLogs();
    }

    public function scopeOperationSelect($query)
    {
        return $query->select([
        'operations.id',
        'operations.slug',
        'operations.operation_id',
        'operations.operation_number',
        'operations.operation_type',
        'operations.is_government_contract',
        'operations.responsibility',
        'operations.preferred_payment_method',
        'operations.contract_title',
        'operations.description',
        'operations.seller_id',
        'operations.issuer_id',
        'operations.preferred_currency',
        'operations.amount',
        'operations.amount_requested',
        'operations.accept_below_requested',
        'operations.check_number',
        'operations.invoice_type',
        'operations.issuer_company_type',
        'operations.invoice_number',
        'operations.tax_id',
        'operations.timbrado',
        'operations.authorized_personnel',
        'operations.authorized_personnel_signature',
        'operations.issuer_bank_id',
        'operations.bcp',
        'operations.inforconf',
        'operations.infocheck',
        'operations.criterium',
        'operations.cheque_status',
        'operations.cheque_type',
        'operations.cheque_payee_type',
        'operations.issuance_date',
        'operations.expiration_date',
        'operations.operations_status',
        'operations.mipo_verified',
        'operations.approved_at',
        'operations.rejection_note',
        'operations.auto_expire',
        'operations.expired_at',
        'operations.extra_expiration_days',
        'operations.legal_telephone',
        'operations.legal_direction',
        'operations.stamp_expiration',
        'operations.contract_title',
        'operations.contract_number',
        'operations.expiration_date_document',
        ]);
    }

    public function getOperationTypeNumberAttribute(){
        return ($this->operation_type == 'Cheque') ? __('Check') . ' '.$this->operation_number : __($this->operation_type) . ' '.$this->operation_number;
        // return $this->operation_type.' '.$this->operation_number;
    }
    
    public function getExpireAtAttribute()
    {
        $get_value = Carbon::createFromDate($this->expiration_date)->diffForHumans();
        $inputString =  str_replace('from now', '',  $get_value);

        $parts = explode(' ', $inputString);
        $stringPart = implode(' ', array_slice($parts, 1));
        
       return $parts[0] .' '. __($stringPart);
    }

    public function getExpireDaysAttribute()
    {
        $datework = Carbon::createFromDate($this->expiration_date);
        $now = Carbon::now();
        return $datework->diffInDays($now);
    }

    public function getExpireHourAttribute()
    {
        $datework = Carbon::createFromDate($this->expiration_date);
        $now = Carbon::now();
        return $datework->diffInHours($now);
    }

    public function getExpireDateIsoAttribute()
    {
        if(!empty($this->expiration_date)) {
            if(app()->getLocale() == 'es') {
                return Carbon::createFromDate($this->expiration_date)->format('j') .' de '. config('constants.MONTHS_NAME')[Carbon::createFromDate($this->expiration_date)->format('m')] .' de '. Carbon::createFromDate($this->expiration_date)->format('Y');
            } else {
                return  Carbon::createFromDate($this->expiration_date)->format('F') .' '. Carbon::createFromDate($this->expiration_date)->format('j') .', '. Carbon::createFromDate($this->expiration_date)->format('Y');
                // return Carbon::createFromDate($this->expiration_date)->format('jS F Y');
            }
        } else {
            return __('N/A');
        }
    }

    public function getIssuanceDateIsoAttribute()
    {
        // return Carbon::createFromDate($this->issuance_date)->format('jS F Y');
        if(!empty($this->expiration_date)) {
            if(app()->getLocale() == 'es') {
                return Carbon::createFromDate($this->issuance_date)->format('j') .' de '. config('constants.MONTHS_NAME')[Carbon::createFromDate($this->issuance_date)->format('m')] .' de '. Carbon::createFromDate($this->issuance_date)->format('Y');
            } else {
                return  Carbon::createFromDate($this->issuance_date)->format('F') .' '. Carbon::createFromDate($this->issuance_date)->format('j') .', '. Carbon::createFromDate($this->issuance_date)->format('Y');
            }
        } else {
            return __('N/A');
        }
    }

    public function getStampExpirationIsoAttribute()
    {
        if(!empty($this->stamp_expiration)) {
            if(app()->getLocale() == 'es') {
                return Carbon::createFromDate($this->stamp_expiration)->format('j') .' de '. config('constants.MONTHS_NAME')[Carbon::createFromDate($this->stamp_expiration)->format('m')] .' de '. Carbon::createFromDate($this->stamp_expiration)->format('Y');
            } else {
                return  Carbon::createFromDate($this->stamp_expiration)->format('F') .' '. Carbon::createFromDate($this->stamp_expiration)->format('j') .', '. Carbon::createFromDate($this->stamp_expiration)->format('Y');
            }
        } else {
            return  '-';
        }
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function ($operation) {
            $operation->operation_id = ($max = Operation::withTrashed()->max('operation_id')) ? $max + 1 : 1;
            $prefix = 'OT';
            if($operation->operation_type == 'Cheque'){
                $prefix = 'CH';
            } else if($operation->operation_type == 'Invoice'){
                $prefix = 'FA';
            } else if($operation->operation_type == 'Contract'){
                $prefix = 'CO';
            }
            // $prefix = 'OP';
            // $operation->operation_number = $prefix . str_pad($operation->operation_id, 4, '0', STR_PAD_LEFT);
            $operation->operation_number = date('s').str_pad($operation->operation_id, 4, '0', STR_PAD_LEFT).date('si').$prefix;
            $operation->created_by = Auth()->user()?->id;
            $operation->updated_by = Auth()->user()?->id;
        });
        static::updating(function ($operation) {
            if($operation->operations_status == 'Approved'){
                // OperationsLogs::operationsAddLogs($operation->id, 3, '0', 'Seller');
                OperationsLogs::operationsAddLogsTitle($operation->id, 'Operations Approved');
            } else if($operation->operations_status == 'Draft'){
                OperationsLogs::operationsAddLogsTitle($operation->id, 'Operations Draft');
            } else if($operation->operations_status == 'Rejected'){
                OperationsLogs::operationsAddLogsTitle($operation->id, 'Operations Rejected');
            } else if($operation->operations_status == 'Pending'){
                OperationsLogs::operationsAddLogsTitle($operation->id, 'Operations Pending');
            }
            $operation->updated_by = Auth()->user()?->id;
            
            /* $send = config('constants.SEND_MAIL_NOTIFICATION');
            if($send) {
                $user_obj = app('user-repo')->firstWhereNotification($operation->seller_id);
                Notification::send($user_obj, new NotificationsOperationStatus($operation->operations_status, $operation->operation_number, $user_obj->name));
            } */
        });
    }

    public function issuer()
    {
        return $this->belongsTo(Issuer::class, 'issuer_id');
    }

    public function issuer_bank()
    {
        return $this->belongsTo(IssuerBank::class, 'issuer_bank_id');
    }

    public function references()
    {
        return $this->hasMany(CommercialReference::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function supportingAttachments()
    {
        return $this->hasMany(SupportingAttachment::class);
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')->orderBy('order_column');
    }

    public function offers()
    {
        return $this->belongsToMany(Offer::class, 'offer_operations')->withPivot('id','offer_id','operation_id', 'is_offered', 'is_disputed')->using(OfferOperation::class);
        // return $this->belongsToMany(Offer::class, 'offer_operations')->withPivot('id')->using(OfferOperation::class);
    }

    public function offer_operations()
    {
        return $this->hasMany(OfferOperation::class);
    }

    public function operations_logs()
    {
        return $this->hasMany(OperationsLogs::class, 'operation_id', 'id');
    }

    public function operations_process_status_file()
    {
        return $this->hasOne(OperationProgressStatusFile::class, 'operation_id', 'id');
    }

    public function operations_admin_staff_file()
    {
        return $this->hasMany(OperationsAdminStaffFile::class, 'operation_id', 'id');
    }

}
