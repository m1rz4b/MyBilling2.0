<?php

namespace App\Http\Controllers;

use App\Models\MasDepartment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Menu;

class MasDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $departments = MasDepartment::get();
        return view('pages.setup.department', compact('menus', 'departments'));
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
            'department' => [
                'string', 
                'max:255', 
                'nullable', 
                Rule::unique('mas_departments')->whereNull('deleted_at')
            ]
        ]);

        $user_id = 1; //Replace by Auth later

        $newDepartment = MasDepartment::create([
            'department' => ($request->department==null) ? '' : $request->department,
            'created_by' => $user_id
        ]);

        return redirect(route('department.index')) -> with('success', 'Department added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasDepartment $masDepartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasDepartment $masDepartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $masDepartment)
    {
        $user_id = 1; //Replace by Auth later

        $updateData = $request->validate([
            'department' => [
                'string', 
                'max:255', 
                'nullable', 
                Rule::unique('mas_departments')->ignore($masDepartment)->whereNull('deleted_at')
            ],
        ]);

        $mas = MasDepartment::find($masDepartment);
        $mas->department = $request->department;
        $mas->status = $request->status;
        $mas->updated_by = $user_id;
        $mas->save();

        return redirect(route('department.index')) -> with('success', 'Department has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($masDepartment = null)
    {
        $user_id = 1; //Replace by Auth later

        $mas = MasDepartment::find($masDepartment);
        $mas->deleted_by = $user_id;
        $mas->save();
        $mas->delete();
        return redirect(route('department.index')) -> with('success', 'Department has been deleted successfully');
    }
}
