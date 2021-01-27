<template>
    <div class="users">
        <v-card>
            <v-card-title>User List</v-card-title>
            <v-btn color="primary mr-4 float-right" to="/user/add" dark class="mb-2">
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
            <v-data-table :headers="headers" :items="users" :search="search">
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="editItem(item)">
                        mdi-pencil
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
    name: "users",
    data() {
        return {
            users: [],
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
                .get("/app/user")
                .then(response => {
                    this.users = response.data;
                })
                .catch(err => {
                    this.$toasted.show("Server Error!");
                });
        },        
        editItem(item) {
            this.$router.push("/user/edit/" + item.id);
        }        
    },
    created() {
        this.initialize();
    }
};
</script>
