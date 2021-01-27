<template>
    <validation-observer ref="observer" v-slot="{ invalid }">
        <form @submit.prevent="handleSubmit" method="POST" refs="form">
            <validation-provider
                v-slot="{ errors }"
                name="Name"
                rules="required|max:50"
            >
                <v-text-field
                    v-model="name"
                    :counter="50"
                    :error-messages="errors"
                    label="Name"
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
        name: "",
        loading: false
    }),

    methods: {
        async handleSubmit() {
            this.loading = true;
            this.$refs.observer.validate();
            const params = {
                name: this.name
            };
            await axios
                .post("/app/detergentscent", params)
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
                        let msg = "Server Data not present";
                        if (response.data) {
                            if (response.data.data.name) {
                                msg = JSON.stringify(
                                    response.data.data.name[0]
                                );
                            }
                            this.$toasted.show(msg);
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
