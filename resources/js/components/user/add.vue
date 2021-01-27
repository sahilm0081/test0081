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
                name="email"
                rules="required|email"
            >
                <v-text-field
                    v-model="form.email"
                    :error-messages="errors"
                    label="Email"
                    required
                ></v-text-field>
            </validation-provider>

            <validation-provider
                v-slot="{ errors }"
                name="password"
                rules="required|min:8"
            >
                <v-text-field
                    v-model="form.password"
                    :error-messages="errors"
                    label="Password"
                    required
                    type="password"
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
        form: {
            name: "",
            email: "",
            password: ""
        },
        loading: false
    }),

    methods: {
        async handleSubmit() {
            this.loading = true;
            this.$refs.observer.validate();
            const params = {
                ...this.form
            };

            await axios
                .post("/app/user", params)
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
                    if (response.status == 422) {
                        let msg = "Some validation errors!";
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
