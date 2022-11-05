<template>
  <!-- USERS -->
  <div class="row d-flex align-items-center">
    <div class="col-6 pt-4 px-2">
      <h3>Roles</h3>
      <div class="card p-4">
        <h5>Create Role</h5>
        <div class="row">
          <div class="col-12">
            <div class="input-group mb-3">
              <input
                v-model="roleName"
                type="text"
                class="form-control"
                placeholder="Role's Name"
              />
              <div class="input-group-append">
                <button
                  class="btn btn-outline-secondary"
                  type="button"
                  :disabled="roleName ? false : true"
                  v-on:click="createRole()"
                >
                  Create Role
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
                v-for="(item, i) in Object.keys(roles[0] ? roles[0] : [])"
                :key="i"
              >
                {{ item }}
              </th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(role, i) in Object.values(roles ? roles : [])"
              :key="i"
              v-on:click="selectRole(role)"
            >
              <td
                scope="col"
                v-for="(item, i) in Object.values(role ? role : [])"
                :key="i"
              >
                {{ item ? item : "*" }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- ROLES PERMISSION ASSIGNMENT -->
    </div>
    <div class="col-6 pt-4 px-2">
      <h3>Assign Permission to Role</h3>
      <div class="h5 pt-2 pb-4">
        <span class="text-muted">Current Role: </span>
        <span> {{ selectedRole ? selectedRole.name : "Select a Role" }} </span>
      </div>
      <div class="h5">
        <span class="text-muted">Current Permissions: </span>
        <span v-if="selectedRolePermissions === null">No Permission</span>
        <div
          v-else
          v-for="(item, i) in Object.values(
            selectedRolePermissions ? selectedRolePermissions : []
          )"
        >
          <div v-for="(subitem, y) in Object.entries(item ?? [])">
            <span v-if="subitem[0] === 'name'">
              {{ subitem[1] }}
            </span>
          </div>
        </div>
      </div>
      <div class="pt-2">
        <span class="text-muted">Remove Permission: </span>
        <select class="px-2" v-on:change="removePermission($event)">
          <option
            v-if="
              selectedRolePermissions && selectedRolePermissions[0]
                ? false
                : true
            "
            value="No Roles"
          >
            No Roles
          </option>
          <option
            v-for="(item, key) in Object.values(
              selectedRolePermissions ? selectedRolePermissions : []
            )"
            v-bind:key="key"
            :value="item.id"
          >
            {{ item.name }}
          </option>
        </select>
        <button
          v-on:click="removeAllPermissions()"
          class="btn btn-primary px-2 mx-2"
          :disabled="
            selectedRolePermissions && selectedRolePermissions[0] ? false : true
          "
        >
          Remove All
        </button>
      </div>
      <div class="pt-4">
        <span>Assign Permission </span>
        <select
          v-on:change="assignPermission($event)"
          :disabled="!selectedRole"
        >
          <option>-</option>
          <option
            v-for="(item, key) in Object.values(
              availablePermissions ? availablePermissions : []
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
<script>
export default {
  data() {
    return {
      availablePermissions: null,
      roleName: "",
      roles: {},
      selectedRole: null,
      selectedRolePermissions: null,
    };
  },
  components: {},
  mounted() {
    // Users
    //Roles
    this.getRoles();
    // Permissions
    this.getPermissions();
  },
  methods: {
    getRoles() {
      axios
        .get("/api/roles", {})
        .then((response) => {
          this.roles = response.data;
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    getPermissions() {
      axios
        .get("/api/permission", {})
        .then((response) => {
          this.availablePermissions = response.data;
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    selectRole(role) {
      console.log("select role", role.name);
      this.selectedRole = role;
      axios
        .get("/api/role/" + role.id + "/permission", {})
        .then((response) => {
          this.selectedRolePermissions =
            response.data.permissions.length !== 0
              ? response.data.permissions
              : null;
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    createRole() {
      axios
        .post("/api/roles", {
          name: this.roleName,
          guard_name: "web",
        })
        .then((response) => {
          this.getRoles();
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    assignPermission() {
      const permissionId =
        event.target.value !== "-" ? event.target.value : null;
      if (permissionId) {
        axios
          .post(
            "/api/role/" +
              this.selectedRole.id +
              "/assignPermission/" +
              permissionId,
            {}
          )
          .then((response) => {
            this.selectRole(this.selectedRole);
          })
          .catch((error) => {
            console.log(error); //Logs a string: Error: Request failed with status code 404
          });
      }
    },
    getRoleSelectedInfo() {
      this.selectRole(this.selectedRole);
    },
    removePermission(event) {
      console.log(event.target.value);
      const roleId = event.target.value;
      axios
        .post(
          "/api/role/" + this.selectedRole.id + "/removePermission/" + roleId,
          {}
        )
        .then((response) => {
          this.selectRole(this.selectedRole);
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    removeAllPermissions() {
      axios
        .post("/api/role/" + this.selectedRole.id + "/removePermissions", {})
        .then((response) => {
          console.log(response.data.roles);
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });

        this.getRoleSelectedInfo();
    },
  },
};
</script>
