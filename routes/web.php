<?php

use App\Http\Controllers\CheckinoutController;
use App\Http\Controllers\HrmApproveSalaryController;
use App\Http\Controllers\HrmBonusGenerationController;
use App\Http\Controllers\HrmEmpMonthlySalaryController;
use App\Http\Controllers\HrmGenerateSalaryController;
use App\Http\Controllers\HrmSalaryAdvancedController;
use App\Http\Controllers\HrmTblEmploanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\HrmPayrollAddCompController;
use App\Http\Controllers\HrmPayrollDeductCompController;
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
use App\Http\Controllers\HrmAttendanceSummaryController;
use App\Http\Controllers\HrmIncrementController;
use App\Http\Controllers\TrnClientsServiceController;
use App\Http\Controllers\PackagePlanController;
use App\Http\Controllers\HrmEmpJobHistoryController;
use App\Http\Controllers\HrmEmpMonthlyAddController;
use App\Http\Controllers\HrmEmpMonthlyDeductController;
use App\Http\Controllers\TblLeaveController;
use Illuminate\Support\Facades\Route;
////////Faruque /
use App\Http\Controllers\BillReports\MonthlyInvoiceController;
use App\Http\Controllers\BillReports\ClientLedgerController;
use App\Http\Controllers\BillReports\DailyBillCollectionController;
use App\Http\Controllers\BillReports\CollectionSummeryController;
use App\Http\Controllers\BillReports\RptClientListController;
use App\Http\Controllers\BillReports\InvoicePrintController;
use App\Http\Controllers\BillReports\DueListController;
use App\Http\Controllers\BillReports\DiscountInCollectionController;
use App\Http\Controllers\MessageLogController;
use App\Http\Controllers\BillReports\OnlineCollectionController;
use App\Http\Controllers\BillReports\DueListDateRangeController;
use App\Http\Controllers\BillReports\CollectionTypeWiseController;
use App\Http\Controllers\BillReports\NewBlockClientController;
use App\Http\Controllers\BillReports\ClientExpiryController;
use App\Http\Controllers\BillReports\VendorMasterClientController;
use App\Http\Controllers\Accounts\GenCahsVoucherController;
use App\Http\Controllers\Accounts\GenChequeVoucherController;
use App\Http\Controllers\Accounts\GenNagadVoucherController;
use App\Http\Controllers\Accounts\GenBkashVoucherController;
use App\Http\Controllers\Accounts\ClientInvoicePostingController;
use App\Http\Controllers\Accounts\SupplierLedgerController;
use App\Http\Controllers\Accounts\SupplierAgingReportController;
use App\Http\Controllers\Accounts\SupplierInvoiceListController;
use App\Http\Controllers\Accounts\SupplierDueListController;
use App\Http\Controllers\Accounts\Setup\BankEntryController;
use App\Http\Controllers\Accounts\Setup\BankAccountController;
use App\Http\Controllers\Accounts\Setup\DeleteJournalController;
use App\Http\Controllers\Accounts\ProjectController;
use App\Http\Controllers\Accounts\TransferVoucherController;
use App\Http\Controllers\Accounts\OpeningBalanceController;
use App\Http\Controllers\Accounts\CashBankController;
use App\Http\Controllers\Accounts\GeneralLedgerController;
use App\Http\Controllers\Accounts\JournalController;
use App\Http\Controllers\Accounts\ChartofAccountsController;
use App\Http\Controllers\RadiusServerController;

