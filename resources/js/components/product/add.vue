<template>
    <validation-observer ref="observer" v-slot="{ invalid }">
        <form @submit.prevent="handleSubmit" method="POST" refs="form">
            <validation-provider
                v-slot="{ errors }"
                name="Select Gender"
                rules="required"
            >
                <v-select
                    :items="genders"
                    :error-messages="errors"
                    label="Select Gender"
                    required
                    name="gender"
                    v-model="form.gender"
                ></v-select>
            </validation-provider>

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
            price: "",
            gender:'',
        },
        genders:['Men','Women']
    }),

    methods: {
        async handleSubmit() {
            this.loading = true;
            this.$refs.observer.validate();
            const params = {
                name: this.form.name,
                price: this.form.price,
                gender: this.form.gender
            };
            await axios
                .post("/app/product", params)
                .then(response => {
                    this.loading = false;
                    const responseData = response.data;
                    if (response.status == 201) {
                        this.$toasted.show("Added");
                    } else {
                        this.$toasted.show("Error!");
                    }
                })
                .catch(err => {
                    this.loading = false;
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

<style></style>
