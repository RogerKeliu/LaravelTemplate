<template>
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">

                    </div>
                    <div class="row">
                        <h3>ADMIN Products</h3>
                        <div class="col-6 pt-4 px-2">

                            <div class="pt-4">
                                <h3> Get Products </h3>
                                <div class="table-responsive w-100" v-if="products !== [] && this.errors === ''">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>

                                            <th
                                                scope="col"
                                                v-for="(item, i) in Object.keys(products[0] ? products[0] : [])"
                                                :key="i"
                                            >
                                                {{ item }}
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr
                                            v-for="(product, i) in Object.values(products ? products : [])"
                                            :key="i"
                                        >
                                            <td
                                                scope="col"
                                                v-for="(item, i) in Object.values(product ? product : [])"
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
                                <div v-else>
                                    Unexpected Error
                                </div>
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
            products: [],
            users: [],
            errors: '',
        };
    },
    mounted() {
        this.getProducts();
    },
    methods: {
        getProducts() {
            axios
                .get("/api/products", {})
                .then((response) => {
                    if(response.data.status === 200) {
                        this.products = response.data.data
                        this.errors = '';
                    } else if(response.data.status === 405) {
                        this.errors = response.data.message;
                        this.products = [];
                    }
                })
                .catch((error) => {
                    this.products = [];
                    this.error =
                    console.log(error); //Logs a string: Error: Request failed with status code 404
                });
        },
    },
};
</script>
