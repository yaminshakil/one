<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Control;
use App\Section;

class ControlController extends Controller
{

    public $validation = [
      'control_number' => 'required|string|max:255',
      'order' => 'required|integer|min:0|max:1000',
      'question' => 'required|string|max:2400',
      'description' => 'required|string|max:2400',
      'section_id' => 'required|integer|exists:sections,id',
      'control_type' => 'required|integer',
      'answer_type' => 'required|integer',

      'video_ref' => 'present|string|max:255|nullable',
      'how_to_answer' => 'present|string|max:2400|nullable',
      'additional_text' => 'present|string|max:2400|nullable',
      'guidance' => 'present|string|max:2400|nullable',
      'nist_controls' => 'present|string|max:2400|nullable',
      'isoiec_controls' => 'present|string|max:2400|nullable',
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
     * Show the Controls page.
     *
     * @return Response
     */
    // public function index()
    // {
    //     $controls = Control::orderBy('order','asc')->get();
    //     return view('admin/control/index', compact('controls'));
    // }

    /**
     * Show a Control page.
     *
     * @return Control $control
     * @return Response
     */
    public function show(Control $control)
    {
        $controlType = Control::types[$control->control_type];
        $answerType = Control::answerTypes[$control->answer_type];
        return view('admin/control/view', compact('control','answerType','controlType'));
    }

    /**
     * Create a Control.
     *
     * @return Response
     */
    public function create()
    {
        $control = new Control;
        if (request()->section){
          $control->section_id=(int)request()->section;
        }
        $sections = Section::all();
        $controlTypes = Control::types;
        $answerTypes = Control::answerTypes;
        return view('admin/control/create',compact('control','sections','answerTypes','controlTypes'));
    }

    /**
     * Create a new Control.
     *
     * @return Control $control
     * @return Response
     */
    public function store(Control $control)
    {
        // Validate the request...
        request()->validate($this->validation);

        $control->control_number = request()->control_number;
        $control->section_id = request()->section_id;
        $control->order = request()->order;
        $control->description = request()->description;
        $control->question = request()->question;
        $control->control_type = request()->control_type;
        $control->answer_type = request()->answer_type;
        //optional
        $control->video_ref = request()->video_ref;
        $control->how_to_answer = request()->how_to_answer;
        $control->additional_text = request()->additional_text;
        $control->nist_controls = request()->nist_controls?:'';
        $control->isoiec_controls = request()->isoiec_controls?:'';
        $control->document_req = request()->document_req?:false;
        $control->guidance = request()->guidance?:'';


        $control->save();

        alert()->success('Success','Saved');
        return redirect()->route('admin.control',$control->id);
    }

    /**
     * Show a Control edit page.
     *
     * @return Control $control
     * @return Response
     */
    public function edit(Control $control)
    {
        $sections = Section::all();
        $controlTypes = Control::types;
        $answerTypes = Control::answerTypes;
        return view('admin/control/edit',compact('control','sections','answerTypes','controlTypes'));
    }

    /**
     * Update a Control
     *
     * @return Control $control
     * @param  Request  $request
     * @return Response
     */
    public function update(Control $control)
    {
      request()->validate($this->validation);

      $control->control_number = request()->control_number;
      $control->section_id = request()->section_id;
      $control->order = request()->order;
      $control->description = request()->description;
      $control->question = request()->question;
      $control->control_type = request()->control_type;
      $control->answer_type = request()->answer_type;
      //optional
      $control->video_ref = request()->video_ref;
      $control->how_to_answer = request()->how_to_answer;
      $control->additional_text = request()->additional_text;
      $control->nist_controls = request()->nist_controls;
      $control->isoiec_controls = request()->isoiec_controls;
      $control->document_req = request()->document_req?:false;
      $control->save();

      alert()->success('Success','Updated');
      return redirect()->route('admin.control',$control->id);
    }

    /**
     * Remove a Control
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
    }


}
