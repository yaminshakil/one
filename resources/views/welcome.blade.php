@extends('spark::layouts.app')

@section('content')
      <div class='top-right-logo hidden-xs hidden-sm' style='position:absolute;top:-8px;right:-60px'>
        <img src="/img/onesevenone-300.png" alt=""/>
      </div>
      <div class='top-right-logo visible-sm-block' style='position:absolute;top:20px;right:-39px'>
        <img src="/img/onesevenone-200.png" alt=""/>
      </div>
      <div class="title m-b-md">
          OneSevenOne
      </div>
      <div class="subtitle m-b-md">
          NIST 800-171 Self-Assessment Solution for Businesses
      </div>

      <div class="container">
      <div class="row">

        <div class="col-sm-4">
          <div class="panel panel-default panel3">
              <div class="panel-heading">
                <a href="{{ route("pre.assessment")}}"><span class="lnr lnr-power-switch"></span><br/>
                  Preassessment</a></div>
              <div class="panel-body text-left">
                Unsure whether you need to do anything about 800-171?
                Take our free <a href="{{ route("pre.assessment")}}">Pre-Assessment</a> to find out.
              </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="panel panel-default panel2">
              <div class="panel-heading"><a href="{{ url("pricing")}}"><span class="lnr lnr-rocket"></span><br/>
                Service Plans</a></div>
              <div class="panel-body text-left">
                Already know that you need to be 800-171 compliant?
                Have a look at our <a href="{{ url("pricing")}}">Service Plans</a> and get started.
              </div>
          </div>
        </div>

        <div class="col-sm-4">
          <div class="panel panel-default panel5">
              <div class="panel-heading"><a href="{{ url("about")}}"><span class="lnr lnr-question-circle"></span><br/>
                Confused</a></div>
              <div class="panel-body text-left">
                Need more information about <strong>NIST 800-171</strong> before continuing?
                Get the <a href="{{ url("about")}}">information</a> you need here.
              </div>
          </div>
        </div>

        <div class="col-sm-1">
        </div>
      </div>
      </div>

      <div class="row"><h1></h1></div>


@endsection
