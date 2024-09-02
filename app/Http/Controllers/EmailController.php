<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Email;
use App\Models\MasDepartment;
use App\Models\Menu;
use App\Models\TblEmailLog;
use App\Models\TblEmailSetup;
use App\Models\TblEmailTemplate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::where('status',1)->get();
        $email_setups = TblEmailSetup::get();
        $departments = MasDepartment::get();
        return view('pages.sms&Email.emailSetup', compact('menus', 'email_setups', 'departments'));
    }

    public function email_and_sms()
    {
        $menus = Menu::where('status',1)->get();
        $customers = Customer::get();
        return view('pages.sms&Email.emailAndSms', compact('menus', 'customers'));
    }

    public function email_log()
    {
        $menus = Menu::where('status',1)->get();
        $emaillogs = TblEmailLog::get();
        return view('pages.sms&Email.emailLog', compact('menus', 'emaillogs'));
    }

    public function email_send()
    {
        $menus = Menu::where('status',1)->get();
        $sendemails = Email::get();
        return view('pages.sms&Email.emailSend', compact('menus', 'sendemails'));
    }

    public function email_template()
    {
        $menus = Menu::where('status',1)->get();
        $emailtemplates = TblEmailTemplate::get();
        return view('pages.sms&Email.emailTemplate', compact('menus', 'emailtemplates'));
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
        $data = $request->validate([
            'name' => 'required', 
            'port' => 'required', 
            'Username' => 'required', 
            'Password' => 'required', 
            'setFrom' => 'required', 
            'SMTPAuth' => 'required',
            'Host' => 'required', 
            'SMTPSecure' => 'required', 
            'addReplyTo' => 'required', 
            'addCC' => 'required', 
            'addBCC' => 'required', 
            'isHTML' => 'required', 
            'Mailer' => 'required', 
            'department_id' => 'required', 
            'status' => 'required'
        ]);

        $data['send_email'] = $request->has('send_email') ? 1 : 0;
        $data['receive_email'] = $request->has('receive_email') ? 1 : 0;

        $emailsetup = TblEmailSetup::create($data);
        return redirect() -> route("emailsetup.index") -> with('success', 'Email setup added successfully');
    }

    public function template_store(Request $request)
    {
        //
        $data = $request->validate([
            'command' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $emailtemplate = TblEmailTemplate::create($data);
        return redirect() -> route("emailtemplate.email_template") -> with('success', 'Email template added successfully');
    }

    public function esend_store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required',
            'subject' => 'required',
            'body_text' => 'required',
            'receiver_email' => 'required'
        ]);

        $data['time'] = Carbon::now();

        $emailsend = Email::create($data);
        return redirect() -> route("sendemail.email_send") -> with('success', 'Email sent successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Email $email)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Email $email)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblEmailSetup $emailsetup)
    {
        //
        $data = $request->validate([
            'name' => 'required', 
            'port' => 'required', 
            'Username' => 'required', 
            'Password' => 'required', 
            'setFrom' => 'required', 
            'SMTPAuth' => 'required',
            'Host' => 'required', 
            'SMTPSecure' => 'required', 
            'addReplyTo' => 'required', 
            'addCC' => 'required', 
            'addBCC' => 'required', 
            'isHTML' => 'required', 
            'Mailer' => 'required', 
            'department_id' => 'required', 
            'status' => 'required'
        ]);

        $data['send_email'] = $request->has('send_email') ? 1 : 0;
        $data['receive_email'] = $request->has('receive_email') ? 1 : 0;

        $emailsetup->update($data);
        return redirect() -> route("emailsetup.index") -> with('success', 'Email setup updated successfully');
    }
    
    public function template_update(Request $request, TblEmailTemplate $emailtemplate)
    {
        $data = $request->validate([
            'command' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $emailtemplate->update($data);
        return redirect() -> route("emailtemplate.email_template") -> with('success', 'Email template updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Email $email)
    {
        //
    }

    public function template_destroy(TblEmailTemplate $emailtemplate)
    {
        //
        $dtemplate = TblEmailTemplate::find($emailtemplate -> id);
        $dtemplate->delete();
        return redirect() -> route("emailtemplate.email_template") -> with('success', 'Email template deleted successfully');
    }
}
