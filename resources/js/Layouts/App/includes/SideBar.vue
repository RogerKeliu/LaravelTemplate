<template>
  <div style="min-height: 100vh">
    <div
      class="
        bg-gray-700
        border-right border-gray-700
        d-flex
        align-items-center
        px-3
      "
      style="height: 5vh"
    >
      <div style="font-size: 18px" class="text-white">Template</div>
    </div>
    <ul
      class="list-group border-right"
      style="border-radius: 0; height: 95vh; overflow-y: auto"
    >
      <li class="list-group-item border-right-0">
        <router-link class="container-fluid p-0" :to="{ name: 'users' }">
          <div class="container-fluid li-button py-2 text-dark">
            <div class="row">
              <div class="col-auto mr-auto">
                <i class="fas fa-user-alt"></i>
              </div>
              <div class="col-auto">
                 <span class=""> {{ $t("user") }} </span>
              </div>
            </div>
          </div>
        </router-link>
      </li>
        <li class="list-group-item border-right-0">
            <router-link class="container-fluid p-0" :to="{ name: 'products' }">
                <div class="container-fluid li-button py-2 text-dark">
                    <div class="row">
                        <div class="col-auto mr-auto">
                            <i class="fas fa-user-alt"></i>
                        </div>
                        <div class="col-auto">
                                   <span class=""> {{ $t("api_permissions") }} </span>
                        </div>
                    </div>
                </div>
            </router-link>
        </li>
        <li class="list-group-item border-right-0">
            <router-link class="container-fluid p-0" :to="{ name: 'admin-products' }">
                <div class="container-fluid li-button py-2 text-dark">
                    <div class="row">
                        <div class="col-auto mr-auto">
                            <i class="fas fa-user-alt"></i>
                        </div>
                        <div class="col-auto">
                            <span class=""> {{ $t("admin_products") }} </span>
                        </div>
                    </div>
                </div>
            </router-link>
        </li>
        <li class="list-group-item border-right-0">
            <router-link class="container-fluid p-0" :to="{ name: 'scan-albarans' }">
                <div class="container-fluid li-button py-2 text-dark">
                    <div class="row">
                        <div class="col-auto mr-auto">
                            <i class="fas fa-user-alt"></i>
                        </div>
                        <div class="col-auto">
                            <span class=""> {{ $t("escaner") }} </span>
                        </div>
                    </div>
                </div>
            </router-link>
        </li>
        <li class="list-group-item border-right-0">
            <router-link class="container-fluid p-0" :to="{ name: 'client-albarans' }">
                <div class="container-fluid li-button py-2 text-dark">
                    <div class="row">
                        <div class="col-auto mr-auto">
                            <i class="fas fa-user-alt"></i>
                        </div>
                        <div class="col-auto">
                            <span class=""> {{ $t("albarans") }} </span>
                        </div>
                    </div>
                </div>
            </router-link>
        </li>
    </ul>
  </div>
</template>
<script>
export default {
  components: {},

  methods: {},
};
</script>
