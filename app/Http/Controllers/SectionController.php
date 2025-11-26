<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Section;
use App\Models\Treasurer;

class SectionController extends Controller
{
    public function index() {
        $sections = Section::with(['user','headTreasurer','events'])->get();
        return view('sections.index', compact('sections'));
    }

    public function create() {
        // Pass all treasurers for the dropdown
        $treasurers = Treasurer::all();
        return view('sections.create', compact('treasurers'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'section_name'=> [
            'required',
            Rule::unique('sections')->where(fn($query) => $query->where('year_level', $request->year_level)),
        ],
        'year_level'=> 'required',
        'no_of_students' => 'required|integer|min:0',
        'treasurer_id' => 'required|exists:users,id', // validate against users table
    ], [
        'section_name.unique' => 'A section with this name and year level already exists.',
        'section_name.required' => 'Section name is required.',
        'year_level.required' => 'Year level is required.',
        'no_of_students.required' => 'Number of students is required.',
        'no_of_students.integer' => 'Number of students must be an integer.',
        'treasurer_id.required' => 'Treasurer is required.',
        'treasurer_id.exists' => 'Selected treasurer is invalid.',
    ]);

    Section::create($validated);

    return redirect()->back()->with('success', 'Section created successfully!');
}

    public function edit(Section $section) {
        $treasurers = Treasurer::all(); // pass treasurers for edit form
        return view('sections.edit', compact('section', 'treasurers'));
    }

    public function update(Request $request, Section $section) {
        $validated = $request->validate([
            'section_name' => 'required|string|max:255',
            'year_level' => 'required|string|max:50',
            'no_of_students' => 'required|integer',
            'treasurer_id' => 'required|exists:treasurers,treasurer_id',
        ]);

        $section->update($validated);

        return redirect()->route('sections.index')->with('success','Section updated');
    }

    public function destroy(Section $section)
    {
        // 1) Delete remittances linked to treasurers of events in this section
        \DB::table('remittances')
            ->whereIn('treasurer_id', function($query) use ($section) {
                $query->select('treasurer_id')
                      ->from('treasurers')
                      ->whereIn('event_id', function($q) use ($section) {
                          $q->select('event_id')
                            ->from('events')
                            ->where('applied_to', $section->section_id);
                      });
            })->delete();

        // 2) Delete treasurers linked to this section’s events
        \DB::table('treasurers')
            ->whereIn('event_id', function($q) use ($section) {
                $q->select('event_id')
                  ->from('events')
                  ->where('applied_to', $section->section_id);
            })->delete();

        // 3) Delete events linked to this section
        \DB::table('events')
            ->where('applied_to', $section->section_id)
            ->delete();

        // 4) Finally delete the section
        $section->delete();

        return redirect()->route('sections.index')
                         ->with('success', 'Section and all related records deleted successfully.');
    }
}
