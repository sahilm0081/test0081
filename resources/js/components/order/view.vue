<template>
    <section class="orderView">
        <v-container>
            <v-row>
                <v-col lg="6">
                    Total Price
                </v-col>
                <v-col lg="6">
                    {{ order.price }}
                </v-col>
                <v-col lg="6">
                    Payment Id
                </v-col>
                <v-col lg="6">
                    {{ order.payment_id }}
                </v-col>
                <v-col lg="6">
                    Order By
                </v-col>
                <v-col lg="6">
                    {{ order.user ? order.user.name : "" }}({{
                        order.user ? order.user.email : ""
                    }})
                </v-col>
                <v-col lg="6">
                    Order Status
                </v-col>
                <v-col lg="6">
                    {{ order.status ? order.status.name : "" }}
                </v-col>
            </v-row>
        </v-container>
        <template>
            <h3 class="pt-4">Order Products</h3>
            <v-simple-table dense>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left">
                                Product name
                            </th>
                            <th class="text-left">
                                Price
                            </th>
                            <th class="text-left">
                                Quantity
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in orderProducts" :key="item.id">
                            <td>{{ item.product ? item.product.name : "" }}</td>
                            <td>{{ item.product_price }}</td>
                            <td>{{ item.quantity }}</td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </template>
    </section>
</template>

<script>
export default {
    data() {
        return {
            order: {},
            orderProducts: []
        };
    },
    methods: {
        async getData(id) {
            await axios
                .get("/app/order/" + id)
                .then(response => {
                    const data = response.data;
                    if (data.id) {
                        this.order = data;
                        this.orderProducts = data.order_products;
                    } else {
                        this.$toasted.show("Server Error!");
                    }
                })
                .catch(err => {
                    this.$toasted.show("Server Error!");
                });
        }
    },
    created() {
        this.getData(this.$route.params.id);
    }
};
</script>

<style></style>
