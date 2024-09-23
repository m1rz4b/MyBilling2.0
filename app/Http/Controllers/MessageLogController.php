<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Radacct;
use App\Models\Nas;
use App\Models\TrnClientsService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\TblSuboffice;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;


class MessageLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $selectedCustomer = -1;
        $selectedMacAddress = '';
        $selectedIpAddress = '';
        $selectedNas = -1;
		$selectedBranch = -1;
        $menus = Menu::where('status',1)->get();
        $nowdate = Carbon::now()->format('Y-m-d');
		$sub_offices = TblSuboffice::select('id', 'name')->orderBy('name', 'desc')->get();
        $customers = TrnClientsService::select('id', 'user_id')->get();
        $nas = Nas::select('id', 'shortname')->orderBy('shortname')->get();
		
			$process = new Process(['tail', '-1000', '/var/log/syslog']);
			$process->run();
			// executes after the command finishes
			if (!$process->isSuccessful()) {
				throw new ProcessFailedException($process);
			}

			$messages = $process->getOutput();
			$messages = (explode("\n",$messages));
//dd($messages);

        return view("pages.radius.messageLog", compact("menus", "nowdate", "customers", "nas", 'selectedCustomer','selectedNas','sub_offices','selectedBranch','messages'));
    }

    public function search(Request $request)
    {

        $selectedCustomer = $request->customer;
        $selectedNas = $request->nas;
		$log_type = $request->log_type;
		$record_limit = $request->record_limit;
		$selectedBranch = $request->branch_id;
		
        $menus = Menu::where('status',1)->get();
        $nowdate = Carbon::now()->format('Y-m-d');
        $customers = TrnClientsService::select('id', 'user_id')->get();
		$sub_offices = TblSuboffice::select('id', 'name')->orderBy('name', 'desc')->get();
        $nas = Nas::select('id', 'shortname')->orderBy('shortname')->get();
	
	$cond=" ";
	
	if($selectedNas != "-1")
	{
		$cond.=" | grep ".$selectedNas;
	}	
	
	if($selectedNas != "-1")
	{
		$cond.=" | grep ".$selectedCustomer;
	}
	
	if($selectedNas != "-1")
	{
		$cond.=" | grep ".$log_type;
	}
//dd($record_limit);
$process = new Process(['tail', '-'.$record_limit, '/var/log/syslog']);
$process->run();

// executes after the command finishes
if (!$process->isSuccessful()) {
    throw new ProcessFailedException($process);
}

$messages = $process->getOutput();
$messages = (explode("\n",$messages));

//	dd($result);	
            // $radaccts = $radaccts->with('nas')
            //     ->orderBy('acctstarttime', 'desc')
            //     ->paginate(10);

        return view('pages.radius.messageLog', compact('menus', 'nowdate', 'customers', 'nas', 'selectedCustomer', 'selectedNas','sub_offices','selectedBranch','messages'));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
