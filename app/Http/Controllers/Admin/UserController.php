<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Riazxrazor\LaravelSweetAlert\LaravelSweetAlert;

use App\User;
use App\Company;

class UserController extends Controller
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

    /**
     * Show the users page.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::orderBy('updated_at','desc')->paginate(15);
        return view('admin/user/index', compact('users'));
    }

    /**
     * Show a user page.
     *
     * @return User $user
     * @return Response
     */
    public function show(User $user)
    {
        return view('admin/user/view', compact('user'));
    }


    /**
     * Create a user.
     *
     * @return Response
     */
    public function create()
    {
        $user = new User;
        $companies = Company::all();
        return view('admin/user/create',compact('user','companies'));
    }

    /**
     * Create a new user.
     *
     * @return Response
     */
    public function store()
    {
        // Validate the request...
        request()->validate([
          'name' => 'required|string|max:255',
          'email' => 'required|string|email|max:255|unique:users',
          'password' => 'required|string|min:12',
          'role' => 'required|string|in:guest,user,manager,admin',
          'company_id' => 'required|integer|exists:companies,id'
        ]);

        $user = new User;
        $user->name = request()->name;
        $user->email = request()->email;
        $user->role = request()->role;
        $user->company_id = request()->company_id;
        $user->password = bcrypt(request()->password);
        $user->save();

        LaravelSweetAlert::setMessageSuccess("Saved");
        return redirect()->route('admin.user',$user->id);
    }

    /**
     * Show a user edit page.
     * @return User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $companies = Company::all();
        return view('admin/user/edit', compact('user','companies'));
    }

    /**
     * Update a user
     *
     * @return User $user
     * @return Response
     */
    public function update(User $user)
    {
      request()->validate([
        'name' => 'required|string|max:255',
        'role' => 'required|string|in:guest,user,manager,admin',
        'company_id' => 'required|integer|exists:companies,id'
      ]);

      $user->name = request()->name;
      $user->role = request()->role;
      $user->company_id = request()->company_id;

      if ($user->email !== request()->email){
        request()->validate([
          'email' => 'required|string|email|max:255|unique:users',
        ]);
        $user->email = request()->email;
      }
      if (request()->password){
        request()->validate([
          'password' => 'string|min:12',
        ]);
        $user->password = bcrypt(request()->password);
      }

      $user->save();

      LaravelSweetAlert::setMessageSuccess("Updated");
      return redirect()->route('admin.user',$user->id);
    }

    /**
     * Remove a user
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
    }

}
