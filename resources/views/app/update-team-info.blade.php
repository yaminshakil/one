<update-team-info :user="user" :team="team" inline-template>
    <div class="panel panel-default">
        <div class="panel-heading">Update Company Information</div>

        <div class="panel-body">
            <!-- Success Message -->
            <div class="alert alert-success" v-if="form.successful">
                Your info has been updated!
            </div>

            <form class="form-horizontal" role="form">


                <h3>Company Address</h3>
                <!-- Company Address -->
                <div class="form-group" :class="{'has-error': form.errors.has('org_name')}">
                    <label class="col-md-4 control-label">Company Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="org_name" v-model="form.org_name">
                        <span class="help-block" v-show="form.errors.has('org_name')">
                            @{{ form.errors.get('org_name') }}
                        </span>
                    </div>
                </div>
                <div class="form-group" :class="{'has-error': form.errors.has('org_address1')}">
                    <label class="col-md-4 control-label">Address 1</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="org_address1" v-model="form.org_address1">
                        <span class="help-block" v-show="form.errors.has('org_address1')">
                            @{{ form.errors.get('org_address1') }}
                        </span>
                    </div>
                </div>
                <div class="form-group" :class="{'has-error': form.errors.has('org_address2')}">
                    <label class="col-md-4 control-label">Address 2</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="org_address2" v-model="form.org_address2">
                        <span class="help-block" v-show="form.errors.has('org_address2')">
                            @{{ form.errors.get('org_address2') }}
                        </span>
                    </div>
                </div>
                <div class="form-group" :class="{'has-error': form.errors.has('org_city')}">
                    <label class="col-md-4 control-label">City</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="org_city" v-model="form.org_city">
                        <span class="help-block" v-show="form.errors.has('org_city')">
                            @{{ form.errors.get('org_city') }}
                        </span>
                    </div>
                </div>
                <div class="form-group" :class="{'has-error': form.errors.has('org_state')}">
                    <label class="col-md-4 control-label">State</label>
                    <div class="col-md-6">
                        <input type="text" maxlength="2" size="3" class="form-control" name="org_state" v-model="form.org_state">
                        <span class="help-block" v-show="form.errors.has('org_state')">
                            @{{ form.errors.get('org_state') }}
                        </span>
                    </div>
                </div>
                <div class="form-group" :class="{'has-error': form.errors.has('org_zip')}">
                    <label class="col-md-4 control-label">Zip</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="org_zip" v-model="form.org_zip">
                        <span class="help-block" v-show="form.errors.has('org_zip')">
                            @{{ form.errors.get('org_zip') }}
                        </span>
                    </div>
                </div>

                <!-- Company Profile -->
                <h3>Company Profile</h3>

                <div class="form-group" :class="{'has-error': form.errors.has('org_employeecount')}">
                    <label class="col-md-4 control-label">How many employees (total in the Organization)?</label>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="org_employeecount" v-model="form.org_employeecount">

                        <span class="help-block" v-show="form.errors.has('org_employeecount')">
                            @{{ form.errors.get('org_employeecount') }}
                        </span>
                    </div>
                </div>

                <!-- Assessment Profile -->
                <h3>Assessment Profile</h3>
                <div class="form-group" :class="{'has-error': form.errors.has('sys_name')}">
                    <label class="col-md-4 control-label">System Name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="sys_name" v-model="form.sys_name">

                        <span class="help-block" v-show="form.errors.has('sys_name')">
                            @{{ form.errors.get('sys_name') }}
                        </span>
                    </div>
                </div>
                <div class='form-group' :class="{'has-error': form.errors.has('op_sys_type')}">
                  <label class="col-md-4 control-label">Information System Type</label>
                  <div class="col-md-6">
                      <input type='radio' name="op_sys_type" v-model="form.op_sys_type" value='Major Application' >
                        Major Application
                      <br/>
                      <input type='radio' name="op_sys_type" v-model="form.op_sys_type" value='General Support System'>
                        General Support System

                      <span class="help-block" v-show="form.errors.has('op_sys_type')">
                          @{{ form.errors.get('op_sys_type') }}
                      </span>
                  </div>
                </div>


                <!-- Update Button -->
                <div class="form-group">
                    <div class="col-md-offset-4 col-md-6">
                        <button type="submit" class="btn btn-primary"
                                @click.prevent="update"
                                :disabled="form.busy">

                            Update
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</update-team-info>
