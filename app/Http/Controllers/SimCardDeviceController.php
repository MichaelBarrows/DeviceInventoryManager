<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SimCard;
use Carbon\Carbon;

class SimCardDeviceController extends Controller
{
    /**
     * Index
     * Returns a collection of devices related to a specified sim card
     * as JSON
     */
    public function index($sim_card)
    {
        $devices = SimCard::findOrFail($sim_card)->devices;
        if ($devices) {
            return response()->json(['devices' => $devices], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Active
     * Returns a collection of active devices related to a specified sim card
     * as JSON
     */
    public function active($sim_card)
    {
        $devices = SimCard::findOrFail($sim_card)->active_devices;
        if ($devices) {
            return response()->json(['active_devices' => $devices], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Inactive
     * Returns a collection of inactive devices related to a specified sim card
     * as JSON
     */
    public function inactive($sim_card)
    {
        $devices = SimCard::findOrFail($sim_card)->inactive_devices;
        if ($devices) {
            return response()->json(['inactive_devices' => $devices], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Store
     * Links a device to a sim card by creating a record in the pivot table.
     * Unsets the relations so that only a single sim card is returned rather
     * than all sim card.
     */
    public function store($sim_card, Request $request)
    {
        try {
            $sim_card = SimCard::findorFail($sim_card);
            $device_id = json_decode($request->getContent(), true)['device_id'];
            $sim_card->devices()->attach($device_id, ['assignment_start' => Carbon::now()->toDateString(), 'assignment_end' => null]);
            $sim_card->device = $sim_card->device($device_id);
            $sim_card->unsetRelation('devices');
            return response()->json(['sim_card' => $sim_card], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['message' => $e->errorInfo[2]], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->errorInfo[2]], 500);
        }
    }

    /**
     * Show
     * Returns a single device related to a specified sim card as JSON
     */
    public function show($sim_card, $id)
    {
        $sim_card = SimCard::findOrFail($sim_card);
        if ($sim_card->device($id) !== null) {
            $sim_card->device = $sim_card->device($id);
            $sim_card->unsetRelation('devices');
            return response()->json(['sim_card' => $sim_card], 200);
        }
        return response()->json(['message' => 'Sim Card not found'], 404);
    }

    /**
     * Destroy
     * Detatches a device from a sim card by setting the assignment_end
     * field to todays date (will no longer appear in active devices
     * for this sim card)
     */
    public function destroy($sim_card, $id)
    {
        $sim_card = SimCard::findorFail($sim_card);
        if ($sim_card->device($id) !== null) {
           $sim_card->devices()->updateExistingPivot($id, ['assignment_end' => Carbon::now()->toDateString()], false);
           return response()->json(['message' => "Sim card device assignment successfully terminated"], 204);
        }
        return response()->json(['message' => 'Sim card not found'], 404);
    }
}
