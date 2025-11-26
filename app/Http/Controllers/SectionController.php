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

    public function store(Request $request) {
        $messages =[
            'section_name.unique' =>'The section name and year level already exists.',
        ];

        $validated =$request->validate([
            'section_name'=> [
                'required',
                Rule::unique('sections')->where(function($query)use($request){
                    return $query->where('year_level', $request->year_level);
                }),
            ],

        'year_level'=> 'required',
    ],
    [
        'section_name.unique'=>'A section with this name and year level already exists.',
        'section_name.required'=>'Section name is required.',
        'year_level.required' =>'Year level is required.',
    ]);

        // $request->validate([
        //     'section_name' => 'required|string|max:255',
        //     'year_level' => 'required|string|max:50',
        //     'no_of_students' => 'required|integer',
        // ]);
        // Section::create($request->all());
        Section::create($validated);
        // return redirect()->route('sections.index')->with('success','Section created');
        // return response()->json(['message'=>'Section created successfully.']);
        return redirect()->back()->with('success','Section created successfully!');
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
    // Check if there are any events linked to this section
    $eventsCount = \DB::table('events')->where('applied_to', $section->section_id)->count();

    // Check if there are any treasurers linked to these events
    $treasurersCount = \DB::table('treasurers')
        ->whereIn('treasurer_id', function($query) use ($section) {
            $query->select('treasurer_id')
                  ->from('remittances');
        })->count();

    if ($eventsCount > 0 || $treasurersCount > 0) {
        return redirect()->route('sections.index')
            ->with('error', 'Cannot delete section: related events or remittances exist.');
    }

    // Safe to delete the section
    $section->delete();

    return redirect()->route('sections.index')
                     ->with('success', 'Section deleted successfully.');
}

}
