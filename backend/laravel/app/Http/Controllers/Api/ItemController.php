<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Item::with('department')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate(([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]));
        $item = Item::create($data);
        return response()->json($item->load('department'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return response()->json($item->load('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $data = $request->validate(([
            'name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
        ]));
        $item->update($data);
        return response()->json($item->load('department')); 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(null, 204);
    }
}
