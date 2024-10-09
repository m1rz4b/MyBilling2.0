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



class SupplierAgingReportController extends Controller
{
 
     /**
     * Display a listing of the resource.
     */
    public function index()
    {

		
		$cboMonth =  date("m");
		$cboYear =  date("Y");
		
		$Current=$cboMonth*10+$cboYear*100;
		$rdate=date('Y-m-d',strtotime($cboYear.'-'.$cboMonth.'-1') );
		
        $menus = Menu::get();
        $suppliers = MasSupplier::select('id', 'clients_name')->orderBy('clients_name', 'asc')->get();

		$due_lists = DB::select('SELECT 
                                    mas_suppliers.id,
                                    mas_suppliers.user_id,
                                    mas_suppliers.clients_name,
                                    Temp1.dues as dues1,
                                    Temp2.dues as dues2,
                                    Temp3.dues as dues3,
                                    Temp4.dues as dues4,
									Temp5.rutern as rutern
                              FROM mas_suppliers 
                                    Left join (SELECT mas_suppliers.id as id, 
                                                year(invoice_date)*100 + month(invoice_date) *10 AS period, 
                                                Sum( total_bill - (collection_amnt+discount_amnt+ait_adjustment+vat_adjust_ment+ other_adjustment) ) AS dues
                                                FROM mas_suppliers
                                                INNER JOIN mas_supplier_invoices ON mas_suppliers.id = mas_supplier_invoices.client_id
                                                
                                                GROUP BY mas_suppliers.id, period
                                                HAVING period = "'.$Current.'"
                                                ) As Temp1 on Temp1.id=mas_suppliers.id 
                                    Left join (SELECT mas_suppliers.id as id, 
                                                year(invoice_date)*100 + month(invoice_date) *10 AS period, 
                                                Sum( total_bill - (collection_amnt+discount_amnt+ait_adjustment+vat_adjust_ment+ other_adjustment ) ) AS dues
                                                FROM mas_suppliers
                                                INNER JOIN mas_supplier_invoices ON mas_suppliers.id = mas_supplier_invoices.client_id
                                                
                                                GROUP BY mas_suppliers.id, period
                                                HAVING period = "'.($Current-10).'"
                                                ) As Temp2 on Temp2.id=mas_suppliers.id
                                    Left join (SELECT mas_suppliers.id as id, 
                                                year(invoice_date)*100 + month(invoice_date) *10 AS period, 
                                                Sum( total_bill - ( collection_amnt+discount_amnt+ait_adjustment+vat_adjust_ment+ other_adjustment ) ) AS dues
                                                FROM mas_suppliers
                                                INNER JOIN mas_supplier_invoices ON mas_suppliers.id = mas_supplier_invoices.client_id
                                                
                                                GROUP BY mas_suppliers.id, period
                                                HAVING period = "'.($Current-20).'"
                                                ) As Temp3 on Temp3.id=mas_suppliers.id
                                    Left join (SELECT mas_suppliers.id as id, 
                                                Sum( total_bill - ( collection_amnt+discount_amnt+ait_adjustment+vat_adjust_ment+ other_adjustment ) ) AS dues
                                                FROM mas_suppliers
                                                INNER JOIN mas_supplier_invoices ON mas_suppliers.id = mas_supplier_invoices.client_id 
                                                where year(invoice_date)*100 + month(invoice_date) *10 < "'.($Current-20).'"
                                                GROUP BY mas_suppliers.id
                                                
                                                ) As Temp4 on Temp4.id=mas_suppliers.id
									Left join (SELECT
													 mas_suppliers.id as id, 
													 SUM(mas_purchase_returns.total_bill) as rutern
													FROM `mas_suppliers`
													LEFT JOIN  mas_purchase_returns ON mas_purchase_returns.customer_id=mas_suppliers.id
                                                where mas_purchase_returns.invoice_date < "'.$rdate.'"
                                                GROUP BY mas_suppliers.id                                                
                                                ) As Temp5 on Temp5.id=mas_suppliers.id			  
                              HAVING dues1>0 OR dues2>0 OR dues3>0 OR dues4>0 OR rutern>0
                              order by mas_suppliers.id');

        return view("pages.accounts.supplierAgingReport", compact("menus",  "due_lists","cboYear","cboMonth"));
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
		
		
		$cboMonth =  $request->month;
		$cboYear =  $request->year;
		
		$Current=$cboMonth*10+$cboYear*100;
		$rdate=date('Y-m-d',strtotime($cboYear.'-'.$cboMonth.'-1') );
		
        $menus = Menu::get();
        $suppliers = MasSupplier::select('id', 'clients_name')->orderBy('clients_name', 'asc')->get();

		$due_lists = DB::select('SELECT 
                                    mas_suppliers.id,
                                    mas_suppliers.user_id,
                                    mas_suppliers.clients_name,
                                    Temp1.dues as dues1,
                                    Temp2.dues as dues2,
                                    Temp3.dues as dues3,
                                    Temp4.dues as dues4,
									Temp5.rutern as rutern
                              FROM mas_suppliers 
                                    Left join (SELECT mas_suppliers.id as id, 
                                                year(invoice_date)*100 + month(invoice_date) *10 AS period, 
                                                Sum( total_bill - (collection_amnt+discount_amnt+ait_adjustment+vat_adjust_ment+ other_adjustment) ) AS dues
                                                FROM mas_suppliers
                                                INNER JOIN mas_supplier_invoices ON mas_suppliers.id = mas_supplier_invoices.client_id
                                                
                                                GROUP BY mas_suppliers.id, period
                                                HAVING period = "'.$Current.'"
                                                ) As Temp1 on Temp1.id=mas_suppliers.id 
                                    Left join (SELECT mas_suppliers.id as id, 
                                                year(invoice_date)*100 + month(invoice_date) *10 AS period, 
                                                Sum( total_bill - (collection_amnt+discount_amnt+ait_adjustment+vat_adjust_ment+ other_adjustment ) ) AS dues
                                                FROM mas_suppliers
                                                INNER JOIN mas_supplier_invoices ON mas_suppliers.id = mas_supplier_invoices.client_id
                                                
                                                GROUP BY mas_suppliers.id, period
                                                HAVING period = "'.($Current-10).'"
                                                ) As Temp2 on Temp2.id=mas_suppliers.id
                                    Left join (SELECT mas_suppliers.id as id, 
                                                year(invoice_date)*100 + month(invoice_date) *10 AS period, 
                                                Sum( total_bill - ( collection_amnt+discount_amnt+ait_adjustment+vat_adjust_ment+ other_adjustment ) ) AS dues
                                                FROM mas_suppliers
                                                INNER JOIN mas_supplier_invoices ON mas_suppliers.id = mas_supplier_invoices.client_id
                                                
                                                GROUP BY mas_suppliers.id, period
                                                HAVING period = "'.($Current-20).'"
                                                ) As Temp3 on Temp3.id=mas_suppliers.id
                                    Left join (SELECT mas_suppliers.id as id, 
                                                Sum( total_bill - ( collection_amnt+discount_amnt+ait_adjustment+vat_adjust_ment+ other_adjustment ) ) AS dues
                                                FROM mas_suppliers
                                                INNER JOIN mas_supplier_invoices ON mas_suppliers.id = mas_supplier_invoices.client_id 
                                                where year(invoice_date)*100 + month(invoice_date) *10 < "'.($Current-20).'"
                                                GROUP BY mas_suppliers.id
                                                
                                                ) As Temp4 on Temp4.id=mas_suppliers.id
									Left join (SELECT
													 mas_suppliers.id as id, 
													 SUM(mas_purchase_returns.total_bill) as rutern
													FROM `mas_suppliers`
													LEFT JOIN  mas_purchase_returns ON mas_purchase_returns.customer_id=mas_suppliers.id
                                                where mas_purchase_returns.invoice_date < "'.$rdate.'"
                                                GROUP BY mas_suppliers.id                                                
                                                ) As Temp5 on Temp5.id=mas_suppliers.id			  
                              HAVING dues1>0 OR dues2>0 OR dues3>0 OR dues4>0 OR rutern>0
                              order by mas_suppliers.id');

             return view("pages.accounts.supplierAgingReport", compact("menus",  "due_lists","cboYear","cboMonth"));
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