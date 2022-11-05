<template>
  <div class="card">
    <div class="card-body">
      <div class="container-fluid">
        <div class="row">
          <!-- USERS -->
          <users></users>
          <!-- ROLES -->
          <roles></roles>
          <!-- PERMISSIONS -->
            <permissions></permissions>
        </div>
      </div>
    </div>
  </div>
</template>
<style>
img {
  max-width: 100%;
}
</style>
<script>
import users from "./components/users.vue"
import roles from "./components/roles.vue"
import permissions from "./components/permissions.vue"
export default {
  data() {
    return {
      roleName: null,
      users: {},
      roles: {},
      permissions: {},
    };
  },
  components: {
      users,
      roles,
      permissions
  },
  mounted() {
    // Users

    //Roles
    this.getRoles();
    // Permissions
  },
  methods: {

    getRoles() {
      axios
        .get("/api/roles", {})
        .then((response) => {
            this.roles = response.data
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    createRole() {
      axios
        .post("/api/role", {
          name: this.roleName,
        })
        .then((response) => {
          this.getRoles();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>
