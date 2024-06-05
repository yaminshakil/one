@extends('admin.layout')

@section('content')
<div class="container admin">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create {{ $answerTypes[$option->control->answer_type] }} Option for {{ $option->control->control_number}}</div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('admin.options.update',['control'=>$option->control_id,'option'=>$option]) }}" class='form-horizontal'>
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}
                        <input type='hidden' id='control_id' name='control_id' value='{{ $option->control_id }}'>

                        <div class='form-group'>
                          <label for='name' class='col-sm-3'>Option Text</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='text' id='name' name='name' placeholder='Value' value='{{ old('name') ?? $option->name }}' required>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='order' class='col-sm-3'>Order</label>
                          <div class='col-sm-2'>
                            <input class='form-control' type='number' id='order' name='order' min="1" max="50" step="1" value='{{ old('order') ?? $option->order }}' required>
                          </div>
                          <div class='col-sm-7 text-left'>
                            <small class="text-muted">Sort/Display order. Lower at top.</small>
                          </div>
                        </div>

                        <div class='form-group'>
                          <label for='risk' class='col-sm-3'>Risk</label>
                          <div class='col-sm-2'>
                            <input class='form-control' type='number' id='risk' name='risk' min="0" max="10" step="1" value='{{ old('risk') ?? $option->risk }}'>
                          </div>
                          <div class='col-sm-7 text-left'>
                            <small class="text-muted">Optional: 0 = This answer poses no risk. 10 = Answer poses high risk.</small>
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
