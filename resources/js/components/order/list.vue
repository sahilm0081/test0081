<template>
    <div class="orders">
        <v-card>
            <v-card-title>Order List</v-card-title>
            <v-btn
                color="primary mr-4 float-right"
                to="/order/add"
                dark
                class="mb-2"
            >
                Add
            </v-btn>
            <v-card-title>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table :headers="headers" :items="orders" :search="search">
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="viewItem(item)">
                        mdi-eye
                    </v-icon>
                    <v-icon small @click="deleteItem(item)">
                        mdi-delete
                    </v-icon>
                    <v-btn small @click="updatePaymentId(item)" color="primary">
                        Update Payment Id
                    </v-btn>
                </template>
                <template v-slot:no-data>
                    <v-btn color="primary" @click="initialize">
                        Reset
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog v-model="dialog" max-width="500px">
            <form @submit.prevent="updateData" method="POST">
                <v-card>
                    <v-card-title>
                        <span class="headline">Update Payment Id</span>
                    </v-card-title>

                    <v-card-text>
                        <v-container>
                            <v-row>
                                <v-col cols="12" sm="6" md="4">
                                    <v-text-field
                                        v-model="editedItem.payment_id"
                                        label="Payment Id"
                                        required
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" text @click="close">
                            Cancel
                        </v-btn>
                        <v-btn color="blue darken-1" type="submit">
                            Save
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </form>
        </v-dialog>
    </div>
</template>

<script>
export default {
    name: "orders",
    data() {
        return {
            orders: [],
            headers: [
                { text: "Id", value: "id" },
                { text: "Payment Id", value: "payment_id" },
                { text: "Name", value: "user.name" },
                { text: "Email", value: "user.email" },
                { text: "Total Price", value: "price" },
                { text: "Order status", value: "status.name" },
                { text: "Actions", value: "actions", sortable: false }
            ],
            search: "",
            dialog: false,
            editedItem: {
                payment_id: ""
            },
            editedIndex: -1
        };
    },
    watch: {
        dialog(val) {
            val || this.close();
        }
    },

    methods: {
        async initialize() {
            await axios
                .get("/app/order")
                .then(response => {
                    this.orders = response.data;
                })
                .catch(err => {
                    this.$toasted.show("Server Error!");
                });
        },
        updatePaymentId(item) {
            this.editedIndex = this.orders.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },
        viewItem(item) {
            this.$router.push("/order/view/" + item.id);
        },
        close() {
            this.dialog = false;
        },
        async deleteItem(item) {
            const deleteIndex = this.orders.indexOf(item);
            await axios
                .post("/app/order/" + item.id, { _method: "delete" })
                .then(response => {
                    this.$toasted.show("Deleted.");
                    this.orders.splice(deleteIndex, 1);
                })
                .catch(err => {
                    this.$toasted.show("Error!");
                });
        },
        async updateData() {
            await axios
                .post("/app/orderupdate/" + this.editedItem.id, this.editedItem)
                .then(response => {
                    const responseData = response.data;
                    this.$toasted.show("Updated.");
                    this.close();
                })
                .catch(err => {
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
    },
    created() {
        this.initialize();
    }
};
</script>
