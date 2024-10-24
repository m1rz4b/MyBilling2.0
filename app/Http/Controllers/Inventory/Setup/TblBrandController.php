<?php

namespace App\Http\Controllers\Inventory\Setup;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\TblBrand;
use Illuminate\Http\Request;

class TblBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::get();
        $tblbrands = TblBrand::get();
        return view('pages.inventory.setup.brand', compact('menus', 'tblbrands'));
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
            'brand_display' => 'required',
            'brand_detail' => 'required',
            'brand_remarks' => 'required',
            'brand_user' => 'required',
            'brand_pass' => 'required',
            'identefire_code_brand' => 'required',
            'status' => 'required'
        ]);

        $brand = TblBrand::create($data);
        return redirect()->route('brand.index') -> with('success', 'Brand created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblBrand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblBrand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblBrand $brand)
    {
        //
        $data = $request->validate([
            'brand_display' => 'required',
            'brand_detail' => 'required',
            'identefire_code_brand' => 'required',
            'status' => 'required'
        ]);

        $brand->update($data);
        return redirect()->route('brand.index') -> with('success', 'Brand updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblBrand $brand)
    {
        //
    }
}
