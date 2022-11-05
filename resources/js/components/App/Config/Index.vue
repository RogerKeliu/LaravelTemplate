<template>
  <div class="card">
    <div class="card-body">
      <div class="container-fluid">
        <div class="row pt-4">
          <!-- Products -->
          <div class="d-inline">
            <span class="px-4">{{ $t("message.language") }}</span>
            <select class="" v-model="locale">
              <option v-for="(item, key) in availableLocales" v-bind:key="key">
                {{ item }}
              </option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  components: {},
  data() {
    return {
      locale: "",
      availableLocales: {},
    };
  },
  methods: {
    setLang() {
      axios
        .post("/api/me/profile/lang", { lang: this.locale })
        .then((response) => {})
        .catch((error) => {
          console.log(error);
        });
    },
     getMe() {
        axios
        .get("/api/me/profile/lang", {})
        .then((response) => {
          this.locale = response.data;
          console.log(this.locale);
        })
        .catch((error) => {
          this.error = console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
  },

  watch: {
    locale: function (val) {
      this.$i18n.locale = val;
      this.locale = val;
      this.setLang();
    },
  },
  mounted() {
    this.getMe();
    this.availableLocales = this.$i18n.availableLocales;
  },
};
</script>
