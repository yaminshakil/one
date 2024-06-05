@extends('spark::layouts.app')

@section('title',config('app.name').': About')

@section('content')
      <div class="title">
          About OneSevenOne
      </div>
      <div class="subtitle m-b-md">
          You have questions
      </div>

      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="media">
              <div class="media-left">
                <a href="https://redport-ia.com" target="_blank">
                  <img class="media-object" src="/img/oso-circle-s.png" alt="OneSevenOne Logo">
                </a>
              </div>
              <div class="media-body">
                <h4 class="media-heading">OneSevenOne</h4>
                OneSevenOne was launched in 2017 by <a href="https://redport-ia.com" target="_blank">Redport Information Assurance LLC</a>
                (Redport) with the goal to allow companies the ability to self-assess and self-certify
                for the NIST Special Publication 800-171 Security Guidelines. The ability to self-
                assess and self-certify through OneSevenOne drastically reduces overhead and
                provides immediate due diligence evidence for audits.
                <p>
                  Federal guidelines and requirements can be a tricky world to navigate.
                </p>
                <p>
                  Feel free to take our <a href="{{ url('/pre-assessment')}}">pre-assessment</a> to see if you need to perform an assessment.
                </p>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="media">
              <div class="media-body">
                <h4 class="media-heading">Redport</h4>
                <a href="https://redport-ia.com" target="_blank">Redport Information Assurance LLC</a> is a Service-Disabled Veteran-Owned Small
                Business (SDVOSB) established in 2010 as an information assurance and cyber
                security solutions provider offering integrated business solutions for all levels of
                government and commercial entities. To effectively thwart information assurance
                threats, we offer risk analysis and technical administrative services to ensure your
                organization fulfills the legal requirements of due diligence for data protection.
              </div>
              <div class="media-right">
                <a href="https://redport-ia.com" target="_blank">
                  <img class="media-object" src="/img/rp-circle-s.png" alt="Redport">
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-sm-offset-3">
            <div class="embed-responsive embed-responsive-4by3">
              <iframe width="560" height="315" src="https://videopress.com/embed/KXZiU39b" frameborder="0" allowfullscreen class="embed-responsive-item"></iframe>
            </div>
          </div>
        </div>
        <div class="row">
          &nbsp;
        </div>
        <div class="row">
          <ul class="list-group">
            <li class="list-group-item">
              <h4 class="list-group-item-heading">How does 800-171 relate to FISMA?</h4>
              <p class="list-group-item-text">
                NIST 800-171 was developed by NIST to further its statutory responsibilities under the Federal Information Security Modernization Act (FISMA) of 2014, 44 U.S.C. § 3541 et seq., Public Law (P.L.) 113-283.
                Whereas FISMA was developed for federal agencies, 800-171 is specifically for <strong>nonfederal</strong> information systems and companies.
              </p>
            </li>
            <li class="list-group-item">
              <h4 class="list-group-item-heading">What do you do with my information?</h4>
              <p class="list-group-item-text">
                Your data is your data.
                We will not look at it unless we have your written approval.
                Make sure to have a look at our <a href="{{ url('privacy')}}">Privacy</a> and Security policies.
              </p>
            </li>
            <li class="list-group-item">
              <h4 class="list-group-item-heading">Where can I find more information about NIST 800-171?</h4>
              <p class="list-group-item-text">Go to the source:
                <a target="_blank" href="http://nvlpubs.nist.gov/nistpubs/SpecialPublications/NIST.SP.800-171r1.pdf">Special Publication NIST.SP.800-171r1.pdf <span class="lnr lnr-link"></span></a>
              </p>
            </li>
          </ul>
        </div>
      </div>

      <div class="row"><h1></h1>
        <p>
          If your question isn't answered here, check out our <a href="https://blog.nist-800-171.com/">blog</a> or please <a href="{{ url('/contact')}}">contact us</a>.
        </p>
      </div>


@endsection
