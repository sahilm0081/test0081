<template>
    <validation-observer ref="observer" v-slot="{ invalid }">
        <form @submit.prevent="handleSubmit" method="POST" refs="form">
            <validation-provider
                v-slot="{ errors }"
                name="Title"
                rules="required|max:50"
            >
                <v-text-field
                    v-model="form.title"
                    :counter="50"
                    :error-messages="errors"
                    label="Title"
                    required
                ></v-text-field>
            </validation-provider>
            <validation-provider
                v-slot="{ errors }"
                name="Description"
                rules="required"
            >
                <v-textarea
                    v-model="form.description"
                    :error-messages="errors"
                    label="Description"
                    required
                    type="area"
                ></v-textarea>
            </validation-provider>
            <input type="file" name="media" @change="imageSelect" />
            <br /><br />
            <v-flex xs12 sm12 md12>
                <gmap-autocomplete
                    @place_changed="setPlace"
                    :select-first-on-enter="true"
                    class="form-control"
                    placeholder="Search Place for Map"
                >
                </gmap-autocomplete>
            </v-flex>
            <v-flex xs12 sm12 md12>
                <GmapMap
                    :center="center"
                    :zoom="zoom"
                    map-type-id="terrain"
                    style="width: auto; height: 300px"
                    @click="newmark"
                >
                    <GmapMarker
                        :position="position"
                        :clickable="true"
                        :draggable="true"
                        @dragend="mapitem"
                    />
                </GmapMap>
            </v-flex>
            <br /><br />
            <v-btn
                class="mr-4 primary"
                type="submit"
                :disabled="invalid"
                :loading="loading"
            >
                Update
            </v-btn>
        </form>
    </validation-observer>
</template>

<script>
export default {
    data: () => ({
        valid: true,
        form: {
            title: "",
            description: "",
            lat: 25.2854,
            lng: 51.531
        },
        media: "",
        loading: false,
        zoom: 16,
        center: {
            lat: 25.2854,
            lng: 51.531
        },
        markers: [
            {
                position: {
                    lat: 25.2854,
                    lng: 51.531
                }
            }
        ]
    }),
    computed: {
        position() {
            
            var position = {
                lat: this.form.lat,
                lng: this.form.lng
            };
            return position;
        }
    },
    methods: {
        imageSelect(e) {
            this.media = e.target.files[0];
        },
        setPlace(place) {
            this.center.lat = place.geometry.location.lat();
            this.center.lng = place.geometry.location.lng();
            this.form.lat = place.geometry.location.lat();
            this.form.lng = place.geometry.location.lng();
            this.zoom = 16;
        },
        mapitem(i) {
            this.center.lat = i.latLng.lat();
            this.center.lng = i.latLng.lng();
            this.form.lat = i.latLng.lat();
            this.form.lng = i.latLng.lng();
        },
        newmark(i) {
            this.form.lat = i.latLng.lat();
            this.form.lng = i.latLng.lng();
        },
        async handleSubmit() {
            this.loading = true;
            this.$refs.observer.validate();
            const formData = new FormData();

            for (var key in this.form) {
                formData.append(key, this.form[key]);
            }
            formData.append("cover_image", this.media);
            formData.append("_method", "put");

            await axios
                .post("/app/place/" + this.$route.params.id, formData)
                .then(response => {
                    this.loading = false;
                    const responseData = response.data;
                    this.$toasted.show("Updated.");
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
        },
        async getData(id) {
            await axios
                .get("/app/place/" + id)
                .then(response => {
                    const data = response.data;
                    if (data.title) {
                        this.form.title = data.title;
                        this.form.description = data.description;
                        this.form.lat = data.lat;
                        this.form.lng = data.lng;
                        this.center.lat = data.lat;
                        this.center.lng = data.lng;
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
