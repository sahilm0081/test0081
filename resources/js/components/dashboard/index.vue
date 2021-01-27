<template>
    <div class="dashboard">
        <v-row>
            <v-col lg="4">
                <v-card max-width="344" outlined>
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline mb-4">
                                Total Products
                            </div>
                        </v-list-item-content>
                        <v-list-item-avatar tile size="80">{{
                            totalProducts
                        }}</v-list-item-avatar>
                    </v-list-item>

                    <v-card-actions>
                        <v-btn to="/products" outlined rounded text>
                            More
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col lg="4">
                <v-card max-width="344" outlined>
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline mb-4">
                                Total Users
                            </div>
                        </v-list-item-content>
                        <v-list-item-avatar tile size="80">{{
                            totalUsers
                        }}</v-list-item-avatar>
                    </v-list-item>

                    <v-card-actions>
                        <v-btn to="/users" outlined rounded text>
                            More
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col lg="4">
                <v-card max-width="344" outlined>
                    <v-list-item three-line>
                        <v-list-item-content>
                            <div class="overline mb-4">
                                Total Orders
                            </div>
                        </v-list-item-content>
                        <v-list-item-avatar tile size="80">{{
                            totalOrders
                        }}</v-list-item-avatar>
                    </v-list-item>

                    <v-card-actions>
                        <v-btn to="/orders" outlined rounded text>
                            More
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-col>
            <v-col lg="6">
                <template>
                    <h4 class="pt-4">Latest 5 Orders</h4>
                    <v-simple-table dense>
                        <template v-slot:default>
                            <thead>
                                <tr>
                                    <th class="text-left">
                                        User name
                                    </th>
                                    <th class="text-left">
                                        User email
                                    </th>
                                    <th class="text-left">
                                        Price
                                    </th>
                                    <th class="text-left">
                                        Status
                                    </th>
                                    <th class="text-left">
                                        Payment Id
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in orders" :key="item.id">
                                    <td>
                                        {{ item.user ? item.user.name : "" }}
                                    </td>
                                    <td>
                                        {{ item.user ? item.user.email : "" }}
                                    </td>
                                    <td>{{ item.price }}</td>
                                    <td>
                                        {{ item.status ? item.status.name : "" }}
                                    </td>
                                    <td>{{ item.payment_id }}</td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </template>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    name: "overviews",
    data() {
        return {
            totalProducts: 0,
            totalUsers: 0,
            totalOrders: 0,
            orders: []
        };
    },
    methods: {
        async initialize() {
            await axios
                .get("/app/dashboard")
                .then(response => {
                    const data = response.data;
                    this.totalProducts = data.totalProducts;
                    this.totalUsers = data.totalUsers;
                    this.totalOrders = data.totalOrders;
                    this.orders = data.orders;
                })
                .catch(err => {
                    this.$toasted.show("Server Error!");
                });
        }
    },
    created() {
        this.initialize();
    }
};
</script>

<style></style>
