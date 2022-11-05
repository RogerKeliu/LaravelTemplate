<template>
  <div class="card">
    <div class="card-body">
      <div class="container-fluid">
        <div class="row">
          <!-- Products -->
          <div class="col-6 pt-4 px-2">
            <h3>Products</h3>
            <div class="pt-4">
              <h3>Get Products</h3>
              <div
                class="table-responsive w-100"
                v-if="products !== [] && this.errors === ''"
              >
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th
                        scope="col"
                        v-for="(item, i) in Object.keys(
                          products[0] ? products[0] : []
                        )"
                        :key="i"
                      >
                        {{ item }}
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr
                      v-for="(product, i) in Object.values(
                        products ? products : []
                      )"
                      :key="i"
                    >
                      <td
                        scope="col"
                        v-for="(item, i) in Object.values(
                          product ? product : []
                        )"
                        :key="i"
                      >
                        {{ item ? item : "*" }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div v-else-if="products === [] && this.errors === ''">
                There's no products to show
              </div>
              <div v-else-if="this.errors !== ''">
                {{ errors }}
              </div>
              <div v-else>Unexpected Error</div>
            </div>
          </div>
          <!-- Users -->
          <div class="col-6 pt-4 px-2">
            <h3>Users</h3>
            <div class="pt-4">
              <h3>Get Users</h3>
              <div
                class="table-responsive w-100"
                v-if="users !== [] && this.userErrors === ''"
              >
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th
                        scope="col"
                        v-for="(item, i) in Object.keys(
                          users[0] ? users[0] : []
                        )"
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
              <div v-else-if="users === [] && this.errors === ''">
                There's no products to show
              </div>
              <div v-else-if="this.errors !== ''">
                {{ errors }}
              </div>
              <div v-else>Unexpected Error</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      users: [],
      products: [],
      errors: "",
      roles: "",
      userErrors: '',
    };
  },
  mounted() {
    this.getUsers();
    this.getProducts();
    this.getCurrentPermissions();
  },
  methods: {
    getProducts() {
      axios
        .get("/api/products", {})
        .then((response) => {
          if (response.data.status === 200) {
            this.products = response.data.data;
            this.errors = "";
          } else if (response.data.status === 405) {
            this.errors = response.data.message;
            this.products = [];
          }
        })
        .catch((error) => {
          this.products = [];
          this.error = console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    getUsers() {
      axios
        .get("/api/user", {})
        .then((response) => {
          if (response.data.status === 200) {
            this.users = response.data.data;
            this.userErrors = "";
          } else if (response.data.status === 405) {
            this.userErrors = response.data.message;
            this.users = [];
          }
        })
        .catch((error) => {
          this.users = [];
          this.error = console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
    getCurrentPermissions() {
      axios
        .get("/api/me/profile", {})
        .then((response) => {
          console.log(response.data);
          this.roles = response.data.roles;
        })
        .catch((error) => {
          console.log(error); //Logs a string: Error: Request failed with status code 404
        });
    },
  },
};
</script>
