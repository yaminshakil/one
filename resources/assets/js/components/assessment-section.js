Vue.component('assessment-section', {
    data() {
      return {
        hide_completed:  false,
      }
    },
    watch: {
      hide_completed: {
        handler() {
          console.log('watch',this.hide_completed);
          localStorage.setItem('hide_completed', JSON.stringify(this.hide_completed));
        },
        deep: true,
      }
    },
    mounted() {
      if (localStorage.getItem('hide_completed')){
        console.log('mounted',this.hide_completed);
        this.hide_completed = JSON.parse(localStorage.getItem('hide_completed'));
      }
    },
});
