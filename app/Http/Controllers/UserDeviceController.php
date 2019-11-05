<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class UserDeviceController extends Controller
{
  /**
   * Index
   * Returns a collection of devices related to a specified user as JSON
   */
    public function index($user)
    {
        $devices = User::findOrFail($user)->devices;
        if ($devices) {
          return response()->json(['devices' => $devices], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Active
     * Returns a collection of active devices related to a specified user
     * as JSON
     */
    public function active($user)
    {
        $devices = User::findOrFail($user)->active_devices;
        if (count($devices) > 0) {
          return response()->json(['active_devices' => $devices], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Inactive
     * Returns a collection of inactive devices related to a specified user
     * as JSON
     */
    public function inactive($user)
    {
        $devices = User::findOrFail($user)->inactive_devices;
        if (count($devices) > 0) {
          return response()->json(['inactive_devices' => $devices], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Store
     * Links a device to a user by creating a record in the pivot table.
     * Unsets the relations so that only a single device is returned rather
     * than all devices.
     */
    public function store($user, Request $request)
    {
        try {
          $user = User::findorFail($user);
          $device_id = json_decode($request->getContent(), true)['device_id'];
          $user->devices()->attach($device_id, ['assignment_start' => Carbon::now()->toDateString(), 'assignment_end' => null]);
          $user->device = $user->device($device_id);
          $user->unsetRelation('devices');
          return response()->json(['user' => $user], 201);
        } catch (\Illuminate\Database\QueryException $e) {
          return response()->json(['message' => $e->errorInfo[2]], 400);
        } catch (\Exception $e) {
          return response()->json(['message' => $e->errorInfo[2]], 500);
        }
    }

    /**
     * Show
     * Returns a single device related to a specified user as JSON
     */
    public function show($user, $id)
    {
        $user = User::findOrFail($user);
        if ($user->device($id) !== null) {
          $user->device = $user->device($id);
          $user->unsetRelation('devices');
          return response()->json(['user' => $user], 200);
        }
        return response()->json(['message' => 'Device not found'], 404);
    }

    /**
     * Destroy
     * Detatches a device from a user by setting the assignment_end field
     * to todays date (will no longer appear in active devices for this user)
     */
    public function destroy($user, $id)
    {
        $user = User::findorFail($user);
        if ($user->device($id) !== null) {
            $user->devices()->updateExistingPivot($id, ['assignment_end' => Carbon::now()->toDateString()], false);
            return response()->json(['message' => "User device assignment successfully terminated"], 204);
        }
        return response()->json(['message' => 'Device not found'], 404);
    }
}
