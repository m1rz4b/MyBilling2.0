<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\TblWeekend;

class TblWeekendController extends Controller
{
    public function index()
    {
        $menus = Menu::get();
        $weekends = TblWeekend::get();
        return view('pages.hrm.weeklyHolidays', compact('menus', 'weekends'));
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

    }

    /**
     * Display the specified resource.
     */
    public function show(TblWeekend $tblWeekend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblWeekend $tblWeekend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TblWeekend $tblWekend = null)
    {
        $days = $request->weekend;
        TblWeekend::query()->update(['weekend' => 0]);
        foreach ($days as $day) {
            TblWeekend::where('id', $day)->update(['weekend' => 1]);
        }

        return redirect(route('weeklyholiday.index'))->with('success', 'Holiday has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TblWeekend $tblWeekend)
    {
        //
    }
}
