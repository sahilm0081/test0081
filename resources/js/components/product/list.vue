<template>
    <div class="products">
        <v-card>
            <v-card-title>Product List</v-card-title>
            <v-btn color="primary mr-4 float-right" to="/product/add" dark class="mb-2">
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
            <v-data-table :headers="headers" :items="products" :search="search">
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="editItem(item)">
                        mdi-pencil
                    </v-icon>
                    <v-icon small @click="deleteItem(item)">
                        mdi-delete
                    </v-icon>
                </template>
                <template v-slot:no-data>
                    <v-btn color="primary" @click="initialize">
                        Reset
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        
    </div>
</template>

<script>
export default {
    name: "products",
    data() {
        return {
            products: [],
            headers: [
                { text: "Id", value: "id" },
                { text: "Gender", value: "gender" },
                { text: "Name", value: "name" },
                { text: "Price", value: "price" },
                { text: "Actions", value: "actions", sortable: false }
            ],
            search: ""
        };
    },
    methods: {
        async initialize() {
            await axios
                .get("/app/product")
                .then(response => {
                    this.products = response.data;
                })
                .catch(err => {
                    this.$toasted.show("Server Error!");
                });
        },
        
        editItem(item) {
            this.$router.push("/product/edit/" + item.id);
        },
        async deleteItem(item) {
            const deleteIndex = this.products.indexOf(item);
            await axios
                .post("/app/product/" + item.id, { _method: "delete" })
                .then(response => {
                    this.$toasted.show("Deleted.");
                    this.products.splice(deleteIndex, 1);
                })
                .catch(err => {
                    this.$toasted.show("Error!");
                });
        }
    },
    created() {
        this.initialize();
    }
};
</script>
