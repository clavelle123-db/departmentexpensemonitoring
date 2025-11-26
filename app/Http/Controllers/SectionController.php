<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Section;


class SectionController extends Controller
{
    public function index() {
        $sections = Section::with(['user','headTreasurer','events'])->get();
        return view('sections.index', compact('sections'));
    }

    public function create() {
        return view('sections.create');
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'section_name'=> [
            'required',
            Rule::unique('sections')->where(function($query) use($request){
                return $query->where('year_level', $request->year_level);
            }),
        ],
        'year_level'=> 'required',
        'no_of_students' => 'required|integer|min:0',
    ], [
        'section_name.unique' => 'A section with this name and year level already exists.',
        'section_name.required' => 'Section name is required.',
        'year_level.required' => 'Year level is required.',
        'no_of_students.required' => 'Number of students is required.',
        'no_of_students.integer' => 'Number of students must be an integer.',
    ]);

    // Create section with all fields
    Section::create($validated);

    return redirect()->back()->with('success', 'Section created successfully!');
}

    public function edit(Section $section) {
        return view('sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section) {
        $request->validate([
            'section_name' => 'required|string|max:255',
            'year_level' => 'required|string|max:50',
             'no_of_students' => 'required|integer',
        ]);
        $section->update($request->all());
        return redirect()->route('sections.index')->with('success','Section updated');
    }
public function destroy(Section $section)
{
    // 1) Delete remittances linked to treasurers of events in this section
    \DB::table('remittances')
        ->whereIn('treasurer_id', function($query) use ($section) {
            $query->select('treasurer_id')
                  ->from('treasurers')
                  ->whereIn('treasurer_id', function($q) use ($section) {
                      $q->select('treasurer_id')
                        ->from('treasurers'); // all treasurers, no filter column, delete all
                  });
        })->delete();

    // 2) Delete treasurers (all treasurers linked to section via events)
    \DB::table('treasurers')->delete();

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
