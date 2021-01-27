<template>
    <section class="addresses">
        <v-data-table
            :headers="headers"
            :items="addresses"
            class="elevation-1 pt-8"
        >
            <template v-slot:top>
                <v-toolbar flat>
                    <v-toolbar-title>Addresses</v-toolbar-title>
                    <v-divider class="mx-4" inset vertical></v-divider>
                    <v-spacer></v-spacer>
                    <v-dialog v-model="dialog" max-width="500px">
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn
                                color="primary"
                                dark
                                class="mb-2"
                                v-bind="attrs"
                                v-on="on"
                            >
                                New Address
                            </v-btn>
                        </template>
                        <form
                            @submit.prevent="saveData"
                            method="POST"
                            refs="addressform"
                        >
                            <v-card>
                                <v-card-title>
                                    <span class="headline">{{
                                        formTitle
                                    }}</span>
                                </v-card-title>

                                <v-card-text>
                                    <v-container>
                                        <v-row>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="editedItem.bldg_no"
                                                    label="Building no"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="
                                                        editedItem.street_no
                                                    "
                                                    label="Street no"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="editedItem.zone_no"
                                                    label="Zone no"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="
                                                        editedItem.street_name
                                                    "
                                                    label="Street name"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="
                                                        editedItem.landmark
                                                    "
                                                    label="Landmark"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-text-field
                                                    v-model="editedItem.area"
                                                    label="Area"
                                                    required
                                                ></v-text-field>
                                            </v-col>
                                            <v-col cols="12" sm="6" md="4">
                                                <v-checkbox
                                                    v-model="editedItem.primary"
                                                    label="Make default"
                                                ></v-checkbox>
                                            </v-col>
                                        </v-row>
                                    </v-container>
                                </v-card-text>

                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="blue darken-1"
                                        text
                                        @click="close"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn color="blue darken-1" type="submit">
                                        Save
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </form>
                    </v-dialog>
                </v-toolbar>
            </template>
            <template v-slot:item.actions="{ item }">
               
                <!-- <v-icon small class="mr-2" @click="editItem(item)">
                    mdi-pencil
                </v-icon>  -->
                <v-icon small @click="deleteItem(item)">
                    mdi-delete
                </v-icon>
                 <v-chip v-if ="item.primary" class="ma-2" color="primary">
                    Default
                </v-chip>
            </template>
            <template v-slot:no-data>
                <v-btn color="primary" @click="initialize">
                    Reset
                </v-btn>
            </template>
        </v-data-table>
    </section>
</template>

<script>
export default {
    props: {
        useraddresses: {
            type: Array
        }
    },
    data: function() {
        return {
            dialog: false,

            headers: [
                { text: "Building No", value: "bldg_no" },
                { text: "Street No", value: "street_no" },
                { text: "Zone No", value: "zone_no" },
                { text: "Street Name", value: "street_name" },
                { text: "Landmark", value: "landmark" },
                { text: "Area", value: "area" },
                { text: "Actions", value: "actions", sortable: false }
            ],
            addresses: this.useraddresses,
            editedIndex: -1,
            editedItem: {
                bldg_no: "",
                street_no: "",
                zone_no: "",
                street_name: "",
                landmark: "",
                area: "",
                primary: 0
            },
            defaultItem: {
                bldg_no: "",
                street_no: "",
                zone_no: "",
                street_name: "",
                landmark: "",
                area: "",
                primary: 0
            }
        };
    },

    computed: {
        formTitle() {
            return this.editedIndex === -1 ? "New Address" : "Edit Address";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        }
    },

    created() {
        this.initialize();
    },

    methods: {
        initialize() {
            this.addresses = this.useraddresses;
        },

        /* editItem(item) {
            this.editedIndex = this.addresses.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        }, */

        async deleteItem(item) {
            const deleteIndex = this.addresses.indexOf(item);
            await axios
                .post(
                    "/app/user/" +
                        this.$route.params.id +
                        "/address/" +
                        item.id,
                    {
                        _method: "delete"
                    }
                )
                .then(response => {
                    this.$toasted.show("Deleted.");
                    this.addresses.splice(deleteIndex, 1);
                })
                .catch(err => {
                    this.$toasted.show("Error!");
                });
        },
        close() {
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },
        async saveData() {
            await axios
                .post(
                    "/app/user/" + this.$route.params.id + "/address",
                    this.editedItem
                )
                .then(response => {
                    if (response.status == 201) {
                        this.$toasted.show("Added");
                        this.close();

                        if (this.editedIndex > -1) {
                            Object.assign(
                                this.addresses[this.editedIndex],
                                response.data
                            );
                        } else {
                            this.addresses.push(response.data);
                        }
                    } else {
                        this.$toasted.show("Error!");
                    }
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
    }
};
</script>
