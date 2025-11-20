<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remittance;
use App\Models\Treasurer;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RemittanceController extends Controller
{
    /**
     * Display a listing of all remittances.
     */
    public function index()
    {
        $remittances = Remittance::with('treasurer')->latest()->get();
        return view('remittances.index', compact('remittances'));
    }

    /**
     * Show form to create a new remittance.
     */
    public function create()
    {
        $treasurers = Treasurer::all();
        $events = Event::all();

        return view('remittances.create', compact('treasurers', 'events'));
    }

    /**
     * Store a newly created remittance.
     */
    public function store(Request $request)
    {
        $request->validate([
            'treasurer_id'     => 'required|exists:treasurers,treasurer_id',
            'event_id'         => 'required|exists:events,event_id',
            'amount'           => 'required|numeric|min:0.01',
            'remittance_date'  => 'required|date',
            'remarks'          => 'nullable|string',
        ]);

        Remittance::create($request->all());

        return redirect()->route('remittances.index')
            ->with('success', 'Remittance recorded successfully!');
    }

    /**
     * Show the form for editing an existing remittance.
     */
    public function edit($id)
    {
        $remittance = Remittance::findOrFail($id);

        return view('remittances.edit', compact('remittance'));
    }

    /**
     * Update an existing remittance.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'treasurer_id'    => 'required|exists:treasurers,treasurer_id',
            'amount'          => 'required|numeric|min:0',
            'remittance_date' => 'required|date',
            'remarks'         => 'nullable|string',
        ]);

        $remittance = Remittance::findOrFail($id);

        $remittance->update($request->all());

        return redirect()->route('remittances.index')
            ->with('success', 'Remittance updated successfully!');
    }

    /**
     * Delete a remittance.
     */
    public function destroy($id)
    {
        $remittance = Remittance::findOrFail($id);
        $remittance->delete();

        return redirect()->route('remittances.index')
            ->with('success', 'Remittance deleted successfully!');
    }

    /**
     * Head Treasurer acknowledges a pending remittance.
     */
    public function acknowledge($id)
    {
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized action.');
        }

        $remittance = Remittance::findOrFail($id);

        $remittance->is_remitted = 1;
        $remittance->save();

        return redirect()
            ->route('remittances.showPending')
            ->with('success', 'Remittance acknowledged!');
    }

    /**
     * API Endpoint — returns pending remittances.
     */
    public function pending()
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $pending = Remittance::where('is_remitted', 0)
            ->with(['treasurer', 'event'])
            ->get();

        return response()->json($pending);
    }

    /**
     * Blade Page — list all pending remittances.
     */
    public function showPending()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $pendingRemittances = DB::table('remittances')
            ->join('treasurers', 'remittances.treasurer_id', '=', 'treasurers.treasurer_id')
            ->join('events', 'remittances.event_id', '=', 'events.event_id')
            ->select(
                'remittances.*',
                'treasurers.first_name',
                'treasurers.last_name',
                'events.event_name'
            )
            ->where('remittances.is_remitted', 0)
            ->get();

        return view('remittances.pending', compact('pendingRemittances'));
    }
}
