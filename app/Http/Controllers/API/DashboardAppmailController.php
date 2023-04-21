<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardAppmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dashboardAppmail = DB::table('appmail_categories', 'appmail_contacts', 'users')
            ->get()
            ->toArray();

        // On retourne les informations de la table commentaire en JSON
        return response()->json([
            'status' => 'Success',
            'data' => $dashboardAppmail,
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
    public function show(string $id)
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
