<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\Section;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $events = Event::with('section')->get();
        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('events.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'applied_to' => 'required|exists:sections,section_id',
        ]);

        Event::create($request->all());
        return redirect()->route('events.index')->with('success', 'Event created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $sections = Section::all();
        return view('events.edit', compact('event', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_description' => 'nullable|string',
            'amount' => 'required|numeric|min:0',
            'applied_to' => 'required|exists:sections,section_id',
        ]);

        $event = Event::findOrFail($id);
        $event->update($request->all());
        return redirect()->route('events.index')->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */public function destroy(string $id)
{
    // Delete all remittances linked to this event
    \DB::table('remittances')->where('event_id', $id)->delete();

    // Now delete the event
    $event = Event::findOrFail($id);
    $event->delete();

    return redirect()->route('events.index')->with('success', 'Event deleted successfully');
}

}
