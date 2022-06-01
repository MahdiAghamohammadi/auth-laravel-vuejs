<template>
  <div class="flex flex-wrap items-center justify-center w-full pt-56">
    <div class="flex flex-wrap max-w-xl">
      <div class="p-2 text-2xl font-semibold text-gray-800">
        <h1>Login to your account</h1>
      </div>
      <div class="w-full p-2">
        <label for="email">Your e-mail</label>
        <span class="w-full text-red-500" v-if="errors.email">{{
          errors.email[0]
        }}</span>
        <input
          class="
            w-full
            px-4
            py-2
            text-base
            bg-gray-100
            border border-gray-400
            rounded
            focus:outline-none focus:border-indigo-500
          "
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
          class="
            w-full
            px-4
            py-2
            text-base
            bg-gray-100
            border border-gray-400
            rounded
            focus:outline-none focus:border-indigo-500
          "
          placeholder="Password"
          type="password"
          v-model="form.password"
          name="password"
        />
      </div>
      <div class="w-full p-2 mt-4">
        <button
          @click.prevent="loginUser"
          type="submit"
          class="
            flex
            px-8
            py-2
            text-lg text-white
            bg-indigo-500
            border-0
            rounded
            focus:outline-none
            hover:bg-indigo-600
          "
        >
          Login
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
        email: "",
        password: "",
      },
      errors: [],
    };
  },
  methods: {
    loginUser() {
      axios
        .post("/api/login", this.form)
        .then((res) => {
          localStorage.setItem("token", res.data.token);
          this.$router.push({ name: "Dashboard" });
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },
  },
};
</script>
