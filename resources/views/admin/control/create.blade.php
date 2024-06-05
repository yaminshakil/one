@extends('admin.layout')

@section('content')
<div class="container admin">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Control</div>

                <div class="panel-body">
                    <form method="POST" action="{{ route('admin.control.create') }}" class='form-horizontal'>
                        {{ csrf_field() }}
                        <div class='form-group'>
                          <label for='section_id' class='col-sm-3'>Section</label>
                          <div class='col-sm-9'>
                            <select class='form-control' name='section_id' id='section_id'>
                              @foreach ($sections as $section)
                              <option value="{{ $section->id }}" @if ($control->section_id==$section->id) selected @endif>{{ $section->code }} {{ $section->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class='form-group'>
                          <label for='control_type' class='col-sm-3'>Control Type</label>
                          <div class='col-sm-9'>
                            <select class='form-control' name='control_type' id='control_type'>
                              @foreach ($controlTypes as $id=>$val)
                              <option value="{{ $id }}" @if ($control->control_type==$id) selected @endif>{{ $val }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='control_number' class='col-sm-3'>Number</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='text' id='control_number' name='control_number' placeholder='eg. 3.4.5' value='{{ old('control_number') }}' required>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='order' class='col-sm-3'>Order</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='number' id='order' name='order' placeholder='Sort/Display Order' value='{{ old('order') }}' required>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='description' class='col-sm-3'>Description</label>
                          <div class='col-sm-9'>
                            <textarea class='form-control' id='description' name='description' placeholder='NIST 800-171 Text' required>{{ old('description') }}</textarea>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='question' class='col-sm-3'>Question</label>
                          <div class='col-sm-9'>
                            <textarea class='form-control' id='question' name='question' placeholder='What we are asking the client' required>{{ old('question') }}</textarea>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='section_id' class='col-sm-3'>Answer Type</label>
                          <div class='col-sm-9'>
                            <select class='form-control' name='answer_type' id='answer_type'>
                              @foreach ($answerTypes as $id=>$val)
                              <option value="{{ $id }}" @if ($control->answer_type==$id) selected @endif>{{ $val }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class='form-group'>
                          <label for='document_req' class='col-sm-3'>Documentation Required</label>
                          <div class='col-sm-9 text-left'>
                              <input type="checkbox" name="document_req" id="document_req" value="1"
                              @if (old('document_req'))
                                checked="checked"
                              @endif>
                              Are documents needed to substantiate the answer?
                          </div>
                        </div>

                        <div class='form-group'>
                          <label for='how_to_answer' class='col-sm-3'>How to Answer</label>
                          <div class='col-sm-9'>
                            <textarea class='form-control' id='how_to_answer' name='how_to_answer' placeholder='Helpful clues what a client should consider when answering' required>{{ old('how_to_answer') }}</textarea>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='additional_text' class='col-sm-3'>Additional Text</label>
                          <div class='col-sm-9'>
                            <textarea class='form-control' id='additional_text' name='additional_text' placeholder='Any supplemental text about the control'>{{ old('additional_text') }}</textarea>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='nist_controls' class='col-sm-3'>NIST Controls</label>
                          <div class='col-sm-9'>
                            <textarea class='form-control' id='nist_controls' name='nist_controls' placeholder='NIST related controls for reference'>{{ old('nist_controls') }}</textarea>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='nist_controls' class='col-sm-3'>ISO/IEC27991 Controls</label>
                          <div class='col-sm-9'>
                            <textarea class='form-control' id='isoiec_controls' name='isoiec_controls' placeholder='Relevant security controls'>{{ old('isoiec_controls') }}</textarea>
                          </div>
                        </div>
                        <div class='form-group'>
                          <label for='guidance' class='col-sm-3'>SSP Guidance</label>
                          <div class='col-sm-9'>
                            <textarea class='form-control' id='guidance' name='guidance' placeholder='Extra SSP Information'>{{ old('guidance') }}</textarea>
                          </div>
                        </div>

                        <div class='form-group'>
                          <label for='video_ref' class='col-sm-3'>Video Reference</label>
                          <div class='col-sm-9'>
                            <input class='form-control' type='text' id='video_ref' name='video_ref' placeholder='Link to video' value='{{ old('video_ref') }}'>
                          </div>
                        </div>

                        <input type='submit' class='btn btn-default'>
                    </form>

                    @include('layouts/errors')

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
