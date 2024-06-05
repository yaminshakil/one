@extends('spark::layouts.app')

@section('title',config('app.name').': Dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><img src="{{$user->current_team->photo_url}}" class="spark-team-photo"> {{ $user->current_team->name }} Dashboard
                  @if ($user->onGenericTrial())
                    <div class='pull-right'><a class='btn btn-xs btn-danger' href='/settings#/subscription'>Subscribe</a></div>
                  @elseif ($user->current_team->onGenericTrial())
                    <div class='pull-right'> <a class='btn btn-xs btn-danger' href='/settings/{{ str_plural(Spark::teamString()) }}/{{ Auth::user()->currentTeam()->id }}#/subscription'>Subscribe</a> </div>
                  @endif
                  @if (Auth::user()->ownsTeam($user->current_team))
                  <div class='pull-right' style='margin-right:1em'> <a class='btn btn-xs btn-primary' title='Assessment Settings' href='/settings/{{str_plural(Spark::teamString())}}/{{$user->current_team->id}}'><i class="fa fa-fw fa-btn fa-cog"></i></a> </div>
                  @endif
                  <div class='pull-right' style='margin-right:1em'> <a class='btn btn-xs btn-info' target="_blank" title='Getting started video' href='https://blognist800171.files.wordpress.com/2018/04/171-firststeps.mp4'><i class="fa fa-fw fa-btn fa-video-camera"></i></a></div>
                </div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="col-sm-5">

                      <div class="panel panel-info">
                        <div class="panel-heading">Assessment Status</div>
                        <div class="panel-body">
                          <div class="col-xs-7 text-right"><strong>Controls</strong></div>
                          <div class="col-xs-5 text-left">{{ $controls->count() }}</div>
                          <div class="col-xs-7 text-right"><strong>Answered</strong></div>
                          <div class="col-xs-5 text-left">{{ $user->current_team->answeredCount() }}</div>
                          <div class="col-xs-7 text-right"><strong>In progress</strong></div>
                          <div class="col-xs-5 text-left">{{ $user->current_team->answerCount()-$user->current_team->answeredCount() }}</div>
                          <div class="col-xs-12">&nbsp;</div>
                          <div class="col-xs-12">
                            <div class="progress">
                              <div class="progress-bar progress-bar-success"
                                    role="progressbar"
                                    aria-valuenow="{{ (int)($user->current_team->answeredCount()*100/$controls->count()) }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                    style="width: {{ (int)($user->current_team->answeredCount()*100/$controls->count()) }}%">
                              </div>
                              <div class="progress-bar progress-bar-info progress-bar-striped"
                                    role="progressbar"
                                    aria-valuenow="{{ (int)(($user->current_team->answerCount()-$user->current_team->answeredCount())*100/$controls->count()) }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                    style="width: {{ (int)(($user->current_team->answerCount()-$user->current_team->answeredCount())*100/$controls->count()) }}%">
                              </div>
                              <div class="progress-bar progress-bar-warning progress-bar-striped"
                                    role="progressbar"
                                    aria-valuenow="{{ (int)(($controls->count()-$user->current_team->answeredCount())*100/$controls->count()) }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                    style="width: {{ (100 - (int)($user->current_team->answeredCount()*100/$controls->count()) - (int)(($user->current_team->answerCount()-$user->current_team->answeredCount())*100/$controls->count())) }}%">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-info">
                        <div class="panel-heading">Company</div>
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-xs-5 text-left"><strong>Profile</strong></div>
                            <div class="col-xs-5"></div>
                            @if (!($user->current_team->onGenericTrial() || $user->current_team->sparkPlan()->id=='free') && Auth::user()->ownsTeam($user->current_team))
                            <div class="col-xs-2 text-right"><a href="/settings/assessments/{{ $user->current_team->id }}" class="btn @if (!$user->current_team->org_address1)
                              btn-danger
                            @else
                              btn-info
                            @endif btn-xs" title="Update Profile"><span class="lnr lnr-pencil"></span></a></div>
                            @endif
                          </div>
                          <div class="row">
                            <div class="col-xs-5 text-left"><strong>Users</strong></div>
                            <div class="col-xs-5 text-center">{{ $user->current_team->users()->count() }} / {{ $user->current_team->totalPotentialUsers() }} </div>
                            @if (!($user->current_team->onGenericTrial() || $user->current_team->sparkPlan()->id=='free') && Auth::user()->ownsTeam($user->current_team))
                            <div class="col-xs-2 text-right"><a href="/settings/assessments/{{ $user->current_team->id }}#/membership" class="btn btn-info btn-xs" title="Manage Users"><span class="lnr lnr-users"></span></a></div>
                            @endif
                          </div>
                          <div class="row">
                            <div class="col-xs-5 text-left"><strong>Files</strong></div>
                            <div class="col-xs-5 text-center">{{ $filecount }} <span class="text-muted">({{ round($filesize/1024000,2) }}MB)</span>
                              @if ($totalfilesize/900000 > $user->current_team->sparkPlan()->attribute('storage',0))
                                <span class="lnr lnr-warning text-warning" title="Nearing plan limit"></span>
                              @elseif ($totalfilesize/1024000 > $user->current_team->sparkPlan()->attribute('storage',0))
                                <span class="lnr lnr-cross-circle text-danger" title="Over plan limit"></span>
                              @endif
                            </div>

                            @if (!($user->current_team->onGenericTrial() || $user->current_team->sparkPlan()->id=='free') && Auth::user()->ownsTeam($user->current_team))
                            <div class="col-xs-2 text-right"><a href="{{ route('manage.uploads') }}" class="btn
                              @if ($totalfilesize/900000 > $user->current_team->sparkPlan()->attribute('storage',0))
                                btn-warning
                              @elseif ($totalfilesize/1024000 > $user->current_team->sparkPlan()->attribute('storage',0))
                                btn-danger
                              @else
                                btn-info
                              @endif
                              btn-xs" title="Manage Uploads"><span class="lnr lnr-cloud-upload"></span></a></div>
                            @endif
                          </div>
{{--                          <br/>
                          <div class="row">
                            <div class="col-xs-5 text-left"><strong>Account Expires</strong></div>
                            <div class="col-xs-7 text-center">Coming Soon $team->expires_on->diffForHumans()   //   //Auth::user()->subscription('main')->asStripeSubscription()->current_period_end </div>
                          </div>
                          --}}
                        </div>
                      </div>

                      <div class="panel panel-info">
                        <div class="panel-heading">
                          @if ($user->current_team->onGenericTrial() || $user->current_team->sparkPlan()->id=='free')
                            Example
                          @endif
                            Reports
                          </div>
                        <div class="panel-body">
                          <div class="row">
                            <div class="col-xs-8 text-left">POAM Template</div>
                            @if (!($user->current_team->onGenericTrial() || $user->current_team->sparkPlan()->id=='free'))
                              <div class="col-xs-4 text-right">
                                <a href="{{ route('report.poam') }}" title="Download POAM Template" class="btn btn-xs btn-info">
                                  <span class="lnr lnr-arrow-right"></span>
                                </a>
                              </div>
                            @endif
                          </div>
                          <div class="row">
                            <div class="col-xs-8 text-left">System Security Plan</div>
                            @if (!($user->current_team->onGenericTrial() || $user->current_team->sparkPlan()->id=='free'))
                              <div class="col-xs-4 text-right"><a href="{{ route('report.ssp') }}" title="System Security Plan" class="btn btn-xs btn-info"
                                ><span class="lnr lnr-arrow-right"></span></a>
                              </div>
                            @endif
                          </div>
                          <div class="row">
                            <div class="col-xs-8 text-left" title="Zip up all your provided documentation into one bundle.">Documentation Package</div>
                            @if (!($user->current_team->onGenericTrial() || $user->current_team->sparkPlan()->id=='free'))
                              <div class="col-xs-4 text-right"><a href="{{ route('report.zip') }}" title="Download Zip" class="btn btn-xs btn-info"
                                ><span class="lnr lnr-download"></span></a>
                              </div>
                            @endif
                          </div>
                          <div class="row">
                            <div class="col-xs-8 text-left">Missing Documentation</div>
                            @if (!($user->current_team->onGenericTrial() || $user->current_team->sparkPlan()->id=='free'))
                              <div class="col-xs-4 text-right"><a href="{{ route('report.missing') }}" title="Missing Documentation" class="btn btn-xs btn-info"
                                ><span class="lnr lnr-arrow-right"></span></a>
                              </div>
                            @endif
                          </div>
                        </div>
                      </div>


                    </div>

                    <div class="col-sm-7">
                      <h3>Assessment Domains</h3>
                      <table class="table">
                        <tbody>
                          @foreach ($sections->sortBy('order') as $section)
                          <?php $answeredCount = $section->answeredCount($user->current_team->id);
                                $totalCount = $section->controls->count();
                           ?>
                          <tr class="@if ($answeredCount==$totalCount) success text-success @endif">
                            <td>{{ $section->code }}</td><td><a href="{{ route('app.section',$section->id) }}">{{ $section->name }}</a></td>
                            <td>{{ $answeredCount }} / {{ $totalCount }}</td>
                          </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
