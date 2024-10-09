<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Nas;
use App\Models\TblServercommand;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $naslist = Nas::get();

        $query = TblServercommand::where('name', 'radius')->value('last_restart');

        $times = Carbon::parse($query)->format('d M Y h:i A');

        $fail = TblServercommand::where('name', 'radius')->value('fail_status');

        return view('pages.radius.naslist',
        compact(
            'menus',
            'naslist',
            'times',
            'fail'
        ));
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function radius_restart()
    {
        $Usql = TblServercommand::where('name', 'radius')->update(['status' => 1]);

        if ($Usql) {
            return redirect(route('nas.index'))->with('success', 'Data successfully updated');
        } else {
            return redirect()->route('nas.index')->withErrors('Failed to update data');
        }

        
    }

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
    public function show(Nas $nas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nas $nas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nas $nas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nas $nas)
    {
        //
    }
}
