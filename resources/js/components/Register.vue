<template>
  <div class="flex flex-wrap items-center justify-center w-full pt-56">
    <div class="flex flex-wrap max-w-xl">
      <div class="p-2 text-2xl font-semibold text-gray-800">
        <h1>Register an account</h1>
      </div>
      <div class="w-full p-2">
        <label class="w-full" for="name">Name</label>
        <span class="w-full text-red-500" v-if="errors.name">{{
          errors.name[0]
        }}</span>
        <input
          class="w-full px-4 py-2 text-base bg-gray-100 border border-gray-400 rounded  focus:outline-none focus:border-indigo-500"
          placeholder="Name"
          type="text"
          v-model="form.name"
        />
      </div>
      <div class="w-full p-2">
        <label for="email">Your e-mail</label>
        <span class="w-full text-red-500" v-if="errors.email">{{
          errors.email[0]
        }}</span>
        <input
          class="w-full px-4 py-2 text-base bg-gray-100 border border-gray-400 rounded  focus:outline-none focus:border-indigo-500"
          placeholder="Email"
          type="email"
          v-model="form.email"
        />
      </div>
      <div class="w-full p-2">
        <label for="password">Password</label>
        <span class="w-full text-red-500" v-if="errors.password">{{
          errors.password[0]
        }}</span>
        <input
          class="w-full px-4 py-2 text-base bg-gray-100 border border-gray-400 rounded  focus:outline-none focus:border-indigo-500"
          placeholder="Password"
          type="password"
          v-model="form.password"
          name="password"
        />
      </div>
      <div class="w-full p-2">
        <label for="confirm_password">Confirm Password</label>
        <span class="w-full text-red-500" v-if="errors.password_confirmation">{{
          errors.password_confirmation[0]
        }}</span>
        <input
          class="w-full px-4 py-2 text-base bg-gray-100 border border-gray-400 rounded  focus:outline-none focus:border-indigo-500"
          placeholder="Confirm Password"
          type="password"
          v-model="form.password_confirmation"
          name="password_confirmation"
        />
      </div>
      <div class="w-full p-2 mt-4">
        <button
          @click.prevent="saveForm"
          type="submit"
          class="flex px-8 py-2 text-lg text-white bg-indigo-500 border-0 rounded  focus:outline-none hover:bg-indigo-600"
        >
          Register
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      },
      errors: [],
    };
  },
  methods: {
    saveForm() {
      axios
        .post("/api/register", this.form)
        .then(() => {
          console.log("saved");
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
  },
};
</script>
