<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrnClientsService extends Model
{
    use HasFactory;

    protected $fillable = [
        'srv_type_id',
        'link_from',
        'link_to',
        'bandwidth',
        'unit_id',
        'unit_qty',
        'vat_rate',
        'rate_amnt',
        'vat_amnt',

        'customer_id',
        'user_id',
        'password',
        'bandwidth_plan_id',
        'installation_date',
        'remarks',
        'type_of_connectivity',
        'router_id',
        'device',
        'mac_address',
        'ip_number',
        'box_id',
        'cable_req',
        'no_of_core',
        'core_color',
        'fiber_code',
        'tbl_bill_type_id',
        'invoice_type_id',
        'bill_start_date',
		'block_date',
        'tbl_client_type_id',
        'monthly_bill',
        'billing_status_id',
        'tbl_status_type_id',
        'include_vat',
        'greeting_sms_sent',

        'number_of_tv',
        'number_of_channel',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function TrnClientsServiceRatechange()
    {
        return $this->hasMany(TrnClientsServiceRatechange::class);
    }

    public function BlockReason()
    {
        return $this->belongsTo(BlockReason::class);
    }

    public function TblStatusType()
    {
        return $this->belongsTo(TblStatusType::class);
    }

    public function TblBandwidthPlan()
    {
        return $this->belongsTo(TblBandwidthPlan::class);
    }

    public function TblRouter()
    {
        return $this->belongsTo(TblRouter::class);
    }

    public function Box()
    {
        return $this->belongsTo(Box::class);
    }

    public function TblClientType()
    {
        return $this->belongsTo(TblClientType::class);
    }

    public function TblBillType()
    {
        return $this->belongsTo(TblBillType::class);
    }

    public function BillingStatus()
    {
        return $this->belongsTo(BillingStatus::class);
    }

    public function InvoiceType()
    {
        return $this->belongsTo(InvoiceType::class);
    }

    public function TblUnit()
    {
        return $this->belongsTo(TblUnit::class);
    }
}
