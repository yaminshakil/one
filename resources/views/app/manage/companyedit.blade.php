@extends('layouts.management')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-heading">Edit <strong>{{ $company->name }} Profile</strong></div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('manage.company.update') }}" class='form-horizontal'>
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input type='hidden' name='company_id' id='company_id' value='{{ $company->id}}'/>

                        <div class='form-group'>
                          <label for='name' class='col-sm-3'>Name</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='text' id='name' name='name' value='{{ $company->name }}' disabled="disabled">
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='contact_email' class='col-sm-3'>Contact E-Mail</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='email' id='contact_email' name='contact_email' placeholder='Used as login ID' value='{{ old('contact_email') ?? $company->contact_email }}' required>
                          </div>
                        </div>

                        <h4>Set-up Questions</h4>

                        <div class='form-group'>
                          <label for='XXXXXXX' class='col-sm-3'>XXXXXXX</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='text' id='XXXXXXX' name='XXXXXXX' placeholder='StuffGoesHere' value='{{ old('XXXXXXX') ?? $company->XXXXXXX }}' required>
                          </div>
                        </div>

                        <div class='form-group'>
                          <label for='YYYYYYY' class='col-sm-3'>YYYYYYY</label>
                          <div class='col-sm-2'>
                            <input class='form-control' type='number' id='YYYYYYY' name='YYYYYYY' placeholder='NumbersGoesHere' value='{{ old('YYYYYYY') ?? $company->YYYYYYY }}' required>
                          </div>
                        </div>

                        <input type='submit' class='btn btn-primary'>
                    </form>

                    @include('layouts/errors')

                    <a href="{{ route('app')}}" class="pull-left">
                      <span class="lnr lnr-arrow-left"></span> Back
                    </a>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection
