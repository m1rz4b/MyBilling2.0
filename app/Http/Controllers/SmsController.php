<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\TblSmsSetup;
use App\Models\TblClientType;
use App\Models\TblStatusType;
use App\Models\TblZone;
use App\Models\TblClientCategory;
use App\Models\TblBillCycle;
use App\Models\TblSmsTemplate;
use App\Models\Customer;
use App\Models\MasInvoice;
use Illuminate\Http\Request;


class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $single_sms = TblSmsSetup::orderby('name')->get();
        return view('pages.sms&Email.sendSingleSms', compact('menus', 'single_sms'));
    }

    public function bulkSms()
    {
        $menus = Menu::where('status',1)->get();
        $bulk_sms = TblSmsSetup::get();
        $packages = TblClientType::orderby('name')->get();
        $status_types = TblStatusType::orderby('inv_name')->get();
        $zones = TblZone::orderby('zone_name')->get();
        $client_categories = TblClientCategory::orderby('name')->get();
        $bill_cycles = TblBillCycle::get();
        $sms_templates = TblSmsTemplate::where('status', '=', 1)->where('type', '=', 0)->get();
        $customers = Customer::with('TblClientType', 'TblBillCycle', 'TblStatusType', 'MasInvoice')->get();

        foreach ($customers as $customer) {
            $customer_id = $customer->id;
            // $bill = MasInvoice::where('client_id', $customer_id)->get();
            // $total_bill = $bill->sum('total_bill');
            // $collection = MasInvoice::where('client_id', $customer_id)->get();
            // $total_collection = $collection->sum('collection_amnt');
            // $total_dues = $total_bill - $total_collection;

            $total_bill = MasInvoice::where('client_id', $customer_id)->value('total_bill');
            $total_collection = MasInvoice::where('client_id', $customer_id)->value('collection_amnt');
            $total_dues = $total_bill - $total_collection;
        }

        return view('pages.sms&Email.sendSms', compact('menus', 'bulk_sms', 'packages', 'status_types', 'zones', 'client_categories', 'bill_cycles', 'sms_templates', 'customers', 'total_dues' ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TblSmsSetup $tblSmsSetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblSmsSetup $tblSmsSetup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblSmsSetup $tblSmsSetup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblSmsSetup $tblSmsSetup)
    {
        //
    }
}
