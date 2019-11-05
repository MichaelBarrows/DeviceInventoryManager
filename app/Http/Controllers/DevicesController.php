<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;

class DevicesController extends Controller
{
    /**
     * Index
     * Returns all devices as JSON
     */
    public function index()
    {
        $devices = Device::all();
        return response()->json(['devices' => $devices], 200);
    }

    /**
     * Store
     * Creates a new device, refreshes the created device so that its relations
     * are loaded and returns as JSON
     */
    public function store(Request $request)
    {
        $device = Device::create($request->json()->all());
        $device = Device::findOrFail($device->id);
        return response()->json(['message' => 'Device created successfully', 'device' => $device], 201);
    }

    /**
     * Show
     * Returns a single device as JSON
     */
    public function show($id)
    {
        $device = Device::findOrFail($id);
        return response()->json(['device' => $device], 200);
    }

    /**
     * Update
     * Updates an existing device and returns as JSON
     */
    public function update(Request $request, $id)
    {
        $device = Device::findOrFail($id);
        $device->update($request->json()->all());
        return response()->json(['message' => 'Device updated successfully', 'device' => $device], 200);
    }

    /**
     * Destroy
     * Deletes a single device and returns a JSON message
     */
    public function destroy($id)
    {
        $device = Device::findOrFail($id);
        $device->delete();
        return response()->json(['message' => 'Device deleted successfully'], 204);
    }
}
