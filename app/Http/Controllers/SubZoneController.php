<?php

namespace App\Http\Controllers;

use App\Models\SubZone;
use App\Models\TblZone;
use Illuminate\Http\Request;

class SubZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $subzones = SubZone::with('TblZone')->get();
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
    public function show(SubZone $subZone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubZone $subZone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubZone $subZone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubZone $subZone)
    {
        //
    }
}
