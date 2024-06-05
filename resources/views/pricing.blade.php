@extends('spark::layouts.app')

@section('title',config('app.name').': Pricing')

@section('content')
      <div class="title">
          Service Plans
      </div>
      <div class="subtitle m-b-md">
          Everyone likes options
      </div>

      <div class="container">
          <div class="row">
            <div class="col-sm-6">
              Each small business has its own unique needs.
              Additionally, many organizations will only want to perform assessments when they are due.
              Please <a href="{{ url('/contact')}}">contact us</a> if you are unsure which plan best fits your needs.
            </div>
            <div class="col-sm-6">
              Redport offers a special discount code to Veteran Owned Small Businesses (VOSB).
              Please <a href="{{ url('/contact')}}">contact us</a> to receive your discount code.
            </div>
          </div>
          <div class="row">
            <p></p>
          </div>
          <div class="row">

            @foreach (Spark::teamPlans() as $plan)
              @if ($plan->name=='Basic')
              <div class="col-sm-3">
                <a href='/register' style='text-decoration:none'>
                  <div class="panel panel-default panel6">
                      <div class="panel-heading">
                        <span class="lnr lnr-star-empty"></span><br/>
                        {{$plan->name}}
                      </div>
                      <div class="panel-body panel-price">
                        ${{$plan->price}}
                        <div class="sub">/year</div>
                      </div>
                      <div class="panel-body text-left text-muted">
                        @foreach ($plan->features as $feature)
                        <p>{{ $feature }}</p>
                        @endforeach
                      </div>
                      <div class="panel-body text-left text-primary">
                        Best for a small business at one location
                      </div>
                  </div>
                </a>
              </div>
                @break
              @endif
            @endforeach

            @foreach (Spark::teamPlans() as $plan)
              @if ($plan->name=='Standard')
              <div class="col-sm-3">
                <a href='/register' style='text-decoration:none'>
                  <div class="panel panel-default panel3">
                      <div class="panel-heading">
                        <span class="lnr lnr-star-half"></span><br/>
                          {{$plan->name}}
                      </div>
                      <div class="panel-body panel-price">
                        ${{$plan->price}}
                        <div class="sub">/year</div>
                      </div>
                      <div class="panel-body text-left text-muted">
                        @foreach ($plan->features as $feature)
                        <p>{{ $feature }}</p>
                        @endforeach
                      </div>
                      <div class="panel-body text-left text-primary">
                        Ideal for a small business at a couple locations
                      </div>
                  </div>
                </a>
              </div>
                @break
              @endif
            @endforeach

            @foreach (Spark::teamPlans() as $plan)
              @if ($plan->name=='Pro')
              <div class="col-sm-3">
                <a href='/register' style='text-decoration:none'>
                  <div class="panel panel-default panel2">
                      <div class="panel-heading">
                        <span class="lnr lnr-star"></span><br/>
                        {{$plan->name}}
                      </div>
                      <div class="panel-body panel-price">
                        ${{$plan->price}}
                        <div class="sub">/year</div>
                      </div>
                      <div class="panel-body text-left text-muted">
                        @foreach ($plan->features as $feature)
                        <p>{{ $feature }}</p>
                        @endforeach
                        <p>&nbsp;</p>
                      </div>
                      <div class="panel-body text-left text-primary">
                        Great for a medium business with multiple locations
                      </div>
                  </div>
                </a>
              </div>
                @break
              @endif
            @endforeach

            <div class="col-sm-3">
                <div class="panel panel-default panel1">
                    <div class="panel-heading">
                      <span class="lnr lnr-rocket"></span><br/>
                      Consultant Pack
                    </div>
                    <div class="panel-body panel-price">
                      Contact
                      <div class="sub">for pricing</div>
                    </div>
                    <div class="panel-body text-left">
                      <p>1 Consultant User Account</p>
                      <p>50 or 100 Assessments</p>
                      <p>Full Reporting</p>
                      <p>1 Hour Free Consulting</p>
                      <p>15 or 30GB Document Storage</p>
                      <p>&nbsp;</p>
                    </div>
                    <div class="panel-body text-left text-primary">
                      Perfect for a team performing assessments on behalf of clients
                    </div>
                </div>
            </div>

          </div>

        </div>

      <div class="row"><h1></h1></div>

@endsection
