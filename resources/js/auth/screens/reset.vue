<template>
    <form class="fk-auth-reset" @submit.prevent="reset">
        <label for="password">Password</label>
        <fk-auth-input
            type="password"
            id="password"
            :error="!!$form.errors.has('password')"
            v-model="password"
            @input="$form.errors.clear('password')"
        />
        <p v-if="$form.errors.has('password')" class="error">{{ $form.errors.first('password') }}</p>
        <label for="password_confirmation">Password Confirmation</label>
        <fk-auth-input
            type="password"
            id="password_confirmation"
            :error="!!$form.errors.has('password_confirmation')"
            v-model="passwordConfirmation"
            @input="$form.errors.clear('password_confirmation')"
        />
        <p v-if="$form.errors.has('password_confirmation')" class="error">{{ $form.errors.first('password_confirmation') }}</p>
        <p v-if="$form.errors.has('email')" class="error">{{ $form.errors.first('email') }}</p>
        <p v-if="$form.errors.has('token')" class="error">{{ $form.errors.first('token') }}</p>
        <button
            type="submit"
            class="fk-auth-button"
            :disabled="$form.processing"
            @click.prevent="reset"
        >
            {{ resetText }}
        </button>
    </form>
</template>

<script>
    import form from '../../mixins/form';

    export default {
        name: 'fk-auth-screen-reset',
        mixins: [form],
        data () {
            return {
                password: null,
                passwordConfirmation: null,
                resetText: 'Reset Password'
            }
        },
        computed: {
            token () {
                return this.$route.params.token;
            },
            email () {
                return this.$route.query.email;
            }
        },
        methods: {
            async reset () {
                try {
                    this.resetText = 'Resetting Password...';
                    const {
                        data: { message, data: { redirect } }
                    } = await this.$form.post('/reset-password', {
                        email: this.email,
                        token: this.token,
                        password: this.password,
                        password_confirmation: this.passwordConfirmation
                    });
                    this.resetText = message;
                    window.location.href = redirect;
                } catch ({ message, response: { data: { message: responseMessage } } }) {
                    if (!this.$form.errors.any()) {
                        this.$form.errors.setErrors({ password: [responseMessage || message] });
                    }
                } finally {
                    this.resetText = 'Reset Password';
                }
            }
        }
    }
</script>
