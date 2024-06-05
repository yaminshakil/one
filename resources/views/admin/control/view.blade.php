@extends('admin.layout')

@section('content')
<div class="container admin">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Control: <strong>{{ $control->control_number }} {{ $control->question }}</strong></div>

                <div class="panel-body">
                  <table class="table table-condensed text-left">
                    <tbody>
                      <tr><th>Section</th><td><a href="{{ route('admin.section',$control->section->id) }}">{{ $control->section->code }}</a></td></tr>
                      <tr><th>Number</th><td>{{ $control->control_number }}</td></tr>
                      <tr><th>Requirements</th><td>{{ $controlType }} Security</td></tr>
                      <tr><th>Description</th><td>{{ $control->description }}</td></tr>
                      <tr><th>Question</th><td>{{ $control->question }}</td></tr>
                      <tr><th>Answer</th><td>{{ $answerType }}</td></tr>
                      <tr><th>Order</th><td>{{ $control->order }}</td></tr>
                      <tr><th>Updated</th><td>{{ $control->updated_at }}</td></tr>
                    </tbody>
                  </table>
                  <a href="{{ route('admin.control.edit',$control->id) }}">/ Edit</a>
                </div>
                @if ($answerType=='Boolean')
                @elseif ($answerType=='Integer')
                @elseif ($answerType=='ShortText')
                @elseif ($answerType=='LongText')
                @else
                <div class="panel-body">
                  <h3>Options</h3>
                  <table class="table table-condensed">
                    <thead>
                      <tr><th>Name</th><th class="text-center">Order</th><th class="text-center">Risk</th><th class="text-right">Remove</th></tr>
                    </thead>
                    <tbody>
                      @foreach ($control->options->sortBy('order') as $option)
                        <tr>
                          <td class="text-left"><a href={{ route('admin.option.edit',['control'=>$control,'option'=>$option]) }}>{{ $option->name }}</a></td>
                          <td class="text-center">{{ $option->order }}</td>
                          <td class="text-center">{{ $option->risk }}</td>
                          <td class="text-right">
                            <button type="button" class="btn btn-default btn-sm" aria-label="Remove">
                              <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                            </button>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <a href="{{ route('admin.options.create',$control->id) }}">+ Control Option</a>
                </div>
                @endif


            </div>
        </div>
    </div>
</div>
@endsection
