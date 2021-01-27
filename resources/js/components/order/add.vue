<template>
    <section class="addOrderProducts">
        <template>
            <form @submit.prevent="handleSubmit" method="POST" ref="form">
                <v-container fluid>
                    <v-row>
                        <v-col class="d-flex" cols="12" sm="4">
                            <v-select
                                :items="users"
                                item-text="name"
                                item-value="id"
                                label="Select User"
                                required
                                name="user"
                            ></v-select>
                        </v-col>
                        <v-col class="d-flex" cols="12" sm="4">
                            <v-select
                                :items="statuses"
                                item-text="name"
                                item-value="id"
                                label="Order Status"
                                required
                                name="orderstatus"
                            ></v-select>
                        </v-col>
                    </v-row>
                    <v-row
                        align="center"
                        v-for="(orderProduct, index) in orderProducts"
                        :key="index"
                    >
                        <v-col class="d-flex" cols="12" sm="4">
                            <v-select
                                :items="products"
                                item-text="name"
                                item-value="id"
                                label="Select product"
                                required
                                name="product[]"
                                v-model="orderProduct.product"
                            ></v-select>
                        </v-col>

                        <v-col class="d-flex" cols="12" sm="4">
                            <v-text-field
                                label="Quantity"
                                required
                                name="quantity[]"
                                v-model="orderProduct.quantity"
                            ></v-text-field>
                        </v-col>
                        <template v-if="index === 0">
                            <v-btn @click="addProduct" color="blue">
                                Add more
                            </v-btn>
                        </template>
                        <template v-if="index > 0">
                            <v-btn
                                @click="deleteProduct(index)"
                                color="red"
                                class="text-white"
                                >Delete</v-btn
                            >
                        </template>
                    </v-row>

                    <v-row>
                        <v-btn
                            class="mr-4 primary"
                            type="submit"
                            :loading="loading"
                        >
                            Submit
                        </v-btn>
                    </v-row>
                </v-container>
            </form>
        </template>
    </section>
</template>

<script>
export default {
    data: () => ({
        valid: true,
        loading: false,
        orderProducts: [{ product: "", quantity: "" }],
        products: [],
        statuses: [],
        users: []
    }),
    created() {
        this.initialize();
    },
    methods: {
        async initialize() {
            await axios
                .get("/app/fetchdata")
                .then(response => {
                    this.products = response.data.products;
                    this.statuses = response.data.statuses;
                    this.users = response.data.users;
                })
                .catch(err => {
                    this.$toasted.show("Data fetching Error!");
                });
        },
        addProduct() {
            this.orderProducts.push({
                product: "",
                quantity: ""
            });
        },
        deleteProduct(index) {
            this.orderProducts.splice(index, 1);
        },
        async handleSubmit() {
            this.loading = true;
            const formData = this.$refs.form;
            const data = $(formData).serialize();
            await axios
                .post("/app/order", data)
                .then(response => {
                    this.loading = false;
                    const responseData = response.data;
                    if (responseData.status) {
                        this.$toasted.show("Added");
                    } else {
                        this.$toasted.show("Error!");
                    }
                })
                .catch(err => {
                    this.loading = false;
                    const response = err.response;
                    this.loading = false;
                    if (response.status == 422) {
                        let msg = "Please check your validation!";
                        if (response.data) {
                            for (var prop in response.data.errors) {
                                this.$toasted.show(response.data.errors[prop]);
                            }
                        }
                    } else {
                        this.$toasted.show("Please try again later!");
                    }
                });
        }
    }
};
</script>

<style></style>
