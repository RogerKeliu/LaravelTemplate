<template>
<div v-if="me.roles">
    {{ me.roles[0].name}}
    <div v-if="me.roles[0].name === 'admin'"> <admin></admin></div>
    <div v-else-if="me.roles[0].name === 'worker'">soc woerker</div>
    <div v-else>soc guest</div>
  </div>
</template>
<script>
import admin from './pages/admin.vue'
export default {
  data() {
    return {
      me: {},
      role: {}
    };
  },
  components: {
      admin
  },
  mounted() {
    this.getCurrentPermissions();
  },
  methods: {
    getCurrentPermissions() {
      axios
        .get("/api/me/profile", {})
        .then((response) => {
          this.me = response.data;
          console.log(this.me);
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
  },
};
</script>
