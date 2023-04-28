<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Appmail_category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Appmail_categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appmail_categories = DB::table('appmail_categories')
            ->get()
            ->toArray();
        return response()->json([
            'status' => 'Success',
            'data' => $appmail_categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'appmail_category_name' => 'required|max:100',
        ]);
        $appmail_category = Appmail_category::create([
            'appmail_category_name' => $request->appmail_category_name,
            'user_id' => $request->user_id,

        ]);
        return response()->json([
            'status' => 'Success',
            'data' => $appmail_category,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appmail_category $appmail_category)
    {
        return response()->json($appmail_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appmail_category $appmail_category)
    {
        $this->validate($request, [
            'appmail_category_name' => 'required|max:100',
        ]);
        $appmail_category->update([
            'appmail_category_name' => $request->appmail_category_name,
            'user_id' => $request->user_id,

        ]);
        return response()->json([
            'status' => 'Mise à jour avec succèss'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appmail_category $appmail_category)
    {
        // On supprime la catégorie
        $appmail_category->delete();
        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Supprimer avec succès'
        ]);
    }
}
