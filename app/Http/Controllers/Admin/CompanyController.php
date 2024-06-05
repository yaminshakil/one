<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Riazxrazor\LaravelSweetAlert\LaravelSweetAlert;

use App\Company;

class CompanyController extends Controller
{

    public $validation = [
      'name' => 'required|string|max:255',
      'contact_email' => 'required|string|email|max:255',
      'account' => 'required|string|max:255',
      'key' => 'required|string|max:255',
      'allowed_users' => 'required|integer|min:1|max:255',
      'expires_on' => 'required|date'
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
     * Show the Companies page.
     *
     * @return Response
     */
    public function index()
    {
        $companies = Company::orderBy('name','desc')->paginate(15);
        return view('admin/company/index', compact('companies'));
    }

    /**
     * Show a Company page.
     *
     * @return Company $company
     * @return Response
     */
    public function show(Company $company)
    {
        return view('admin/company/view', compact('company'));
    }


    /**
     * Create a Company.
     *
     * @return Response
     */
    public function create()
    {
        $company = new Company;
        $company->expires_on= new \Carbon\Carbon();
        return view('admin/company/create',compact('company'));
    }

    /**
     * Create a new Company.
     *
     * @return Response
     */
    public function store()
    {
        // Validate the request...
        request()->validate($this->validation);

        $company = new Company;

        $company->name = request()->name;
        $company->contact_email = request()->contact_email;
        $company->account = request()->account;
        $company->key = request()->key;
        $company->allowed_users = request()->allowed_users;
        $company->expires_on = request()->expires_on;

        $company->save();

        LaravelSweetAlert::setMessageSuccess("Saved");
        return redirect()->route('admin.company',$company->id);
    }

    /**
     * Show a Company edit page.
     *
     * @return Company $company
     * @return Response
     */
    public function edit(Company $company)
    {
        return view('admin/company/edit', compact('company'));
    }

    /**
     * Update a Company
     *
     * @return Company $company
     * @return Response
     */
    public function update(Company $company)
    {
      request()->validate($this->validation);

      $company->name = request()->name;
      $company->contact_email = request()->contact_email;
      $company->account = request()->account;
      $company->key = request()->key;
      $company->allowed_users = request()->allowed_users;
      $company->expires_on = request()->expires_on;

      $company->save();

      LaravelSweetAlert::setMessageSuccess("Updated");
      return redirect()->route('admin.company',$company->id);
    }

    /**
     * Remove a Company
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {

    }



}
