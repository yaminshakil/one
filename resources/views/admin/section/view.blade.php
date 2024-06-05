@extends('admin.layout')

@section('content')
<div class="container admin">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Section: <strong>{{ $section->name }}</strong></div>

                <div class="panel-body">
                  <table class="table table-condensed">
                    <tbody class="text-left">
                      <tr><th>Name</th><td>{{ $section->name }}</td></tr>
                      <tr><th>Code</th><td>{{ $section->code }}</td></tr>
                      <tr><th>Order</th><td>{{ $section->order }}</td></tr>
                      <tr><th>Created</th><td>{{ $section->created_at }}</td></tr>
                      <tr><th>Updated</th><td>{{ $section->updated_at }}</td></tr>
                    </tbody>
                  </table>
                  <a href="{{ route('admin.section.edit',$section->id) }}">/ Edit</a>
                </div>

                <div class="panel-body">
                  <h3>Controls</h3>
                  <table class="table table-condensed">
                    <thead>
                      <tr><th>Type</th><th>Code</th><th>Control</th></tr>
                    </thead>
                    <tbody>
                      @foreach ($section->controls->sortBy('order') as $control)
                        <tr>
                          <td>{{ $controlTypes[$control->control_type]}}</td>
                          <td><a href={{ route('admin.control',$control->id) }}>{{ $control->control_number }}</a></td>
                          <td class="text-left">{{ substr($control->description,0,60) }}...</td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <a href="{{ route('admin.controls.create',$section->id) }}">+ Control</a>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
