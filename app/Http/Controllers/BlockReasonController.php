<?php

namespace App\Http\Controllers;

use App\Models\BlockReason;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Menu;

class BlockReasonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::get();
        $block_reasons = BlockReason::get();
        return view('pages.setup.blockReason', compact('menus', 'block_reasons'));
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
        $storeData = $request->validate([
            'block_reason_name' => [
                'required',
                'string',
                Rule::unique('block_reasons')->whereNull('deleted_at')
            ],
            'block_reason_desc' => ['required', 'string']
        ]);

        $user_id = 1; //Replace by Auth later

        $newBlockReason = BlockReason::create([
            'block_reason_name' => ($request->block_reason_name == null) ? '' : $request->block_reason_name,
            'block_reason_desc' => ($request->block_reason_desc == null) ? '' : $request->block_reason_desc,
            'status' => ($request->status == null) ? '' : $request->status,
            'created_by' => $user_id
        ]);

        return redirect(route('blockreason.index'))->with('success', 'Block Reason added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(BlockReason $blockreason)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlockReason $blockreason)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $blockreason)
    {
        $user_id = 1; //Replace by Auth later

        $updateData = $request->validate([
            'block_reason_name' => [
                'required',
                'string',
                Rule::unique('block_reasons')->ignore($blockreason)->whereNull('deleted_at')
            ],
            'block_reason_desc' => ['required', 'string']
        ]);

        $blocks = BlockReason::find($blockreason);
        $blocks->block_reason_name = $request->block_reason_name;
        $blocks->block_reason_desc = $request->block_reason_desc;
        $blocks->status = $request->status;
        $blocks->updated_by = $user_id;
        $blocks->save();

        return redirect(route('blockreason.index'))->with('success', 'Block Reason has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($blockreason = null)
    {
        $user_id = 1; //Replace by Auth later

        $blocks = BlockReason::find($blockreason);
        $blocks->deleted_by = $user_id;
        $blocks->save();
        $blocks->delete();
        return redirect(route('blockreason.index'))->with('success', 'Block Reason has been deleted successfully');
    }
}
