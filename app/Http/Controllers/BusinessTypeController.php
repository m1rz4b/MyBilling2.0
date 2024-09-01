<?php

namespace App\Http\Controllers;

use App\Models\BusinessType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Menu;

class BusinessTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $business_types = BusinessType::get();
        return view('pages.setup.businessType', compact('menus', 'business_types'));
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
        $data = $request->validate([
            'business_name' => [
                'required', 
                'string', 
                Rule::unique('business_types')->whereNull('deleted_at')
            ]
        ]);

        $user_id = 1; //Replace by Auth later

        $newBusinessType = BusinessType::create([
            'business_name' => ($request->business_name==null) ? '' : $request->business_name,
            'created_by' => $user_id
        ]);

        return redirect(route('businesstype.index')) -> with('success', 'Business Type added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(BusinessType $businessType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BusinessType $businessType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $businesstype)
    {
        $user_id = 1; //Replace by Auth later

        $updateData = $request->validate([
            'business_name' => [
                'required', 
                'string', 
                Rule::unique('business_types')->ignore($businesstype)->whereNull('deleted_at')
            ]
        ]);

        $business = BusinessType::find($businesstype);
        $business->business_name = $request->business_name;
        $business->status = $request->status;
        $business->updated_by = $user_id;
        $business->save();

        return redirect(route('businesstype.index')) -> with('success', 'Business Type has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($businesstype = null)
    {
        $user_id = 1; //Replace by Auth later

        $business = BusinessType::find($businesstype);
        $business->deleted_by = $user_id;
        $business->save();
        $business->delete();
        return redirect(route('businesstype.index')) -> with('success', 'Business Type has been deleted successfully');
    }
}