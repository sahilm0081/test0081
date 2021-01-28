<template>
    <div class="straches">
        <v-card>
            <v-card-title>Temperature List</v-card-title>
            <v-btn color="primary mr-4 float-right" to="/temperature/add" dark class="mb-2">
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
            <v-data-table :headers="headers" :items="temperatures" :search="search">
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
    name: "trousers",
    data() {
        return {
            temperatures: [],
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
                .get("/app/temperature")
                .then(response => {
                    this.temperatures = response.data;
                })
                .catch(err => {
                    this.$toasted.show("Server Error!");
                });
        },
        
        editItem(item) {
            this.$router.push("/temperature/edit/" + item.id);
        },
        async deleteItem(item) {
            const deleteIndex = this.temperatures.indexOf(item);
            await axios
                .post("/app/temperature/" + item.id, { _method: "delete" })
                .then(response => {
                    this.$toasted.show("Deleted.");
                    this.temperatures.splice(deleteIndex, 1);
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
