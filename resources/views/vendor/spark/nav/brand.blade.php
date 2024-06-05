@if (Auth::guest())
  <a class="navbar-brand" href="/">
      <span style="color:red">One</span><span style="color:black">Seven</span><span style="color:red">One</span>
  </a>
@else
  <a class="navbar-brand" href="{{ route('home') }}">
      <span style="color:red">One</span><span style="color:black">Seven</span><span style="color:red">One</span>
  </a>
@endif