//Fruque End/////////////


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
    Route::resource('menu', MenuController::class);

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
    Route::resource('radius-server', RadiusServerController::class);

    Route::resource('ippool', IpPoolController::class);
    Route::post('importRouter', [IpPoolController::class, 'importRouter'])->name('ippool.importRouter');
    Route::post('ippool/{search}', [IpPoolController::class, 'search'])->name('ippool.search');
    Route::post('otherInv/prodByCategory', [MasInvoiceController::class, 'prodByCategory'])->name('otherInv.prodByCategory');
    Route::post('otherInv/prodDetail', [MasInvoiceController::class, 'prodDetail'])->name('otherInv.prodDetail');
    Route::post('getCustomerByBranch', [CustomerController::class, 'getCustomerByBranch'])->name('getCustomerByBranch');
    
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
	//Faruque
	Route::resource('messagelog', MessageLogController::class);
    Route::post('messagelog/search', [MessageLogController::class, 'search'])->name('messagelog.search');


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
    Route::post('dailycollectionsheet/show', [MasInvoiceController::class, 'dailyCollectionSheet'])->name('masinvoice.dailycollectionsheet.show');
    Route::resource('packageplan', PackagePlanController::class);

    Route::get('invoicecollectionhome', [MasInvoiceController::class, 'invoiceCollectionHome'])->name('invoicecollectionhome.invoicecollectionhome');
    Route::post('invoicecollectionhomeshow', [MasInvoiceController::class, 'invoiceCollectionHomeShow'])->name('invoicecollectionhome.show');
    Route::post('invoicecollectionhomestore', [MasInvoiceController::class, 'invoiceCollectionHomeStore'])->name('invoice_collection_home.store');
    Route::get('advanceinformation', [MasInvoiceController::class, 'advanceInformation'])->name('advanceinformation.advanceinformation');

    Route::get('renewcustomer', [MasInvoiceController::class, 'renew'])->name('renewcustomer.renew');
    Route::get('otherinvoice', [MasInvoiceController::class, 'otherInv'])->name('otherinvoice.other_inv');
