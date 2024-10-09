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



class SupplierLedgerController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $selectedSupplier = -1;
		$cbocustomer=$selectedSupplier;
		$start_date = date("Y-m-d");
		$end_date = date("Y-m-d");
		
        $menus = Menu::get();
        $suppliers = MasSupplier::select('id', 'clients_name')->orderBy('clients_name', 'asc')->get();

		$due_lists = DB::select('SELECT
					  mas_supplier_invoices.id as invoiceobjet_id,
					  mas_supplier_invoices.invoice_date as invoice_date,
					 mas_supplier_invoices. bill_amount as bill_amount,
					  mas_supplier_invoices.vat as vat,
					  mas_supplier_invoices.total_bill as total_bill,
					 mas_supplier_invoices. discount_amnt as discount_amnt,
					  "0" as collection_id,   
					  "0" as money_receipt, 
					  "0" as coll_amount ,
					  "0" as r_invoiceobjet_id,
					  "0" as r_total_bill,
					  "Invoiced" as type
					FROM
					  mas_supplier_invoices
					WHERE
			 mas_supplier_invoices.client_id="'.$cbocustomer.'" AND (mas_supplier_invoices.invoice_date>="'.$start_date.'" AND mas_supplier_invoices.invoice_date<="'.$end_date.'")
					 UNION ALL
					 SELECT 
					 "0" as invoiceobjet_id,
					 mas_payments.collection_date as invoice_date,
					 "0" as bill_amount,
					 "0" as vat,
					 "0" as total_bill,
					 "0" as discount_amnt,
					 mas_payments.id as collection_id,  
					 mas_payments.money_receipt as money_receipt, 
					 mas_payments.coll_amount as coll_amount, 
					  "0" as r_invoiceobjet_id,
					  "0" as r_total_bill,
					  "Payment" as type
					FROM
					  mas_payments
					WHERE
						mas_payments.customer_id="'.$cbocustomer.'" AND (mas_payments.collection_date>="'.$start_date.'" AND mas_payments.collection_date<="'.$end_date.'")
					UNION ALL
					 SELECT 
					 "0" as invoiceobjet_id,
					 mas_purchase_returns.invoice_date as invoice_date,
					 "0" as bill_amount,
					 "0" as vat,
					 "0" as total_bill,
					 "0" as discount_amnt,
					 "0" as collection_id, 
					 "0" as money_receipt, 
					 "0" as coll_amount , 
					 mas_purchase_returns.id as r_invoiceobjet_id,
					 mas_purchase_returns.total_bill as r_total_bill,
					 "Return" as type
					 FROM 
					 mas_purchase_returns
					 where 
					mas_purchase_returns.customer_id="'.$cbocustomer.'" AND (mas_purchase_returns.invoice_date>="'.$start_date.'" AND mas_purchase_returns.invoice_date<="'.$end_date.'")
					ORDER BY invoice_date ASC');

			$invtotal=pick('mas_supplier_invoices','SUM(total_bill) as total_due','client_id='.$cbocustomer.' AND invoice_date < "'.$start_date.'"')[0]->total_due;
			$coltotal=pick('mas_payments','SUM(coll_amount) as total_due','customer_id='.$cbocustomer.' AND collection_date < "'.$start_date.'"')[0]->total_due;
			$returntotal=pick('mas_purchase_returns','SUM(total_bill) as total_due','customer_id='.$cbocustomer.' AND invoice_date < "'.$start_date.'"')[0]->total_due;
			$pre_due= $invtotal-($coltotal+ $returntotal);
		  
        return view("pages.accounts.supplierLedger", compact("menus",  "due_lists","start_date","end_date","suppliers","selectedSupplier","pre_due"));
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
		$cbocustomer=$selectedSupplier;
		
		$start_date = $request->start_date;
		$end_date = $request->end_date;
		
        $menus = Menu::get();
        $suppliers = MasSupplier::select('id', 'clients_name')->orderBy('clients_name', 'asc')->get();

		$due_lists = DB::select('SELECT
					  mas_supplier_invoices.id as invoiceobjet_id,
					  mas_supplier_invoices.invoice_date as invoice_date,
					 mas_supplier_invoices. bill_amount as bill_amount,
					  mas_supplier_invoices.vat as vat,
					  mas_supplier_invoices.total_bill as total_bill,
					 mas_supplier_invoices. discount_amnt as discount_amnt,
					  "0" as collection_id,   
					  "0" as money_receipt, 
					  "0" as coll_amount ,
					  "0" as r_invoiceobjet_id,
					  "0" as r_total_bill,
					  "Invoiced" as type
					FROM
					  mas_supplier_invoices
					WHERE
					  mas_supplier_invoices.client_id="'.$cbocustomer.'" AND (mas_supplier_invoices.invoice_date>="'.$start_date.'" AND mas_supplier_invoices.invoice_date<="'.$end_date.'")
					 UNION ALL
					 SELECT 
					 "0" as invoiceobjet_id,
					 mas_payments.collection_date as invoice_date,
					 "0" as bill_amount,
					 "0" as vat,
					 "0" as total_bill,
					 "0" as discount_amnt,
					 mas_payments.id as collection_id,  
					 mas_payments.money_receipt as money_receipt, 
					 mas_payments.coll_amount as coll_amount, 
					  "0" as r_invoiceobjet_id,
					  "0" as r_total_bill,
					  "Payment" as type
					FROM
					  mas_payments
					WHERE
						mas_payments.customer_id="'.$cbocustomer.'" AND (mas_payments.collection_date>="'.$start_date.'" AND mas_payments.collection_date<="'.$end_date.'")
					UNION ALL
					 SELECT 
					 "0" as invoiceobjet_id,
					 mas_purchase_returns.invoice_date as invoice_date,
					 "0" as bill_amount,
					 "0" as vat,
					 "0" as total_bill,
					 "0" as discount_amnt,
					 "0" as collection_id, 
					 "0" as money_receipt, 
					 "0" as coll_amount , 
					 mas_purchase_returns.id as r_invoiceobjet_id,
					 mas_purchase_returns.total_bill as r_total_bill,
					 "Return" as type
					 FROM 
					 mas_purchase_returns
					 where 
					mas_purchase_returns.customer_id="'.$cbocustomer.'" AND (mas_purchase_returns.invoice_date>="'.$start_date.'" AND mas_purchase_returns.invoice_date<="'.$end_date.'")
					ORDER BY invoice_date ASC');
					
			$invtotal=pick('mas_supplier_invoices','SUM(total_bill) as total_due','client_id='.$cbocustomer.' AND invoice_date < "'.$start_date.'"')[0]->total_due;
			$coltotal=pick('mas_payments','SUM(coll_amount) as total_due','customer_id='.$cbocustomer.' AND collection_date < "'.$start_date.'"')[0]->total_due;
			$returntotal=pick('mas_purchase_returns','SUM(total_bill) as total_due','customer_id='.$cbocustomer.' AND invoice_date < "'.$start_date.'"')[0]->total_due;
			$pre_due= $invtotal-($coltotal+ $returntotal);
		  
        return view("pages.accounts.supplierLedger", compact("menus",  "due_lists","start_date","end_date","suppliers","selectedSupplier","pre_due"));
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