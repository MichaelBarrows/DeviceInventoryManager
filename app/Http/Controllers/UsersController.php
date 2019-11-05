<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
  /**
   * Index
   * Returns all users as JSON
   */
    public function index()
    {
        return User::all();
    }

    /**
     * Store
     * Creates a new user, refreshes the created user so that its
     * relations are loaded and returns as JSON
     */
    public function store(Request $request)
    {
        $user = User::create($request->json()->all());
        $user = User::findOrFail($user->id);
        return response()->json(['user' => $user], 200);
    }

    /**
     * Show
     * Returns a single user as JSON
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['user' => $user], 200);
    }

    /**
     * Update
     * Updates an existing user and returns as JSON
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->json()->all());
        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    /**
     * Destroy
     * Deletes a single user and returns a JSON message
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 204);
    }
}
