<one-off-purchases :user="user" :team="team" :options="{{json_encode(config('app.oneOffOptions'))}}" inline-template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left">
                    Additional Options
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="panel-body table-responsive">

              <table class="table table-borderless m-b-none">
                  <thead></thead>
                  <tbody>
                      <tr v-for="option in oneOffOptions">
                          <!-- option Name -->
                          <td>
                              <div class="btn-table-align" @click="showOptionDetails(option)">
                                  <span style="cursor: pointer;">
                                      <strong>@{{ option.name }}</strong>
                                  </span>
                              </div>
                          </td>

                          <!-- option Features Button -->
                          <td>
                              <button class="btn btn-default m-l-sm" @click="showOptionDetails(option)">
                                  <i class="fa fa-btn fa-star-o"></i>Benefits
                              </button>
                          </td>

                          <!-- option Price -->
                          <td>
                              <div class="btn-table-align">
                                  <span>
                                      $@{{ option.price }}
                                  </span>
                              </div>
                          </td>

                          <!-- option Select Button -->
                          <td class="text-right">
                              <button class="btn btn-primary-outline btn-plan"
                                      v-if="selectingOneOffPurchase !== option"
                                      @click="confirmOneOffPurchase(option)"
                                      :disabled="selectingOneOffPurchase">
                                  Purchase
                              </button>

                              <button class="btn btn-primary btn-plan"
                                      v-if="selectingOneOffPurchase && selectingOneOffPurchase === option"
                                      disabled>

                                  <i class="fa fa-btn fa-spinner fa-spin"></i>Pending
                              </button>
                          </td>
                      </tr>
                  </tbody>
              </table>


            </div>
        </div>

        <!-- Confirm Option Update Modal -->
        <div class="modal fade" id="modal-confirm-one-off-purchase" tabindex="-2" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content" v-if="confirmingOneOffPurchase">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Add Subscription Option
                        </h4>
                    </div>

                    <!-- Modal Body -->
                    <div class="modal-body">
                        <p>
                            Are you sure you want to add the
                            <strong>@{{ confirmingOneOffPurchase.name }}</strong> option for <strong>$@{{ confirmingOneOffPurchase.price }}</strong>?
                        </p>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No, Go Back</button>

                        <button type="button" class="btn btn-primary" @click="approveOneOffPurchase">Yes, I'm Sure</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</one-off-purchases>
