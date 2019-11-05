<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SimCard;

class SimCardsController extends Controller
{
   /**
    * Index
    * Returns all sim cards as JSON
    */
    public function index()
    {
        $sim_cards = SimCard::all();
        return response()->json(['sim_cards' => $sim_cards], 200);
    }

    /**
     * Store
     * Creates a new sim card, refreshes the created sim card so that its
     * relations are loaded and returns as JSON
     */
    public function store(Request $request)
    {
        $sim_card = SimCard::create($request->json()->all());
        $sim_card = SimCard::findOrFail($sim_card->id);
        return response()->json(['sim_card' => $sim_card], 200);
    }

    /**
     * Show
     * Returns a single sim card as JSON
     */
    public function show($id)
    {
        $sim_card = SimCard::findOrFail($id);
        return response()->json(['sim_card' => $sim_card], 200);
    }

    /**
     * Update
     * Updates an existing sim card and returns as JSON
     */
    public function update(Request $request, $id)
    {
        $sim_card = SimCard::findOrFail($id);
        $sim_card->update($request->json()->all());
        return response()->json(['message' => 'Sim Card updated successfully', 'sim_card' => $sim_card], 200);
    }

    /**
     * Destroy
     * Deletes a single sim card and returns a JSON message
     */
    public function destroy($id)
    {
        $sim_card = SimCard::findOrFail($id);
        $sim_card->delete();
        return response()->json(['message' => 'Sim Card deleted successfully'], 204);
    }
}
