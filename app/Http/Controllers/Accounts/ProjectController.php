<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Models\MasBank;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Models\TrnCustomerProject;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $menus = Menu::where('status',1)->get();
		
		 $customerprojects = TrnCustomerProject::query()
			->leftJoin('customers', 'customers.id', '=', 'trn_customer_project.client_id')
					
			->select([
				'trn_customer_project.id', 
				'trn_customer_project.project_name', 
				'trn_customer_project.contract_person', 
				'trn_customer_project.address',
				'trn_customer_project.active_statust as status',				
				'customers.customer_name', 
        ]);
		 $customerprojects = $customerprojects->get();
		
        return view("pages.accounts.project", compact("menus", "customerprojects"));
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
            'project_name' => 'required|unique:trn_customer_project,project_name',
			'active_statust' => 'required'
        ]);
        $project = TrnCustomerProject::create($data);
        return redirect()->route("project.index") -> with('success', 'Bank added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrnCustomerProject $project)
    {
        //
        $data = $request->validate([
            'project_name' => 'required|unique:trn_customer_project,project_name',
            'active_statust' => 'required'
        ]);
        $project->update($data);
        return redirect()->route("project.index") -> with('success', 'Bank updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrnCustomerProject $project)
    {
        //
        $darea = TrnCustomerProject::find($project ->id);
        $darea->delete();
        return redirect() -> route("project.index") -> with('success', 'Area deleted successfully');
    }
}
