<template>
    <form class="fk-auth-forgot" @submit.prevent="reset">
        <p v-if="responseText" class="success">{{ responseText }}</p>
        <template v-else>
            <label for="email">Email Address</label>
            <fk-auth-input
                id="email"
                :error="!!$form.errors.has('email')"
                v-model="email"
                @input="$form.errors.clear('email')"
            />
            <p v-if="$form.errors.has('email')" class="error">{{ $form.errors.first('email') }}</p>
            <button
                type="submit"
                class="fk-auth-button"
                :disabled="$form.processing"
                @click.prevent="reset"
            >
                {{ forgotText }}
            </button>
        </template>
    </form>
</template>

<script>
    import form from '../../mixins/form';

    export default {
        name: 'fk-auth-screen-forgot',
        mixins: [form],
        data () {
            return {
                email: null,
                forgotText: 'Reset Password',
                responseText: null
            }
        },
        methods: {
            async reset () {
                try {
                    this.forgotText = 'Requesting Reset...';
                    this.responseText = null;
                    const { data: { message } } = await this.$form.post('/forgot-password', { email: this.email });
                    this.responseText = message;
                } catch ({ message, response: { data: { message: responseMessage } } }) {
                    if (!this.$form.errors.any()) {
                        this.$form.errors.setErrors({ email: [responseMessage || message] });
                    }
                } finally {
                    this.forgotText = 'Reset Password';
                }
            }
        }
    }
</script>
