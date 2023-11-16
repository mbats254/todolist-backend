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
        $organisations = Organisation::get();


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
            'uniqid' => uniqid()
        ]);

       

        return response()->json(['organisation' => $organisation], 201);
    }

    /**
     * Display the specified organisation.
     *
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $organisation = Organisation::where('id','=',$request->id)->first();

        return response()->json(['organisation' => $organisation]);
    }

    /**
     * Update the specified organisation in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
      

        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $organisation = Organisation::where('id','=',$request->id)->first();
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
    public function destroy(Request $request)
    {
        

        $organisation = Organisation::where('id','=',$request->id)->first();

        // Delete the organisation
        $organisation->delete();

        return response()->json(['message' => 'Organisation deleted successfully']);
    }
}
