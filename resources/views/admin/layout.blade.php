@extends('spark::layouts.app')

<div class="row">
  <div class="col-xs-5">
    <h2 style='margin-left:1em;'>Admin App Configuration</h2>
  </div>
  <div class="col-xs-1" style='margin-top:2em'>
    <a href="{{ route('admin.home')}}">Home</a>
  </div>
  <div class="col-xs-1" style='margin-top:2em'>
    <a href="{{ route('admin.sections')}}">Sections</a>
  </div>
</div>
<hr class="divider"/>
