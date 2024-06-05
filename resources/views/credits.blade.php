@extends('spark::layouts.app')

@section('title',config('app.name').': Credits')

@section('content')
      <div class="title">
          OneSevenOne
      </div>
      <div class="subtitle m-b-md">
          Website Credits
      </div>

      <h3>Frameworks</h3>
      <p>
        <a href="https://laravel.com">Laravel</a>
      </p>
      <p>
        <a href="https://getbootstrap.com">Bootstrap</a>
      </p>

      <h3>Some icons</h3>
      <p>
        https://linearicons.com created by https://perxis.com
      </p>

      <h3>Developers</h3>
      <p>
        Gregory Wilson <a href="https://awnage.com">@awnage</a>
      </p>
      <p>
        Ken Knudsen
      </p>


@endsection
