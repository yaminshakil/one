@extends('admin.layout')
@section('content')
<div class="container admin">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Sections</div>

                <div class="panel-body">
                  <table class="table table-striped table-hover table-condensed">
                    <theader>
                        <tr>
                          <th>Code</th>
                          <th>Name</th>
                        </tr>
                    </theader>
                    <tbody>
                  @foreach ($sections->sortBy('order') as $section)
                      <tr>
                        <td>{{ $section->code }}</td>
                        <th><a href="{{ route('admin.section',$section->id) }}">{{ $section->name }}</a></th>
                      </tr>
                  @endforeach
                    </tbody>
                  </table>
                  <hr/>
                  <p>
                    <a href="{{ route('admin.sections.create') }}">+ Section</a>
                  </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
