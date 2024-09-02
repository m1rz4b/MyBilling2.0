<?php

namespace App\Http\Controllers;

use App\Models\TblSuboffice;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Menu;

class TblSubofficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::where('status',1)->get();
        $suboffices = TblSuboffice::get();
        return view('pages.setup.suboffice', compact('menus', 'suboffices'));
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
            'name' => [
                'string', 
                'max:255', 
                'nullable', 
                Rule::unique('tbl_suboffices')->whereNull('deleted_at')
            ],
            'contact_person' => ['string', 'max:255', 'nullable'],
            'contact_number' => ['string', 'max:255', 'nullable'],
            'email' => ['string', 'max:255', 'nullable'],
            'address' => ['string', 'max:255', 'nullable']
        ]);

        $user_id = 1; //Replace by Auth later

        $newSuboffice = TblSuboffice::create([
            'name' => ($request->name==null) ? '' : $request->name,
            'contact_person' => ($request->contact_person==null) ? '' : $request->contact_person,
            'contact_number' => ($request->contact_number==null) ? '' : $request->contact_number,
            'email' => ($request->email==null) ? '' : $request->email,
            'address' => ($request->address==null) ? '' : $request->address,
            'created_by' => $user_id
        ]);

        return redirect(route('suboffice.index')) -> with('success', 'Suboffice added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TblSuboffice $tblSuboffice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TblSuboffice $tblSuboffice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $tblSuboffice)
    {
        $user_id = 1; //Replace by Auth later

        $updateData = $request->validate([
            'name' => [
                'string', 
                'max:255', 
                'nullable', 
                Rule::unique('tbl_suboffices')->ignore($tblSuboffice)->whereNull('deleted_at')
            ],
            'contact_person' => ['string', 'max:255', 'nullable'],
            'contact_number' => ['string', 'max:255', 'nullable'],
            'email' => ['string', 'max:255', 'nullable'],
            'address' => ['string', 'max:255', 'nullable']
        ]);

        $offices = TblSuboffice::find($tblSuboffice);
        $offices->name = $request->name;
        $offices->contact_person = $request->contact_person;
        $offices->contact_number = $request->contact_number;
        $offices->email = $request->email;
        $offices->address = $request->address;
        $offices->status = $request->status;
        $offices->updated_by = $user_id;
        $offices->save();

        return redirect(route('suboffice.index')) -> with('success', 'Suboffice has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($tblSuboffice = null)
    {
        $user_id = 1; //Replace by Auth later

        $offices = TblSuboffice::find($tblSuboffice);
        $offices->deleted_by = $user_id;
        $offices->save();
        $offices->delete();
        return redirect(route('suboffice.index')) -> with('success', 'Suboffice has been deleted successfully');
    }
}
