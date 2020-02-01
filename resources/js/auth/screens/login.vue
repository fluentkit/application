<template>
    <form class="fk-auth-login" @submit.prevent="login">
        <label for="email">Email Address</label>
        <fk-auth-input
            id="email"
            :error="!!$form.errors.has('email')"
            v-model="email"
            @input="$form.errors.clear('email')"
        />
        <p v-if="$form.errors.has('email')" class="error">{{ $form.errors.first('email') }}</p>
        <label for="password">Password</label>
        <fk-auth-input
            type="password"
            id="password"
            :error="!!$form.errors.has('password')"
            v-model="password"
            @input="$form.errors.clear('password')"
        />
        <p v-if="$form.errors.has('password')" class="error">{{ $form.errors.first('password') }}</p>
        <button
            type="submit"
            class="fk-auth-button"
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
