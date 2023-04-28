<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\Appmail_contact;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Appmail_category;
use App\Filters\ContactCategoryFilter;

class Appmail_contactController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // $contacts = DB::table('appmail_contacts')
        // ->leftJoin('appmail_category_appmail_contact', 'appmail_category_appmail_contact.appmail_contact_id', '=', 'appmail_contacts.id')
        // ->leftJoin('appmail_categories', 'appmail_categories.id', '=', 'appmail_category_appmail_contact.appmail_category_id')
        // ->select('appmail_contacts.*', 'appmail_categories.appmail_category_name as category_name')
        // ->get();
        $contacts = Appmail_contact::with("appmail_category")->get();
        // $groupedContacts = $contacts->groupBy('id');
        // $result = $groupedContacts->map(function ($item, $key) {
        //     $categoryNames = $item->pluck('category_name')->unique()->toArray();
        //     $contact = $item;
        //     $contact->category_name = $categoryNames;
        //     return $contact;
        // });

        return response()->json([
            'status' => 'Success',
            // 'data' => $result,
            'data' => $contacts,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'appmail_contact_firstname' => 'required|max:100',
            'appmail_contact_lastname' => 'required|max:100',
            'appmail_contact_email' => 'required|max:100',
            'appmail_contact_business' => 'required|max:100',

        ]);

        $appmail_contact = Appmail_contact::create([
            'appmail_contact_firstname' => $request->appmail_contact_firstname,
            'appmail_contact_lastname' => $request->appmail_contact_lastname,
            'appmail_contact_email' => $request->appmail_contact_email,
            'appmail_contact_business' => $request->appmail_contact_business,
            'user_id' => $request->user_id,

        ]);

        // // ====================table pivot appmail_contacts_categories ====================== // //

        // récupèration des identifiants des modèles Categories à partir de la requête HTTP : $contactCategoriesIds[] = $request->appmail_category_id;.
        $contactCategoriesIds[] = $request->category_id;
        // on vérifie que le tableau $contactCategoryIds n'est pas vide,
        if (!empty($contactCategoriesIds)) {
            // puis pour chaque identifiant dans le tableau, on récupère le modèle Appmail_category correspondant en utilisant la méthode find() 
            for ($i = 0; $i < count($contactCategoriesIds); $i++) {
                $appmail_category = Appmail_category::find($contactCategoriesIds[$i]);
                //  et on attache à l'événement en utilisant la méthode attach().
                $appmail_contact->appmail_category()->attach($appmail_category);
            }
            // En résumé, ce code attache un ou plusieurs appmail_category à un appmail_contact en utilisant leurs identifiants respectifs.
        }
        // // ====================Fin table pivot appmail_contacts_categories ====================== // //

        return response()->json([
            'status' => 'Success',
            'data' => $appmail_contact,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Appmail_contact $appmail_contact)
    {
        // On récupère tous les éléments de la table appmail_contacts et de la table appmail_category

        $appmail_contact_with_category = Appmail_contact::with("appmail_category")->where('appmail_contacts.id', $appmail_contact->id)->first();
        return response()->json($appmail_contact_with_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appmail_contact $appmail_contact)
    {
        $this->validate($request, [
            'appmail_contact_firstname' => 'required|max:100',
            'appmail_contact_lastname' => 'required|max:100',
            'appmail_contact_email' => 'required|max:100',
            'appmail_contact_business' => 'required|max:100',
        ]);

        DB::table('appmail_category_appmail_contact')->where('appmail_contact_id', '=', $appmail_contact->id)->delete();


        $appmail_contact->update([
            'appmail_contact_firstname' => $request->appmail_contact_firstname,
            'appmail_contact_lastname' => $request->appmail_contact_lastname,
            'appmail_contact_email' => $request->appmail_contact_email,
            'appmail_contact_business' => $request->appmail_contact_business,
            'user_id' => $request->user_id,

        ]);

        // // ====================table pivot appmail_contacts_categories ====================== // //

        // ajoute l'ID d'une catégory, récupéré à partir d'une requête HTTP ($request), à un tableau $appmail_categories.
        $appmail_categories[] = $request->category_id;

        // on vérifie que le tableau $appmail_categories n'est pas vide,
        if (!empty($appmail_categories)) {
            // Cela initialise une boucle for pour parcourir tous les éléments du tableau $appmail_categories.
            for ($i = 0; $i < count($appmail_categories); $i++) {
                // Cela récupère une catégory spécifique à partir de la base de données en utilisant son ID, qui est stocké dans le tableau $appmail_categories à l'indice $i.
                $appmail_category = Appmail_category::find($appmail_categories[$i]);
                // Cela attache la categoryau contact en utilisant la méthode attach() fournie par la relation appmail_category() définie sur l'objet $appmail_contact.
                //  Cette méthode prend un objet appmail_category en paramètre et gère la création de l'entrée de la relation dans la base de données.
                $appmail_contact->appmail_category()->attach($appmail_category);
            }
            // ce code récupère les ID des appmail_categories liés à un appmail_contact, les parcourt un par un pour récupérer les objets appmail_category correspondants à partir de la base de données et les attache ensuite à appmail_contact.
        }
        // // ====================Fin table pivot appmail_contacts_categories ====================== // //



        return response()->json([
            'status' => 'Mise à jour avec succèss'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appmail_contact $appmail_contact)
    {
        // On supprime tous les enregistrements associés dans la table pivot
        $appmail_contact->appmail_category()->detach();

        // On supprime l'évenement
        $appmail_contact->delete();
        // On retourne la réponse JSON
        return response()->json([
            'status' => 'Supprimer avec succès'
        ]);
    }

    // // ====================Filtre business ====================== // //

    public function indexFilterBusiness(Request $request)
    {
        $contacts = Appmail_contact::filter($request)->with("appmail_category")->get();
        return response()->json([
            'status' => 'Success',
            // 'data' => $result,
            'data' => $contacts,
        ]);
    }


    // // ====================Filtre Category ====================== // //


    public function indexFilterCategory(Appmail_category $appmail_category)
    {


        $appmail_contacts_with_categories = Appmail_contact::whereHas('appmail_category', function ($query) use ($appmail_category) {
            $query->where('appmail_category_id', $appmail_category->id);
        })
            ->with('appmail_category')
            ->get()
            ->toArray();

        return response()->json([
            'status' => 'Success',
            'data' => $appmail_contacts_with_categories
        ]);
    }
}
