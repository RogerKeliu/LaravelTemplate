<template>
  <div class="vh-100 wh-100 overflow-hidden">
    <div class="container-fluid">
      <div class="row">
        <div class="col-2 p-0" style="height: 100vh; overflow-y: auto">
          <side-bar class="bg-gray-500"></side-bar>
        </div>
        <main class="col-10 p-0">
          <top-bar style="height: 5vh"></top-bar>
          <div style="height: 92vh; overflow-y: auto" class="bg-gray-100">
            <router-view />
          </div>
          <sfooter style="height: 5vh"></sfooter>
        </main>
      </div>
    </div>
  </div>
</template>

<script>
import sideBar from "./includes/SideBar.vue";
import topBar from "./includes/TopBar.vue";
import sfooter from "./includes/Footer.vue";

export default {
  data() {
    return {
        locale: '',
    };
  },
  components: {
    sideBar,
    topBar,
    sfooter,
  },
  watch: {
        locale: function (val) {
            this.$i18n.locale = val;
        },
    },
  mounted() {
    this.getMe();
  },
  methods: {
    getMe() {
        console.log('aa');
        axios
        .get("/api/me/profile/lang", {})
        .then((response) => {
          console.log(response.data);
          this.locale = response.data;
        })
        .catch((error) => {
          this.error = console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
  },
};
</script>
