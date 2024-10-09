<?php

namespace App\Http\Controllers;

use App\Models\TblSmsSetup;
use App\Models\Menu;
use Illuminate\Http\Request;

class TblSmsSetupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $sms_setup = TblSmsSetup::get();
        return view('pages.sms&Email.smsSetup', compact('menus', 'sms_setup'));
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
        $storeData = $request->validate([
            'name' => 'required|string',
            'sms_url' => 'required|string',
            'submit_param' => 'required|string',
            'type' => 'required',
            'status' => 'required'
        ]);

        $user_id = 1; //Replace by Auth later

        $newSmsSetup = TblSmsSetup::create([
            'name' => ($request->name==null) ? '' : $request->name,
            'sms_url' => ($request->sms_url==null) ? '' : $request->sms_url,
            'submit_param' => ($request->submit_param==null) ? '' : $request->submit_param,
            'type' => ($request->type==null) ? '' : $request->type,
            'status' => ($request->status==null) ? '' : $request->status,
            'created_by' => $user_id
        ]);

        return redirect(route('smssetup.index')) -> with('success', 'SMS Setup added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblSmsSetup $smsSetup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblSmsSetup $smsSetup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $smsSetup)
    {
         $storeData = $request->validate([
            'name' => 'required|string',
            'sms_url' => 'required|string',
            'submit_param' => 'required|string',
            'type' => 'required',
            'status' => 'required'
        ]);

        $user_id = 1; //Replace by Auth later

        $sms = TblSmsSetup::find($smsSetup);
        $sms->name = $request->name;
        $sms->sms_url = $request->sms_url;
        $sms->submit_param = $request->submit_param;
        $sms->type = $request->type;
        $sms->status = $request->status;
        $sms->updated_by = $user_id;
        $sms->save();

        return redirect(route('smssetup.index')) -> with('success', 'SMS Setup has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblSmsSetup $smsSetup)
    {
        //
    }
}
