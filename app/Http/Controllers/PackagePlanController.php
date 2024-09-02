<?php

namespace App\Http\Controllers;

use App\Models\TblClientType;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Validation\Rule;

class PackagePlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $client_types = TblClientType::get();
        $customers = Customer::select('id', 'customer_name')
            ->where('tbl_client_category_id', 3)
            ->orderBy('id')
            ->get();
        return view('pages.billing.packagePlan', compact('menus', 'client_types', 'customers'));
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
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('tbl_client_types')->whereNull('deleted_at')
            ],
            'hotspot' => ['required', 'integer'],
            'unit' => ['required', 'string'],
            'pcq' => ['required', 'integer'],
            'days' => ['required', 'integer'],
            'view_portal' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'share_rate' => ['required', 'integer'],
            'reseller_id' => ['required', 'integer'],
        ]);

        $user_id = 1; //Replace by Auth later

        TblClientType::create([
            'name' => ($request->name == null) ? '' : $request->name,
            'hotspot' => ($request->hotspot == null) ? 0 : $request->hotspot,
            'unit' => ($request->unit == null) ? '' : $request->unit,
            'pcq' => ($request->pcq == null) ? '' : $request->pcq,
            'days' => ($request->days == null) ? '' : $request->days,
            'view_portal' => ($request->view_portal == null) ? '' : $request->view_portal,
            'price' => ($request->price == null) ? '' : $request->price,
            'share_rate' => ($request->share_rate == null) ? '' : $request->share_rate,
            'reseller_id' => ($request->reseller_id == null) ? '' : $request->reseller_id,
            'status' => ($request->status == null) ? '' : $request->status,
            'created_by' => $user_id
        ]);

        return redirect(route('packageplan.index'))->with('success', 'Package Plan added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblClientType $clientType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblClientType $clientType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $clientType)
    {
        $user_id = 1; //Replace by Auth later

        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('tbl_client_types')->whereNull('deleted_at')
            ],
            'hotspot' => ['required', 'integer'],
            'unit' => ['required', 'string'],
            'pcq' => ['required', 'integer'],
            'days' => ['required', 'integer'],
            'view_portal' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'share_rate' => ['required', 'integer'],
            'reseller_id' => ['required', 'integer'],
        ]);

        $client_types = TblClientType::find($clientType);
        $client_types->name = $request->name;
        $client_types->hotspot = $request->hotspot;
        $client_types->unit = $request->unit;
        $client_types->pcq = $request->pcq;
        $client_types->days = $request->days;
        $client_types->view_portal = $request->view_portal;
        $client_types->price = $request->price;
        $client_types->share_rate = $request->share_rate;
        $client_types->reseller_id = $request->reseller_id;
        $client_types->status = $request->status;
        $client_types->updated_by = $user_id;
        $client_types->save();

        return redirect(route('packageplan.index'))->with('success', 'Package Plan has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($clientType = null)
    {
        $user_id = 1; //Replace by Auth later

        $client_types = TblClientType::find($clientType);
        $client_types->deleted_by = $user_id;
        $client_types->save();
        $client_types->delete();
        return redirect(route('packageplan.index'))->with('success', 'Package Plan has been deleted successfully');
    }
}
