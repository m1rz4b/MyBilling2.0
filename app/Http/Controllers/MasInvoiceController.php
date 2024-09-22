<?php

namespace App\Http\Controllers;

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
use App\Models\TblProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function App\Helpers\pick;
use function App\Helpers\dateDifference;

class MasInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    //Function for displaying invoice generation page
    public function monthlyInvoiceCreate()
    {
        $menus = Menu::where('status',1)->get();
        //$mas_invoices = MasInvoice::paginate(18);
        $branches = TblSuboffice::where('status',1)->get();
        //dump($branches->toSql());

        return view('pages.billing.monthlyInvoiceCreate', compact('menus', 'branches'));
    }

    //invoice generation 
    public function monthlyInvoiceStore(Request $request)
    {
        $menus = Menu::get();
        //$mas_invoices = MasInvoice::get();
        $branches = TblSuboffice::where('status',1)->get();;
		$succes_status=false;
		$process_compelted =0;
		$last_process_customer="";
        //dd($request);

        $data = $request->validate([
            'branch' => 'required|not_in:-1',
            'year' => 'required|not_in:-1',
            'month' => 'required|not_in:-1',
        ]);

        // $messages = [
        //     'same' => 'The :attribute and :other must match.',
        //     'size' => 'The :attribute must be exactly :size.',
        //     'between' => 'The :attribute value :input is not between :min - :max.',
        //     'in' => 'The :attribute must be one of the following types: :values',
        // ];

        //get user id
        $userid = Auth::id();
        


        //get date difference

        //get date month, year and make invoice date
        $invoiceMonth = $request->month;
        $invoiceYear = $request->year;
        //dd($invoiceMonth,$invoiceYear);
        $subzone = $request->branch;
        //dump($subzone);
   

        //calc invoice month
        $invoiceDate = $invoiceYear.'-'.$invoiceMonth.'-01';

        if($invoiceMonth==12){
            $sinvoiceMonth = 1;
            $sinvoiceYear = $request->year+1;
            $sinvoiceDate = $sinvoiceYear.'-'.$sinvoiceMonth.'-01';
        }
        else{
            $sinvoiceMonth = $invoiceMonth+1;
            $sinvoiceYear = $request->year;
            $sinvoiceDate = $sinvoiceYear.'-'.$sinvoiceMonth.'-01';
        }

        if($invoiceMonth==1){
            $pinvoiceMonth=12;
            $pinvoiceYear=$request->year-1;
            $pinvoiceDate=$pinvoiceYear.'-'.$pinvoiceMonth.'-01';
            }
        else{
            $pinvoiceMonth=$request->month-1;
            $pinvoiceYear=$request->year;
            $pinvoiceDate=$pinvoiceYear.'-'.$pinvoiceMonth.'-01';
            }

////////////
$current_invoice_date=$invoiceYear.'-'.$invoiceMonth.'-01';
$current_invoice_time=strtotime($current_invoice_date);

$last_inv_id = pick('mas_invoices','MAX(id) max_id',"");
$last_inv_id=$last_inv_id[0]->max_id;
if($last_inv_id>=1)
{
$last_invoice_period = pick('mas_invoices','invoice_period',"id=".$last_inv_id."");
$last_invoice_period=$last_invoice_period[0]->invoice_period;
$last_invoice_time=strtotime($last_invoice_period);

$max_invoice_time=strtotime("+1 month", $last_invoice_time);

//dd($last_inv_id);

if($current_invoice_time < $last_invoice_time || $current_invoice_time > $max_invoice_time )
			{
				return redirect('/monthlyinvoicecreate')->withErrors(['Invoice generartion not allowed for early/advance month']);
			}

}
//"invoice_period": "2019-10-01"

//////////////////


            ///////////////////////Process bill for service Start////////////////////////
          //  dd($invoiceDate);
            $processSql="SELECT serv_id as pserv_id FROM mas_invoices WHERE invoice_date='".$invoiceDate."' AND tbl_invoice_cat_id = 1";
            //dd($processSql);
            $processResult = DB::select($processSql);
            //dd($processResult);
            $listOfService=array();
            $hmm=0;
            foreach ($processResult as $processRow) {
                    //extract($processRow);
                    $listOfService[$hmm]=$processRow->pserv_id;
                    $hmm++;
            }
            //dd($listOfService);
            $hasval=count($listOfService);
            //dd($listOfService);
			// dd($hasval);

            

            
            ///////////////////////Process bill for service end////////////////////////
            $vatper=pick("tbl_parameters","parameter_value","parameter_name='vat_percentage'");

            //*****************************************************	
            //Process Start for genereal user 
            //*****************************************************
       // Will generate bill :  Only active client from trn_clients_services,  not Pre-paid, service type not HotSpot

        $customerResult = Customer::select([
            'customers.id',
            'customers.customer_name',
            'customers.reseller_id',
            
            'customers.mobile1',
            'customers.mobile2',
            'trn_clients_services.tbl_client_type_id as client_type',
            'trn_clients_services.vat_amnt',
            'trn_clients_services.rate_amnt',
            'trn_clients_services.monthly_bill',
            'trn_clients_services.bill_start_date',
            'trn_clients_services.ip_number',
            'tbl_client_types.share_percent',
            'trn_clients_services.srv_type_id AS srv_id',
            'trn_clients_services.id AS serv_id',
			'trn_clients_services.user_id'
        ])
        ->leftJoin('trn_clients_services', 'trn_clients_services.customer_id', '=', 'customers.id')
        ->leftJoin('tbl_client_types', 'tbl_client_types.id', '=', 'trn_clients_services.tbl_client_type_id')
        ->where('trn_clients_services.tbl_status_type_id', 1)
        ->where('trn_clients_services.tbl_bill_type_id', '<>', 1)
        ->where('trn_clients_services.srv_type_id', '<>', 9)
        ->where('sub_office_id', $subzone);
        if($hasval){
            $customerResult->whereNotIn('trn_clients_services.id',$listOfService);;
            }     
     //   dd($customerResult->toSql());
		
        $customerResult = $customerResult->orderBy('customers.id')->get();
    //    dd($customerResult);
     //   dd($customerResult);
		if($customerResult->isEmpty())
			{
				return redirect('/monthlyinvoicecreate')->withErrors(['No Customer Found for Invoice Generartion']);
			}
		
        foreach($customerResult as $customerRow){
            $user_id = $customerRow->user_id;
			 
            $client_type =  $customerRow->client_type;
            $id = $customerRow->id;   
            $rate_amnt = $customerRow->rate_amnt;
            //$vat_amnt =round(($rate_amnt*$vatper/($vatper+100)),2);
            $vat_amnt =$customerRow->vat_amnt;
            $bill_amnt = round(($rate_amnt),2);
            $srv_id = $customerRow->srv_id;
            $serv_id = $customerRow->serv_id; //primary key of trn client service to be used in invoice and collection
            
            $ip_number = $customerRow->ip_number;
            $bill_start_date = date_format(date_create($customerRow->bill_start_date),"Y-m-d");
            $reseller_id = $customerRow->reseller_id;
            $share_percent = $customerRow->share_percent;
            $billnum = 0 ;
            $rmark = "";
            $other_add_item = "";
            $radjust = 0;
            $radv_date = null;
            $unit = 0;
            
            


        //    dd($customerRow);

            if($customerRow->tbl_bill_type_id==2)
			{
				$invoice_period=$pinvoiceDate;
			}else{
				$invoice_period=$invoiceDate;
			}

            $ctype=$customerRow->client_type;

            $invnums=pick("mas_invoices","MAX(invoice_number) as max_inv"," customer_id='".$customerRow->id."' and invoice_period='".$invoice_period."' and invoice_cat='Monthly'");
            $invnums=$invnums[0]->max_inv;

            
            if($invnums != null){
                $invnum=$invnums;
            }else{
                
                $invnum=pick("mas_invoices","MAX(invoice_number) as max_inv","");
                $invnum=($invnum[0]->max_inv)+1;
            }
// dd($invnum);
            $extra_bill=pick("trn_invoices","Sum(extra_bill) as extra_bill","serv_id='".$customerRow->serv_id."' AND client_id='".$customerRow->id."' AND MONTH(from_date) = '".$pinvoiceMonth."' AND YEAR(from_date) = '".$pinvoiceYear."' ");
            $extra_bill = $extra_bill[0]->extra_bill;
            
            
            if($extra_bill == null){
                $extra_bill=0;
                } 
            //dd($extra_bill);

            
			$sarrear=0;
            $sarrear=pick("mas_invoices","Sum(mas_invoices.total_bill-(collection_amnt+vat_adjust_ment+discount_amnt+other_adjustment)) as arrear","customer_id='".$customerRow->id."' and serv_id='".$customerRow->serv_id."'"); 
            $sarrear=$sarrear[0]->arrear; 
			
	//	dd($customerRow->id,$customerRow->serv_id,$sarrear);		
		
            if($sarrear>0){
				$sarrear=$sarrear;
			}else{
						$sarrear=0;
					}
			

           
            $pieces = explode("-", $customerRow->bill_start_date);
            //dd($pieces);
                $start_year = $pieces[0];
                $start_month = $pieces[1];

                $pieces2 = explode("-", $invoiceDate);
                //dd($pieces2);
                $inv_year = $pieces2[0];
                $inv_month = $pieces2[1];
            
            $last_dateG=date("Y-m-t", strtotime($invoiceDate));

            $discounts=pick('tbl_advance_bills','discount','client_id="'.$customerRow->id.'" and bill_year="'.$invoiceYear.'" and bill_month="'.$invoiceMonth.'"');
            if(count($discounts)>0){
                $discounts=$discounts[0]->discount;
            }
            else{
                $discounts= 0;
            }


            if($rate_amnt==0){
                $share_rate=0;
            }
            $tbill=0;
            $vat = 0;
            $bill_amount =1000;
            //$total_bill =1000;

      //      dd($start_year ,$inv_year ,$start_month,$inv_month,$rate_amnt);
            if (intval($start_year) == intval($inv_year) && intval($start_month) == intval($inv_month)) {
						
                $dayG=dateDifference($customerRow->bill_start_date , $last_dateG , '%a' )+1;
            
                $insertInvoice = DB::table('mas_invoices')->insert([
                    'invoice_date' => $invoiceDate,
                    'invoice_period' => $invoice_period,
                    'client_type' => $client_type,
                    'customer_id' => $id,
                    'invoice_number' => $invnum,
                    'bill_number' => $billnum,
                    'remarks' => $rmark,
                    'tbl_invoice_cat_id' => 1,
                    'discount_amnt' => $discounts,
                    'other_add_item' => $other_add_item,
                    'other_adjustment' => $radjust,
                    'last_col_date' => $radv_date,
                    'entry_by' => Auth::id(),
                    'entry_date' => Carbon::now(),
                    'vat' => DB::raw('ROUND(('.$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                    'bill_amount' => DB::raw('ROUND(('.$rate_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                    'total_bill' => DB::raw('ROUND(('.$rate_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                    'serv_id' => $serv_id,
                    'cur_arrear' => $extra_bill,
                    'unit' => $unit,
                    'ip_number' => $ip_number,
                    'rate_amnt' => $rate_amnt,
                    'tbl_srv_type_id' => $srv_id,
                    'from_date' => $bill_start_date,
                    'to_date' => $invoiceDate,
                    'pre_arrear' => $sarrear
                ]);

       //         dd($insertInvoice);
                $last_idG = pick('mas_invoices','MAX(id) as id',"")[0]->id;
                if ($last_idG==null) {
                    $last_idG = 0;
                }

                
                //dd($invoiceDate, $invoiceDate, $bill_start_date);

                $trn_insert = $invoiceData = [
                    'invoiceobject_id' => $last_idG,
                    'client_id' => $id,
                    'billing_year' => $inv_year,
                    'billing_month' => $inv_month,
                    'rate' => $rate_amnt,
                    'vat' => $vat_amnt,
                    'billingdays' => $dayG,
                    'camnt' => DB::raw('ROUND(('.$rate_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                    'cvat' => DB::raw('ROUND(('.$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                    'total' => DB::raw('ROUND(('.$rate_amnt+$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),

                    'entry_by' => Auth::id(),
                    'entry_date' => NOW(),
                    'from_date' => $bill_start_date,
                    'to_date' => $last_dateG,
                    //'share_rate' => DB::raw('ROUND((('.($vat_amnt+$rate_amnt)*( $share_percent /100).') / DAY(LAST_DAY('.$invoiceDate.'))) * (DATEDIFF(LAST_DAY('.$invoiceDate.'), '.$bill_start_date.')+1))'),
                    'share_rate' => 4,
                    'reseller_id' => $reseller_id,
                    'serv_id' => $serv_id,
                    'unit' => $client_type,
                    'invoice_date' => $invoiceDate,
                ];
         //       dd($invoiceData);
                $result =  DB::table('trn_invoices')->insert($invoiceData);
             //   dd($result);
				

                $updateInvoice = DB::table('trn_invoices')
                                ->whereYear('from_date', $pinvoiceYear)
                                ->whereMonth('from_date', $pinvoiceMonth)
                                ->where('serv_id', $srv_id)
                                ->where('extra_bill', '<>', 0)
                                ->update([
                                    'invoiceobject_id' => $last_idG,
                                    'billing_year' => DB::raw('YEAR(from_date)'),
                                    'billing_month' => DB::raw('MONTH(from_date)'),
                                    'invoice_date' => $invoiceDate,
                                ]);
								
                $succes_status=$result;
				if($succes_status=true)
					{ 
					$process_compelted ++;
					$last_process_customer=$id;
					}
            }

            else
 //elseif(intval($inv_year) >= intval($start_year) && intval($inv_month) >= intval($start_month))			
			{
				
                
                $last_idG = pick('mas_invoices','MAX(id)',"");
                $dayG=dateDifference($invoiceDate , $last_dateG , '%a' )+1;
          //      dd($rate_amnt,$extra_bill,$last_idG,$dayG);
                
                $tbill=$rate_amnt+$extra_bill;
                $share_rate=ROUND(($rate_amnt+$vat_amnt )*($share_percent/100));

                $insertInvoice = DB::table('mas_invoices')->insert([
				'invoice_date' => $invoiceDate,
                    'invoice_period' => $invoice_period,
                    'client_type' => $client_type,
                    'customer_id' => $id,
                    'invoice_number' => $invnum,
                    'bill_number' => $billnum,
                    'remarks' => $rmark,
                    'tbl_invoice_cat_id' => 1,
                    'discount_amnt' => $discounts,
                    'other_add_item' => $other_add_item,
                    'other_adjustment' => $radjust,
                    'last_col_date' => $radv_date,
                    'entry_by' => Auth::id(),
                    'entry_date' => Carbon::now(),
                     'vat' => $vat_amnt,
                    'bill_amount' => $bill_amnt,
                    'total_bill' => $tbill,
                    'serv_id' => $serv_id,
                    'cur_arrear' => $extra_bill,
                    'unit' => $unit,
                    'ip_number' => $ip_number,
                    'rate_amnt' => $rate_amnt,
                    'tbl_srv_type_id' => $srv_id,
                    'from_date' => $bill_start_date,
                    'to_date' => $invoiceDate,
                    'pre_arrear' => $sarrear
					
               ]);
				
				
//dd($insertInvoice);
			$last_idG = pick('mas_invoices','MAX(id) as id',"")[0]->id;
                if ($last_idG==null) {
                    $last_idG = 0;
                }

                $year = $pinvoiceYear;
                $month = $pinvoiceMonth;
                $invoiceDate = $invoiceDate; 
                $serviceId = $serv_id;
                $lastId = $last_idG;
				
				
			 $trn_insert = $invoiceData = [
                    'invoiceobject_id' => $last_idG,
                    'client_id' => $id,
                    'billing_year' => $inv_year,
                    'billing_month' => $inv_month,
                    'rate' => $rate_amnt,
                    'vat' => $vat_amnt,
                    'billingdays' => $dayG,
					 'cvat' => $vat_amnt,
                    'camnt' => $bill_amnt,
                    'total' => $tbill,
                    'entry_by' => Auth::id(),
                    'entry_date' => NOW(),
                    'from_date' => $bill_start_date,
                    'to_date' => $last_dateG,
                    //'share_rate' => DB::raw('ROUND((('.($vat_amnt+$rate_amnt)*( $share_percent /100).') / DAY(LAST_DAY('.$invoiceDate.'))) * (DATEDIFF(LAST_DAY('.$invoiceDate.'), '.$bill_start_date.')+1))'),
                    'share_rate' => 4,
                    'reseller_id' => $reseller_id,
                    'serv_id' => $serv_id,
                    'unit' => $client_type,
                    'invoice_date' => $invoiceDate,
                ];
				
         //       dd($invoiceData);
                $result =  DB::table('trn_invoices')->insert($invoiceData);
            //    dd($result);

                $updateInvoice = DB::table('trn_invoices')
                                ->whereYear('from_date', $pinvoiceYear)
                                ->whereMonth('from_date', $pinvoiceMonth)
                                ->where('serv_id', $srv_id)
                                ->where('extra_bill', '<>', 0)
                                ->update([
                                    'invoiceobject_id' => $last_idG,
                                    'billing_year' => DB::raw('YEAR(from_date)'),
                                    'billing_month' => DB::raw('MONTH(from_date)'),
                                    'invoice_date' => $invoiceDate,
                                ]);	
				$succes_status=$result;
				if($succes_status=true)
					{ 
					$process_compelted ++;
					$last_process_customer=$user_id;
					}
            }


            //Process Start for Reseller user 
            $resellers = DB::table('customers')
                        ->select([
                            'customers.id',
                            'trn_clients_services.user_id',
                            'customers.customer_name', // Replaced clients_name with customer_name
                            'customers.mobile2',
                            'trn_clients_services.unit_id',
                            'trn_clients_services.tbl_bill_type_id',
                            'trn_clients_services.ip_number',
                            DB::raw('customers.id AS reseller_id'),
                            DB::raw('customers.mobile1 AS re_mob'),
                            'trn_clients_services.rate_amnt',
                            'trn_clients_services.vat_rate',
                            'trn_clients_services.id',
                        ])
                        ->leftJoin('trn_clients_services', function ($join) use ($subzone) { // Replaced trn_clients_services with trn_clients_services (plural)
                            $join->on('trn_clients_services.customer_id', '=', 'customers.id');
                        })
                        ->where('customers.tbl_client_category_id', '=', 3)
                        ->where('trn_clients_services.srv_type_id', '=', 1)
                        ->where('trn_clients_services.tbl_bill_type_id', '<>', 3)
                        ->where('customers.sub_office_id', '=', $subzone)
                        ->get();

            $res_cid = 0;
            $last_dateG=date("Y-m-t", strtotime($invoiceDate));

           // dd($resellers);
            foreach ($resellers as $row) {
                $id = $row->id;

                $hasclient=pick('customers','count(id)',"reseller_id='$id'");

                if ($hasclient>0) {
                    $vat=0;

                    $last_id=pick('mas_invoices','id',"invoice_period='".$invoice_period."' and client_id='".$id."' and serv_id='".$srv_id."'");

                    $getTotal = DB::table('trn_invoices')
                                    ->select([
                                        DB::raw('SUM(share_rate) AS share_rate'),
                                        DB::raw('SUM(extra_share_rate) AS extra_share_rate')
                                    ])
                                    ->where('reseller_id', $id)
                                    ->where('invoice_date', $invoiceDate)
                                    ->first();
                    $share_rate = $getTotal->share_rate;
                    $extra_share_rate = $getTotal->extra_share_rate;

                    $shared_total_bill = $share_rate + $extra_share_rate;


                    $upate_masinv = DB::table('mas_invoices')
                                    ->where('id', $last_id)
                                    ->update([
                                        'avat' => $total_vat,
                                        'abill_amount' => $total_rate,
                                        'atotal_bill' => $total_bill,
                                        'vat' => $shared_total_vat,
                                        'cur_arrear' => $extra_share_rate,
                                        'bill_amount' => $share_rate,
                                        'total_bill' => $shared_total_bill,
                                    ]);

                    $upate_trninv = DB::table('trn_invoices')
                                    ->where('invoiceobject_id', $last_id)
                                    ->update([
                                        'camnt' => $share_rate,
                                        'cvat' => $shared_total_vat,
                                        'total' => $shared_total_bill,
                                    ]);

                    


                } else {
                    # code...
                }
                

            }

            $adupdate=DB::table('tbl_advance_bills')
                            ->leftJoin('trn_clients_services', 'tbl_advance_bills.srv_id', '=', 'trn_clients_services.id')
                            ->select(
                                'trn_clients_services.id',
                                DB::raw('SUM(tbl_advance_bills.amount) as amount'),
                                DB::raw('SUM(tbl_advance_bills.discount) as discount'),
                                'tbl_advance_bills.rec_date'
                            )
                            ->where('tbl_advance_bills.bill_month', $invoiceMonth)
                            ->where('tbl_advance_bills.bill_year', $invoiceYear)
                            ->where('trn_clients_services.tbl_bill_type_id', '<>', 3)
                            ->groupBy('trn_clients_services.id', 'tbl_advance_bills.rec_date')
                            ->get();
            foreach($adupdate as $adupdateRow)
            {
                $dates=date('Y-m-d',strtotime($invoiceYear."-".$invoiceMonth."-1"));

                $upate_masinv = DB::table('mas_invoices')
                                    ->where('id', $srv_id)
                                    ->where('invoice_period', $dates)
                                    ->where('invoice_cat', 'Monthly')
                                    ->update([
                                        'discount_amnt' => DB::raw("discount_amnt + $discount"),
                                        'other_adjustment' => $amount,
                                        'remarks' => 'Advance adjusted Auto',
                                        'last_col_date' => $rec_date,
                                    ]);


            }



        }

			if($succes_status==true)
			{
     return redirect('/monthlyinvoicecreate')->with('success', '  '.$process_compelted.' Invoices Generated Successfully for the month of '.$invoiceMonth.'-'.$invoiceYear.' , Branch '.$subzone.' , Last Customer is '.$last_process_customer);
			}
			else
			{
			return redirect('/monthlyinvoicecreate')->withErrors(['Invoice Generartion Failed']);
			}
    }

    //Show invoice update page
    public function monthlyInvoiceUpdate()
    {
        $menus = Menu::get();
        //$mas_invoices = MasInvoice::get();
        $customers = Customer::orderBy('id')->get()->take(1000);

        return view('pages.billing.monthlyInvoiceUpdate', compact('menus', 'customers'));
    }

    //Update Invoice
    public function monthlyInvoiceUpdateSave(Request $request)
    {

         //get date month, year and make invoice date
         $invoiceMonth = $request->month;
         $invoiceYear = $request->year;  
         $subzone = $request->branch;
         $sclientid = $request->client;
//		 dd($invoiceYear);
         //dump($subzone);
		if($sclientid == "Select a Client" || $invoiceYear == "Please Choose A Year" )
		{
		return redirect('/monthlyinvoiceupdate')->withErrors(['Please Select Client, Month and Year']);
		}
         //calc invoice month
         $invoiceDate = $invoiceYear.'-'.$invoiceMonth.'-01';
 
         if($invoiceMonth==12){
             $sinvoiceMonth = 1;
             $sinvoiceYear = $request->year+1;
             $sinvoiceDate = $sinvoiceYear.'-'.$sinvoiceMonth.'-01';
         }
         else{
             $sinvoiceMonth = $invoiceMonth+1;
             $sinvoiceYear = $request->year;
             $sinvoiceDate = $sinvoiceYear.'-'.$sinvoiceMonth.'-01';
         }
 
         if($invoiceMonth==1){
             $pinvoiceMonth=12;
             $pinvoiceYear=$request->year-1;
             $pinvoiceDate=$pinvoiceYear.'-'.$pinvoiceMonth.'-01';
             }
             else{
             $pinvoiceMonth=$request->month-1;
             $pinvoiceYear=$request->year;
             $pinvoiceDate=$pinvoiceYear.'-'.$pinvoiceMonth.'-01';
             }


      //       $last_dateinv=date("Y-m-t", strtotime($invoiceDate));

            $customerQuery = "SELECT 
                                customers.id,
                                customers.customer_name,
                                customers.mobile1,
                                customers.mobile2,
                                trn_clients_services.tbl_client_type_id,
                                trn_clients_services.tbl_bill_type_id,
                                trn_clients_services.id as serv_id,
                                trn_clients_services.vat_amnt,
                                trn_clients_services.rate_amnt,
                                trn_clients_services.bill_start_date,
                                tbl_client_types.share_rate,
                                customers.reseller_id,
                                trn_clients_services.id,
								trn_clients_services.user_id
                                FROM customers
                                LEFT JOIN trn_clients_services ON trn_clients_services.customer_id = customers.id
                                LEFT JOIN tbl_client_types ON tbl_client_types.id = trn_clients_services.tbl_client_type_id
								LEFT JOIN mas_invoices ON mas_invoices.customer_id = customers.id
                                WHERE customers.id = ".$sclientid." AND mas_invoices.invoice_date ='".$invoiceDate."'";
       //     dd($customerQuery);
            $customers = DB::select($customerQuery);
      //      dd($customers);

				if(!$customers)
					{
				return redirect('/monthlyinvoiceupdate')->withErrors(['No Invoice Available to Update']);
					}
			
            foreach ($customers as $customerRow) {
				
                if($customerRow->tbl_bill_type_id=='2')
                {
                    $invoice_period=$pinvoiceDate;
                }else{
                    $invoice_period=$invoiceDate;
                }
/*
                $ctype = $customerRow->tbl_client_type_id;

                $maxInvoiceNumber = DB::table('mas_invoices')
                                            ->max('invoice_number');
                $invnum = $maxInvoiceNumber + 1;
*/
                
                $pinvnum = DB::table('mas_invoices')
                                ->where('serv_id', $customerRow->serv_id)
                                ->where('customer_id', $customerRow->id)
                                ->whereYear('invoice_date', $invoiceYear)
                                ->whereMonth('invoice_date', $invoiceMonth)
                                ->value('id');
//	dd($pinvnum);
                $extraBill = DB::table('trn_invoices')
                                ->where('serv_id', $customerRow->serv_id)
                                ->where('client_id', $customerRow->id)
                                ->where('billing_month', $pinvoiceMonth)
                                ->where('billing_year', $pinvoiceYear)
                                ->sum('extra_bill');

                $extraBill = $extraBill > 0 ? $extraBill : 0;

                // $discounts = $customerRow->discount;
        $discounts=pick('tbl_advance_bills','discount','client_id="'.$customerRow->id.'" and bill_year="'.$invoiceYear.'" and bill_month="'.$invoiceMonth.'"');
                if(count($discounts)>0){
                    $discounts=$discounts[0]->discount;
                }
                else{
                    $discounts= 0;
                }

                // Fetch the advance adjustment amount
                $advanceAdjust = DB::table('tbl_advance_bills')
                                    ->where('srv_id', $customerRow->serv_id)
                                    ->where('client_id', $customerRow->id)
                                    ->where('bill_year', $invoiceYear)
                                    ->where('bill_month', $invoiceMonth)
                                    ->value('amount');

                // Fetch the advance bill received date
                $radvDate = DB::table('tbl_advance_bills')
                                    ->where('srv_id', $customerRow->serv_id)
                                    ->where('client_id', $customerRow->id)
                                    ->where('bill_year', $invoiceYear)
                                    ->where('bill_month', $invoiceMonth)
                                    ->value('rec_date');

                $client_type = $customerRow->tbl_client_type_id;
       //         $id = $customerRow->id;
                
                $rate_amnt = $customerRow->rate_amnt;
                $vat_amnt = $customerRow->vat_amnt;				
                $bill_amnt = round($rate_amnt, 2);
			//	$bill_amnt = round(($rate_amnt - $vat_amnt), 2);
                
                // $ip_number = $customerRow->ip_number;
                
                $bill_start_date = Carbon::parse($customerRow->bill_start_date);
                $start_year = $bill_start_date->year;
                $start_month = $bill_start_date->month;
                
                $invoice_date = Carbon::parse($invoiceDate);
                $inv_year = $invoice_date->year;
                $inv_month = $invoice_date->month;
                
                $last_dateG = $invoice_date->endOfMonth()->format('Y-m-d');
                
                $share_rate = 0;
                $tbill = 0;
                $billnum = 0 ;
                $rmark = "";
                $other_add_item = "";
                $radjust = 0;
                $radv_date = null;
                $unit = 0;

                if ($pinvnum>0) 
					{ 
							if (intval($start_year) == intval($inv_year) && intval($start_month) == intval($inv_month)) 
							{
							
							$sarrear = 0;
							$reseller_id = 0;

							$dayG=dateDifference($customerRow->bill_start_date , $last_dateG , '%a' )+1;
                            $tbill=$rate_amnt+$vat_amnt+$extraBill;

							$updateMasInvoice = DB::table('mas_invoices')
                                        ->where('invoice_date', $invoiceDate)
                                        ->where('id', $pinvnum)
                                        ->update([
                                'discount_amnt' => $discounts,
                                'other_add_item' => $other_add_item,
                                'other_adjustment' => $radjust,
                                'last_col_date' => $radv_date,
                                'updated_by' => Auth::id(),
                                'updated_at' => Carbon::now(), // Use Carbon to get the current date and time
                               'vat' => DB::raw('ROUND(('.$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
							'bill_amount' => DB::raw('ROUND(('.$rate_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
							'total_bill' => DB::raw('ROUND(('.$rate_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                                'cur_arrear' => $extraBill,
                                'unit' => $unit,
                                'rate_amnt' => $rate_amnt,
                                'from_date' => $bill_start_date, // Use appropriate date variable
                                'to_date' => $last_dateG,
                                'pre_arrear' => $sarrear,
                                       ]);

                            //dd($last_idG);

							$updateTrnInvoice = DB::table('trn_invoices')
                                        ->where('invoice_date', $invoiceDate)
										->where('invoiceobject_id', $pinvnum)
                                        ->update([
										'rate' => $rate_amnt,
										'vat' => $vat_amnt,
										'billingdays' => $dayG,
										'camnt' => DB::raw('ROUND(('.$rate_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                    'cvat' => DB::raw('ROUND(('.$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                    'total' => DB::raw('ROUND(('.$rate_amnt+$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
										'updated_by' => Auth::id(),
										'updated_at' => NOW(),
										'from_date' => $bill_start_date,
										'to_date' => $last_dateG,
										'share_rate' => 4,
										'reseller_id' => $reseller_id,
										'unit' => $client_type,
                                       ]);
							}
							else 
							{
							$sarrear = 0;
							$reseller_id = 0;

                            $dayG=dateDifference($invoiceDate , $last_dateG , '%d' )+1;
                            $tbill=$rate_amnt+$vat_amnt+$extraBill;

						$updateMasInvoice = DB::table('mas_invoices')
                                        ->where('invoice_date', $invoiceDate)
                                        ->where('id', $pinvnum)
                                        ->update([
                                'discount_amnt' => $discounts,
                                'other_add_item' => $other_add_item,
                                'other_adjustment' => $radjust,
                                'last_col_date' => $radv_date,
                                'updated_by' => Auth::id(),
                                'updated_at' => Carbon::now(), // Use Carbon to get the current date and time
                                'vat' => $vat_amnt,
                                'bill_amount' => $bill_amnt,
                                'total_bill' => $tbill,
                                'cur_arrear' => $extraBill,
                                'unit' => $unit,
                                'rate_amnt' => $rate_amnt,
                                'from_date' => $invoiceDate, // Use appropriate date variable
                                'to_date' => $last_dateG,
                                'pre_arrear' => $sarrear,
                                       ]);

                            //dd($last_idG);

							$updateTrnInvoice = DB::table('trn_invoices')
                                        ->where('invoice_date', $invoiceDate)
										->where('invoiceobject_id', $pinvnum)
                                        ->update([
										'rate' => $rate_amnt,
										'vat' => $vat_amnt,
										'billingdays' => $dayG,
										 'cvat' => $vat_amnt,
										'camnt' => $bill_amnt,
										'total' => $tbill,
										'updated_by' => Auth::id(),
										'updated_at' => NOW(),
										'from_date' => $invoiceDate,
										'to_date' => $last_dateG,
										'share_rate' => 4,
										'reseller_id' => $reseller_id,
										'unit' => $client_type,
                                       ]);
						}
								 
				}		
				else
				{
				return redirect('/monthlyinvoiceupdate')->withErrors(['No Invoice Available For Update']);
				}
		/*
				else{
                    if ($start_year == $inv_year && $start_month == $inv_month) {
                        $dayG=dateDifference($bill_start_date , $last_dateG , '%d' )+1;

                        $vat = 0;
                        $bill_amount = 0;
                        $total_bill = 0;
                        $extra_bill = 0;
                        $srv_id = 0;
                        $sarrear = 0;

                        $insertInvoice = DB::table('mas_invoices')->insertOrIgnore([
                            'invoice_date' => $invoiceDate,
                            'invoice_period' => $invoice_period,
                            'client_type' => $client_type,
                            'client_id' => $id,
                            'invoice_number' => $invnum,
                            'bill_number' => $billnum,
                            'remarks' => $rmark,
                            'invoice_cat' => 'Monthly',
                            'discount_amnt' => $discounts,
                            'other_add_item' => $other_add_item,
                            'other_adjustment' => $radjust,
                            'last_col_date' => $radv_date,
                            'entry_by' => Auth::id(),
                            'entry_date' => Carbon::now(),
                            'vat' => $vat,
                            'bill_amount' => $bill_amount,
                            'total_bill' => $total_bill,
                            'cur_arrear' => $extra_bill,
                            'unit' => $unit,
                            'rate_amnt' => $rate_amnt,
                            'serv_id' => $srv_id,
                            'from_date' => $bill_start_date,
                            'to_date' => $invoiceDate,
                            'pre_arrear' => $sarrear
                        ]);
        
                        //dd($insertInvoice);
                        $last_idG = pick('mas_invoices','MAX(id) as id',"")[0]->id;
        
                        //dd($last_idG);
        
                        $reseller_id = 0;
                        $share_percent = 0;
                        $share_rate = ROUND(($rate_amnt+$vat_amnt )*($share_percent/100));
                        $invoiceData = [
                            'invoiceobject_id' => $last_idG,
                            'client_id' => $id,
                            'billing_year' => $inv_year,
                            'billing_month' => $inv_month,
                            'rate' => $rate_amnt,
                            'vat' => $vat_amnt,
                            'billingdays' => $dayG,
                            'camnt' => DB::raw('ROUND(('.$rate_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                            'cvat' => DB::raw('ROUND(('.$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                            'total' => DB::raw('ROUND(('.$rate_amnt+$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),

                            'entry_by' => Auth::id(),
                            'entry_date' => NOW(),
                            'from_date' => $bill_start_date,
                            'to_date' => $last_dateG,
                            'share_rate' => $share_rate,
                            'reseller_id' => $reseller_id,
                            'serv_id' => $srv_id,
                            'unit' => $client_type,
                            'invoice_date' => $invoiceDate,
                        ];
                        //dd($invoiceData);
                        DB::table('trn_invoices')->insert($invoiceData);
        
                        $updateInvoice = DB::table('trn_invoices')
                                        ->whereYear('from_date', $pinvoiceYear)
                                        ->whereMonth('from_date', $pinvoiceMonth)
                                        ->where('serv_id', $srv_id)
                                        ->where('extra_bill', '<>', 0)
                                        ->update([
                                            'invoiceobject_id' => $last_idG,
                                            'billing_year' => DB::raw('YEAR(from_date)'),
                                            'billing_month' => DB::raw('MONTH(from_date)'),
                                            'invoice_date' => $invoiceDate,
                                        ]);

                    } 
                    else 
                        {
                            $srv_id = 0;
                            $sarrear = 0;

                            $dayG=dateDifference($invoiceDate , $last_dateG , '%d' )+1;
                            $tbill=$rate_amnt+$vat_amnt+$extraBill;

                            $insertInvoice = DB::table('mas_invoices')->insertOrIgnore([
                                'invoice_date' => $invoiceDate,
                                'invoice_period' => $invoice_period,
                                'client_type' => $client_type,
                                'client_id' => $id,
                                'invoice_number' => $invnum,
                                'bill_number' => $billnum,
                                'remarks' => $rmark,
                                'invoice_cat' => 'Monthly',
                                'discount_amnt' => $discounts,
                                'other_add_item' => $other_add_item,
                                'other_adjustment' => $radjust,
                                'last_col_date' => $radv_date,
                                'entry_by' => Auth::id(),
                                'entry_date' => Carbon::now(), // Use Carbon to get the current date and time
                                'vat' => $vat_amnt,
                                'bill_amount' => $bill_amnt,
                                'total_bill' => $tbill,
                                'cur_arrear' => $extraBill,
                                'unit' => $unit,
                                'ip_number' => $ip_number,
                                'rate_amnt' => $rate_amnt,
                                'from_date' => $invoiceDate, // Use appropriate date variable
                                'to_date' => $last_dateG,
                                'serv_id' => $srv_id,
                                'pre_arrear' => $sarrear
                            ]);

                            $last_idG = pick('mas_invoices','MAX(id)',"");

                            //dd($last_idG);

                            $reseller_id = 0;
                            $trbill=$rate_amnt+$vat_amnt;
                            $share_rate=ROUND(($rate_amnt+$vat_amnt )*($share_percent/100));
                            $trn_insert = $invoiceData = [
                                'invoiceobject_id' => $last_idG,
                                'client_id' => $id,
                                'billing_year' => $inv_year,
                                'billing_month' => $inv_month,
                                'rate' => $rate_amnt,
                                'vat' => $vat_amnt,
                                'billingdays' => $dayG,
                                'camnt' => DB::raw('ROUND(('.$rate_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                                'cvat' => DB::raw('ROUND(('.$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                                'total' => DB::raw('ROUND(('.$rate_amnt+$vat_amnt.' / DAY(LAST_DAY("'.$invoiceDate.'"))) * (DATEDIFF(LAST_DAY("'.$invoiceDate.'"),"'.$bill_start_date.'")+1))'),
                                'entry_by' => Auth::id(),
                                'entry_date' => NOW(),
                                'from_date' => $bill_start_date,
                                'to_date' => $last_dateG,
                                'share_rate' => $share_rate,
                                'reseller_id' => $reseller_id,
                                'serv_id' => $srv_id,
                                'unit' => $client_type,
                                'invoice_date' => $invoiceDate,
                            ];
                            
                            DB::table('trn_invoices')->insert($invoiceData);

                            $updateQuery = "
                                UPDATE trn_invoices
                                SET invoiceobject_id = $last_idG
                                WHERE billing_year = $pinvoiceYear
                                AND billing_month = $pinvoiceMonth
                                AND serv_id = $srv_id
                                AND extra_bill <> 0
                                AND client_id = $id
                            ";

                            DB::update($updateQuery);
                
                    }
                    
                }
			*/
         }


        $menus = Menu::get();
        //$mas_invoices = MasInvoice::get();
        $customers = Customer::orderBy('id')->get()->take(100);

        return redirect('/monthlyinvoiceupdate')->with('success', 'Invoice Updated successfully For the Customer '.$customerRow->user_id);
    }
	

    //Show Edit Invoice Page
    public function editInvoice()
    {
        $menus = Menu::get();
        $mas_invoices = MasInvoice::with('Customer', 'TblInvoiceCat')->get();
        $customers = Customer::orderBy('id')->get();

        return view('pages.billing.editInvoice', compact('menus', 'mas_invoices', 'customers'));
    }

    //Show Edit Invoice detail Page
    public function editInvoiceShow(Request $request)
    {
        $customerid = $request->client;
        //dd($customerid);
        $menus = Menu::get();
        $mas_invoices = MasInvoice::with('Customer', 'TblInvoiceCat')->where('customer_id',$customerid)->get();
        //dd($mas_invoices);
        $customers = Customer::orderBy('id')->get();
        

        return view('pages.billing.editInvoiceShow', compact('menus', 'mas_invoices', 'customers'));
    } 

    //Show Invoice Collection Page
    public function invoiceCollection()
    {
        $menus = Menu::get();
        $mas_invoices = MasInvoice::with('TblSrvType')->get();
        $customers = Customer::orderBy('id')->get();
        $dates = Carbon::now();
        $banks = MasBank::get();

        return view('pages.billing.invoiceCollection', compact('menus', 'mas_invoices', 'customers', 'dates', 'banks'));
    }

    //Show Invoice Collection Home 
    public function invoiceCollectionHome()
    {
        $menus = Menu::get();
        $customers = Customer::get()->take(2000);
        //dd($customers);
        $dates = Carbon::now();
        return view('pages.billing.invoiceCollectionHome', compact('menus', 'customers', 'dates'));
    }

    public function invoiceCollectionHomeShow(Request $request)
    {

        $cboDebtor = $request->customer_id;
        //dump($cboDebtor);
        $invoices = null;

        $invoices = DB::table('mas_invoices')
                        ->select(
                            'mas_invoices.id as invoiceobjet_id',
                            DB::raw("DATE_FORMAT(mas_invoices.invoice_date, '%d-%m-%Y') as smonth"),
                            'mas_invoices.invoice_cat as syear',
                            'mas_invoices.total_bill as net_bill',
                            'mas_invoices.total_bill as total_bill',
                            'mas_invoices.invoice_number',
                            'tbl_srv_types.srv_name',
                            DB::raw('(mas_invoices.collection_amnt + mas_invoices.discount_amnt + mas_invoices.ait_adjustment + mas_invoices.vat_adjust_ment + mas_invoices.other_adjustment) as ReceivedAmount'),
                            'mas_invoices.customer_id',
                            'trn_clients_services.id'
                        )
                        ->leftJoin('trn_clients_services', 'trn_clients_services.id', '=', 'mas_invoices.serv_id')
                        ->leftJoin('tbl_srv_types', 'tbl_srv_types.id', '=', 'trn_clients_services.srv_type_id')
                        ->where('mas_invoices.customer_id', $cboDebtor)
                        ->whereRaw('mas_invoices.total_bill > (mas_invoices.collection_amnt + mas_invoices.discount_amnt + mas_invoices.ait_adjustment + mas_invoices.vat_adjust_ment + mas_invoices.other_adjustment + mas_invoices.downtimeadjust)')
                        ->get();
       
        //dd($invoices->invoiceobjet_id);
        $menus = Menu::get();
        $customers = Customer::where('id',$cboDebtor)->get();
        //dd($customers);
        $dates = Carbon::now();
        return view('pages.billing.invoiceCollectionHomeShow', compact('menus', 'customers','cboDebtor', 'dates','invoices'));
    }

    public function invoiceCollectionHomeStore(Request $request)
    {

        //dd($request);

        $index = (int)$request->input('hidIndex');
        $netBill = 0;
        $receivedAmount = 0;
        $amount = 0;
        $possibleMaxAmount = 0;
    
        // if ($request->input('rdoReceiveType') == '') {
        //     return redirect()->route('masinvoice.invoicecollection')->withErrors(['Please Enter Received Type']);
        // }
    
       
       
        for ($i = 0; $i < $index; $i++) {
            //dd(count($request->chkAccept));
            if (count($request->chkAccept)>0) {
                $netBill = $request->input("txtNetBill[.$i.]");
                $receivedAmount = $request->input("txtReceivedAmount[.$i.]");
                //dd($request->input("txtAmount[.$i.]"));
                $amount = $request->input("txtAmount[.$i.]");
                $possibleMaxAmount = (float)$netBill - (float)$receivedAmount;
    
                //dd($amount , $possibleMaxAmount);
                // if ($amount > $possibleMaxAmount || $amount <= 0 || is_nan($amount)) {
                //     return redirect()->route('masinvoice.invoicecollection')->withErrors(['Please Enter Valid Amount.']);
                // }
                $flag = false;
            }
            else{
                return redirect()->route('masinvoice.invoicecollection')->withErrors(['Please Select At Least One Invoice.']);
            }
        }
    
        

        //dd($request->client_Id);
        $hidIndex = $request->hidIndex;
        $chkAccept = $request->chkAccept;
        $serv_id = $request->serv_id;
        $client_Id = $request->client_Id;
        $txtInvoiceObjectID = $request->txtInvoiceObjectID;
        $syear = $request->syear;
        $smonth = $request->smonth;
        $txtAmount = $request->txtAmount;
        $cboVoucherDay = $request->cboVoucherDay;
        $cboVoucherMonth = $request->cboVoucherMonth;
        $cboVoucherYear = $request->cboVoucherYear;
        $SUserID = $request->SUserID;
        $txtDiscount = $request->txtDiscount;
        $txtAdvance = $request->txtAdvance;
        $txtVat = $request->txtVat;
        $txtAit = $request->txtAit;
        $txtDownTime = $request->txtDownTime;
    
        // Combine voucher date parts
        //dd($cboVoucherYear, $cboVoucherMonth, $cboVoucherDay);
        $coldate = Carbon::create($cboVoucherYear, $cboVoucherMonth, $cboVoucherDay);
        
    
        // Insert into mas_collections
        //dd($request->txtMoneyReceiptNo);
        $collection_id = DB::table('mas_collections')->insertGetId([
            'customer_id' => $client_Id,
            'money_receipt' => $request->txtMoneyReceiptNo,
            'collection_date' => $coldate,
            'pay_type' => $request->rdoReceiveType,
            'bank_id' => $request->cbobank,
            'cheque_no' => $request->txtChequeNo,
            'cheque_date' => $coldate,
            'coll_amount' => $request->txtTotalAmount,
            'discoun_amnt' => $request->txtTotalDiscount,
            'adv_rec' => $request->txtTotalAdvance,
            'vatadjust' => $request->txtTotalVat,
            'aitadjust' => $request->txtTotalAit,
            'downtimeadjust' => $request->txtTotalDownTime,
            'remarks' => $request->txaRemarks,
        ]);

        
    
        for ($i = 0; $i < $hidIndex; $i++) {
            
            if ($chkAccept[$i] == "ON") {
                $txtAdvance[$i] = $txtAdvance[$i] ?? 0;
    
                //dd(Carbon::createFromFormat('d/m/Y', $smonth[$i]));
                // Insert data into trn_collections
                DB::table('trn_collections')->insert([
                    'collection_id' => $collection_id,
                    'serv_id' => $serv_id[$i],
                    'client_Id' => $client_Id,
                    'masinvoiceobject_id' => $txtInvoiceObjectID[$i],
                    'billing_year' => explode("-", $smonth[$i])[0],
                    'billing_month' => explode("-", $smonth[$i])[1],
                    'collamnt' => $txtAmount[$i],
                    'collection_date' => $coldate,
                    'adv_rec' => $txtAdvance[$i],
                    'discoun_amnt' => $txtDiscount[$i] ?? 0,
                    'vatadjust' => $txtVat[$i] ?? 0,
                    'aitadjust' => $txtAit[$i] ?? 0,
                    'downtimeadjust' => $txtDownTime[$i] ?? 0,
                ]);
    
                // Prepare the update query for mas_invoices
                $updates = [];
                if ($txtDiscount[$i] > 0) {
                    $updates['discount_amnt'] = DB::raw("discount_amnt + {$txtDiscount[$i]}");
                }
                if ($txtVat[$i] > 0) {
                    $updates['vat_adjust_ment'] = DB::raw("vat_adjust_ment + {$txtVat[$i]}");
                }
                if ($txtAit[$i] > 0) {
                    $updates['ait_adjustment'] = DB::raw("ait_adjustment + {$txtAit[$i]}");
                }
                if ($txtDownTime[$i] > 0) {
                    $updates['downtimeadjust'] = DB::raw("downtimeadjust + {$txtDownTime[$i]}");
                }
                $updates['collection_amnt'] = DB::raw("collection_amnt + {$txtAmount[$i]}");
                $updates['adv_rec'] = DB::raw("adv_rec + {$txtAdvance[$i]}");
                $updates['last_col_date'] = $coldate->format('Y-m-d');
    
                DB::table('mas_invoices')
                    ->where('id', $txtInvoiceObjectID[$i])
                    ->update($updates);
    
                // Check total bill
                $totalbill = DB::table('mas_invoices')
                    ->where('client_id', $serv_id[$i])
                    ->sum(DB::raw('total_bill - (other_adjustment + discount_amnt + collection_amnt + ait_adjustment + vat_adjust_ment)'));
    
                if ($totalbill <= 0) {
                    $clientService = DB::table('trn_clients_services')
                        ->where('id', $serv_id[$i])
                        ->first();
    
                    $new_date = Carbon::now()->firstOfMonth()->day(9);
                    $NewExp_date = $new_date->copy()->addMonth()->toDateString();
                    $date_exp = $new_date->copy()->addMonth()->format('d M Y');
    
                    DB::table('radcheck')
                        ->where('attribute', 'Expiration')
                        ->where('username', $clientService->user_id)
                        ->update(['value' => $date_exp]);
    
                    DB::table('trn_clients_services')
                        ->where('id', $serv_id[$i])
                        ->update([
                            'status' => 1,
                            'block_date' => $NewExp_date
                        ]);
                }
            }
        }

        $menus = Menu::get();
        $customers = Customer::get()->take(2000);
        $dates = Carbon::now();
        return redirect('/invoicecollectionhome')->with('success', 'Collection added successfully');
    }

    public function dailyCollectionSheet()
    {
        $menus = Menu::get();
        $nisl_mas_members = NislMasMember::orderby('username')->get();
        $client_categories = TblClientCategory::orderby('name')->get();
        $zones = TblZone::orderby('zone_name')->get();
        $suboffices = TblSuboffice::orderby('name')->get();
        $dates = Carbon::now();

        return view('pages.billing.dailyCollectionSheet', compact('menus', 'nisl_mas_members', 'client_categories', 'zones', 'suboffices', 'dates'));
    }

    public function advanceInformation(Request $request)
    {
        $menus = Menu::get();
        $customers = Customer::get();
		$dates = date("Y-m-d");
		
		$branch_id = -1;
		
		if ($request->branch_id >=1) { $branch_id = $request->branch_id;}
		if ($request->customer_id >=1) { $customer_id = $request->customer_id;} else {$customer_id = -1; }
		if ($request->fromDate) { $fromDate = $request->fromDate;} else {$fromDate = $dates; }
		if ($request->toDate) { $toDate = $request->toDate;} else {$toDate = $dates; }
		//	$fromDate = $request->fromDate;
		//	$toDate = $request->toDate;

//dd($fromDate);

		$suboffices = TblSuboffice::orderby('name')->get();
		$services = TblSrvType::orderby('srv_name')->get();
		$banks = MasBank::orderby('bank_name')->get();
		
	//	$advancebills = AdvanceBill::get();
		
		$advancebills = AdvanceBill::query()
						->Join('customers', 'customers.id', '=', 'tbl_advance_bills.client_id')
						->Join('mas_collections', 'mas_collections.id', '=', 'tbl_advance_bills.collection_id')
						
        ->select([
						'tbl_advance_bills.rec_date',
						'tbl_advance_bills.money_recipt',
						'tbl_advance_bills.bill_month',
						'tbl_advance_bills.bill_year',
						'tbl_advance_bills.amount',
						'customers.customer_name',
						'mas_collections.remarks',
        ]);
		
		if ($branch_id>=1) {
            $advancebills->where('customers.sub_office_id', $branch_id);
        }else {
			 $advancebills->where('customers.sub_office_id','>=', 1);
		}
		if ($customer_id>=1) {
            $advancebills->where('tbl_advance_bills.client_id', $customer_id);
        }
		if ($fromDate) {
            $advancebills->where('tbl_advance_bills.rec_date','>=', $fromDate);
        }
		if ($toDate) {
            $advancebills->where('tbl_advance_bills.rec_date','<=',$toDate);
        }
		
		$advancebills->orderBy('tbl_advance_bills.rec_date', 'desc');
		
        $advancebills = $advancebills->get();
		
		
        return view('pages.billing.advanceInformation', compact('menus', 'customers', 'advancebills','suboffices','services','banks'));
    }
	
	    public function advanceInformationStore(Request $request)
    {
		
		$request->validate([
			'customer_id1' => 'required|not_in:-1',
			'year' => 'required|not_in:-1',
			'month' => 'required|not_in:-1',
			'amount' => 'required','integer',
			'collection_date' => 'required',
			'service_id' => 'required|not_in:-1',


        ]);
		
		 if ($request->customer_id1 >=1) {
		
			$entry_by = 1;
		//	$collection_id = "34";
			
			$insertData1 = [
					'customer_id' => $request->customer_id1,
					'coll_amount' => $request->amount,
					'discoun_amnt' => ($request->discount == null) ? '0' : $request->discount,
					'collection_date' => $request->collection_date,
					'money_receipt' => ($request->money_recpt == null) ? '0' : $request->money_recpt,
					'pay_type' => ($request->pay_type == null) ? 'C' : $request->pay_type,
					'bank_id' => ($request->bank_id == -1) ? '0' : $request->bank_id,
					'cheque_no' => ($request->cheque_no == null) ? '0' : $request->cheque_no,
					'remarks' => ($request->remarks == null) ? '0' : $request->remarks,
					'cheque_date' => $request->cheque_date,
					'coll_by' => $entry_by,	
						];	
				$result1 =  DB::table('mas_collections')->insert($insertData1);		
				
	$collection_id = pick('mas_collections','MAX(id) as id',"")[0]->id;				
// $collection_id=pick('mas_collections','id','customer_id="'.$request->customer_id1.'"');

 //$collection_id=mysql_insert_id();
				 
				 $insertData = [
					'client_id' => $request->customer_id1,
					'srv_id' => $request->service_id,
					'bill_month' => $request->month,
					'bill_year' => $request->year,
					'amount' => $request->amount,
					'rec_date' => $request->collection_date,
					'discount' => ($request->discount == null) ? '0' : $request->discount,
					'entry_date' => ($request->entry_date == null) ? now(): $request->entry_date,
					'money_recipt' => ($request->money_recpt == null) ? '0' : $request->money_recpt,
					'pay_type' => ($request->pay_type == null) ? 'C' : $request->pay_type,
					'entry_by' => $entry_by,
					'collection_id' => $collection_id,
                ];
				
                $result =  DB::table('tbl_advance_bills')->insert($insertData);				
					
				$succes_status=$result;
				if($succes_status=true)
					{ 
                return redirect('/advanceinformation')->with('success', 'Advance Collection added successfully');
					} 
					else
					{
                return redirect(route('/advanceinformation'))->with('error', 'Failed to update data.');
					}
        } else {
			return redirect('/advanceinformation')->withErrors(['Error: Select Customer, Month, Year and amount']);
        }
		
    }
	

    public function renew()
    {
        $menus = Menu::get();
        $customers = Customer::get();
        $dates = Carbon::now();
        return view('pages.billing.renewCustomer', compact('menus', 'customers', 'dates'));
    }

    public function otherInv()
    {
        $menus = Menu::get();
        $branches = TblSuboffice::where('status',1)->get();
        $customers = Customer::get();
        $invoices = MasInvoice::get();
        $categories = DB::select("SELECT
                                    IF(level_id=1,id,(if(level_id=2,cat_parent_id,(select cat_parent_id from tbl_categories where id=tt.cat_parent_id ))))AS l2,
                                    IF(level_id=1,0,(if(level_id=2,id,(select id from tbl_categories where id=tt.cat_parent_id ))))AS l1,
                                    `id`,
                                    `cat_parent_id`,
                                    `cat_name`,
                                    `level_id`
									FROM
											`tbl_categories` as tt
									Where tt.id>0
									Order By l2,l1,cat_parent_id,cat_name");
                                    //dd($categories);
        return view('pages.billing.otherInvoice', compact('menus', 'customers', 'invoices','categories','branches'));
    }

    public function prodByCategory(Request $req)
    {
        //
        $response = TblProduct::where('cat_id',$req->catID)->get();

        //dd($response);
        if ($response) {
            return response()->json([
                "status" => true,
                "msg" => "",
                "data" => $response
            ]);
        }
    }
    public function prodDetail(Request $req)
    {
        //
        $response = TblProduct::where('id',$req->prodID)->first();

        //dd($response);
        if ($response) {
            return response()->json([
                "status" => true,
                "msg" => "",
                "data" => $response
            ]);
        }
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
    public function show(MasInvoice $masInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasInvoice $masInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $masInvoice)
    {
        $user_id = 1; //Replace by Auth later

        $updateData = $request->validate([
            'total_bill' => 'integer',

        ]);
        //dd($request->vat);
        $vat = $request->vat;

        $mas_invoices = MasInvoice::find($masInvoice);
        $mas_invoices->total_bill = $request->total_bill;
        $mas_invoices->vat = $request->vat==null?0:$request->vat;
        $mas_invoices->discount_amnt = $request->discount_amnt==null?0:$request->discount_amnt;
        $mas_invoices->comments = $request->comments==null?"":$request->comments;
        $mas_invoices->updated_by = $user_id;
        $mas_invoices->save();

        

        return redirect(route('masinvoice.editinvoice')) -> with('success', 'Invoice has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($masInvoice = null)
    {
        $user_id = 1; //Replace by Auth later

        $mas_invoices = MasInvoice::find($masInvoice);
        $mas_invoices->deleted_by = $user_id;
        $mas_invoices->save();
        $mas_invoices->delete();
        return redirect(route('masinvoice.index')) -> with('success', 'Invoice has been deleted successfully');
    }
}
