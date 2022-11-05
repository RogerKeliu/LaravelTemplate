<template>
  <div>
    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

      <div class="mt-8 text-2xl">
        Bienvenido a la aplicación de Gestión de Albaranes
      </div>

      <div>
        <p class="error">{{ error }}</p>

        <p class="decode-result">
          Albaran Escaneado: <b>{{ result }}</b>
        </p>

      </div>

      <div class="mt-6 text-gray-500">
        Des de esta web application podremos ver todos albaranes y relizar las
        diferentes gestiones permitidas
      </div>
    </div>

    <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
      <div class="p-6">
        <div class="flex items-center">
        <!--  <svg
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            class="w-8 h-8 text-gray-400"
          >
            <path
              d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
            ></path>
            <path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
          -->
          <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
            Documentación
          </div>
        </div>

        <div class="ml-12">
          <div class="mt-2 text-sm text-gray-500">
            Podremos subir todos los albaranes firmados para que lleguen
            directamente a la Sede central reduciendo así los tiempos de
            comunicación y devolución de los albaranes firmados. Además se
            evitan los problemas de posible deterioro o pérdida de los mismos
          </div>
        </div>
      </div>

      <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
        <div class="flex items-center">
          <!-- <svg
            fill="none"
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            viewBox="0 0 24 24"
            class="w-8 h-8 text-gray-400"
          >
            <path
              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"
            ></path>
          </svg> -->
          <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
            Visualización de Rutas
          </div>
        </div>

        <div class="ml-12">
          <div class="mt-2 text-sm text-gray-500">
            Con la aplicación cada uno podra ver las rutas asignadas a el mismo,
            reduciendo los papeles y dando una información ràpida, fiable y
            actualizada.
          </div>
        </div>

      </div>
    </div>
  </div>
</template>

<script>


export default {
  components: {
  },
  data() {
    return {
      result: "",
      error: "",
      users: [],
      products: [],
      errors: "",
      roles: "",
      userErrors: "",
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
    onDecode(result) {
      this.result = result;
      let me = this;
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };
      let formData = new FormData();
      formData.append("id", me.result);
      this.$inertia.post("/entregarAlbaran", formData);
    },

    async onInit(promise) {
      try {
        await promise;
      } catch (error) {
        if (error.name === "NotAllowedError") {
          this.error = "ERROR: you need to grant camera access permission";
        } else if (error.name === "NotFoundError") {
          this.error = "ERROR: no camera on this device";
        } else if (error.name === "NotSupportedError") {
          this.error = "ERROR: secure context required (HTTPS, localhost)";
        } else if (error.name === "NotReadableError") {
          this.error = "ERROR: is the camera already in use?";
        } else if (error.name === "OverconstrainedError") {
          this.error = "ERROR: installed cameras are not suitable";
        } else if (error.name === "StreamApiNotSupportedError") {
          this.error = "ERROR: Stream API is not supported in this browser";
        } else if (error.name === "InsecureContextError") {
          this.error =
            "ERROR: Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.";
        } else {
          this.error = `ERROR: Camera error (${error.name})`;
        }
      }
    },
  },
};
</script>

<style scoped>
.error {
  font-weight: bold;
  color: red;
}
</style>
