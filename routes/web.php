<?php

use App\Http\Controllers\InvoiceTypeController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\MasEmployeeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HrmLevelController;
use App\Http\Controllers\HrmShiftSetupController;
use App\Http\Controllers\IpPoolController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\MicrotikGraphController;
use App\Http\Controllers\TblRouterController;
use App\Http\Controllers\TblScheduleController;
use App\Http\Controllers\TblScheduleTeamController;
use App\Http\Controllers\TblShiftTeamController;
use App\Http\Controllers\TblZoneController;
use App\Http\Controllers\VariablesController;
use App\Http\Controllers\BlockReasonController;
use App\Http\Controllers\BusinessTypeController;
use App\Http\Controllers\TblSubofficeController;
use App\Http\Controllers\MasDepartmentController;
use App\Http\Controllers\StaticIpController;
use App\Http\Controllers\TaskProgressController;
use App\Http\Controllers\NasController;
use App\Http\Controllers\BulkRouterChangeController;
use App\Http\Controllers\IpController;
use App\Http\Controllers\AssignPoolController;
use App\Http\Controllers\ClientControlController;
use App\Http\Controllers\AccessLogController;
use App\Http\Controllers\UserStatusReportController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\TblSmsTemplateController;
use App\Http\Controllers\TblSmsSetupController;
use App\Http\Controllers\MasInvoiceController;
use App\Http\Controllers\TblClientTypeController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\TblHolidayController;
use App\Http\Controllers\TblWeekendController;
use App\Http\Controllers\HrmAttendenceSummaryController;
use App\Http\Controllers\HrmIncrementController;
use App\Http\Controllers\TrnClientsServiceController;
use App\Http\Controllers\PackagePlanController;
use App\Http\Controllers\BillReports\MonthlyInvoiceController;
use App\Http\Controllers\BillReports\ClientLedgerController;
use App\Http\Controllers\BillReports\DailyBillCollectionController;
use App\Http\Controllers\BillReports\CollectionSummeryController;
use App\Http\Controllers\BillReports\RptClientListController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|-------------------------------------------------------------------------- 
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// This part needs to be ignored after the controllers etc are made: Frome here -

Route::get('/permissions', function () {
    return view('auth.permissions');
});
Route::get('/roles', function () {
    return view('auth.roles');
});
Route::get('/users', function () {
    return view('auth.user');
});
// To here

