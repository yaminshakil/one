@extends('spark::layouts.app')

@section('title',config('app.name').': Control')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ route('app')}}">{{ $team->name }} Assessment</a>
                  <span class="pull-right"><a href="{{ route('app.section',$control->section_id)}}" title="Nav up"><i class="fa fa-fw fa-btn fa-chevron-up"></i></a>
                </div>

                <div class="panel-body">

                    <div class="row controlpanel">
                      <div class="col-sm-5">
                        <h3 class="controlname"><a href="{{ route('app.section',$control->section_id)}}">{{ $control->section->code }} {{ $control->section->name }}</a></h3>
                        <div class="controltype">{{ $controlTypes[$control->control_type] }} Security Requirements</div>
                      </div>
                      <div class='col-sm-7 text-left' style='margin-top:1em;'>
                        <h4 class="controldesc"><strong>{{ $control->control_number }}</strong> {{ $control->description }}</h4>
                      </div>
                    </div>

                    <div class="row">
                      <div class="@if ($control->video_ref!='')
                      col-sm-9
                    @else
                      col-sm-12
                    @endif">
                        <div class="panel panel-primary">
                          <div class="panel-heading controlquestion">{{ $control->question }}</div>
                          <div class="panel-body">
                            <form method="POST" action="{{ route('app.answer',$control) }}" class='form' enctype="multipart/form-data">
                              {{ csrf_field() }}
                              <div class="row">
                                <div class='form-group'>
                                  @if ($answerTypes[$control->answer_type]=='Boolean')
                                  <!-- Yes/No Booleans -->
                                  <div class='col-sm-4 col-sm-offset-4'>
                                    <select class='form-control' name='answer_int' id='answer_int' required
                                      @if ($answer && $answer->locked)
                                        disabled
                                      @endif>
                                      <option value=""></option>
                                      <option value="1" @if (old('answer_int') || ($answer && $answer->answer_int==1)) selected @endif>Yes</option>
                                      <option value="-1" @if (old('answer_int') || ($answer && $answer->answer_int==-1)) selected @endif>No</option>
                                      <option value="0" @if (old('answer_int') || ($answer && $answer->answer_int==0)) selected @endif>N/A</option>
                                    </select>
                                  </div>
                                  @elseif ($answerTypes[$control->answer_type]=='Integer')
                                  <!-- Integer Input -->
                                  <div class='col-sm-4 col-sm-offset-4'>
                                    <input type="number" step="1" class='form-control' name='answer_int' id='answer_int'
                                      value="{{ old('answer_int') ?? $answer->answer_int }}"
                                      @if ($answer && $answer->locked)
                                        disabled
                                      @endif
                                      >
                                  </div>
                                  @elseif ($answerTypes[$control->answer_type]=='ShortText')
                                  <!-- ShortText -->
                                  <div class='col-sm-10 col-sm-offset-1'>
                                    <input type="text" class='form-control' name='answer' id='answer' placeholder='Short text response'
                                      value="{{ old('answer') ?? $answer->answer }}"
                                      @if ($answer && $answer->locked)
                                        disabled
                                      @endif
                                      >
                                  </div>
                                  @elseif ($answerTypes[$control->answer_type]=='LongText')
                                  <!-- LongText -->
                                  <div class='col-sm-10 col-sm-offset-1'>
                                    <textarea rows="3" class='form-control' name='answer' id='answer' placeholder='Long text response'
                                        @if ($answer && $answer->locked)
                                          disabled
                                        @endif
                                        >{{ old('answer') ?? $answer->answer }}</textarea>
                                  </div>
                                  @elseif ($answerTypes[$control->answer_type]=='Select List')
                                  <!-- LongText -->
                                  <div class='col-sm-10 col-sm-offset-1'>
                                    <select class='form-control' name='option_id' id='option_id' required
                                      @if ($answer && $answer->locked)
                                        disabled
                                      @endif>
                                      <option value=""></option>
                                      @foreach ($control->options as $option)
                                      <option value="{{ $option->id }}" @if (old('answer') || ($answer && $answer->option_id==$option->id )) selected @endif>{{ $option->name }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  @endif
                                  <div class='col-sm-10 col-sm-offset-1'>

                                    <button class="btn btn-primary btn-xs pull-right" type="button" data-toggle="collapse" data-target="#answerComment" title="Add Comment"
                                      aria-expanded="false" aria-controls="answerComment">
                                      <span class="lnr lnr-bubble" alt="Add Comment"></span>
                                    </button>

                                    @if ($control->document_req && !($team->onGenericTrial() || $team->sparkPlan()->id=='free'))
                                      <button class="btn
                                      @if ($overfilelimit)
                                        btn-danger
                                      @else
                                        btn-success
                                      @endif btn-xs pull-right" style='margin-right:1em' type="button" data-toggle="collapse" data-target="#answerFile"
                                      @if ($answer && $answer->locked)
                                        title="Add File (Locked)"
                                      @else
                                        title="Add File"
                                      @endif
                                        aria-expanded="false" aria-controls="answerFile"
                                        @if ($answer && $answer->locked)
                                          disabled
                                        @else
                                        @endif
                                          >
                                        <span class="lnr lnr-upload" alt='Upload File'></span>
                                      </button>
                                    @endif

                                    <div class="{{ ($answer && strlen($answer->comment)>0)?'':'collapse' }}" id="answerComment">
                                      <label for='comment'>Comment</label>
                                      <textarea class="form-control" name='comment' id='comment' rows="3" placeholder="Additional information you want to provide"
                                      @if ($answer && $answer->locked)
                                        disabled
                                      @endif>{{ old('comment') ?? $answer->comment }}</textarea>
                                    </div>

                                    @if ($control->document_req && !($team->onGenericTrial() || $team->sparkPlan()->id=='free'))
                                      <div class="text-center">
                                        <h4>Attached Documents</h4>
                                        @if ($answer->uploadCount())
                                          @foreach ($answer->uploads as $upload)
                                            <div class="row">
                                              <div class="col-sm-3 col-sm-offset-1 col-xs-3 text-left">
                                                {{ $upload->title }}
                                              </div>
                                              <div class="col-sm-5 col-xs-6 text-left">
                                                {{ $upload->name }}
                                              </div>
                                              <div class="col-sm-3 col-xs-3">
                                                <a href="{{ route("app.download", ['answer'=>$answer->id,'upload'=>$upload->id])}}" class="btn btn-xs btn-success" title="Download"><span class="lnr lnr-download"></span></a>
                                                @if ((Auth::user()->ownsTeam($team)) || Auth::user()->can('accessAdmin'))
                                                  @if ($answer->locked)
                                                    <span class="btn btn-xs btn-default lnr lnr-cross" title="Locked"></span>
                                                  @else
                                                    <a href="{{ route("app.upload.delete", ['control'=>md5($control->id),'answer'=>$answer->id,'upload'=>$upload->id])}}" class="btn btn-xs btn-warning" title="Delete"><span class="lnr lnr-cross"></span></a>
                                                  @endif
                                                @endif
                                              </div>
                                          </div>
                                          @endforeach
                                        @else
                                          -none-
                                        @endif
                                      </div>

                                      <div class="collapse" id="answerFile">
                                        <h5 class="text-center text-success">Upload Document, Observation, or Interview Artifact</h5>
                                        @if ($overfilelimit)
                                          <h5 class="text-danger text-center">You are over your plan's file storage limit. Additional uploads are disabled.</h5>
                                        @else
                                          <div class="row">
                                            <label for='file_title' class="col-xs-4">Title</label>
                                            <input type="text" id="file_title" name="file_title" placeholder="Short description" class="col-xs-6"@if ($overfilelimit)
                                              disabled
                                            @endif />
                                          </div>
                                          <div class="row">
                                            <label for='answerFile' class="col-xs-4">File Upload</label>
                                            <input type="file" name="file" class="col-xs-6" @if ($overfilelimit)
                                              disabled
                                            @endif></input>
                                          </div>
                                          <div class="small">Max size: {{ ini_get('post_max_size')}}</div>
                                          <div class="small">Valid formats: doc,docx,odt,odp,ods,rtf,txt,pdf,ppt,pptx,xls,xlsx,vsd,vsdx,png,jpg</div>
                                        @endif
                                      </div>
                                    @endif

                                  </div>

                                </div>
                              </div>
                              <div class="row text-center" style='margin-top:1em;'>
                                @if ($team->onGenericTrial() || $team->sparkPlan()->id=='free')
                                  To save you need to
                                    <a class='btn btn-danger' href='/settings/{{ str_plural(Spark::teamString()) }}/{{ Auth::user()->currentTeam()->id }}#/subscription'>Subscribe</a>
                                @else

                                  @if ($answer && $answer->locked)
                                  <input type="submit" id="unlock" name="unlock" value="Unlock" class='btn btn-warning'
                                  @if (!(Auth::user()->ownsTeam($team)) && !Auth::user()->can('accessAdmin'))
                                    disabled="disabled"
                                  @endif
                                  ><br/>
                                  <small>Locked by {{ $answer->user->name }} on {{ $answer->updated_at }}</small>
                                  @else
                                  <input type="submit" id="save" name="save" value="Save" class='btn btn-info'>
                                  <input type="submit" id="lock" name="lock" value="Save &amp; Lock" class='btn btn-primary'>
                                  @endif

                                @endif
                              </div>
                            </form>
                          </div>
                            @include('layouts/errors')
                        </div>
                      </div>

                      @if ($control->video_ref!='')
                      <div class="col-sm-3" style="padding:1em;">
                          <div class="embed-responsive embed-responsive-4by3 bg-info">
                            <iframe width="560" height="315" src="https://videopress.com/embed/{{ $control->video_ref }}" frameborder="0" allowfullscreen></iframe>
                          </div>
                      </div>
                      @endif


                    </div>


                    <div class="row">
                      @if ($control->how_to_answer!='')
                      <div class="col-xs-9">
                      <div class="panel panel-info">
                        <div class="panel-heading">Supplemental Guidance</div>
                        <div class="panel-body">{!! nl2br(e($control->how_to_answer)) !!}</div>
                      </div>
                      </div>
                      @endif
                      @if ($control->additional_text!='')
                      <div class="col-xs-3">
                      <div class="panel panel-info">
                        <div class="panel-heading">Additional Information</div>
                        <div class="panel-body">{{ $control->additional_text }}</div>
                      </div>
                      </div>
                      @endif
                      @if ($control->nist_controls!='')
                      <div class="col-xs-3">
                      <div class="panel panel-info">
                        <div class="panel-heading">NIST SP 800-53 Relevant Security Controls</div>
                        <div class="panel-body">{{ nl2br($control->nist_controls) }}</div>
                      </div>
                      </div>
                      @endif
                      @if ($control->isoiec_controls!='')
                      <div class="col-xs-3">
                      <div class="panel panel-info">
                        <div class="panel-heading">ISO/IEC 27001 Relevant Security Controls</div>
                        <div class="panel-body">{{ nl2br($control->isoiec_controls) }}</div>
                      </div>
                      </div>
                      @endif
                    </div>

                    <a href="{{ route('app.section',$control->section_id)}}" class="pull-left">
                      <span class="lnr lnr-arrow-left"></span> Back
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
