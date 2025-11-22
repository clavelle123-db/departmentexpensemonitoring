<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remittance;
use Illuminate\Support\Facades\Auth;

class HeadTreasurerController extends Controller
{
    /**
     * Display a listing of pending remittances.
     */
    public function index()
    {
        if (Auth::user()->role !== 'head') {
            abort(403, 'Unauthorized action.');
        }

        // Fetch pending remittances
        $pendingRemittances = Remittance::where('is_remitted', 0)
            ->with('treasurer', 'event')
            ->latest()
            ->get();

        return view('head.remittances.pending', compact('pendingRemittances'));
    }

    /**
     * Acknowledge a remittance.
     */
    public function acknowledge($id)
    {
        if (Auth::user()->role !== 'head') {
            abort(403, 'Unauthorized action.');
        }

        $remittance = Remittance::findOrFail($id);
        $remittance->is_remitted = 1;
        $remittance->save();

        return redirect()->route('head.remittances.index')
                         ->with('success', 'Remittance acknowledged successfully!');
    }
}
