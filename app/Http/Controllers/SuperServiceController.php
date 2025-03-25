<?php

namespace App\Http\Controllers;

use App\Models\SuperService;
use Illuminate\Http\Request;

class SuperServiceController extends Controller
{
    public function index()
    {
        return response()->json(SuperService::all());
    }

    public function store(Request $request)
    {
        $request->validate([
                               'name' => 'required|string|max:255',
                               'price' => 'required|numeric|min:0',
                               'type' => 'required|string|max:255',
                               'description' => 'required|string',
                           ]);

        $superservice = SuperService::create($request->all());

        return response()->json(['message' => 'SuperService created successfully!', 'superservice' => $superservice], 201);
    }

    public function show(SuperService $superservice)
    {
        return response()->json($superservice);
    }

    public function update(Request $request, SuperService $superservice)
    {
        $request->validate([
                               'name' => 'string|max:255',
                               'price' => 'numeric|min:0',
                               'type' => 'string|max:255',
                               'description' => 'string',
                           ]);

        $superservice->update($request->all());

        return response()->json(['message' => 'SuperService updated successfully!', 'superservice' => $superservice]);
    }

    public function destroy(SuperService $superservice)
    {
        $superservice->delete();

        return response()->json(['message' => 'SuperService deleted successfully!']);
    }
}