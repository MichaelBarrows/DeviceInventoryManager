<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use Carbon\Carbon;

class DeviceSimCardController extends Controller
{
    /**
     * Index
     * Returns a collection of sim cards related to a specified device as JSON
     */
    public function index($device)
    {
        $sim_cards = Device::findOrFail($device)->sim_cards;
        if ($sim_cards) {
            return response()->json(['sim_cards' => $sim_cards], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Active
     * Returns a collection of active sim cards related to a specified device
     * as JSON
     */
    public function active($device)
    {
        $sim_cards = Device::findOrFail($device)->active_sim_cards;
        if ($sim_cards) {
            return response()->json(['active_sim_cards' => $sim_cards], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Inactive
     * Returns a collection of inactive sim cards related to a specified device
     * as JSON
     */
    public function inactive($device)
    {
        $sim_cards = Device::findOrFail($device)->inactive_sim_cards;
        if ($sim_cards) {
            return response()->json(['inactive_sim_cards' => $sim_cards], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Store
     * Links a sim card to a device by creating a record in the pivot table.
     * Unsets the relations so that only a single sim card is returned rather
     * than all sim cards.
     */
     public function store($device, Request $request)
     {
        try {
            $device = Device::findorFail($device);
            $sim_card_id = json_decode($request->getContent(), true)['sim_card_id'];
            $device->sim_cards()->attach($sim_card_id, ['assignment_start' => Carbon::now()->toDateString(), 'assignment_end' => null]);
            $device->sim_card = $device->sim_card($sim_card_id);
            $device->unsetRelation('sim_cards');
            return response()->json(['device' => $device], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => $e->errorInfo[2]], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->errorInfo[2]], 500);
        }
     }

     /**
      * Show
      * Returns a single sim card related to a specified device as JSON
      */
    public function show($device, $id)
    {
        $device = Device::findOrFail($device);
        if ($device->sim_card($id) !== null) {
            $device->sim_card = $device->sim_card($id);
            $device->unsetRelation('sim_cards');
            return response()->json(['device' => $device], 200);
        }
        return response()->json(['message' => 'Device not found'], 404);
    }

    /**
     * Destroy
     * Detatches a sim card from a device by setting the assignment_end field
     * to todays date (will no longer appear in active sim cards for this device)
     */
     public function destroy($device, $id)
     {
         $device = Device::findorFail($device);
         if ($device->sim_card($id) !== null) {
            $device->sim_cards()->updateExistingPivot($id, ['assignment_end' => Carbon::now()->toDateString()], false);
            return response()->json(['message' => "Device sim card assignment successfully terminated"], 204);
         }
         return response()->json(['message' => 'Device not found'], 404);
     }
}
