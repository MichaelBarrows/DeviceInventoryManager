<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use Carbon\Carbon;

class DeviceUserController extends Controller
{
    /**
    * Index
    * Returns a collection of users related to a specified device as JSON
    */
    public function index($device)
    {
        $users = Device::findOrFail($device)->users;
        if ($users) {
          return response()->json(['users' => $users], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Active
     * Returns a collection of active users related to a specified device
     * as JSON
     */
    public function active($device)
    {
        $users = Device::findOrFail($device)->active_users;
        if (count($users) > 0) {
          return response()->json(['active_users' => $users], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Inactive
     * Returns a collection of inactive users related to a specified device
     * as JSON
     */
    public function inactive($device)
    {
        $users = Device::findOrFail($device)->inactive_users;
        if (count($users) > 0) {
          return response()->json(['inactive_users' => $users], 200);
        }
        return response()->json(['message' => 'Not found'], 404);
    }

    /**
     * Store
     * Links a device to a user by creating a record in the pivot table.
     * Unsets the relations so that only a single user is returned rather
     * than all users.
     */
    public function store($device, Request $request)
    {
        try {
          $device = Device::findorFail($device);
          $user_id = json_decode($request->getContent(), true)['user_id'];
          $device->users()->attach($user_id, ['assignment_start' => Carbon::now()->toDateString(), 'assignment_end' => null]);
          $device->user = $device->user($user_id);
          $device->unsetRelation('users');
          return response()->json(['device' => $device], 201);
        } catch (\Illuminate\Database\QueryException $e) {
          return response()->json(['message' => $e->errorInfo[2]], 400);
        } catch (\Exception $e) {
          return response()->json(['message' => $e->errorInfo[2]], 500);
        }
    }

    /**
     * Show
     * Returns a single user related to a specified device as JSON
     */
    public function show($device, $id)
    {
        $device = Device::findOrFail($device);
        if ($device->user($id) !== null) {
          $device->user = $device->user($id);
          $device->unsetRelation('users');
          return response()->json(['device' => $device], 200);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    /**
     * Destroy
     * Detatches a user from a device by setting the assignment_end field
     * to todays date (will no longer appear in active users for this user)
     */
    public function destroy($device, $id)
    {
        $device = Device::findorFail($device);
        if ($device->user($id) !== null) {
            $device->users()->updateExistingPivot($id, ['assignment_end' => Carbon::now()->toDateString()], false);
            return response()->json(['message' => "Device user assignment successfully terminated"], 204);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}