Route::middleware(['auth'])->group(function () {
    // Company Setup
    Route::get('/', [HomeController::class, 'index']);
    Route::resource('customers', CustomerController::class);
    Route::post('customers/search', [CustomerController::class, 'search'])->name('customers.search');
    Route::resource('services', TrnClientsServiceController::class);
    Route::post('services/search', [TrnClientsServiceController::class, 'search'])->name('services.search');

    // Global Setup Module
    Route::resource('blockreason', BlockReasonController::class);
    Route::resource('businesstype', BusinessTypeController::class);
    Route::resource('suboffice', TblSubofficeController::class);
    Route::resource('department', MasDepartmentController::class);
    Route::resource('taskprogress', TaskProgressController::class);

    Route::resource('designation', DesignationController::class);
    Route::resource('area', AreaController::class);
    Route::resource('invoicetype', InvoiceTypeController::class);
    Route::resource('mikrotikgraph', MicrotikGraphController::class);
    Route::resource('variables', VariablesController::class);
    Route::resource('zone', TblZoneController::class);

    // Radius Module
    Route::resource('ip', IpController::class);
    Route::resource('assignpool', AssignPoolController::class);
    Route::resource('clientcontrol', ClientControlController::class);
    Route::put('clientcontrol/{uniqueclientcontrol}/block', [ClientControlController::class, 'blockOrActive'])->name('clientcontrol.block');
    Route::put('clientcontrol/{uniqueclientcontrol}/changepackage', [ClientControlController::class, 'changePackage'])->name('clientcontrol.changepackage');
    Route::put('clientcontrol/{uniqueclientcontrol}/changeip', [ClientControlController::class, 'changeIpPassMac'])->name('clientcontrol.changeip');
    Route::put('clientcontrol/{uniqueclientcontrol}/pppoetohotspot', [ClientControlController::class, 'pppoeToHotspot'])->name('clientcontrol.pppoetohotspot');
    Route::put('clientcontrol/{uniqueclientcontrol}/hotspottopppoe', [ClientControlController::class, 'hotspotToPPPOE'])->name('clientcontrol.hotspottopppoe');
    Route::put('clientcontrol/{uniqueclientcontrol}/updateuserid', [ClientControlController::class, 'updateUserid'])->name('clientcontrol.updateuserid');
    Route::put('clientcontrol/{uniqueclientcontrol}/updaterouter', [ClientControlController::class, 'updateRouter'])->name('clientcontrol.updaterouter');
    Route::post('clientcontrol/search', [ClientControlController::class, 'search'])->name('clientcontrol.search');
    Route::get('servicelog', [ClientControlController::class, 'serviceLog'])->name('clientcontrol.servicelog');

    Route::resource('ippool', IpPoolController::class);
    Route::resource('router', TblRouterController::class);
    Route::resource('bulkrouterchange', BulkRouterChangeController::class);
    //Route::get('bulkrouterchange', [BulkRouterChangeController::class, 'show'])->name('bulkrouterchange.show');
    //Route::get('bulkrouterchange', [BulkRouterChangeController::class, 'index'])->name('bulkrouterchange.index');
    Route::get('bulkrouterchange.show', [BulkRouterChangeController::class, 'show'])->name('bulkrouterchange.show');
    //Route::get('bulkrouterchange.store', [BulkRouterChangeController::class, 'store'])->name('bulkrouterchange.store');
    
    Route::resource('staticip', StaticIpController::class);
    Route::resource('nas', NasController::class);
    Route::post('/nas/radius_restart/', [NasController::class, 'radius_restart'])->name('nas.radius_restart');
    Route::resource('accesslog', AccessLogController::class);
    Route::post('accesslog/search', [AccessLogController::class, 'search'])->name('accesslog.search');
    Route::resource('userstatusreport', UserStatusReportController::class);
    Route::get('userstatusreport/show', [UserStatusReportController::class, 'show'])->name('userstatusreport.show');


    // SMS & Email Module
    Route::resource('sendsinglesms', SmsController::class);
    Route::get('sendsms', [SmsController::class, 'bulkSms'])->name('sendsms.bulksms');
    Route::resource('smstemplate', TblSmsTemplateController::class);
    Route::resource('smssetup', TblSmsSetupController::class);

    Route::resource('emailsetup', EmailController::class);
    Route::get('emailandsms', [EmailController::class, 'email_and_sms']);
    Route::get('emaillog', [EmailController::class, 'email_log']);
    Route::get('sendemail', [EmailController::class, 'email_send'])->name('sendemail.email_send');
    Route::post('sendemail', [EmailController::class, 'esend_store'])->name('sendemail.esend_store');
    Route::get('emailtemplate', [EmailController::class, 'email_template'])->name('emailtemplate.email_template');
    Route::post('emailtemplate', [EmailController::class, 'template_store'])->name('emailtemplate.template_store');
    Route::put('emailtemplate/{emailtemplate}', [EmailController::class, 'template_update'])->name('emailtemplate.template_update');
    Route::delete('emailtemplate/{emailtemplate}', [EmailController::class, 'template_destroy'])->name('emailtemplate.template_destroy');

    // Billing Module
    Route::resource('clienttype', TblClientTypeController::class);
    Route::resource('masinvoice', MasInvoiceController::class);
    Route::get('monthlyinvoicecreate', [MasInvoiceController::class, 'monthlyinvoicecreate'])->name('masinvoice.monthlyinvoicecreate');
    Route::post('monthlyinvoicecreate', [MasInvoiceController::class, 'monthlyinvoicestore'])->name('masinvoice.monthlyinvoicestore');
    Route::get('monthlyinvoiceupdate', [MasInvoiceController::class, 'monthlyInvoiceUpdate'])->name('masinvoice.monthlyinvoiceupdate');
    Route::get('monthlyinvoiceupsave', [MasInvoiceController::class, 'monthlyInvoiceUpdateSave'])->name('masinvoice.monthlyInvoiceUpdateSave');
    Route::get('editinvoice', [MasInvoiceController::class, 'editInvoice'])->name('masinvoice.editinvoice');
    Route::get('editinvoiceShow', [MasInvoiceController::class, 'editInvoiceShow'])->name('masinvoice.editinvoiceshow');
    Route::get('invoicecollection', [MasInvoiceController::class, 'invoiceCollection'])->name('masinvoice.invoicecollection');
    Route::post('invoicecollectionhomeshow', [MasInvoiceController::class, 'invoiceCollectionHomeShow'])->name('invoice_collection_home.show');
    Route::post('invoicecollectionhomestore', [MasInvoiceController::class, 'invoiceCollectionHomeStore'])->name('invoice_collection_home.store');
    
    Route::get('dailycollectionsheet', [MasInvoiceController::class, 'dailyCollectionSheet'])->name('masinvoice.dailycollectionsheet');
    Route::resource('packageplan', PackagePlanController::class);

    Route::get('invoicecollectionhome', [MasInvoiceController::class, 'invoiceCollectionHome'])->name('invoicecollectionhome.invoicecollectionhome');
    Route::post('invoicecollectionhomeshow', [MasInvoiceController::class, 'invoiceCollectionHomeShow'])->name('invoicecollectionhome.show');
    Route::post('invoicecollectionhomestore', [MasInvoiceController::class, 'invoiceCollectionHomeStore'])->name('invoice_collection_home.store');
    Route::get('advanceinformation', [MasInvoiceController::class, 'advanceInformation'])->name('advanceinformation.advanceinformation');
    Route::get('renewcustomer', [MasInvoiceController::class, 'renew'])->name('renewcustomer.renew');
    Route::get('otherinvoice', [MasInvoiceController::class, 'otherInv'])->name('otherinvoice.other_inv');
	
	Route::resource('monthlyinvoices', MonthlyInvoiceController::class);
    Route::get('monthlyinvoices/show', [MonthlyInvoiceController::class, 'show'])->name('monthlyinvoices.show');
	Route::resource('clientledger', ClientLedgerController::class);
    Route::get('clientledger/show', [ClientLedgerController::class, 'show'])->name('clientledger.show');
	Route::resource('dailybillcollection', DailyBillCollectionController::class);
    Route::get('dailybillcollection/show', [DailyBillCollectionController::class, 'show'])->name('dailybillcollection.show');
	Route::resource('collectionsummery', CollectionSummeryController::class);
    Route::get('collectionsummery/show', [CollectionSummeryController::class, 'show'])->name('collectionsummery.show');
	Route::resource('rptclientlist', RptClientListController::class);
    Route::get('rptclientlist/show', [RptClientListController::class, 'show'])->name('rptclientlist.show');


    // Authentication
    Route::get('permissions', [HomeController::class, 'permission_page']);
    Route::get('users', [HomeController::class, 'user_page']);
    Route::get('roles', [HomeController::class, 'roles_page']);

    // HRM Setup
    Route::resource('holiday', TblHolidayController::class);
    Route::resource('weeklyholiday', TblWeekendController::class);
    Route::resource('leavetype', LeaveTypeController::class);
    Route::get('empwopin', [MasEmployeeController::class, 'woPin'])->name('empwopin.woPin');
    Route::put('empwopin/{empwopin}', [MasEmployeeController::class, 'woPinUpdate'])->name('empwopin.woPinUpdate');
    Route::resource('shift', TblScheduleController::class);
    Route::get('shiftschedule', [TblScheduleController::class, 'shiftschdlIndex'])->name('shiftschedule.shiftschdlIndex');
    Route::post('shiftschedule', [TblScheduleController::class, 'shiftschdlStore'])->name('shiftschedule.shiftschdlStore');
    Route::put('shiftschedule/{shiftschedule}', [TblScheduleController::class, 'shiftschdlUpdate'])->name('shiftschedule.shiftschdlUpdate');
    Route::resource('hrmlevel', HrmLevelController::class);
    Route::resource('scheduleteam', TblScheduleTeamController::class);
    Route::resource('shiftteam', TblShiftTeamController::class);
    Route::resource('shiftsetup', HrmShiftSetupController::class);

    //HRM Entry Form
    Route::resource('attendancesummary', HrmAttendenceSummaryController::class);
    Route::resource('hrmincrement', HrmIncrementController::class);

    //Pdf
    Route::get('monthly_invoices_pdf', [MonthlyInvoiceController::class, 'indexPdf'])->name('monthly_invoices_pdf');


    //ajax
    Route::post('routerApiCheck/{router}', [TblRouterController::class, 'apiCheckPost'])->name('routerApiCheck');
    Route::post('routerSShCheck/{router}', [TblRouterController::class, 'sshCheckPost'])->name('routerSShCheck');
});





Route::get('routes', function () {
    $routeCollection = Route::getRoutes();

    echo "<table style='width:100%'>";
    echo "<tr>";
    echo "<td width='10%'><h4>HTTP Method</h4></td>";
    echo "<td width='10%'><h4>Route</h4></td>";
    echo "<td width='10%'><h4>Name</h4></td>";
    echo "<td width='70%'><h4>Corresponding Action</h4></td>";
    echo "</tr>";
    foreach ($routeCollection as $value) {
        echo "<tr>";
        echo "<td>" . $value->methods()[0] . "</td>";
        echo "<td>" . $value->uri() . "</td>";
        echo "<td>" . $value->getName() . "</td>";
        echo "<td>" . $value->getActionName() . "</td>";
        echo "</tr>";
    }
    echo "</table>";
});



