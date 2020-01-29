<template>
    <form class="fk-auth-login" @submit.prevent="login">
        <label for="email">Email Address</label>
        <input
            type="text"
            id="email"
            class="fk-auth-login-input"
            :class="{ error: $form.errors.has('email') }"
            v-model="email"
            @input="$form.errors.clear('email')"
        />
        <p v-if="$form.errors.has('email')" class="error">{{ $form.errors.first('email') }}</p>
        <label for="password">Password</label>
        <input
            type="password"
            id="password"
            class="fk-auth-login-input"
            :class="{ error: $form.errors.has('password') }"
            v-model="password"
            @input="$form.errors.clear('password')"
        />
        <p v-if="$form.errors.has('password')" class="error">{{ $form.errors.first('password') }}</p>
        <button
            type="submit"
            class="fk-auth-login-button"
            :disabled="$form.processing"
            @click.prevent="login"
        >
            {{ loginText }}
        </button>
    </form>
</template>

<script>
    import form from '../../mixins/form';

    export default {
        name: 'fk-auth-screen-login',
        mixins: [form],
        data () {
            return {
                email: null,
                password: null,
                loginText: 'Login'
            }
        },
        methods: {
            async login () {
                try {
                    this.loginText = 'Logging In...';
                    const {
                        data: { message, data: { redirect } }
                    } = await this.$form.post('/login', {
                        email: this.email,
                        password: this.password
                    });
                    this.loginText = message;
                    window.location.href = redirect;
                } catch ({ message, response: { data: { message: responseMessage } } }) {
                    if (!this.$form.errors.any()) {
                        this.$form.errors.setErrors({ email: [responseMessage || message] });
                    }
                } finally {
                    this.loginText = 'Login';
                }
            }
        }
    }
</script>

<style>
    .fk-auth-login {
        @apply .flex .flex-col .w-full;
    }

    .fk-auth-login label {
        @apply .flex .mb-2;
    }

    .fk-auth-login-input {
        @apply .shadow .appearance-none .border .rounded .py-2 .px-3 .mb-8 .text-gray-700 .leading-tight;
    }
    .fk-auth-login-input:focus {
        @apply .outline-none .shadow-outline;
    }

    .fk-auth-login-input.error {
        @apply .border .border-red-500 .mb-3;
    }

    .fk-auth-login p.error {
        @apply .text-red-500 .text-xs .italic .h-5;
    }

    .fk-auth-login-button {
        @apply .cursor-pointer .text-center .font-semibold .py-3 .px-6 .rounded .shadow-md .mt-2;
        @apply .bg-green-500 .text-white;
    }
    .fk-auth-login-button:hover {
        @apply .bg-green-600;
    }
    .fk-auth-login-button[disabled],
    .fk-auth-login-button[disabled]:hover{
        @apply .bg-green-700 .text-gray-300;
    }
</style>
