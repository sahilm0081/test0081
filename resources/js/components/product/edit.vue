<template>
    <validation-observer ref="observer" v-slot="{ invalid }">
        <form @submit.prevent="handleSubmit" method="POST" refs="form">
            <validation-provider
                v-slot="{ errors }"
                name="Name"
                rules="required|max:50"
            >
                <v-text-field
                    v-model="form.name"
                    :counter="50"
                    :error-messages="errors"
                    label="Name"
                    required
                ></v-text-field>
            </validation-provider>

            <validation-provider
                v-slot="{ errors }"
                name="Price"
                rules="required"
            >
                <v-text-field
                    v-model="form.price"
                    :error-messages="errors"
                    label="Price"
                    required
                ></v-text-field>
            </validation-provider>

            <v-btn
                class="mr-4 primary"
                type="submit"
                :disabled="invalid"
                :loading="loading"
            >
                Submit
            </v-btn>
        </form>
    </validation-observer>
</template>

<script>
export default {
    data: () => ({
        valid: true,
        loading: false,
        form: {
            name: "",
            price: ""
        }
    }),

    methods: {
        async handleSubmit() {
            this.loading = true;
            this.$refs.observer.validate();
            const params = {
                name: this.form.name,
                price: this.form.price,
                _method: "put"
            };
            await axios
                .post("/app/product/" + this.$route.params.id, params)
                .then(response => {
                    this.loading = false;
                    const responseData = response.data;
                    this.$toasted.show("Updated.");
                })
                .catch(err => {
                    const response = err.response;
                    this.loading = false;
                    if (response.status == 422) {
                        let msg = "Server Data not present";
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
                .get("/app/product/" + id)
                .then(response => {
                    const data = response.data;
                    if (data.name) {
                        this.form.name = data.name;
                        this.form.price = data.price;
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
