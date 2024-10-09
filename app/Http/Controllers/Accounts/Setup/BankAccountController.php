<?php

namespace App\Http\Controllers\Accounts\Setup;

use App\Http\Controllers\Controller;
use App\Models\TrnBank;
use App\Models\MasBank;
use App\Models\Menu;
use Illuminate\Http\Request;


class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::where('status',1)->get();
        $trnbanks = TrnBank::get();
		$masbanks = MasBank::get();
        return view("pages.accounts.setup.bankAccount", compact("menus", "trnbanks","masbanks"));
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
            'account_no' => 'required|unique:trn_banks,account_no',
            'bank_id' => 'required',
			'branch' => 'required',
        ]);
        $trnbanks = TrnBank::create($data);
        return redirect()->route("bankaccount.index") -> with('success', 'Bank added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TrnBank $masbank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrnBank $masbank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrnBank $bankaccount)
    {
        //
        $data = $request->validate([
            'account_no' => 'required',
			 'branch' => 'required',
			  'bank_id' => 'required',
            'status' => 'required'
        ]);
        $bankaccount->update($data);
        return redirect()->route("bankaccount.index") -> with('success', 'Bank updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrnBank $bankaccount)
    {
        //
        $darea = TrnBank::find($bankaccount -> id);
        $darea->delete();
        return redirect() -> route("bankaccount.index") -> with('success', 'Area deleted successfully');
    }
}
