<template>
  <div class="row">
    <!-- USERS -->
    <div class="col-6 pt-4 px-2">
      <h3>Permissions</h3>

      <div class="card p-4">
        <h5>Create Permissions</h5>
        <div class="row">
          <div class="col-12">
            <div class="input-group mb-3">
              <input
                v-model="permissionName"
                type="text"
                class="form-control"
                placeholder="Permission Name"
              />
              <div class="input-group-append">
                <button
                  class="btn btn-outline-secondary"
                  type="button"
                  :disabled="permissionName ? false : true"
                  v-on:click="createPermission()"
                >
                  Create Permission
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="table-responsive w-100">
        <table class="table table-striped">
          <thead>
            <tr>
              <th
                scope="col"
                v-for="(item, i) in Object.keys(users[0] ? users[0] : [])"
                :key="i"
              >
                {{ item }}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(user, i) in Object.values(users ? users : [])" :key="i">
              <td
                scope="col"
                v-for="(item, i) in Object.values(user ? user : [])"
                :key="i"
              >
                {{ item ? item : "*" }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      permissionName: null,
      users: {},
    };
  },
  mounted() {
    this.getPermission();
  },
  methods: {
    createPermission() {
      axios.post("/api/permission", {
        name: this.permissionName,
      });

      this.getPermission();
    },
    getPermission() {
      axios
        .get("/api/permission", {})
        .then((response) => {
          this.users = response.data;
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
  },
};
</script>
