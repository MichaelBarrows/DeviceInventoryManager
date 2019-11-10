<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhoneNumber;
use App\SimCard;
use Carbon\Carbon;

class PhoneNumberSimCardController extends Controller
{
    /**
     * Index
     * Returns a collection of sim cards related to a specified phone number
     * as JSON
     */
    public function index($phone_number)
    {
        $sim_cards = PhoneNumber::findOrFail($phone_number)->sim_cards;
        if ($sim_cards) {
            return response()->json(['sim_cards' => $sim_cards], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Active
     * Returns a collection of active sim cards related to a specified phone
     * number as JSON
     */
    public function active($phone_number)
    {
        $sim_cards = PhoneNumber::findOrFail($phone_number)->active_sim_cards;
        if (count($sim_cards) > 0) {
            return response()->json(['active_sim_cards' => $sim_cards], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Inactive
     * Returns a collection of inactive sim cards related to a specified phone
     * number as JSON
     */
    public function inactive($phone_number)
    {
        $sim_cards = PhoneNumber::findOrFail($phone_number)->inactive_sim_cards;
        if (count($sim_cards) > 0) {
            return response()->json(['inactive_sim_cards' => $sim_cards], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Store
     * Links a phone number to a sim card by creating a record in the pivot table.
     * Unsets the relations so that only a single phone number is returned rather
     * than all phone numbers.
     *
     * Also ensures that the sim card and phone number have the same network
     * provider ID
     */
    public function store($phone_number, Request $request)
    {
        try {
            $phone_number = PhoneNumber::findorFail($phone_number);
            $sim_card_id = json_decode($request->getContent(), true)['sim_card_id'];
            $sim_card_instance = SimCard::findOrFail($sim_card_id);
            if ($sim_card_instance->network_provider_id !== $phone_number->network_provider_id) {
               return response()->json(['message' => 'Incompatible network providers'], 409);
            }
            if (count($phone_number->active_sim_cards) >= 1) {
               foreach($phone_number->active_sim_cards as $sim) {
                  $phone_number->sim_cards()->updateExistingPivot($sim->id, ['assignment_end' => Carbon::now()->toDateString()], false);
               }
            }
            $phone_number->sim_cards()->attach($sim_card_id, ['assignment_start' => Carbon::now()->toDateString(), 'assignment_end' => null]);
            $phone_number->sim_card = $phone_number->sim_card($sim_card_id);
            $phone_number->unsetRelation('sim_cards');
            $phone_number->unsetRelation('active_sim_cards');
            return response()->json(['phone_number' => $phone_number], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => $e->errorInfo[2]], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->errorInfo[2]], 500);
        }
    }

    /**
     * Show
     * Returns a single sim card related to a specified phone number as JSON
     */
    public function show($phone_number, $id)
    {
        $phone_number = PhoneNumber::findOrFail($phone_number);
        if ($phone_number->sim_card($id) !== null) {
            $phone_number->sim_card = $phone_number->sim_card($id);
            $phone_number->unsetRelation('sim_cards');
            return response()->json(['phone_number' => $phone_number], 200);
        }
        return response()->json(['message' => 'Sim Card not found'], 404);
    }

    /**
     * Destroy
     * Detatches a sim card from a phone number by setting the assignment_end
     * field to todays date (will no longer appear in active sim cards
     * for this phone number)
     */
    public function destroy($phone_number, $id)
    {
        $phone_number = PhoneNumber::findorFail($phone_number);
        if ($phone_number->sim_card($id) !== null) {
           $phone_number->sim_cards()->updateExistingPivot($id, ['assignment_end' => Carbon::now()->toDateString()], false);
           return response()->json(['message' => "Phone number sim card assignment successfully terminated"], 204);
        }
        return response()->json(['message' => 'Phone number or sim card not found'], 404);
    }
}
