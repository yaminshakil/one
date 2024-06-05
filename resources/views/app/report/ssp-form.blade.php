@extends('layouts.report')

@section('title',config('app.name').': Reports')

@section('content')
<div class="container" style="width:100%">
        <h1>System Security Plan Pre-flight Check</h1>

        @if ($completed!==true)
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class="panel-title">Warning</h3>
          </div>
          <div class="panel-body">
            <p>
              You have not finished answering all the controls. Your SSP will not be valid.
            </p>
            <p>
              <a href="{{ route('app') }}" class='btn btn-danger'>Dashboard</a>
            </p>
          </div>
        </div>
        @endif

        <form method="POST" action="{{ route('report.ssp.generate')}}">
          {{ csrf_field() }}

          <ssp :user="user" inline-template><div>
          <div class="panel-body">

            <div class="row">

              <div class='form-group'>
                <label for='org_name' class='col-sm-3 required'>Organization Name</label>
                <div class='col-sm-9 @if ($errors->has('org_name')) has-error @endif'>
                  <input class='form-control' type='text' id='org_name' name='org_name' placeholder='Value' value='{{ old('org_name')?:$team->org_name?:$team->org_name }}' required>
                  <span class="help-block small">
                      {{ $errors->first('org_name') }}
                  </span>
                </div>
                <label for='sys_name' class='col-sm-3 required'>Information System Name/Title</label>
                <div class='col-sm-9 @if ($errors->has('sys_name')) has-error @endif'>
                  <input class='form-control' type='text' id='sys_name' name='sys_name' placeholder='Value' value='{{ old('sys_name')?:$team->sys_name?:$team->sys_name }}' required>
                  <span class="help-block small">
                      {{ $errors->first('sys_name') }}
                  </span>
                </div>
              </div>

            </div>
            <div class="row">

              <div class='form-group col-sm-6'>
                <h3 class='col-xs-12 required'>Information System Owner</h3>
                <small class='col-xs-12'>The person who owns the system.</small>
                <label for='owner_name' class='col-sm-3 required'>Name</label>
                <div class='col-sm-9 @if ($errors->has('owner_name')) has-error @endif'>
                  <input class='form-control' maxlength="128" type='text' id='owner_name' name='owner_name' placeholder='Name' value='{{ old('owner_name')?:$team->owner_name?:$user->name }}' required>
                  <span class="help-block small">
                      {{ $errors->first('owner_name') }}
                  </span>
                </div>
                <label for='owner_title' class='col-sm-3 required'>Title</label>
                <div class='col-sm-9 @if ($errors->has('owner_title')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='owner_title' name='owner_title' placeholder='Title' value='{{ old('owner_title')?:$team->owner_title }}' required>
                  <span class="help-block small">
                      {{ $errors->first('owner_title') }}
                  </span>
                </div>
                <label for='owner_company' class='col-sm-3 required'>Company</label>
                <div class='col-sm-9 @if ($errors->has('owner_company')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='owner_company' name='owner_company' placeholder='Company' value='{{ old('owner_company')?:$team->owner_company?:$team->org_name }}' required>
                  <span class="help-block small">
                      {{ $errors->first('owner_company') }}
                  </span>
                </div>
                <label for='owner_address1' class='col-sm-3 required'>Address 1</label>
                <div class='col-sm-9 @if ($errors->has('owner_address1')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='owner_address1' name='owner_address1' placeholder='1 Main Street' value='{{ old('owner_address1')?:$team->owner_address1?:$team->org_address1 }}' required>
                  <span class="help-block small">
                      {{ $errors->first('owner_address1') }}
                  </span>
                </div>
                <label for='owner_address2' class='col-sm-3'>Address 2</label>
                <div class='col-sm-9 @if ($errors->has('owner_address2')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='owner_address2' name='owner_address2' placeholder='' value='{{ old('owner_address2')?:$team->owner_address2?:$team->org_address2 }}'>
                  <span class="help-block small">
                      {{ $errors->first('owner_address2') }}
                  </span>
                </div>
                <label for='owner_city' class='col-sm-3 required'>City</label>
                <div class='col-sm-9 @if ($errors->has('owner_city')) has-error @endif'>
                  <input class='form-control' maxlength="32" type='text' id='owner_city' name='owner_city' placeholder='' value='{{ old('owner_city')?:$team->owner_city?:$team->org_city }}' required>
                  <span class="help-block small">
                      {{ $errors->first('owner_city') }}
                  </span>
                </div>
                <label for='owner_state' class='col-sm-3 required'>State</label>
                <div class='col-sm-9 @if ($errors->has('owner_state')) has-error @endif'>
                  <input class='form-control' maxlength="2" type='text' id='owner_state' name='owner_state' placeholder='' value='{{ old('owner_state')?:$team->owner_state?:$team->org_state }}' required>
                  <span class="help-block small">
                      {{ $errors->first('owner_state') }}
                  </span>
                </div>
                <label for='owner_zip' class='col-sm-3 required'>Zip</label>
                <div class='col-sm-9 @if ($errors->has('owner_zip')) has-error @endif'>
                  <input class='form-control' maxlength="10" type='text' id='owner_zip' name='owner_zip' placeholder='' value='{{ old('owner_zip')?:$team->owner_zip?:$team->org_zip }}' required>
                  <span class="help-block small">
                      {{ $errors->first('owner_zip') }}
                  </span>
                </div>
                <label for='owner_email' class='col-sm-3 required'>Email</label>
                <div class='col-sm-9 @if ($errors->has('owner_email')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='owner_email' name='owner_email' placeholder='abc@acme.com' value='{{ old('owner_email')?:$team->owner_email?:$user->email }}' required>
                  <span class="help-block small">
                      {{ $errors->first('owner_email') }}
                  </span>
                </div>
                <label for='owner_phone' class='col-sm-3 required'>Phone</label>
                <div class='col-sm-9 @if ($errors->has('owner_phone')) has-error @endif'>
                  <input class='form-control' maxlength="12" type='text' id='owner_phone' name='owner_phone' placeholder='123-456-7890' value='{{ old('owner_phone')?:$team->owner_phone }}' required>
                  <span class="help-block small">
                      {{ $errors->first('owner_phone') }}
                  </span>
                </div>
              </div>


              <div class='form-group col-sm-6'>
                <h3 class='col-xs-12 required'>Authorizing Official</h3>
                <small class='col-xs-12'>The official designated as the authorizing official, such as owner, CEO, president, etc. </small>
                <label for='authorizing_name' class='col-sm-3 required'>Name</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_name')) has-error @endif'>
                  <input class='form-control' maxlength="128" type='text' id='authorizing_name' name='authorizing_name' placeholder='Name' value='{{ old('authorizing_name')?:$team->authorizing_name }}' required>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_name') }}
                  </span>
                </div>
                <label for='authorizing_title' class='col-sm-3 required'>Title</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_title')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='authorizing_title' name='authorizing_title' placeholder='Title' value='{{ old('authorizing_title')?:$team->authorizing_title }}' required>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_title') }}
                  </span>
                </div>
                <label for='authorizing_company' class='col-sm-3 required'>Company</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_company')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='authorizing_company' name='authorizing_company' placeholder='Company' value='{{ old('authorizing_company')?:$team->authorizing_company?:$team->org_name }}' required>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_company') }}
                  </span>
                </div>
                <label for='authorizing_address1' class='col-sm-3 required'>Address 1</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_address1')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='authorizing_address1' name='authorizing_address1' placeholder='1 Main Street' value='{{ old('authorizing_address1')?:$team->authorizing_address1?:$team->org_address1 }}' required>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_address1') }}
                  </span>
                </div>
                <label for='authorizing_address2' class='col-sm-3'>Address 2</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_address2')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='authorizing_address2' name='authorizing_address2' placeholder='' value='{{ old('authorizing_address2')?:$team->authorizing_address2?:$team->org_address2 }}'>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_address2') }}
                  </span>
                </div>
                <label for='authorizing_city' class='col-sm-3 required'>City</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_city')) has-error @endif'>
                  <input class='form-control' maxlength="32" type='text' id='authorizing_city' name='authorizing_city' placeholder='' value='{{ old('authorizing_city')?:$team->authorizing_city?:$team->org_city }}' required>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_city') }}
                  </span>
                </div>
                <label for='authorizing_state' class='col-sm-3 required'>State</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_state')) has-error @endif'>
                  <input class='form-control' maxlength="2" type='text' id='authorizing_state' name='authorizing_state' placeholder='' value='{{ old('authorizing_state')?:$team->authorizing_state?:$team->org_state }}' required>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_state') }}
                  </span>
                </div>
                <label for='authorizing_zip' class='col-sm-3 required'>Zip</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_zip')) has-error @endif'>
                  <input class='form-control' maxlength="10" type='text' id='authorizing_zip' name='authorizing_zip' placeholder='' value='{{ old('authorizing_zip')?:$team->authorizing_zip?:$team->org_zip }}' required>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_zip') }}
                  </span>
                </div>
                <label for='authorizing_email' class='col-sm-3 required'>Email</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_email')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='authorizing_email' name='authorizing_email' placeholder='abc@acme.com' value='{{ old('authorizing_email')?:$team->authorizing_email }}' required>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_email') }}
                  </span>
                </div>
                <label for='authorizing_phone' class='col-sm-3 required'>Phone</label>
                <div class='col-sm-9 @if ($errors->has('authorizing_phone')) has-error @endif'>
                  <input class='form-control' maxlength="12" type='text' id='authorizing_phone' name='authorizing_phone' placeholder='123-456-7890' value='{{ old('authorizing_phone')?:$team->authorizing_phone }}' required>
                  <span class="help-block small">
                      {{ $errors->first('authorizing_phone') }}
                  </span>
                </div>
              </div>

            </div>
            <div class="row">

              <div class='form-group col-sm-6'>
                <h3 class='col-xs-12'>Other Designated Contact</h3>
                <small class='col-xs-12'>Other key personnel, if applicable.</small>
                <label for='other_name' class='col-sm-3'>Name</label>
                <div class='col-sm-9 @if ($errors->has('other_name')) has-error @endif'>
                  <input class='form-control' maxlength="128" type='text' id='other_name' name='other_name' placeholder='Name' value='{{ old('other_name')?:$team->other_name }}' >
                  <span class="help-block small">
                      {{ $errors->first('other_name') }}
                  </span>
                </div>
                <label for='other_title' class='col-sm-3'>Title</label>
                <div class='col-sm-9 @if ($errors->has('other_title')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='other_title' name='other_title' placeholder='Title' value='{{ old('other_title')?:$team->other_title }}' >
                  <span class="help-block small">
                      {{ $errors->first('other_title') }}
                  </span>
                </div>
                <label for='other_company' class='col-sm-3'>Company</label>
                <div class='col-sm-9 @if ($errors->has('other_company')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='other_company' name='other_company' placeholder='Company' value='{{ old('other_company')?:$team->other_company }}' >
                  <span class="help-block small">
                      {{ $errors->first('other_company') }}
                  </span>
                </div>
                <label for='other_address1' class='col-sm-3'>Address 1</label>
                <div class='col-sm-9 @if ($errors->has('other_address1')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='other_address1' name='other_address1' placeholder='1 Main Street' value='{{ old('other_address1')?:$team->other_address1 }}' >
                  <span class="help-block small">
                      {{ $errors->first('other_address1') }}
                  </span>
                </div>
                <label for='other_address2' class='col-sm-3'>Address 2</label>
                <div class='col-sm-9 @if ($errors->has('other_address2')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='other_address2' name='other_address2' placeholder='' value='{{ old('other_address2')?:$team->other_address2 }}'>
                  <span class="help-block small">
                      {{ $errors->first('other_address2') }}
                  </span>
                </div>
                <label for='other_city' class='col-sm-3'>City</label>
                <div class='col-sm-9 @if ($errors->has('other_city')) has-error @endif'>
                  <input class='form-control' maxlength="32" type='text' id='other_city' name='other_city' placeholder='' value='{{ old('other_city')?:$team->other_city }}'>
                  <span class="help-block small">
                      {{ $errors->first('other_city') }}
                  </span>
                </div>
                <label for='other_state' class='col-sm-3'>State</label>
                <div class='col-sm-9 @if ($errors->has('other_state')) has-error @endif'>
                  <input class='form-control' maxlength="2" type='text' id='other_state' name='other_state' placeholder='' value='{{ old('other_state')?:$team->other_state }}'>
                  <span class="help-block small">
                      {{ $errors->first('other_state') }}
                  </span>
                </div>
                <label for='other_zip' class='col-sm-3'>Zip</label>
                <div class='col-sm-9 @if ($errors->has('other_zip')) has-error @endif'>
                  <input class='form-control' maxlength="10" type='text' id='other_zip' name='other_zip' placeholder='' value='{{ old('other_zip')?:$team->other_zip }}'>
                  <span class="help-block small">
                      {{ $errors->first('other_zip') }}
                  </span>
                </div>
                <label for='other_email' class='col-sm-3'>Email</label>
                <div class='col-sm-9 @if ($errors->has('other_email')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='other_email' name='other_email' placeholder='abc@acme.com' value='{{ old('other_email')?:$team->other_email }}' >
                  <span class="help-block small">
                      {{ $errors->first('other_email') }}
                  </span>
                </div>
                <label for='other_phone' class='col-sm-3'>Phone</label>
                <div class='col-sm-9 @if ($errors->has('other_phone')) has-error @endif'>
                  <input class='form-control' maxlength="12" type='text' id='other_phone' name='other_phone' placeholder='123-456-7890' value='{{ old('other_phone')?:$team->other_phone }}' >
                  <span class="help-block small">
                      {{ $errors->first('other_phone') }}
                  </span>
                </div>
              </div>

              <div class='form-group col-sm-6'>
                <h3 class='col-xs-12 required'>Responsible Security Contact</h3>
                <small class='col-xs-12'>Contact informtion of person who is responsible for the security of the system.</small>
                <label for='security_name' class='col-sm-3 required'>Name</label>
                <div class='col-sm-9 @if ($errors->has('security_name')) has-error @endif'>
                  <input class='form-control' maxlength="128" type='text' id='security_name' name='security_name' placeholder='Name' value='{{ old('security_name')?:$team->security_name }}' required>
                  <span class="help-block small">
                      {{ $errors->first('security_name') }}
                  </span>
                </div>
                <label for='security_title' class='col-sm-3 required'>Title</label>
                <div class='col-sm-9 @if ($errors->has('security_title')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='security_title' name='security_title' placeholder='Title' value='{{ old('security_title')?:$team->security_title }}' required>
                  <span class="help-block small">
                      {{ $errors->first('security_title') }}
                  </span>
                </div>
                <label for='security_company' class='col-sm-3 required'>Company</label>
                <div class='col-sm-9 @if ($errors->has('security_company')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='security_company' name='security_company' placeholder='Company' value='{{ old('security_company')?:$team->security_company?:$team->org_name }}' required>
                  <span class="help-block small">
                      {{ $errors->first('security_company') }}
                  </span>
                </div>
                <label for='security_address1' class='col-sm-3 required'>Address 1</label>
                <div class='col-sm-9 @if ($errors->has('security_address1')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='security_address1' name='security_address1' placeholder='1 Main Street' value='{{ old('security_address1')?:$team->security_address1?:$team->org_address1 }}' required>
                  <span class="help-block small">
                      {{ $errors->first('security_address1') }}
                  </span>
                </div>
                <label for='security_address2' class='col-sm-3'>Address 2</label>
                <div class='col-sm-9 @if ($errors->has('security_address2')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='security_address2' name='security_address2' placeholder='' value='{{ old('security_address2')?:$team->security_address2?:$team->org_address2 }}'>
                  <span class="help-block small">
                      {{ $errors->first('security_address2') }}
                  </span>
                </div>
                <label for='security_city' class='col-sm-3 required'>City</label>
                <div class='col-sm-9 @if ($errors->has('security_city')) has-error @endif'>
                  <input class='form-control' maxlength="32" type='text' id='security_city' name='security_city' placeholder='' value='{{ old('security_city')?:$team->security_city?:$team->org_city }}' required>
                  <span class="help-block small">
                      {{ $errors->first('security_city') }}
                  </span>
                </div>
                <label for='security_state' class='col-sm-3 required'>State</label>
                <div class='col-sm-9 @if ($errors->has('security_state')) has-error @endif'>
                  <input class='form-control' maxlength="2" type='text' id='security_state' name='security_state' placeholder='' value='{{ old('security_state')?:$team->security_state?:$team->org_state }}' required>
                  <span class="help-block small">
                      {{ $errors->first('security_state') }}
                  </span>
                </div>
                <label for='security_zip' class='col-sm-3 required'>Zip</label>
                <div class='col-sm-9 @if ($errors->has('security_zip')) has-error @endif'>
                  <input class='form-control' maxlength="10" type='text' id='security_zip' name='security_zip' placeholder='' value='{{ old('security_zip')?:$team->security_zip?:$team->org_zip }}' required>
                  <span class="help-block small">
                      {{ $errors->first('security_zip') }}
                  </span>
                </div>
                <label for='security_email' class='col-sm-3 required'>Email</label>
                <div class='col-sm-9 @if ($errors->has('security_email')) has-error @endif'>
                  <input class='form-control' maxlength="64" type='text' id='security_email' name='security_email' placeholder='abc@acme.com' value='{{ old('security_email')?:$team->security_email }}' required>
                  <span class="help-block small">
                      {{ $errors->first('security_email') }}
                  </span>
                </div>
                <label for='security_phone' class='col-sm-3 required'>Phone</label>
                <div class='col-sm-9 @if ($errors->has('security_phone')) has-error @endif'>
                  <input class='form-control' maxlength="12" type='text' id='security_phone' name='security_phone' placeholder='123-456-7890' value='{{ old('security_phone')?:$user->phone }}' required>
                  <span class="help-block small">
                      {{ $errors->first('security_phone') }}
                  </span>
                </div>
                </div>
              </div>

            </div>
            <div class="row">

              <div class='form-group'>
                <h3 class='col-xs-12 required'>Information System Operational Status</h3>
                <small class='col-xs-12'>Indicate the operational status of the system. If more than one status is selected, list which part of the system is covered under each status.</small>
                <div class="row">
                  <div class='col-xs-1 text-right'>
                    <input type="checkbox" v-model="opstatus_op"/>
                  </div>
                  <label for='op_status_operational' class='col-sm-2'>Operational</label>
                  <div class='col-sm-8 @if ($errors->has('op_status_operational')) has-error @endif' v-if="opstatus_op==true">
                    <input class='form-control' type='text' id='op_status_operational' name='op_status_operational' placeholder='' value='{{ old('op_status_operational')?:$team->op_status_operational }}' >
                  </div>
                </div>
                <div class="row">
                  <div class='col-xs-1 text-right'>
                    <input type="checkbox" v-model="opstatus_ud"/>
                  </div>
                  <label for='op_status_dev' class='col-sm-2'>Under Development</label>
                  <div class='col-sm-8 @if ($errors->has('op_status_dev')) has-error @endif' v-if="opstatus_ud==true">
                    <input class='form-control' type='text' id='op_status_dev' name='op_status_dev' placeholder='' value='{{ old('op_status_dev')?:$team->op_status_dev }}' >
                  </div>
                </div>
                <div class="row">
                  <div class='col-xs-1 text-right'>
                    <input type="checkbox" v-model="opstatus_mm"/>
                  </div>
                  <label for='op_status_majormod' class='col-sm-2'>Major Modification</label>
                  <div class='col-sm-8 @if ($errors->has('op_status_operational') || $errors->has('op_status_dev') || $errors->has('op_status_majormod')) has-error @endif' v-if="opstatus_mm==true">
                    <input class='form-control' type='text' id='op_status_majormod' name='op_status_majormod' placeholder='' value='{{ old('op_status_majormod')?:$team->op_status_majormod }}' >
                  </div>
                </div>
                @if ($errors->has('op_status_operational') || $errors->has('op_status_dev') || $errors->has('op_status_majormod'))
                <span class="help-block small text-error">
                    At least one field must be filled in
                </span>
                @endif
              </div>

            </div>
            <div class="row">

              <div class='form-group'>
                <h3 class='col-xs-12 required'>Information System Type</h3>
                <small class='col-xs-12'>Indicate if the system is a major application or a general support system. If the system contains minor applications, list them below in "General System Description/Purpose".</small>
                <div class='radio col-xs-12 @if ($errors->has('op_sys_type')) has-error @endif'>
                  <label for='op_systype_major'>
                    <input class='radio' type='radio' id='op_sys_type_m' name='op_sys_type' value='Major Application' @if (old('op_sys_type')=='Major Application' || $team->op_sys_type=='Major Application') checked @endif>
                      Major Application
                  </label>
                </div>
                <div class='radio col-xs-12 @if ($errors->has('op_sys_type')) has-error @endif'>
                  <label for='op_systype_general'>
                    <input class='radio' type='radio' id='op_sys_type_g' name='op_sys_type' value='General Support System' @if (old('op_sys_type')=='General Support System' || $team->op_sys_type=='General Support System') checked @endif>
                      General Support System
                  </label>

                  <span class="help-block small">
                      {{ $errors->first('op_sys_type') }}
                  </span>
                </div>
            </div>

            </div>
            <div class="row">

              <div class='form-group'>
                <h3 class='col-xs-12 required'>General System Description/Purpose</h3>
                <small class='col-xs-12'>Describe the function or purpose of the system and the information processes.</small>
                <div class='col-sm-9 @if ($errors->has('sys_desc')) has-error @endif'>
                  <textarea class='form-control' type='text' id='sys_desc' name='sys_desc' placeholder=''>{{ old('sys_desc')?:$team->sys_desc }}</textarea>
                  <span class="help-block small">
                      {{ $errors->first('sys_desc') }}
                  </span>
                </div>
              </div>

            </div>
            <div class="row">

              <div class='form-group'>
                <h3 class='col-xs-12 required'>System Environment, Boundaries and Relationships/Connections to Other Systems</h3>
                <small class='col-xs-12'>Provide a general description of the technical system and the environment in which the system operates. Include the primary hardware, software, and communications equipment.</small>
                <div class='col-sm-9 @if ($errors->has('sys_env')) has-error @endif'>
                  <textarea class='form-control' type='text' id='sys_env' name='sys_env' placeholder=''>{{ old('sys_env')?:$team->sys_env }}</textarea>
                  <span class="help-block small">
                      {{ $errors->first('sys_env') }}
                  </span>
                </div>
              </div>

            </div>
            <div class="row">

              <div class='form-group'>
                <h3 class='col-xs-12 required'>Information System Security Plan Approval Date</h3>
                <small class='col-xs-7'>Enter the date the system security plan was approved.</small>
                <div class='col-xs-5 @if ($errors->has('ssp_approval_date')) has-error @endif'>
                  <input class='form-control' type='date' id='ssp_approval_date' name='ssp_approval_date' value='{{ old('ssp_approval_date') }}' required>
                  <span class="help-block small">
                      {{ $errors->first('ssp_approval_date') }}
                  </span>
                </div>
              </div>

            </div>
          <hr/>
            <div class="row">
              <div class='form-group col-xs-4 col-xs-offset-2'>
                <input type="submit" class='btn btn-primary' name="Generate SSP" value="Generate & Download"/>
              </div>
              <div class='form-group col-xs-6'>
                <a href="{{ route('app')}}" class='btn btn-warning'>Back</a>
              </div>
            </div>

          </div></div>
          </ssp>
        </form>
        @include('layouts/errors')

</div>
@endsection
