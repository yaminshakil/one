@extends('admin.layout')

@section('title',config('app.name').': Admin')

@section('content')
<div class="container admin">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Admin Dashboard</div>

                <div class="panel-body">

                  <div class='col-xs-4'><strong><a href="{{ route('admin.sections') }}">Sections</a></strong></div>

                  @if (Auth::user()->email=='g.wilson@redport-ia.com')
                  <div class='col-xs-4'>
                    Purge user accounts:<br/>
                    <a href='#' class='btn btn-lg btn-danger'>DOOM</a><br/>
                    <small>You don't want to click this.</small>
                  </div>
                  @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
