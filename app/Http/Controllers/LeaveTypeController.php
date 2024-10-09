<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use App\Models\Menu;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $leavetypes = LeaveType::get();
        return view('pages.hrm.leaveType', compact('menus', 'leavetypes'));
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
            'short_name' => 'required',
            'default_allocation' => 'required',
            'carry_forward' => 'required',
            'carry_max_days' => 'required',
            'status' => 'required'
        ]);

        $data['carry_forward'] = $request->has('carry_forward') ? 1 : 0;

        $leavetype = LeaveType::create($data);
        return redirect()->route('leavetype.index')->with('success', 'Leave Type added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveType $leaveType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveType $leaveType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveType $leavetype)
    {
        //
        $data = $request->validate([
            'name' => 'required',
            'short_name' => 'required',
            'default_allocation' => 'required',
            'carry_forward' => 'string',
            'carry_max_days' => 'required',
            'status' => 'required'
        ]);

        $data['carry_forward'] = $request->has('carry_forward') ? 1 : 0;

        $leavetype->update($data);
        return redirect()->route('leavetype.index')->with('success', 'Leave Type updated successfully');
        ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($leaveType = null)
    {
        $user_id = 1; //Replace by Auth later

        $leaveTypes = LeaveType::find($leaveType);
        $leaveTypes->deleted_by = $user_id;
        $leaveTypes->save();
        $leaveTypes->delete();
        return redirect(route('leavetype.index'))->with('success', 'Leave Type has been deleted successfully');
    }
}
