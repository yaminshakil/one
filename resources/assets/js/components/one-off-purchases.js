Vue.component('one-off-purchases', {
    props: ['user', 'team', 'options'],

    /**
     * The component's data.
     */
    data() {
        return {
            oneOffOptions: this.options,
            confirmingOneOffPurchase: null,
            selectingOneOffPurchase: null,
        };
    },


    /**
     * Prepare the component.
     */
    mounted() {
    },


    methods: {
        /**
         * Confirm the upsell with the user.
         */
        confirmOneOffPurchase(option) {
            this.confirmingOneOffPurchase = option;

            $('#modal-confirm-one-off-purchase').modal('show');
        },


        /**
         * Approve the option update.
         */
        approveOneOffPurchase() {
            $('#modal-confirm-one-off-purchase').modal('hide');

            this.purchaseOneOffOption(this.confirmingOneOffPurchase);
        },


        /**
         * Show the option details for the given option.
         *
         * We'll ask the parent subscription component to display it.
         */
        showOptionDetails(option) {
            this.$parent.$emit('showPlanDetails', option);
        },

        /**
         * Add a One-Off purchase
         *
         * Used when completing the purchase.
         */
        purchaseOneOffOption(option) {
            this.selectingOneOffPurchase = option;
             // Here we will send the request to the server to pay
            axios.put(this.urlForOneOffPurchase, {"option": option.id})
                .then(() => {
                    swal("Complete", "Your purchase has been processed! Check your email for a receipt.", "success");
                })
                .catch(errors => {
                  swal("Error", "Your purchase could not be completed.", "error");
                })
                .finally(() => {
                    this.selectingOneOffPurchase = null;
                });
        },

    },

    computed: {
      /**
       * Get the URL for the One-Off Purchase processor.
       */
      urlForOneOffPurchase() {
          return `/settings/oneoff/${this.user.current_team_id}/purchase`;
      }
    }

});
