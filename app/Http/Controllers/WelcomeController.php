<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Parsedown;

class WelcomeController extends Controller
{
    /**
     * Show the application splash screen.
     *
     * @return Response
     */
    public function show()
    {
        return view('welcome');
    }

    public function privacy()
    {
      return view('privacy', [
          'privacy' => (new Parsedown)->text(file_get_contents(base_path('privacy.md')))
      ]);
    }

}
