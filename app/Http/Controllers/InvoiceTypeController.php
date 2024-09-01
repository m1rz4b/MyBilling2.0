<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\InvoiceType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InvoiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $invoicetypes  = InvoiceType::get();
        return view("pages.setup.invoiceType", compact("menus", "invoicetypes"));
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
            'invoice_type_name' => 'required|unique:invoice_types,invoice_type_name',
            'status' => 'required'
        ]);
        $invoicetype = InvoiceType::create($data);
        return redirect(route('invoicetype.index'))->with('success', 'Invoice Type added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceType $invoiceType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceType $invoiceType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $invoiceType)
    {
        $user_id = 1; //Replace by Auth later

        $data = $request->validate([
            'invoice_type_name' => [
                'required',
                'string',
                Rule::unique('invoice_types')->ignore($invoiceType)->whereNull('deleted_at')
            ],
            'status' => 'required'
        ]);
        $invoices = InvoiceType::find($invoiceType);
        $invoices->invoice_type_name = $request->invoice_type_name;
        $invoices->status = $request->status;
        $invoices->updated_by = $user_id;
        $invoices->save();

        return redirect(route('invoicetype.index'))->with('success', 'Invoice Type has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($invoiceType = null)
    {
        $user_id = 1; //Replace by Auth later

        $invoices = InvoiceType::find($invoiceType);
        $invoices->deleted_by = $user_id;
        $invoices->save();
        $invoices->delete();
        return redirect(route('invoicetype.index'))->with('success', 'Invoice Type has been deleted successfully');
    }
}
