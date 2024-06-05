Vue.component('update-team-info', {
    props: ['user', 'team'],

    /**
     * The component's data.
     */
    data() {
        return {
            form: new SparkForm({
                org_name: '',
                org_address1: '',
                org_address2: '',
                org_city: '',
                org_state: '',
                org_zip: '',
                org_employeecount: '',
                sys_name: '',
                op_sys_type: 'Major Application',

            })
        };
    },

    /**
     * Prepare the component.
     */
    mounted() {
      this.form.org_name = this.team.org_name;
      this.form.org_address1 = this.team.org_address1;
      this.form.org_address2 = this.team.org_address2;
      this.form.org_city = this.team.org_city;
      this.form.org_state = this.team.org_state;
      this.form.org_zip = this.team.org_zip;
      this.form.org_employeecount = this.team.org_employeecount;
      this.form.sys_name = this.team.sys_name;
      this.form.op_sys_type = this.team.op_sys_type;
    },

     methods: {
        /**
         * Update the team url.
         */
        update() {
            Spark.put(`/settings/teams/${this.team.id}/info`, this.form)
                .then(() => {
                    this.$dispatch('updateTeam');
                    this.$dispatch('updateTeams');
                });
        }
    }
});
