<!-- Left Side Of Navbar -->
@if (Auth::guest())
    <li><a href="{{ url('/') }}">Home</a></li>
    <li><a href="{{ url('/about') }}">About</a></li>
    <li><a href="{{ url('/pricing') }}">Pricing</a></li>
@else
  <li><a href="{{ route('home') }}">Dashboard</a></li>
@endif
<li><a href="https://blog.nist-800-171.com">Blog</a></li>
<li><a href="{{ url('/contact') }}">Contact</a></li>
<li><a href="{{ url('/privacy') }}">Privacy</a></li>
