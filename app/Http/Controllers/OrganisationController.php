<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Organisation;
use Illuminate\Support\Facades\Auth;

class OrganisationController extends Controller
{
    /**
     * Display a listing of the organisations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retrieve organisations based on user role
        $organisations = Auth::user()->organisations;

        return response()->json(['organisations' => $organisations]);
    }

    /**
     * Store a newly created organisation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Create a new organisation
        $organisation = Organisation::create([
            'name' => $request->input('name'),
        ]);

        // Attach the organisation to the current user (assuming you have a many-to-many relationship)
        $organisation->users()->attach(auth()->id());

        return response()->json(['organisation' => $organisation], 201);
    }

    /**
     * Display the specified organisation.
     *
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function show(Organisation $organisation)
    {
        // Check if the user has access to the organisation
        $this->authorize('view', $organisation);

        return response()->json(['organisation' => $organisation]);
    }

    /**
     * Update the specified organisation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organisation $organisation)
    {
        // Check if the user has access to update the organisation
        $this->authorize('update', $organisation);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update organisation details
        $organisation->update([
            'name' => $request->input('name'),
        ]);

        return response()->json(['organisation' => $organisation]);
    }

    /**
     * Remove the specified organisation from storage.
     *
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organisation $organisation)
    {
        // Check if the user has access to delete the organisation
        $this->authorize('delete', $organisation);

        // Detach the organisation from all users before deleting
        $organisation->users()->detach();

        // Delete the organisation
        $organisation->delete();

        return response()->json(['message' => 'Organisation deleted successfully']);
    }
}
