<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SimCard;
use Carbon\Carbon;

class SimCardPhoneNumberController extends Controller
{
  /**
   * Index
   * Returns a collection of phone numbers related to a specified sim card as
   * JSON
   */
    public function index($sim)
    {
        $phone_numbers = SimCard::findOrFail($sim)->active_phone_numbers;
        if ($phone_numbers) {
            return response()->json(['phone_numbers' => $phone_numbers], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Active
     * Returns a collection of active phone numbers related to a specified sim
     * card as JSON
     */
    public function active($sim)
    {
        $phone_numbers = SimCard::findOrFail($sim)->active_phone_numbers;
        if ($phone_numbers) {
            return response()->json(['active_phone_numbers' => $phone_numbers], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Inactive
     * Returns a collection of inactive phone numbers related to a specified sim
     * cards as JSON
     */
    public function inactive($sim)
    {
        $phone_numbers = SimCard::findOrFail($sim)->inactive_phone_numbers;
        if ($phone_numbers) {
            return response()->json(['inactive_phone_numbers' => $phone_numbers], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Store
     * Links a phone number to a sim card by creating a record in the pivot table.
     * Unsets the relations so that only a single phone number is returned rather
     * than all phone numbers.
     */
     public function store($sim, Request $request)
     {
         try {
             $sim_card = SimCard::findorFail($sim);
             $phone_number_id = json_decode($request->getContent(), true)['phone_number_id'];
             $sim_card->phone_numbers()->attach($phone_number_id, ['assignment_start' => Carbon::now()->toDateString(), 'assignment_end' => null]);
             $sim_card->phone_number = $sim_card->phone_number($phone_number_id);
             $sim_card->unsetRelation('phone_numbers');
             return response()->json(['sim_card' => $sim_card], 200);
         } catch (\Illuminate\Database\QueryException $e) {
             return response()->json(['message' => $e->errorInfo[2]], 400);
         } catch (\Exception $e) {
             return response()->json(['message' => $e->errorInfo[2]], 500);
         }
     }

     /**
      * Show
      * Returns a single phone number related to a specified sim card as JSON
      */
     public function show($sim, $id)
     {
         $sim_card = SimCard::findOrFail($sim);
         if ($sim_card->phone_number($id) !== null) {
             $sim_card->phone_number = $sim_card->phone_number($id);
             $sim_card->unsetRelation('phone_number');
             return response()->json(['sim_card' => $sim_card], 200);
         }
         return response()->json(['message' => 'Device not found'], 404);
     }

     /**
      * Destroy
      * Detatches a phone number from a sim card by setting the assignment_end
      * field to todays date (will no longer appear in active phone numbers
      * for this sim card)
      */
     public function destroy($sim, $id)
     {
         $sim_card = SimCard::findorFail($sim);
         if ($sim_card->phone_number($id) !== null) {
            $sim_card->phone_numbers()->updateExistingPivot($id, ['assignment_end' => Carbon::now()->toDateString()], false);
            return response()->json(['message' => "Sim card phone number assignment successfully terminated"], 204);
         }
         return response()->json(['message' => 'Device not found'], 404);
     }
}