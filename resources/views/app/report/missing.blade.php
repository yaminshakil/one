@extends('layouts.report')

@section('title',config('app.name').': Reports')

@section('content')
<div class="container">
        <h1>Missing Documentation Report</h1>
        <p>Some questions require you to provide supporting documentation.</p>

        <table class="table table-condensed">
          <thead>
            <tr class="bg-info">
              <th>Control</th>
              <th>Section</th>
              <th>Link</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($controls as $control)
              @php
                // is documentation even required?
                if (!$control->document_req || $control->document_req==='N'){
                  continue;
                }
                //find their answer
                $answer=false;
                foreach ($answers as $a){
                  if ($a->control_id==$control->id){
                    $answer=$a;
                  }
                }
                //did they answer the question?
                if ($answer!==false){
                  //they uploaded documents
                  if ($answer->uploadCount()>0){
                    continue;
                  }
                  //N answers don't require documentation or justification
                  if ($answerTypes[$control->answer_type]==='Boolean' && $answer->answer_int==0){
                    continue;
                  }
                }

              @endphp
            <tr>
              <td><a href="{{ route('app.control',$control) }}" title="View Answer">{{ $control->control_number }}</a></td>
              <td>{{ $control->section->name }}</td>
              <td><a href="{{ route('app.control',$control) }}" title="View Answer"><span class="lnr lnr-arrow-right"></span></a></td>
              </tr>
            @endforeach
          </tbody>
        </table>

</div>
@endsection
