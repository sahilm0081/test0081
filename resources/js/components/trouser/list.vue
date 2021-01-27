<template>
    <div class="straches">
        <v-card>
            <v-card-title>Trouser List</v-card-title>
            <v-btn color="primary mr-4 float-right" to="/trouser/add" dark class="mb-2">
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
            <v-data-table :headers="headers" :items="trousers" :search="search">
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
    name: "trousers",
    data() {
        return {
            trousers: [],
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
                .get("/app/trouser")
                .then(response => {
                    this.trousers = response.data;
                })
                .catch(err => {
                    this.$toasted.show("Server Error!");
                });
        },
        addItem() {
            this.$router.push("/trouser/add");
        },
        editItem(item) {
            this.$router.push("/trouser/edit/" + item.id);
        },
        async deleteItem(item) {
            const deleteIndex = this.trousers.indexOf(item);
            await axios
                .post("/app/trouser/" + item.id, { _method: "delete" })
                .then(response => {
                    this.$toasted.show("Deleted.");
                    this.trousers.splice(deleteIndex, 1);
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
