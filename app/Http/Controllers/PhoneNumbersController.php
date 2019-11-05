<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PhoneNumber;

class PhoneNumbersController extends Controller
{
  /**
   * Index
   * Returns all phone numbers as JSON
   */
    public function index()
    {
        $phone_number = PhoneNumber::all();
        return response()->json(['phone_number' => $phone_number], 200);
    }

    /**
     * Store
     * Creates a new phone number, refreshes the created phone number so that
     * its relations are loaded and returns as JSON
     */
    public function store(Request $request)
    {
        $phone_number = PhoneNumber::create($request->json()->all());
        $phone_number = PhoneNumber::findOrFail($phone_number->id);
        return response()->json(['message' => 'Phone Number created successfully', 'phone_number' => $phone_number], 201);
    }

    /**
     * Show
     * Returns a single phone number as JSON
     */
    public function show($id)
    {
        $phone_number = PhoneNumber::findOrFail($id);
        return response()->json(['phone_number' => $phone_number], 200);

    }

    /**
     * Update
     * Updates an existing phone number and returns as JSON
     */
    public function update(Request $request, $id)
    {
        $phone_number = PhoneNumber::findOrFail($id);
        $phone_number->update($request->json()->all());
        return response()->json(['message' => 'Phone Number updated successfully', 'phone_number' => $phone_number], 200);
    }

    /**
     * Destroy
     * Deletes a single phone number and returns a JSON message
     */
    public function destroy($id)
    {
        $phone_number = PhoneNumber::findOrFail($id);
        $phone_number->delete();
        return response()->json(['message' => 'Phone Number deleted successfully'], 204);
    }
}
