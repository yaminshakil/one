<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ControlOption;
use App\Control;

class OptionController extends Controller
{

    public $validation = [
      'name' => 'required|string|max:255',
      'order' => 'required|integer|min:0|max:50',
      'risk' => 'present',
      'control_id' => 'required|integer|exists:controls,id',
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
     * Show the ControlOptions for a given control.
     *
     * @return Response
     */
    public function index($control)
    {
        $options = ControlOption::where('control_id',$control)->orderBy('order','asc')->get();
        return $options;
    }

    /**
     * Display Create an Option page.
     *
     * @return Response
     */
    public function create()
    {
        $option = new ControlOption;
        if (request()->control){
          $option->control_id=(int)request()->control;
        }
        $answerTypes = Control::answerTypes;
        return view('admin/option/create',compact('option','answerTypes'));
    }

    /**
     * Create a new Option.
     *
     * @return Response
     */
    public function store()
    {
        // Validate the request...
        request()->validate($this->validation);

        if (!request()->control || request()->control!=request()->control_id){
          //they are messing with the form
          return redirect()->route('admin.home');
        }

        $option = new ControlOption;
        $option->control_id = request()->control_id;
        $option->name = request()->name;
        $option->order = (int)request()->order;
        if (!request()->risk){
          $option->risk = 0;
        }
        else{
          $option->risk = request()->risk;
        }
        $option->save();

        alert()->success('Success','Saved');
        return redirect()->route('admin.control',request()->control_id);
    }

    /**
     * Show a Option edit page.
     *
     * @return Response
     */
    public function edit($controlid, $optionid)
    {
        $option = ControlOption::find($optionid);
        $answerTypes = Control::answerTypes;
        return view('admin/option/edit',compact('option','answerTypes'));
    }


    /**
     * Update an Option
     *
     * @param  int $id
     * @return Response
     */
    public function update($control_id, $option_id)
    {
      request()->validate($this->validation);

      $option = ControlOption::find($option_id);
      $option->name = request()->name;
      $option->order = (int)request()->order;
      if (!request()->risk){
        $option->risk = 0;
      }
      else{
        $option->risk = request()->risk;
      }
      $option->save();

      alert()->success('Success','Updated');
      return redirect()->route('admin.control',request()->control_id);
    }

}
