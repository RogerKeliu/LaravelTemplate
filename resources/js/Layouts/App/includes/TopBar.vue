<template>
  <div class="container-fluid bg-gray-300">
    <div class="row h-100">
      <div class="col-9">
        <div class="row">
          <span v-for="(item, i) of roles" :key="i">
            {{ item.name }} - Permissions:
            <span v-for="(subitem, y) of item.permissions" :key="y">
              {{ subitem.guard_name }} - {{ subitem.name }} //
            </span>
          </span>
        </div>
      </div>
      <div
        class="col-3 text-right d-flex align-items-center justify-content-end"
      >
        <div class="px-1">
            <router-link class="container-fluid p-0" :to="{ name: 'config' }">
          <button
            id="button"
            class="
              rounded
              top-bar-button
              bg-gray-200
              d-flex
              justify-content-center
              align-items-center
            "
            style="height: 5vh; width: 5vh; border: none"
          >
            <i class="fas fa-cog" style="font-size: 26px"></i>
          </button>
          </router-link>
        </div>
        <div class="px-1">

            <button
              v-on:click="logout"
              id="button"
              class="
                rounded
                top-bar-button
                bg-gray-200
                d-flex
                justify-content-center
                align-items-center
              "
              style="height: 5vh; width: 5vh; border: none"
            >
              <i class="fas fa-sign-out-alt" style="font-size: 26px"></i>
            </button>

        </div>
      </div>
    </div>
  </div>
</template>
<style>
#button:hover {
  background-color: #495057;
  color: white !important;
  opacity: 0.5;
}
</style>
<script>
export default {
  data() {
    return {
      roles: null,
      hover: false,
    };
  },
  mounted() {
    this.getCurrentPermissions();
  },
  methods: {
    logout() {
      axios
        .post("/logout", {})
        .then((response) => {
          window.location.href = "/login";
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    getCurrentPermissions() {
        axios
        .get("/api/me/profile", {})
        .then((response) => {
          this.roles = response.data.roles;
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
  },
};
</script>
