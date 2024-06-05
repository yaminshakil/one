<?php

namespace App\Http\Controllers\Settings\Teams;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamInfoController extends Controller
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
     * Update the given team's extra info.
     *
     * @param  Request  $request
     * @param  \Laravel\Spark\Team  $team
     * @return Response
     */
    public function update(Request $request, $team)
    {
        abort_unless($request->user()->ownsTeam($team), 404);

        $this->validate($request, [
            'org_address1' => 'required|string',
            'org_address2' => '',
            'org_city'  => 'required|string',
            'org_state' => 'required|string|size:2',
            'org_zip'   => 'required|string',
            'org_employeecount' => 'required|min:1|integer',

            'org_name' => 'required|string|max:64',
            'sys_name' => 'required|string|max:128',
            'op_sys_type'       => 'required|string|in:Major Application,General Support System',


        ]);

        $team->forceFill([
          'org_name' => $request->org_name,
          'org_address1' => $request->org_address1,
          'org_address2' => $request->org_address2,
          'org_city' => $request->org_city,
          'org_state' => $request->org_state,
          'org_zip' => $request->org_zip,
          'org_employeecount' => $request->org_employeecount,
          'sys_name' => $request->sys_name,
          'op_sys_type' => $request->op_sys_type,
        ])->save();

    }
}
