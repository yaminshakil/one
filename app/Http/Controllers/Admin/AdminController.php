<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Team;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        //@TODO: create redport admin middleware
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $teams = Team::all();

        // $exp = \Illuminate\Support\Facades\DB::table('companies')
        //   ->whereDate('expires_on', '<', date('Y-m-d',time()+60*60*24*30))->select('id')->get();
        // $expiring = count($exp);
        return view('admin/home',compact('teams'));
    }


    /**
    * A hack to clean out the users from the system.
    * @return Response
    */
    public function purgeUsers()
    {
        $user = request()->user();
        // if ($user->email === 'g.wilson@redport-ia.com'){
        //   $deleted1 = DB::delete('delete from team_users');
        //   $deleted2 = DB::delete('delete from team_subscriptions');
        //   $deleted3 = DB::delete('delete from users');
        //   $deleted4 = DB::delete('delete from teams');
        //   $deleted5 = DB::delete('delete from subscriptions');
        //
        //   alert()->success('Success',"The evil has been purged!\nfvf");
        // }
        // else{
        //   alert()->error('What?','Why are you here?');
        // }
        return view('admin/home',compact('teams'));
    }

}
