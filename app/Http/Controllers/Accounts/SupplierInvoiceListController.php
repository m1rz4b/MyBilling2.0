<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\AdvanceBill;
use App\Models\BillType;
use App\Models\Customer;
use App\Models\User;
use App\Models\MasInvoice;
use App\Models\Menu;
use App\Models\TrnClientsService;
use App\Models\TblSrvType;
use App\Models\MasBank;
use App\Models\NislMasMember;
use App\Models\SubZone;
use App\Models\TblClientCategory;
use App\Models\TblClientType;
use App\Models\TblZone;
use App\Models\TblSuboffice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\pick;
use function App\Helpers\dateDifference;

use App\Models\TblStatusType;
use App\Models\TblBillType;
use App\Models\TblBandwidthPlan;
use App\Models\MasCollection;
use App\Models\MasSupplier;
use App\Models\MasSupplierInvoice;



class SupplierInvoiceListController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $selectedSupplier = -1;
		$start_date = date("Y-m-d");
		$end_date = date("Y-m-d");
		
        $menus = Menu::get();
        $suppliers = MasSupplier::select('id', 'clients_name')->orderBy('clients_name', 'asc')->get();

		$supplierinvoices = MasSupplierInvoice::query()
						->Join('mas_suppliers', 'mas_suppliers.id', '=', 'mas_supplier_invoices.client_id')
						
        ->select([
							'mas_supplier_invoices.id as invoiceobjet_id',
							'user_id',
							'invoice_number',
							'invoice_date',
							DB::raw("DATE_FORMAT(mas_supplier_invoices.invoice_date,'%d/%m/%Y') as invoicedate"),
							'bill_number',
							'invoice_cat',
							'mas_supplier_invoices.client_type',
							'mas_suppliers.clients_name', 
							'vat', 
							'bill_amount', 
							DB::raw("mas_supplier_invoices.total_bill + mas_supplier_invoices.other_add_amount as total_bill"),
        ])
		->where('mas_supplier_invoices.invoice_date','>=',$start_date)
		->where('mas_supplier_invoices.invoice_date','<=',$end_date)
		->orderBy('invoice_date')
		->orderBy('client_type')
		->orderBy('mas_suppliers.clients_name');
		
		if ($selectedSupplier>=1) {
            $supplierinvoices->where('mas_supplier_invoice.client_id', $selectedSupplier);
        }
		
		  $supplierinvoices = $supplierinvoices->get();
		
		  
        return view("pages.accounts.supplierInvoiceList", compact("menus",  "supplierinvoices","start_date","end_date","suppliers","selectedSupplier"));
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
    public function show(Request $request)
    {
		
		
        $selectedSupplier = -1;
		$selectedSupplier = $request->supplier;
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		
        $menus = Menu::get();
        $suppliers = MasSupplier::select('id', 'clients_name')->orderBy('clients_name', 'asc')->get();

		$supplierinvoices = MasSupplierInvoice::query()
						->Join('mas_suppliers', 'mas_suppliers.id', '=', 'mas_supplier_invoices.client_id')
						
        ->select([
							'mas_supplier_invoices.id as invoiceobjet_id',
							'user_id',
							'invoice_number',
							'invoice_date',
							DB::raw("DATE_FORMAT(mas_supplier_invoices.invoice_date,'%d/%m/%Y') as invoicedate"),
							'bill_number',
							'invoice_cat',
							'mas_supplier_invoices.client_type',
							'mas_suppliers.clients_name', 
							'vat', 
							'bill_amount', 
							DB::raw("mas_supplier_invoices.total_bill + mas_supplier_invoices.other_add_amount as total_bill"),
        ])
		->orderBy('invoice_date')
		->orderBy('client_type')
		->orderBy('mas_suppliers.clients_name');
 
		$supplierinvoices->where('mas_supplier_invoices.invoice_date','>=',$start_date);
		$supplierinvoices->where('mas_supplier_invoices.invoice_date','<=',$end_date);

		
		if ($selectedSupplier>=1) {
            $supplierinvoices->where('mas_supplier_invoices.client_id', $selectedSupplier);
        }
		 $supplierinvoices = $supplierinvoices->get();
        return view("pages.accounts.supplierInvoiceList", compact("menus",  "supplierinvoices","start_date","end_date","suppliers","selectedSupplier"));
 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}