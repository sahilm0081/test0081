<template>
    <div class="straches">
        <v-card>
            <v-card-title>Detergent type List</v-card-title>
            <v-btn color="primary mr-4 float-right" to="/type/add" dark class="mb-2">
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
            <v-data-table :headers="headers" :items="types" :search="search">
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
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    name: "types",
    data() {
        return {
            types: [],
            headers: [
                { text: "Id", value: "id" },
                { text: "Name", value: "name" },
                { text: "Actions", value: "actions", sortable: false }
            ],
            search: ""
        };
    },
    methods: {
        async initialize() {
            await axios
                .get("/app/detergenttype")
                .then(response => {
                    this.types = response.data;
                })
                .catch(err => {
                    this.$toasted.show("Server Error!");
                });
        },
        addItem() {
            this.$router.push("/type/add");
        },
        editItem(item) {
            this.$router.push("/type/edit/" + item.id);
        },
        async deleteItem(item) {
            const deleteIndex = this.types.indexOf(item);
            await axios
                .post("/app/detergenttype/" + item.id, { _method: "delete" })
                .then(response => {
                    this.$toasted.show("Deleted.");
                    this.types.splice(deleteIndex, 1);
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
