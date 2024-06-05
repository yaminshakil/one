@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-warning">
                <div class="panel-heading">
                  {{ $user->current_team->name }} Uploads
                </div>

                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-6">

                      <div class="panel panel-warning">
                        <div class="panel-heading">
                          <h3 class="panel-title">Assessment</h3>
                        </div>
                        <div class="panel-body">
                          <strong>Files: </strong>{{ $filecount }}<br/>
                          <strong>Space Used: </strong>{{ round($filesize/1024000,2) }} MB
                        </div>
                      </div>

                    </div>
                    <div class="col-sm-6">

                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h3 class="panel-title">Total</h3>
                        </div>
                        <div class="panel-body">
                          <strong>Files: </strong>{{ $totalfilecount }}<br/>
                          <strong>Space Used: </strong>{{ round($totalfilesize/1024000,2) }} / {{$user->current_team->sparkPlan()->attribute('storage',0)}} MB
                          @if ($totalfilesize/900000 > $user->current_team->sparkPlan()->attribute('storage',0))
                            <span class="lnr lnr-warning text-warning" title="Nearing plan limit"></span>
                          @elseif ($totalfilesize/1024000 > $user->current_team->sparkPlan()->attribute('storage',0))
                            <span class="lnr lnr-cross-circle text-danger" title="Over plan limit"></span>
                          @endif
                        </div>
                      </div>

                    </div>
                  </div>

                  <table class="table text-left">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Size</th>
                        <th>Uploaded</th>
                        <th>By</th>
                        <th>Control</th>
                        <th>&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($files as $file)
                        <tr>
                          <td>{{ $file->name }}</td>
                          <td>{{ round($file->size/1024000,2) }}MB</td>
                          <td>{{ date('Y-m-d h:i:s', strtotime($file->updated_at)) }}</td>
                          <td>{{ $file->username }}</td>
                          <td>
                            <a href="{{ route('app.control',$file->control_id)}}">
                              {{ $file->control_number }}
                            </a>
                          </td>
                          <td>
                            <a href="{{ route("app.download", ['answer'=>$file->answer_id,'upload'=>$file->id])}}" class="btn btn-xs btn-success"><span class="lnr lnr-download"></span></a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>

                  <a href="{{ route('app')}}" class="pull-left">
                    <span class="lnr lnr-arrow-left"></span> Back
                  </a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
