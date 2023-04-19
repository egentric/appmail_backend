<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->select('users.*', 'roles.nameRole as role')

            ->get()
            ->toArray();
        return response()->json([
            'status' => 'Success',
            'data' => $users,
        ]);
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
    public function show($id)
    {
        $users = DB::table('users')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->select('users.*', 'roles.nameRole as role')
            ->where('users.id', '=', $id)
            ->first();

        return response()->json([
            'status' => 'Success',
            'data' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'user_firstname' => 'required|max:40',
            'user_lastname' => 'required|max:40',
            'user_email' => 'required|string',
            'user_center' => 'required|string',
            'role_id' => 'required|max:15',
        ]);
        // On modifie le type
        $user->update([
            $user->user_firstname = $request->input('user_firstname'),
            $user->user_lastname = $request->input('user_lastname'),
            $user->user_center = $request->input('user_center'),
            $user->user_email = $request->input('user_email'),
            $user->role_id = $request->input('role_id'),
        ]);

        // On retourne les informations du type en JSON
        return response()->json([
            'status' => 'Mise à jour avec succèss'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // On supprime le commentaire
        $user->delete();
        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Supprimer avec succès'
        ]);
    }
}
