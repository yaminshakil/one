@extends('admin.layout')
@section('content')
<div class="container admin">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>

                <div class="panel-body">
                  <table class="table table-striped table-hover table-condensed">
                    <theader>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Company</th>
                          <th>Created</th>
                          <th>Updated</th>
                        </tr>
                    </theader>
                    <tbody>
                  @foreach ($users->sortBy('order') as $user)
                      <tr>
                        <th><a href="{{ route('admin.user',$user->id) }}">{{ $user->name }}</a></th>
                        <td class="small">{{ $user->email }}</td>
                        <td>{{ $user->company }}</td>
                        <td class="small">{{ $user->created_at }}</td>
                        <td class="small">{{ $user->updated_at }}</td>
                      </tr>
                  @endforeach
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
