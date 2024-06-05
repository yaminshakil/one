@extends('admin.layout')

@section('content')
<div class="container admin">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Section</div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('admin.section.create') }}" class='form-horizontal'>
                        {{ csrf_field() }}
                        <div class='form-group'>
                          <label for='name' class='col-sm-3'>Name</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='text' id='name' name='name' placeholder='Main control area' value='{{ old('name') ?? $section->name }}' required>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='code' class='col-sm-3'>Code</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='text' id='code' name='code' placeholder='Something like "5.4"' value='{{ old('code') ?? $section->code }}' required>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='order' class='col-sm-3'>Order</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='number' id='order' name='order' placeholder='For sorting' value='{{ old('order') ?? $section->order }}' required>
                          </div>
                        </div>
                        <input type='submit' class='btn btn-default'>
                    </form>

                    @include('layouts/errors')

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
