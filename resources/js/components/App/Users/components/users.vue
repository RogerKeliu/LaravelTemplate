<template>
  <div class="row d-flex align-items-center">
    <!-- USERS -->
    <div class="col-6 pt-4 px-2">
      <h3>{{ $t("user") }}</h3>
      <div class="card p-4">
        <h5>Create User</h5>
        <div class="row">
          <div class="col-5">
            <div class="input-group mb-3">
              <input
                v-model="user.name"
                type="text"
                class="form-control"
                placeholder="User's Name"
              />
            </div>
          </div>
          <div class="col-7">
            <div class="input-group mb-3">
              <input
                v-model="user.email"
                type="email"
                class="form-control"
                placeholder="User's Email"
              />
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input
            v-model="user.password"
            type="text"
            class="form-control text-center"
            placeholder="Password"
          />
        </div>
        <button
          class="btn btn-outline-secondary"
          type="button"
          :disabled="!(user.name && user.email && user.password)"
          v-on:click="createUser()"
        >
          Create User
        </button>
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
            <tr
              v-for="(user, i) in Object.values(users ? users : [])"
              :key="i"
              v-on:click="selectUser(user)"
            >
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
    <div class="col-6 pt-4 px-2">
      <h3>{{ $t("assign_role_to_user") }}</h3>
      <div class="h5 pt-2 pb-4">
        <span class="text-muted">Current User: </span>
        <span> {{ selectedUser ? selectedUser.email : "Select a User" }} </span>
      </div>
      <div class="h5">
        <span class="text-muted">Current Role: </span>
        <span v-if="selectedUserRoles === null">No Roles</span>
        <span v-else>
          <ul>
            <li
              v-for="(item, key) in Object.values(
                selectedUserRoles ? selectedUserRoles : []
              )"
              :key="key"
            >
              {{ item.name }}
            </li>
          </ul>
        </span>
      </div>
      <div class="pt-2">
        <span class="text-muted">Remove Role: </span>
        <select class="px-2" v-on:change="removeRole($event)">
          <option
            v-if="selectedUserRoles && selectedUserRoles[0] ? false : true"
            value="No Roles"
          >
            No Roles
          </option>
          <option
            v-for="(item, key) in Object.values(
              selectedUserRoles ? selectedUserRoles : []
            )"
            v-bind:key="key"
            :value="item.id"
          >
            {{ item.name }}
          </option>
        </select>
        <button
          v-on:click="removeAllRoles()"
          class="btn btn-primary px-2 mx-2"
          :disabled="selectedUserRoles && selectedUserRoles[0] ? false : true"
        >
          Remove All
        </button>
      </div>
      <div class="pt-4">
        <span>Assign Role </span>
        <select v-on:change="assignRole($event)" :disabled="!selectedUser">
          <option>-</option>
          <option
            v-for="(item, key) in Object.values(
              availableRoles ? availableRoles : []
            )"
            v-bind:key="key"
            :value="item.id"
          >
            {{ item.name }}
          </option>
        </select>
      </div>
    </div>
    <div>
      <hr class="w-100" />
    </div>
  </div>
</template>
<style>
img {
  max-width: 100%;
}
</style>
<script>
export default {
  data() {
    return {
      user: {
        name: "",
        email: "",
        password: "",
      },
      selectedUser: null,
      selectedUserRoles: null,
      availableRoles: null,
      selectedRole: null,
      users: {},
    };
  },
  mounted() {
    // Users
    this.getUsers();

    this.getRoles();
  },
  methods: {
    createUser() {
      axios
        .post("/api/user", { user: this.user })
        .then((response) => {
          this.getUsers();
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    getUsers() {
      console.log("aa");
      axios
        .get("/api/user", {})
        .then((response) => {
          this.users = response.data.data;
          console.log(response.data.data);
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    getRoles() {
      axios
        .get("/api/roles", {})
        .then((response) => {
          this.availableRoles = response.data;
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    getSelectedUserInfo() {
      axios
        .get("/api/user/" + this.selectedUser.id + "/roles", {})
        .then((response) => {
          this.selectedUserRoles = response.data.roles
            ? response.data.roles
            : null;
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    selectUser(value) {
      this.selectedUser = value;
      this.getSelectedUserInfo();
    },
    assignRole(event) {
      const roleId = event.target.value !== "-" ? event.target.value : null;
      if (roleId) {
        axios
          .post(
            "/api/user/" + this.selectedUser.id + "/assignRole/" + roleId,
            {}
          )
          .then((response) => {
            console.log(response.data);
          })
          .catch((error) => {
            console.log(error); //Logs a string: Error: Request failed with status code 404
          });

        this.getSelectedUserInfo();
      }
    },
    removeRole(event) {
      console.log(event.target.value);
      const roleId = event.target.value;
      axios
        .post("/api/user/" + this.selectedUser.id + "/removeRole/" + roleId, {})
        .then((response) => {
          console.log(response.data);
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
      this.getSelectedUserInfo();
    },
    removeAllRoles() {
      axios
        .post("/api/user/" + this.selectedUser.id + "/removeRoles", {})
        .then((response) => {
          console.log(response.data.roles);
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
      this.getSelectedUserInfo();
    },
  },
};
</script>