//Faruque////////////
	Route::post('advanceinformationstore', [MasInvoiceController::class, 'advanceInformationStore'])->name('advanceinformation.store');
	Route::resource('monthlyinvoices', MonthlyInvoiceController::class);
    Route::post('monthlyinvoices/show', [MonthlyInvoiceController::class, 'show'])->name('monthlyinvoices.show');
	Route::resource('clientledger', ClientLedgerController::class);
    Route::get('clientledger/show', [ClientLedgerController::class, 'show'])->name('clientledger.show');
	Route::resource('dailybillcollection', DailyBillCollectionController::class);
    Route::get('dailybillcollection/show', [DailyBillCollectionController::class, 'show'])->name('dailybillcollection.show');
	Route::resource('collectionsummery', CollectionSummeryController::class);
    Route::get('collectionsummery/show', [CollectionSummeryController::class, 'show'])->name('collectionsummery.show');
	Route::resource('rptclientlist', RptClientListController::class);
    Route::get('rptclientlist/show', [RptClientListController::class, 'show'])->name('rptclientlist.show');
	
	Route::resource('invoiceprint', InvoicePrintController::class);
    Route::get('invoiceprint/show', [InvoicePrintController::class, 'show'])->name('invoiceprint.show');
	Route::resource('duelist', DueListController::class);
    Route::get('duelist/show', [DueListController::class, 'show'])->name('duelist.show');
	Route::resource('discountincollection', DiscountInCollectionController::class);
    Route::get('discountincollection/show', [DiscountInCollectionController::class, 'show'])->name('onlinecollection.show');
	Route::resource('onlinecollection', OnlineCollectionController::class);
    Route::get('onlinecollection/show', [OnlineCollectionController::class, 'show'])->name('onlinecollection.show');
	Route::resource('duelistdaterange', DueListDateRangeController::class);
    Route::get('duelistdaterange/show', [DueListDateRangeController::class, 'show'])->name('duelistdaterange.show');
	Route::resource('collectiontypewise', CollectionTypeWiseController::class);
    Route::get('collectiontypewise/show', [CollectionTypeWiseController::class, 'show'])->name('collectiontypewise.show');
	Route::resource('newblockclient', NewBlockClientController::class);
    Route::get('newblockclient/show', [NewBlockClientController::class, 'show'])->name('newblockclient.show');
	Route::resource('expiry', ClientExpiryController::class);
    Route::get('expiry/show', [ClientExpiryController::class, 'show'])->name('expiry.show');
	Route::resource('vendormasterclient', VendorMasterClientController::class);
    Route::get('vendormasterclient/show', [VendorMasterClientController::class, 'show'])->name('vendormasterclient.show');

    // Accounts Module

	Route::resource('gencahsvoucher', GenCahsVoucherController::class);
    Route::get('gencahsvoucher/show', [GenCahsVoucherController::class, 'show'])->name('gencahsvoucher.show');
	Route::resource('genchequevoucher', GenChequeVoucherController::class);
    Route::get('genchequevoucher/show', [GenChequeVoucherController::class, 'show'])->name('genchequevoucher.show');
	Route::resource('gennagadvoucher', GenNagadVoucherController::class);
    Route::get('gennagadvoucher/show', [GenNagadVoucherController::class, 'show'])->name('gennagadvoucher.show');
	Route::resource('genbkashvoucher', GenBkashVoucherController::class);
    Route::get('genbkashvoucher/show', [GenBkashVoucherController::class, 'show'])->name('genbkashvoucher.show');
	Route::resource('clientinvoiceposting', ClientInvoicePostingController::class);
    Route::get('clientinvoiceposting/show', [ClientInvoicePostingController::class, 'show'])->name('clientinvoiceposting.show');
	Route::resource('supplierledger', SupplierLedgerController::class);
    Route::get('supplierledger/show', [SupplierLedgerController::class, 'show'])->name('supplierledger.show');
	Route::resource('supplieragingreport', SupplierAgingReportController::class);
    Route::get('supplieragingreport/show', [SupplierAgingReportController::class, 'show'])->name('supplieragingreport.show');
	Route::resource('supplierinvoicelist', SupplierInvoiceListController::class);
    Route::get('supplierinvoicelist/show', [SupplierInvoiceListController::class, 'show'])->name('supplierinvoicelist.show');
	Route::resource('supplierdueinvoice', SupplierDueListController::class);
    Route::get('supplierdueinvoice/show', [SupplierDueListController::class, 'show'])->name('supplierdueinvoice.show');
	
	// Accounts Setup
	Route::resource('bankentry', BankEntryController::class);
	Route::resource('bankaccount', BankAccountController::class);
	Route::resource('deletejournal', DeleteJournalController::class);
    Route::get('deletejournal/show', [DeleteJournalController::class, 'show'])->name('deletejournal.show');
	
	// Other Transaction
	Route::resource('project', ProjectController::class);
	Route::resource('transfervoucher', TransferVoucherController::class);
    Route::get('transfervoucher/show', [TransferVoucherController::class, 'show'])->name('transfervoucher.show');
	Route::resource('openingbalance', OpeningBalanceController::class);
    Route::get('openingbalance/show', [OpeningBalanceController::class, 'show'])->name('openingbalance.show');
	
	//Reports
	Route::resource('cashbank', CashBankController::class);
    Route::get('cashbank/show', [CashBankController::class, 'show'])->name('cashbank.show');
	Route::resource('generalledger', GeneralLedgerController::class);
    Route::get('generalledger/show', [GeneralLedgerController::class, 'show'])->name('generalledger.show');
	Route::resource('journal', JournalController::class);
    Route::get('journal/show', [JournalController::class, 'show'])->name('journal.show');
	Route::resource('chartofaccounts', ChartofAccountsController::class);
    Route::get('chartofaccounts/show', [ChartofAccountsController::class, 'show'])->name('chartofaccounts.show');
	

