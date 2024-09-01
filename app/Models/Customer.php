<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    // business_type_id, subzone_id, 	greeting_sms_sent	int(11)  -  greeting_sms_sent	varchar(11)	utf8mb4_unicode_ci	
    protected $fillable = [
        'customer_name',
        'father_or_husband_name',
        'mother_name',
        'gender',
        'blood_group',
        'date_of_birth',
        'reg_form_no',
        'occupation',
        'vat_status',
        'nid_number',
        'email',
        'fb_id',
        'mobile1',
        'mobile2',
        'phone',
        'road_no',
        'house_flat_no',
        'area_id',
        'district_id',
        'upazila_id',
        'tbl_zone_id',
        'subzone_id',
        'latitude',
        'longitude',
        'present_address',
        'permanent_address',
        'remarks',
        'business_type_id',
        'connection_employee_id',
        'reference_by',
        'contract_person',
        'profile_pic',
        'nid_pic',
        'reg_form_pic',
        'account_no',
        'tbl_client_category_id',
        'sub_office_id',

        'trn_clients_service_ratechange_id',
        'tbl_bill_cycle_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function TblZone()
    {
        return $this->belongsTo(TblZone::class);
    }

    public function TblClientCategory()
    {
        return $this->belongsTo(TblClientCategory::class);
    }

    public function TrnClientsService()
    {
        return $this->belongsTo(TrnClientsService::class);
    }

    public function SubZone()
    {
        return $this->belongsTo(SubZone::class);
    }

    public function TrnClientsServiceRatechange()
    {
        return $this->belongsTo(TrnClientsServiceRatechange::class);
    }

    public function TblBillCycle()
    {
        return $this->belongsTo(TblBillCycle::class);
    }

    public function MasInvoice()
    {
        return $this->hasMany(MasInvoice::class);
    }
}
