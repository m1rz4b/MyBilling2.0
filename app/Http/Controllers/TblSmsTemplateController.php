<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\TblSmsTemplate;
use Illuminate\Http\Request;

class TblSmsTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $sms_templates = TblSmsTemplate::get();
        return view('pages.sms&Email.smsTemplate', compact('menus', 'sms_templates'));
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
            'command' => 'required|string',
            'description' => 'required|string'
        ]);

        $user_id = 1; //Replace by Auth later

        $newSmsTemplate = TblSmsTemplate::create([
            'command' => ($request->command==null) ? '' : $request->command,
            'description' => ($request->description==null) ? '' : $request->description,
            'status' => ($request->status==null) ? '' : $request->status,
            'created_by' => $user_id
        ]);

        return redirect(route('smstemplate.index')) -> with('success', 'SMS Template added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblSmsTemplate $smsTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblSmsTemplate $smsTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $smsTemplate)
    {
        $storeData = $request->validate([
            'command' => 'required|string',
            'description' => 'required|string'
        ]);
        // dd($request);

        $user_id = 1; //Replace by Auth later

        $sms = TblSmsTemplate::find($smsTemplate);
        
        $sms->command = $request->command;
        $sms->description = $request->description;
        $sms->status = $request->status;
        $sms->updated_by = $user_id;
        $sms->save();

        return redirect(route('smstemplate.index')) -> with('success', 'SMS Template has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblSmsTemplate $smsTemplate)
    {
        //
    }
}
