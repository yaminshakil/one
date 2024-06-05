@extends('layouts.report')

@section('title',config('app.name').': Reports')

@section('content')
<div class="container" style="width:100%">
        <h1>POAM Report <form method="POST" action="{{ route('report.poam.generate')}}" class="pull-right">
          {{ csrf_field() }}
          <input type="submit" class='btn btn-primary' name="Generate POA&M" value="Generate & Download"/>
        </form></h1>

        @if ($controls->count() > $answers->count())
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title">Warning</h3>
          </div>
          <div class="panel-body">
            <p>
              You have not finished answering all the controls. Your POA&amp;M will not be valid.
            </p>
            <p>
              <a href="{{ route('app') }}" class='btn btn-danger'>Dashboard</a>
            </p>
          </div>
        </div>
        @endif

        <table class="table table-bordered table-condensed small">
          <thead>
            <tr>
              <th colspan="16">{{ $team->name }}</th>
            </tr>
            <tr>
              <th colspan="16">&nbsp;</th>
            </tr>
            <tr>
              <th colspan="2">Security Cost Total:</th>
              <th>$0</th>
              <td colspan="13" class="small">(update this formula to span all rows, exclude items with Completed status)</td>
            </tr>
            <tr class="bg-info">
              <th>ID</th>
              <th></th>
              <th>Control</th>
              <th>Risk</th>
              <th>Point of Contact (POC)</th>
              <th>Resources Required</th>
              <th>Resource/Funding Source</th>
              <th>Status</th>
              <th>Accepted Risk</th>
              <th>Entry Date</th>
              <th>Scheduled Completion Date</th>
              <th>Actual Completion Date</th>
              <th>Milestones (e.g. remediation actions) with Completion Dates</th>
              <th>Changes to Milestones</th>
              <th>Identified in Audit or other review?</th>
              <th>Source of Discovery</th>
            </tr>
            <tr class='bg-primary' style='font-size:x-small'>
              <th style="font-weight:100;vertical-align:top"></th>
              <th style="font-weight:100;vertical-align:top">Summarize description of the weakness, vulnerability or area  of non-compliance</th>
              <th></th>
              <th style="font-weight:100;vertical-align:top">Low, Moderate, High</th>
              <th style="font-weight:100;vertical-align:top">Person responsible for the corrective action</th>
              <th style="font-weight:100;vertical-align:top">Specify resources needed beyond current resources to mitigate task (If no new resources are needed, specify $0. (hr x $80))</th>
              <th style="font-weight:100;vertical-align:top">If resource/funding comes from the program, specify "program".  Otherwise, indicate source by program or office.</th>
              <th style="font-weight:100;vertical-align:top">Not Started, Planned, In Progress, Delayed, Cancelled, Completed</th>
              <th style="font-weight:100;vertical-align:top">Yes or No (Must have documentation to support Authorizing Official acceptance of the risk)</th>
              <th style="font-weight:100;vertical-align:top">Enter the date the weaknesses was entered to the POA&amp;M</th>
              <th style="font-weight:100;vertical-align:top">This is permanent and should not be changed.  Rescheduled completion dates should be entered in column G (milestone changes)</th>
              <th style="font-weight:100;vertical-align:top">Enter date that the remediation/corrective action was completed	</th>
              <th style="font-weight:100;vertical-align:top">This is permanent and should not be changed.  Recommendation/Fix to correct the weaknesses.</th>
              <th style="font-weight:100;vertical-align:top">Note any changes to the original corrective action plan and associated milestones.</th>
              <th style="font-weight:100;vertical-align:top">If yes, indicate as such along with the source and date</th>
              <th style="font-weight:100;vertical-align:top">Indicate the method or activity that discovered the weakness. E.g., Security Assessment Report along with date.</th>
            </tr>
          </thead>
          <tbody>
            @php
              $i=0;
            @endphp
            @foreach ($controls as $control)
              @php
                $answer=false;
                foreach ($answers as $a){
                  if ($a->control_id==$control->id){
                    $answer=$a;
                  }
                }
                if ($answer && $answer->answer_int==1){
                  continue;
                }
                $i++;
              @endphp
            <tr>
              <td>{{ $i }}</td>
              <td>{{ $control->description }}</td>
              <td>{{ $control->control_number }}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>@if ($answer!=false)
                {{ $answer->updated_at}}
                @endif
              </td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td>@if ($answer!=false)
                Self-Assessment - {{ $answer->updated_at}}
                @endif
              </td>
              </tr>
            @endforeach
          </tbody>
        </table>

</div>
@endsection
