@extends('spark::layouts.app')

@section('title',config('app.name').': Contact')

@section('content')
      <div class="title">
          Contact
      </div>
      <div class="subtitle m-b-md">

      </div>

      <div class="container">
        <div class="row">
          <p>
            We are committed to responding to reasonable requests within 12 hours.
          </p>
        </div>

        <div class="row">

          <div class="col-sm-4">
            <div class="panel panel-default panel4">
                <div class="panel-heading">
                  <span class="lnr lnr-phone-handset"></span><br/>
                  Sales
                </div>
                <div class="panel-body">
                  <p><a target="_blank" href="mailto://sales@redport-ia.com?subject=OneSevenOne%20Sales">sales@redport-ia.com</a></p>
                  <p><a href="tel:703.229.6709">703.229.6709</a></p>
                  <p>&nbsp;</p>
                </div>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="panel panel-default panel7">
                <div class="panel-heading">
                  <span class="lnr lnr-magic-wand"></span><br/>
                  Support
                </div>
                <div class="panel-body">
                  <p><a target="_blank" href="mailto://support@redport-ia.com?subject=OneSevenOne%20Support">support@redport-ia.com</a></p>
                  <p><a href="tel:703.229.6709">703.229.6709</a></p>
                  <p>&nbsp;</p>
                </div>
              </div>
          </div>
          <div class="col-sm-4">
            <div class="panel panel-default panel1">
                <div class="panel-heading">
                  <span class="lnr lnr-envelope"></span><br/>
                  Fan Mail
                </div>
                <div class="panel-body">
                  <p>
                    Redport Information Assurance<br/>
                    814 W. Diamond Ave.<br/>
                    Suite 370<br/>
                    Gaithersburg, MD 20878<br/>
                  </p>
                </div>
              </div>
          </div>



        </div>

        <div class="row"><h1></h1></div>

      </div>

@endsection
