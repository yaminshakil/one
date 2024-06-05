@extends('spark::layouts.app')

@section('title',config('app.name').': Privacy Policy')

@section('content')
      <div class="title">
          Privacy &amp; Security
      </div>
      <div class="subtitle m-b-md">
          Information security is the reason we exist.
      </div>

      <div class="container">
        <div class="row">
          <p>
            This site is 800-171 secure.
            Your data is safe with us!
          </p>
        </div>
        <div class="row">

          <div class="col-sm-6">
            <div class="panel panel-default panel4">
                <div class="panel-heading">
                  <span class="lnr lnr-eye"></span><br/>
                  Privacy
                </div>
                <div class="panel-body">
                  Is it secret?
                </div>
                <ul class="list-group">
                  <li class="list-group-item">
                    <h4 class="list-group-item-heading">SSL Connections</h4>
                    <p class="list-group-item-text">
                      Industry standard SSL certificates are used for end-to-end encryption of all communication between your browser and our server.
                    </p>
                  </li>
                  <li class="list-group-item">
                    <h4 class="list-group-item-heading">Cookie Encryption</h4>
                    <p class="list-group-item-text">
                      Cookies are encrypted and only used to manage your experience on the site.
                    </p>
                  </li>
                  <li class="list-group-item">
                    <h4 class="list-group-item-heading">Data Encrypted at Rest</h4>
                    <p class="list-group-item-text">
                      Both our filestores and database are encrypted should someone manage to find this hard drive among the millions of servers in the Amazon cloud infrastructure.
                    </p>
                  </li>
                  <li class="list-group-item">
                    <h4 class="list-group-item-heading">Cloud Privacy</h4>
                    <p class="list-group-item-text">
                      For more information on AWS cloud security please see the
                      <a href="https://aws.amazon.com/compliance/data-privacy-faq/" target="_blank">AWS Data Privacy</a> site.
                    </p>
                  </li>
                </ul>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="panel panel-default panel7">
                <div class="panel-heading">
                  <span class="lnr lnr-lock"></span><br/>
                  Data Security
                </div>
                <div class="panel-body">
                  Is it safe?
                </div>
                <ul class="list-group">
                  <li class="list-group-item">
                    <h4 class="list-group-item-heading">CSRF Token Verification</h4>
                    <p class="list-group-item-text">
                      All forms are CSRF token tagged to prevent forgery attempts.
                    </p>
                  </li>
                  <li class="list-group-item">
                    <h4 class="list-group-item-heading">Login Throttling</h4>
                    <p class="list-group-item-text">
                      Brute force attempts against our server are automatically throttled to reduce the chance a client's password can be compromised.
                    </p>
                  </li>
                  <li class="list-group-item">
                    <h4 class="list-group-item-heading">Cloud Security</h4>
                    <p class="list-group-item-text">
                      For more information on AWS cloud security please see the
                      <a href="https://aws.amazon.com/security/" target="_blank">AWS Cloud Security</a> site.
                    </p>
                  </li>



                </ul>
              </div>
          </div>
        </div>

        <div class="row text-left">
          {!! $privacy !!}
        </div>



      </div>

@endsection
