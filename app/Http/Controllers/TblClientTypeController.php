<?php

namespace App\Http\Controllers;

use App\Models\TblClientType;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TblClientTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $packages = TblClientType::get();
        $customers = Customer::where('tbl_client_category_id', 3)
            ->orderBy('id')
            ->get(['id', 'customer_name']);


        $searchQuery = 'q';
        $resellers = Customer::leftJoin('trn_clients_services', 'trn_clients_services.client_id', '=', 'customers.id')
            ->select(
                'customers.id AS ID',
                DB::raw("CONCAT(
            customers.customer_name,
            ' | ',
            customers.mobile1,
            ' | ',
            IFNULL(trn_clients_services.user_id, ''),
            ' | ',
            customers.present_address
        ) AS NAME")
            )
            ->where(function ($query) use ($searchQuery) {
                $query->where('trn_clients_services.user_id', 'like', "%{$searchQuery}%")
                    ->orWhere('customers.customer_name', 'like', "%{$searchQuery}%")
                    ->orWhere('customers.mobile1', 'like', "%{$searchQuery}%")
                    ->orWhere('customers.present_address', 'like', "%{$searchQuery}%");
            })->get();

        return view('pages.billing.packagePlan', compact('menus', 'packages', 'customers', 'resellers'));
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
            'name' => 'string',
            'hotspot' => 'integer',
            'unit' => 'string',
            'pcq' => 'integer',
            'price' => 'integer',
            'days' => 'integer',
            'view_portal' => 'integer',
            'reseller_id' => 'integer',
            'share_rate' => 'numeric ',
            'status' => 'integer'
        ]);

        $authid = Auth::id();

        TblClientType::create([
            'name' => ($request->name == null) ? '' : $request->name,
            'hotspot' => ($request->hotspot == null) ? '' : $request->hotspot,
            'unit' => ($request->unit == null) ? '' : $request->unit,
            'pcq' => ($request->pcq == null) ? '' : $request->pcq,
            'price' => ($request->price == null) ? '' : $request->price,
            'days' => ($request->days == null) ? '' : $request->days,
            'view_portal' => ($request->view_portal == null) ? '' : $request->view_portal,
            'reseller_id' => ($request->reseller_id == null) ? '' : $request->reseller_id,
            'share_rate' => ($request->share_rate == null) ? '' : $request->share_rate,
            'status' => ($request->status == null) ? '' : $request->status,
            'created_by' => $authid
        ]);

        return redirect(route('clienttype.index'))->with('success', 'Package Plan added successfully');
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
        $request->validate([
            'name' => 'string',
            'hotspot' => 'integer',
            'unit' => 'string',
            'pcq' => 'integer',
            'price' => 'integer',
            'days' => 'integer',
            'view_portal' => 'integer',
            'reseller_id' => 'integer',
            'share_rate' => 'numeric ',
            'status' => 'integer'
        ]);

        $authid = Auth::id();

        $clientTypes = TblClientType::find($clientType);
        $clientTypes->name = $request->name;
        $clientTypes->hotspot = $request->hotspot;
        $clientTypes->unit = $request->unit;
        $clientTypes->pcq = $request->pcq;
        $clientTypes->price = $request->price;
        $clientTypes->days = $request->days;
        $clientTypes->view_portal = $request->view_portal;
        $clientTypes->reseller_id = $request->reseller_id;
        $clientTypes->share_rate = $request->share_rate;
        $clientTypes->status = $request->status;
        $clientTypes->updated_by = $authid;
        $clientTypes->save();

        return redirect(route('clienttype.index'))->with('success', 'Package Plan has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($clientType = null)
    {
        $authid = Auth::id(); //Replace by Auth later

        $clientTypes = TblClientType::find($clientType);
        $clientTypes->deleted_by = $authid;
        $clientTypes->save();
        $clientTypes->delete();

        return redirect(route('clienttype.index'))->with('success', 'Package Plan has been deleted successfully');
    }
}