////////////////////////Faruque End /////////////
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
    Route::resource('attendancesummary', HrmAttendanceSummaryController::class);
    Route::resource('hrmincrement', HrmIncrementController::class);
    Route::resource('employeeinformation', MasEmployeeController::class);
    // Route::get('employeepromotion', [MasEmployeeController::class, 'employeePromotionlIndex'])->name('employeepromotion.employeePromotionlIndex');
    // Route::post('employeepromotion', [MasEmployeeController::class, 'employeePromotionlStore'])->name('employeepromotion.employeePromotionlStore');
    // Route::post('employeepromotion/{employeepromotion}', [MasEmployeeController::class, 'employeePromotionlUpdate'])->name('employeepromotion.employeePromotionlUpdate');
    Route::resource('employeepromotion', HrmEmpJobHistoryController::class);
    Route::resource('additioncomponent', HrmEmpMonthlyAddController::class);
    Route::post('additioncomponent.show', [HrmEmpMonthlyAddController::class, 'show'])->name('additioncomponent.show');

    Route::resource('deductioncomponent', HrmEmpMonthlyDeductController::class);
    Route::post('deductioncomponent.show', [HrmEmpMonthlyDeductController::class, 'show'])->name('deductioncomponent.show');

    Route::resource('employeeleave', TblLeaveController::class);
    Route::post('employeeleave.show', [TblLeaveController::class, 'show'])->name('employeeleave.show');

    Route::get('approveleave', [TblLeaveController::class, 'approveLeaveIndex'])->name('approveleave.approveleaveIndex');
    Route::post('approveleave.show', [TblLeaveController::class, 'approveLeaveShow'])->name('approveleave.show');
    Route::post('approveleave.update', [TblLeaveController::class, 'approveLeavelUpdate'])->name('approveleave.update');

    Route::get('dayoffentry', [MasEmployeeController::class, 'dayoffentryIndex'])->name('dayoffentry.index');

    Route::get('leaveregister', [MasEmployeeController::class, 'leaveregisterIndex'])->name('leaveregister.index');
    Route::post('leaveregister.store', [MasEmployeeController::class, 'leaveRegisterStore'])->name('leaveregister.store');
    Route::put('leaveregister/{leaveregister}', [MasEmployeeController::class, 'leaveRegisterUpdate'])->name('leaveregister.update');
    Route::post('leaveregister.show', [MasEmployeeController::class, 'leaveregisterShow'])->name('leaveregister.show');

    Route::get('regenerateattendance', [HrmAttendanceSummaryController::class, 'regenerateAttendanceIndex'])->name('regenerateattendance.index');
    Route::post('regenerateattendance.show', [HrmAttendanceSummaryController::class, 'regenerateAttendanceShow'])->name('regenerateattendance.show');

    Route::get('importdata', [MasEmployeeController::class, 'importDataIndex'])->name('importdata.index');

    //HRM Reports
    Route::get('employee-increment-report', [HrmIncrementController::class, 'employeeIncrementIndex'])->name('employee-increment-report.index');
    Route::post('employee-increment-report.show', [HrmIncrementController::class, 'employeeIncrementShow'])->name('employee-increment-report.show');

    Route::get('employee-promotion-report', [HrmEmpJobHistoryController::class, 'employeePromotionIndex'])->name('employee-promotion-report.index');
    Route::get('employee-promotion-report.show', [HrmEmpJobHistoryController::class, 'employeePromotionShow'])->name('employee-promotion-report.show');

    Route::get('employee-list-report', [MasEmployeeController::class, 'employeeListIndex'])->name('employee-list-report.index');
    Route::get('employee-list-report.show', [MasEmployeeController::class, 'employeeListShow'])->name('employee-list-report.show');

    Route::get('performance-report', [MasEmployeeController::class, 'performanceReportIndex'])->name('performance-report.index');
    Route::post('performance-report.show', [MasEmployeeController::class, 'performanceReportShow'])->name('performance-report.show');

    Route::get('attendance-time-sheet', [MasEmployeeController::class, 'attendanceTimeSheetIndex'])->name('attendance-time-sheet.index');
    Route::post('attendance-time-sheet.show', [MasEmployeeController::class, 'attendanceTimeSheetShow'])->name('attendance-time-sheet.show');

    Route::get('daily-attendance-report', [HrmAttendanceSummaryController::class, 'dailyAttendanceReportIndex'])->name('daily-attendance-report.index');
    Route::post('daily-attendance-report.show', [HrmAttendanceSummaryController::class, 'dailyAttendanceReportShow'])->name('daily-attendance-report.show');
    
    Route::get('act-and-plan-work-report', [CheckinoutController::class, 'actAndPlanWorkIndex'])->name('act-and-plan-work-report.index');
    Route::get('act-and-plan-work-report.show', [CheckinoutController::class, 'actAndPlanWorkShow'])->name('act-and-plan-work-report.show');

    Route::get('late-in-report', [MasEmployeeController::class, 'lateInIndex'])->name('late-in-report.index');
    Route::get('late-in-report.show', [MasEmployeeController::class, 'lateInShow'])->name('late-in-report.show');

    Route::get('absent-report', [MasEmployeeController::class, 'absentIndex'])->name('absent-report.index');
    Route::get('absent-report.show', [MasEmployeeController::class, 'absentShow'])->name('absent-report.show');

    Route::get('night-allowance-report', [HrmAttendanceSummaryController::class, 'nightAllowanceIndex'])->name('night-allowance-report.index');
    Route::post('night-allowance-report.show', [HrmAttendanceSummaryController::class, 'nightAllowanceShow'])->name('night-allowance-report.show');

    Route::get('early-out-report', [MasEmployeeController::class, 'earlyOutIndex'])->name('early-out-report.index');
    Route::post('early-out-report.show', [MasEmployeeController::class, 'earlyOutShow'])->name('early-out-report.show');

    Route::get('provision-report', [MasEmployeeController::class, 'provisionReportIndex'])->name('provision-report.index');
    Route::get('provision-report.show', [MasEmployeeController::class, 'provisionReportShow'])->name('provision-report.show');

    Route::get('holiday-allowance-report', [HrmAttendanceSummaryController::class, 'holidayAllowanceIndex'])->name('holiday-allowance-report.index');
    Route::post('holiday-allowance-report.show', [HrmAttendanceSummaryController::class, 'holidayAllowanceShow'])->name('holiday-allowance-report.show');

    Route::get('raw-check-in-out-report', [MasEmployeeController::class, 'rawCheckInOutIndex'])->name('raw-check-in-out-report.index');
    Route::get('raw-check-in-out-report.show', [MasEmployeeController::class, 'rawCheckInOutShow'])->name('raw-check-in-out-report.show');

    Route::get('leave-transaction-report', [TblLeaveController::class, 'leaveTransactionIndex'])->name('leave-transaction-report.index');

    Route::get('leave-register-report', [MasEmployeeController::class, 'leaveRegisterReportIndex'])->name('leave-register-report.index');
    Route::get('leave-register-report.show', [MasEmployeeController::class, 'leaveRegisterReportShow'])->name('leave-register-report.show');

    // HRM Payroll Setup
    Route::resource('payrolladdcomponent', HrmPayrollAddCompController::class);
    Route::resource('payrolldeductcomponent', HrmPayrollDeductCompController::class);
    
    // HRM Payroll Entry Form
    Route::get('salaryreporttemp', [HrmEmpMonthlySalaryController::class, 'empsalarytemp'])->name('salaryreporttemp.empsalarytemp');
    Route::post('salaryreporttemp.show', [HrmEmpMonthlySalaryController::class, 'show'])->name('salaryreporttemp.show');
    
    Route::resource('generate-salary', HrmGenerateSalaryController::class);

    Route::resource('approve-salary', HrmApproveSalaryController::class);

    Route::resource('emp-loan', HrmTblEmploanController::class);

    Route::resource('salary-advanced', HrmSalaryAdvancedController::class);

    Route::resource('bonus-generation', HrmBonusGenerationController::class);


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



