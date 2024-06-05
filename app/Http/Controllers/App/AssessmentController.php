<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Team;
use App\Section;
use App\Control;
use App\ControlOption;
use App\Answer;
use App\Upload;

class AssessmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function getFileTotals($user)
    {
      $totalfilecount = 0;
      $totalfilesize = 0;
      foreach ($user->teams as $team) {
        $fs = $team->getFiles();
        foreach($fs as $f){
          $totalfilecount++;
          $totalfilesize += $f->size;
        }
      }
      return [$totalfilecount,$totalfilesize];
    }


    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $user = request()->user();
        if (!$user->currentTeam){
          return redirect('/');
        }
        request()->session()->put('team',$user->currentTeam->id);
        $team = $user->currentTeam;
        if (!$team){
          return redirect('/');
        }
        $controls = Control::all();
        $sections = Section::all();
        $answers = $team->answers;

        //get # and size of files stored
        $files = $team->getFiles();
        $filecount = 0;
        $filesize = 0;
        foreach($files as $file){
          $filecount++;
          $filesize += $file->size;
        }

        //get the file totals
        // list ($totalfilecount, $totalfilesize) = $this->getFileTotals($user);
        //get global file stats
        $totalfilecount = 0;
        $totalfilesize = 0;
        foreach ($user->teams as $team) {
          $fs = $team->getFiles();
          foreach($fs as $f){
            $totalfilecount++;
            $totalfilesize += $f->size;
          }
        }


        return view('app/dashboard',compact('user','team','sections','controls','answers','filesize','filecount','totalfilesize','totalfilecount'));
    }


    /**
     * Show the section tht needs to be answered.
     *
     * @return Response
     */
    public function section()
    {
        $user = request()->user();
        $team = $user->currentTeam;
        $section_id = request()->section;
        $section = Section::find($section_id);
        $controls = $section->controls;
        $answers = $team->answers;

        return view('app/section',compact('user','team','section','controls','answers'));
    }

    /**
     * Show the Question
     *
     * @return Response
     */
    public function control()
    { 
        $user = request()->user();
        $team = $user->currentTeam;
        $control_id = request()->control;
        $control = Control::find($control_id);
        $answer = $control->answers()
          ->where('team_id',$team->id)
          ->where('archived',false)
          ->get()->first();
        if (!$answer){
          $answer = new Answer;
          $answer->control_id = $control_id;
          $answer->team_id = $team->id;
          $answer->locked=false;
          $answer->answer = '';
          $answer->comment = '';
          $answer->option_id = 1;
        }

        $controlTypes = Control::types;
        $answerTypes = Control::answerTypes;

        //Check to see if they are over their storage limit (which is per account, not per assessment)
        $overfilelimit = false;
        //get the file totals
        list ($totalfilecount, $totalfilesize) = $this->getFileTotals($user);
        $limit = $team->sparkPlan()->attribute('storage',0);
        if ($totalfilesize/1024000 > $limit){
          $overfilelimit = true;
        }

        return view('app/control',compact('user','team','control','answer','answerTypes','controlTypes','overfilelimit'));
    }

    /**
     * Save an answer
     *
     */
    public function answer()
    {
        $validation = ['file' => 'mimes:doc,docx,odt,odp,ods,rtf,txt,pdf,ppt,pptx,xls,xlsx,vsd,vsdx,png,jpg'];

        $user = request()->user();
        $team = $user->currentTeam;
        $control_id = request()->control;
        $control = Control::find($control_id);
        $answer = $control->answers()
          ->where('team_id',$team->id)
          ->where('archived',false)
          ->get()->first();
        $answerTypes = Control::answerTypes;
        $messages = '';

        //If this is a new answer, create the object and prepopulate
        if (!$answer){
          $answer = new Answer;
          $answer->control_id = $control_id;
          $answer->team_id = $team->id;
          $answer->locked=false;
          $answer->answer = '';
          $answer->comment = '';
          $answer->option_id = 1;
        }

        //some user changed something so record it
        $answer->user_id=$user->id;

        //Unlock and redirect
        if (request()->unlock=='Unlock'){
          $answer->locked=false;
          $answer->save();
          return redirect()->route('app.control',$control->id);
        }

        if (request()->lock=='Save & Lock'){
          //don't require docs for "N/A" answers
          if ($answerTypes[$control->answer_type]==='Boolean' && (int)request()->answer_int===0){
              if (trim(request()->comment)==''){
                  $messages = 'A comment explaining your N/A response is required before Locking.';
              }
              else{
                  $answer->locked=true;
              }
          }
          //don't require docs for "No" answers
          else if ($answerTypes[$control->answer_type]==='Boolean' && (int)request()->answer_int===-1){
              $answer->locked=true;
          }
          else if ($control->document_req){
            if ($answer->uploadCount()>0 || request()->file('file')){
              $answer->locked=true;
            }
            else{
              $messages = 'A document is required before Locking.';
            }
          }
          else{
            $answer->locked=true;
          }
        }
        switch($answerTypes[$control->answer_type]){
          case 'Boolean':
            $validation['answer_int']='required|integer|max:1|min:-1';
            $answer->answer_int=request()->answer_int;
          break;
          case 'Integer':
            $validation['answer_int']='required|integer|min:0';
            $answer->answer_int=request()->answer_int;
          break;
          case 'ShortText':
            $validation['answer']='required|string|max:255';
            $answer->answer=request()->answer;
          break;
          case 'LongText':
            $validation['answer']='required|string|max:2400';
            $answer->answer=request()->answer;
          break;
          case 'Select List':
          case 'Radio Buttons':
            $validation['option_id']='required|integer|exists:controloptions,id';
            $answer->option_id=request()->option_id;
            $o = ControlOption::find(request()->option_id);
            $answer->answer=$o->name;
          break;
        }

        if (request()->comment!=''){
          $validation['comment']='max:4000';
          $answer->comment=request()->comment;
        }

        request()->validate($validation);

        $answer->save();

        if (request()->file('file')){

          //make sure they are allowed to save more files
          //get the file totals
          list ($totalfilecount, $totalfilesize) = $this->getFileTotals($user);
          $limit = $team->sparkPlan()->attribute('storage',0);
          if ($totalfilesize/1024000 > $limit){
            $messages = $messages.' File not saved. Over storage limit.';
          }
          else{

            $file = request()->file('file');
            $path = $file->store('uploads/'.$team->id);

            $ftitle = request()->file_title;
            if ($ftitle==''){
              $ftitle= $control->control_number." File";
            }
            $upload = new Upload;
            $upload->user_id = $user->id;
            $upload->answer_id = $answer->id;
            $upload->title = $ftitle;
            $upload->name=$file->getClientOriginalName();
            $upload->filename = $path;
            $upload->mimetype=$file->getClientMimeType();
            $upload->size=$file->getClientSize();
            $upload->save();

          }
        }

        if ($messages!=''){
          alert()->info('Note',$messages);
        }
        else{
          alert()->success('Success',($answer->locked===true?'Saved & Locked':'Saved'));
        }

        return redirect()->route('app.section',$control->section_id);
    }

    /**
     * Download a doc that they uploaded
     */
    public function download(Answer $answer, Upload $upload)
    {
        $user = request()->user();
        $team_id = $user->currentTeam->id;

        if ($answer->id!==(int)$upload->answer_id){
            //@TODO:: syslog bad person
            alert()->error('Failure','Do not try to access random files 1');
            return redirect()->route('app');
        }
        if ((int)$answer->team_id!==$team_id){
            //@TODO:: syslog bad person
            alert()->error('Failure','Do not try to access random files 2');
            return redirect()->route('app');
        }

        if (Storage::exists($upload->filename)){
          return Storage::download($upload->filename, $upload->name);
        }

        alert()->error('Failure','File missing');
        return redirect()->route('app.control',$answer->control_id);
    }

    /**
     * Remove an uploaded file (manager/admin only)
     */
    public function deleteupload($controlMD5, Answer $answer, Upload $upload)
    {
        $user = request()->user();
        $team_id = $user->currentTeam->id;

        //validation
        if (md5($answer->control_id)!==$controlMD5){
            //@TODO:: syslog bad person
            alert()->error('Failure','Do not try to delete random files');
            return redirect()->route('app');
        }
        if ($answer->id!==(int)$upload->answer_id){
            //@TODO:: syslog bad person
            alert()->error('Failure','Do not try to delete random files');
            return redirect()->route('app');
        }
        if ($answer->team_id!==$team_id){
            //@TODO:: syslog bad person
            alert()->error('Failure','Do not try to delete random files');
            return redirect()->route('app');
        }

        Storage::delete($upload->filename);
        $upload->delete();
        alert()->success('Success','File Deleted');
        return redirect()->route('app.control',$answer->control_id);
    }


}
