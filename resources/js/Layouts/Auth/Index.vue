<template>
  <body>
    <div class="container-fluid d-flex align-items-center vh-100 wh-100">
      <div class="row w-100">
        <div class="col-12 d-flex justify-content-center align-items-center">
          <h1>Welcome</h1>
        </div>
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card border-0 shadow rounded-3 my-5 bg-gray-500">
            <div class="card-body p-4 p-sm-5">
              <div class="form-floating mb-3">
                <input
                  type="email"
                  class="form-control"
                  id="floatingInput"
                  v-model="email"
                />
                <label for="floatingInput">Email address</label>
              </div>
              <div class="form-floating mb-3">
                <input
                  type="password"
                  class="form-control"
                  id="floatingPassword"
                  v-model="password"
                />
                <label for="floatingPassword">Password</label>
              </div>


              <div class="d-grid py-2">
                <button
                  class="btn btn-primary text-uppercase fw-bold w-25"
                  v-on:click="login()"
                >
                  Sign in
                </button>
              </div>
              <div class="d-grid py-2">
                <button
                  class="btn btn-primary btn-login text-uppercase fw-bold w-25"
                  v-on:click="register()"
                >
                  Register
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</template>

<script>
export default {
  data() {
    return {
        email: 'roger@roger.com',
        password: 'rogerroger'
    };
  },
  mounted() {
    axios.get("/sanctum/csrf-cookie").then((response) => (this.info = response));
  },
  methods: {
    login: function () {
      axios
        .post("/login", {
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          window.location.href = "/app";
        })
        .catch((error) => {
          console.log(error);
        });
    },
    register: function () {
      axios
        .post("/register", {
          name: "Name Input",
          email: this.email,
          password: this.password,
          password_confirmation: this.password,
        })
        .then((response) => (this.info = response));
    },
  },
};
</script>
<style></style>
