<?php

namespace App\Http\Controllers\Accounts\Setup;

use App\Http\Controllers\Controller;
use App\Models\MasBank;
use App\Models\Menu;
use Illuminate\Http\Request;

class BankEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::where('status',1)->get();
        $masbanks = MasBank::get();
        return view("pages.accounts.setup.bankEntry", compact("menus", "masbanks"));
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
            'bank_name' => 'required|unique:mas_banks,bank_name',
            'status' => 'required'
        ]);
        $masbanks = MasBank::create($data);
        return redirect()->route("bankentry.index") -> with('success', 'Bank added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasBank $masbank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasBank $masbank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasBank $bankentry)
    {
        //
        $data = $request->validate([
            'bank_name' => 'required',
            'status' => 'required'
        ]);
        $bankentry->update($data);
        return redirect()->route("bankentry.index") -> with('success', 'Bank updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasBank $bankentry)
    {
        //
        $darea = MasBank::find($bankentry -> id);
        $darea->delete();
        return redirect() -> route("bankentry.index") -> with('success', 'Area deleted successfully');
    }
}
