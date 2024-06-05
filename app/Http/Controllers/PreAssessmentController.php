<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreAssessmentController extends Controller
{

    /**
     * Show the about page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pre/index');
    }

    /**
     * Process the questionarre
     *
     * @return \Illuminate\Http\Response
     */
    public function process()
    {
        return view('pre/process');
    }

}
