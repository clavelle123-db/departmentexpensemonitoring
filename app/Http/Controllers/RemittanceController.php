<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remittance;
use App\Models\Treasurer;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class RemittanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $remittances = Remittance::with('treasurer')->latest()->get();
        // return view('remittances.index', compact('remittances',$remittances));
        return view('remittances.index', compact('remittances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $treasurers = Treasurer::all();
        $events = Event::all();
        return view('remittances.create', compact('treasurers','events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'treasurer_id' => 'required|exists:treasurers,treasurer_id',
            'event_id' => 'required|exists:events,event_id',
            'amount' => 'required|numeric|min:0.01',
            'remittance_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        Remittance::create($request->all());

        return redirect()->route('remittances.index')->with('success', 'Remittance recorded successfully!');
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
    public function edit(Remittance $remittance)
    {
        $remittance = Remittance::findOrFail($remittance->remittance_id);
        return view('remittances.edit', compact('remittance'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Remittance $remittance)
    {
        $request->validate([
            'treasurer_id' => 'required|exists:treasurers,treasurer_id',
            'amount' => 'required|numeric|min:0',
            'remittance_date' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $remittance->update($request->all());

        return redirect()->route('remittances.index')->with('success', 'Remittance updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Remittance $remittance)
    {
       $remittance->delete();
        return redirect()->route('remittances.index')->with('success', 'Remittance deleted successfully!');
    }


    // Head treasurer acknowledges the remittance
// Head treasurer acknowledges the remittance
public function acknowledge($id)
{
    $remittance = Remittance::findOrFail($id);

    if (Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized.'], 403);
    }

    $remittance->is_remitted = 1;
    $remittance->save();

    return redirect()->route('remittances.showPending')->with('success', 'Remittance acknowledged!');
}


// This returns JSON only (used by API or debugging)
public function pending()
{
    if (Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Unauthorized.'], 403);
    }

    $pending = Remittance::where('is_remitted', 0)->with('user', 'event')->get();

    return response()->json($pending);
}


// This loads the Blade page
public function showPending()
{
    if (Auth::user()->role !== 'admin') {
        abort(403);
    }

    $pendingRemittances = Remittance::where('is_remitted', 0)
        ->with('treasurer', 'event')
        ->get();

    return view('remittances.pending', compact('pendingRemittances'));
}


}
