<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TodoItem;
use App\Organisation; // Make sure to include the Organisation model if not already done
use Illuminate\Support\Facades\Auth;

class TodoItemController extends Controller
{
    /**
     * Display a listing of the to-do items for a specific organisation.
     *
     * @param int $organisationId
     * @return \Illuminate\Http\Response
     */
    public function index($organisationId)
    {
        // Retrieve to-do items for the specified organisation
        $todoItems = TodoItem::where('organisation_id', $organisationId)->get();

        return response()->json(['todoItems' => $todoItems]);
    }

    /**
     * Store a newly created to-do item for a specific organisation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $organisationId
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Add other validation rules as needed
        ]);
        // return response()->json([$request->organisationId]);
        // Check if the user is a member of the specified organisation
        $organisation = Organisation::where('id','=',$request->organisationId)->first();
        
        if($organisation)
        {
              // Create a new to-do item
        $todoItem = TodoItem::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'organisation_id' => $organisation->id,
            'user_id' => Auth::user()->id, 
            'uniqid' => uniqid()
        ]);
        }
      

        return response()->json(['todoItem' => $todoItem], 201);
    }

    /**
     * Display the specified to-do item for a specific organisation.
     *
     * @param int $organisationId
     * @param int $todoItemId
     * @return \Illuminate\Http\Response
     */
    public function show($organisationId, $todoItemId)
    {
        // Retrieve the specified to-do item for the specified organisation
        $todoItem = TodoItem::where('organisation_id', $organisationId)->findOrFail($todoItemId);

        return response()->json(['todoItem' => $todoItem]);
    }

    /**
     * Update the specified to-do item for a specific organisation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param int $organisationId
     * @param int $todoItemId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            // Add other validation rules as needed
        ]);

        
        $organisation = Organisation::where('id','=',$request->organisationId)->first();
        return response()->json([$organisation]);
        // Retrieve the specified to-do item for the specified organisation
        $todoItem = TodoItem::where('organisation_id', $request->organisationId)->where('id','=',$request->todoItemId)->first();

        // Update to-do item details
        $todoItem->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return response()->json(['todoItem' => $todoItem]);
    }

    /**
     * Remove the specified to-do item for a specific organisation.
     *
     * @param int $organisationId
     * @param int $todoItemId
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // Check if the user is a member of the specified organisation
        $organisation = Organisation::where('id','=',$request->organisationId)->first();
        

        // Retrieve the specified to-do item for the specified organisation
        $todoItem = TodoItem::where('organisation_id', $request->organisationId)->where('id','=',$request->todoItemId)->first();

        // Delete the to-do item
        $todoItem->delete();

        return response()->json(['message' => 'To-Do Item deleted successfully']);
    }
}
