@extends('spark::layouts.app')

@section('title',config('app.name').': Preassessment')

@section('content')
      <div class="title m-b-md">
        Preassessment
      </div>
      <div class="subtitle m-b-md">
        NIST 800-171
      </div>

      <div class="container">
        <div class="row text-left">
            <div class="col-sm-9 col-sm-offset-1">
                    <a href="http://nvlpubs.nist.gov/nistpubs/SpecialPublications/NIST.SP.800-171r1.pdf" target="_blank">
                      NIST Special Publication 800-171</a> deals with
                    "<strong>Protecting Controlled Unclassified Information in Nonfederal Information Systems and Organizations</strong>".
                    Not every company needs to concern themselves with the Controlled Unclassified Information (<abbr title="Controlled Unclassified Information">CUI</abbr>) details of 800-171.
                    Take this quick pre-assessment to see if your organization needs to report on this publication.
            </div>
        </div>
        <div class="row">
                <div class="panel-body col-sm-offset-1">
                  <preassessment :user="user" inline-template>
                    <form class="form-horizontal" method="POST" action='#' id='preassessment'>

                      <div class="form-group">
                        <label class="col-sm-6 text-left">
                          Are you currently covered by other safeguarding requirements such as <abbr title="Federal Information Security Management Act ">FISMA</abbr>?
                        </label>
                        <div class="col-sm-3">
                          <select class="form-control" v-model="covered">
                            <option disabled value=''>Select one</option>
                            <option>Yes</option>
                            <option>No</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <h4>
                            <span class="lnr lnr-layers"
                              v-bind:class="{ 'text-success': covered=='Yes', 'text-danger': covered=='No'}">
                            </span>
                          </h4>
                        </div>
                      </div>

                      <div class="form-group" v-if="covered=='No'">
                        <label class="col-sm-6 text-left">
                          Do you process <abbr title="Controlled Unclassified Information">CUI</abbr>?
                        </label>
                        <div class="col-sm-3">
                          <select class="form-control" v-model="process">
                            <option disabled value=''>Select one</option>
                            <option>Yes</option>
                            <option>No</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <h4>
                            <span class="lnr lnr-keyboard"
                              v-bind:class="{ 'text-danger': process=='Yes', 'text-warning': process=='Unsure', 'text-success': process=='No'}">
                            </span>
                          </h4>
                        </div>
                      </div>



                      <div class="form-group" v-if="covered=='No'">
                        <label class="col-sm-6 text-left">
                          Do you store <abbr title="Controlled Unclassified Information">CUI</abbr>?
                        </label>
                        <div class="col-sm-3">
                          <select class="form-control" v-model="store">
                            <option disabled value=''>Select one</option>
                            <option>Yes</option>
                            <option>No</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <h4>
                            <span class="lnr lnr-database"
                              v-bind:class="{ 'text-danger': store=='Yes', 'text-warning': store=='Unsure', 'text-success': store=='No'}">
                            </span>
                          </h4>
                        </div>
                      </div>


                      <div class="form-group" v-if="covered=='No'">
                        <label class="col-sm-6 text-left">
                          Do you transfer <abbr title="Controlled Unclassified Information">CUI</abbr>?
                        </label>
                        <div class="col-sm-3">
                          <select class="form-control" v-model="transfer">
                            <option disabled value=''>Select one</option>
                            <option>Yes</option>
                            <option>No</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <h4>
                            <span class="lnr lnr-upload"
                              v-bind:class="{ 'text-danger': transfer=='Yes', 'text-warning': transfer=='Unsure', 'text-success': transfer=='No'}">
                            </span>
                          </h4>
                        </div>
                      </div>

                      <div class="form-group" v-if="covered=='No'">
                        <label class="col-sm-6 text-left">
                          Do you provide security protection for processing, storing, or transferring <abbr title="Controlled Unclassified Information">CUI</abbr>?
                        </label>
                        <div class="col-sm-3">
                          <select class="form-control" v-model="provide">
                            <option disabled value=''>Select one</option>
                            <option>Yes</option>
                            <option>No</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <h4>
                            <span class="lnr lnr-camera-video"
                              v-bind:class="{ 'text-danger': provide=='Yes', 'text-warning': provide=='Unsure', 'text-success': provide=='No'}">
                            </span>
                          </h4>
                        </div>
                      </div>
{{--
                      <div class="form-group" v-if="covered=='No'">
                        <label class="col-sm-6 text-left">
                          Does the <abbr title="Controlled Unclassified Information">CUI</abbr> reside in nonfederal or organizational systems?
                        </label>
                        <div class="col-sm-3">
                          <select class="form-control" v-model="reside">
                            <option disabled value=''>Select one</option>
                            <option>Yes</option>
                            <option>No</option>
                            <option>Unsure</option>
                          </select>
                        </div>
                        <div class="col-sm-1">
                          <h4>
                            <span class="lnr lnr-apartment"
                              v-bind:class="{ 'text-danger': reside=='Yes', 'text-warning': reside=='Unsure'}">
                            </span>
                          </h4>
                        </div>
                      </div>
--}}
                      <div class="panel panel-default col-sm-8 col-sm-offset-1" v-if="covered=='No' && (process=='Yes' || store=='Yes' || transfer=='Yes' || provide=='Yes')">
                        <div class="panel-body">
                          <p>
                            You will need to <a href="{{ url('/pricing') }}"> complete an assessment</a>.
                          </p>
                          <p>
                            Per NIST Special Publication 800-171, <em>"The security requirements apply to all components of nonfederal
                            systems and organizations that
                            <span v-bind:class="{'text-danger':process!='No'}">process</span>,
                            <span v-bind:class="{'text-danger':store!='No'}">store</span>,
                            or
                            <span v-bind:class="{'text-danger':transfer!='No'}">transmit</span>
                            CUI, or that
                            <span v-bind:class="{'text-danger':provide!='No'}">provide security protection</span>
                            for such components."</em>
                          </p>
                        </div>
                      </div>


                      <div class="panel panel-default col-sm-8 col-sm-offset-1" v-if="covered=='No' && (process=='No' && store=='No' && transfer=='No' && provide=='No')">
                        <div class="panel-body">
                          <p>
                            You may not need to complete an assessment</a>.
                          </p>
                          <p>
                            Per NIST Special Publication 800-171, <em>"The security requirements apply to all components of nonfederal
                            systems and organizations that
                            <span v-bind:class="{'text-danger':process!='No'}">process</span>,
                            <span v-bind:class="{'text-danger':store!='No'}">store</span>,
                            or
                            <span v-bind:class="{'text-danger':transfer!='No'}">transmit</span>
                            CUI, or that
                            <span v-bind:class="{'text-danger':provide!='No'}">provide security protection</span>
                            for such components."</em>
                          </p>
                          <p>
                            Ensure you have read the <strong>CAUTIONARY NOTE</strong> (p. iv) in the 800-171 publication.
                          </p>
                          <p>
                            You will want to contact your Federal Agency to verify your compliance.
                          </p>
                          <p>
                            If you would like a consultation, please <a href="{{ url('/contact') }}">contact us</a>.
                          </p>
                        </div>
                      </div>


                      <div class="panel panel-default col-sm-8 col-sm-offset-1" v-if="covered=='Yes'">
                        <div class="panel-body">
                          <p>
                            You may not need to complete an assessment.
                          </p>
                          <p>
                            NIST Special Publication 800-171 applies <em>"where there
                            are no specific safeguarding requirements for protecting the confidentiality of CUI prescribed by
                            the authorizing law, regulation, or governmentwide policy for the CUI category or subcategory
                            listed in the CUI Registry."</em>
                          </p>
                          <p>
                            Ensure you have read the <strong>CAUTIONARY NOTE</strong> (p. iv) in the 800-171 publication.
                          </p>
                          <p>
                            You will want to contact your Federal Agency to verify your compliance.
                          </p>
                          <p>
                            If you would like a consultation, please <a href="{{ url('/contact') }}">contact us</a>.
                          </p>
                        </div>
                      </div>


                    </form>
                  </preassessment>

                </div>
            </div>
        </div>

@endsection
