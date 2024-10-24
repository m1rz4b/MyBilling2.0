<?php

namespace App\Http\Controllers\Inventory\EntryStoreOut;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesInvoiceInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $customers = Customer::get();
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
        return view('pages.inventory.entryStoreOut.salesInvoice', compact('menus', 'customers', 'categories'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
