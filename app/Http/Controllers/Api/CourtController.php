<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Court;
use Illuminate\Http\Request;

class CourtController extends Controller
{
    public function index(Request $request)
    {
        $query = Court::query();
        
        // Filter by branch
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->input('branch_id'));
        }
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        
        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price_per_hour', '>=', $request->input('min_price'));
        }
        
        if ($request->has('max_price')) {
            $query->where('price_per_hour', '<=', $request->input('max_price'));
        }
        
        $courts = $query->with('branch')->paginate($request->input('per_page', 15));
        
        return response()->json($courts);
    }

    public function show(Court $court)
    {
        $court->load('branch');
        return response()->json($court);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'branch_id' => 'required|exists:branches,id',
            'price_per_hour' => 'required_if:use_branch_price,false|nullable|numeric|min:0',
            'use_branch_price' => 'required|boolean',
            'status' => 'required|in:open,closed,maintenance',
        ]);

        $court = Court::create($validated);
        
        return response()->json($court, 201);
    }

    public function update(Request $request, Court $court)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'branch_id' => 'sometimes|required|exists:branches,id',
            'price_per_hour' => 'required_if:use_branch_price,false|nullable|numeric|min:0',
            'use_branch_price' => 'sometimes|required|boolean',
            'status' => 'sometimes|required|in:open,closed,maintenance',
        ]);

        $court->update($validated);
        
        return response()->json($court);
    }

    public function destroy(Court $court)
    {
        $court->delete();
        return response()->json(null, 204);
    }
}