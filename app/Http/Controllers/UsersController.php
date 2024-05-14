<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        response()->json([$users], 200);
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json([$user], 200);
    }

    public function update(Request $request, $id){
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json([$user], 200);
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json([$user], 200);
    }
}
