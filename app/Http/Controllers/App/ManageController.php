<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\User;

class ManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('teamSubscribed');
    }

    /**
     * Show the company's uploads
     * @return Response
     */
    public function uploads()
    {
      $user = request()->user();
      $team = $user->currentTeam;
      $files = $team->getFiles();

      $filecount = 0;
      $filesize = 0;
      foreach($files as $file){
        $filecount++;
        $filesize += $file->size;
      }

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

      return view('app/manage/uploads',compact('user','team','files','filecount','filesize', 'totalfilesize', 'totalfilecount'));
    }

}
