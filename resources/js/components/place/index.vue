<template>
    <div class="places">
        <v-card>
            <v-card-title>Place List</v-card-title>
            <v-btn
                color="primary mr-4 float-right "
                to="/place/add"
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
            <v-data-table :headers="headers" :items="places" :search="search">
                <template v-slot:item.cover_image="{ item }">
                    <img
                        :src="'./storage/' + item.cover_image"
                        width="80px"
                        height="80px"
                    />
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon small class="mr-2" @click="viewItem(item)">
                        mdi-eye
                    </v-icon>
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
        <template v-if="viewShow == true">
            <div class="text-center">
                <v-dialog v-model="dialog" width="500">
                    <v-card>
                        <v-card-title class="headline grey lighten-2">
                            {{ itemView.title }}
                        </v-card-title>

                        <v-card-text>
                            {{ itemView.description }}
                            <v-divider></v-divider>
                            <img
                                :src="'./storage/' + itemView.cover_image"
                                width="150px"
                                height="150px"
                            />
                        </v-card-text>

                        <v-divider></v-divider>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" text @click="dialog = false">
                                Close
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    name: "places",
    data() {
        return {
            places: [],
            headers: [
                { text: "Id", value: "id" },
                { text: "Cover image", value: "cover_image" },
                { text: "Title", value: "title" },
                { text: "Actions", value: "actions", sortable: false }
            ],
            search: "",
            viewShow: false,
            dialog: false,
            itemView: ""
        };
    },
    methods: {
        async initialize() {
            await axios
                .get("/app/place")
                .then(response => {
                    this.places = response.data;
                })
                .catch(err => {
                    this.$toasted.show("Server Error!");
                });
        },
        editItem(item) {
            this.$router.push("/place/edit/" + item.id);
        },
        viewItem(item) {
            this.viewShow = true;
            this.dialog = true;
            this.itemView = item;
        },
        async deleteItem(item) {
            const deleteIndex = this.places.indexOf(item);
            await axios
                .post("/app/place/" + item.id, { _method: "delete" })
                .then(response => {
                    this.$toasted.show("Deleted.");
                    this.places.splice(deleteIndex, 1);
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
