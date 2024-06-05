<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Section;
use App\Control;

class SectionController extends Controller
{

    public $validation = [
      'name' => 'required|string|max:255',
      'code' => 'required|string|max:8',
      'order' => 'required|integer|min:1|max:100',
    ];


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the Sections page.
     *
     * @return Response
     */
    public function index()
    {
        $sections = Section::orderBy('order','asc')->get();
        return view('admin/section/index', compact('sections'));
    }

    /**
     * Show a Section page.
     *
     * @param Section $section
     * @return Response
     */
    public function show(Section $section)
    {
        $controlTypes = Control::types;
        $answerTypes = Control::answerTypes;
        return view('admin/section/view', compact('section','controlTypes','answerTypes'));
    }


    /**
     * Create a Section.
     *
     * @return Response
     */
    public function create()
    {
        $section = new Section;
        return view('admin/section/create',compact('section'));
    }

    /**
     * Create a new Section.
     *
     * @return Response
     */
    public function store()
    {
        // Validate the request...
        request()->validate($this->validation);

        $section = new Section;
        $section->name = request()->name;
        $section->code = request()->code;
        $section->order = request()->order;
        $section->save();

        alert()->success('Success','Saved');
        return redirect()->route('admin.section',$section->id);
    }

    /**
     * Show a Section edit page.
     * @param Section $section
     * @return Response
     */
    public function edit(Section $section)
    {
        return view('admin/section/edit', compact('section'));
    }

    /**
     * Update a Section
     *
     * @param  Section $section
     * @return Response
     */
    public function update(Section $section)
    {
      request()->validate($this->validation);

      $section->name = request()->name;
      $section->code = request()->code;
      $section->order = request()->order;
      $section->save();

      alert()->success('Success','Updated');
      return redirect()->route('admin.section',$section->id);
    }

    /**
     * Remove a Section
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
    }


}
