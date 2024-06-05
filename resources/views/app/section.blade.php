@extends('spark::layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><a href="{{ route('app')}}">{{ $team->name }} Assessment</a>
                    <span class="pull-right"><a href="{{ route('app')}}" title="Nav up"><i class="fa fa-fw fa-btn fa-chevron-up"></i></a>
                </div>

                <assessment-section inline-template>

                <div class="panel-body">

                  <div class="checkbox pull-right">
                    <label class="checkbox-inline small">
                      <input type="checkbox" v-model="hide_completed">
                      <i class="fa fa-fw fa-btn fa-eye" v-if="!hide_completed" title="Hide Completed"></i>
                      <i class="fa fa-fw fa-btn fa-eye-slash" v-if="hide_completed" title="Show Completed"></i>
                    </label>
                  </div>

                      <h3>{{ $section->code }} {{ $section->name }}</h3>
                      <table class="table table-hover">
                        <tbody>
                          @foreach ($controls->sortBy('order') as $control)
                            <tr
                              @foreach ($answers as $answer)
                                @if ($answer->control_id==$control->id && $answer->locked==true)
                                  v-if="hide_completed==false"
                                @endif
                              @endforeach>
                              <td>{{ $control->control_number }}</td>
                              <td class='text-left controldesc'>

                                  <a href="{{ route('app.control',$control->id)}}"> {{ $control->description }} </a>

                              </td>
                              <td class='text-right col-xs-2'>
                                  @foreach ($answers as $answer)
                                    @if ($answer->control_id==$control->id)
                                      @if ($answer->locked==false)
                                        <span class="label label-info">Started</span>
                                      @else
                                        <span class="label label-success">Finished</span>
                                      @endif
                                    @endif
                                  @endforeach
                                    <a href="{{ route('app.control',$control->id)}}">
                                      <i class="fa fa-fw fa-btn fa-chevron-right"></i>
                                    </a>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>

                      <a href="{{ route('app')}}" class="pull-left">
                        <span class="lnr lnr-arrow-left"></span> Back
                      </a>

                </div>

              </assessment-section>

            </div>
        </div>
    </div>
</div>
@endsection
