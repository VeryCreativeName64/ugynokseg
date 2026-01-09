<?php

namespace App\Http\Controllers;

use App\Models\Participate;
use Illuminate\Http\Request;

class ParticipateController extends Controller
{
    public function index()
    {
        return Participate::all();
    }

    public function store(Request $request)
    {
        $participate = Participate::create($request->all());
        return response()->json($participate, 201);
    }

    public function show($id)
    {
        return Participate::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $participate = Participate::findOrFail($id);
        $participate->update($request->all());
        return $participate;
    }

    public function destroy($id)
    {
        Participate::findOrFail($id)->delete();
        return response()->json(['message' => 'Részvétel törölve'], 200);
    }
}