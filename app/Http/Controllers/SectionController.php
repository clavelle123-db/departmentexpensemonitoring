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
    // 1) Delete remittances linked to treasurers of this section
    \DB::table('remittances')
        ->whereIn('treasurer_id', function($query) use ($section) {
            $query->select('treasurer_id')
                  ->from('treasurers')
                  // adjust this line based on how treasurers link to sections
                  ->where('headTreasurer_id', $section->section_id);
        })->delete();

    // 2) Delete treasurers linked to this section
    \DB::table('treasurers')
        ->where('headTreasurer_id', $section->section_id) // adjust column
        ->delete();

    // 3) Delete events linked to this section
    \DB::table('events')
        ->where('applied_to', $section->section_id)
        ->delete();

    // 4) Finally delete the section
    $section->delete();

    return redirect()->route('sections.index')
                     ->with('success', 'Section deleted successfully');
}

}
