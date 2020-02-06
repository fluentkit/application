<script>
    import dot from '../../../../mixins/dot';

    export default {
        name: 'fk-admin-field',
        mixins: [dot],
        props: {
            field: {
                type: Object,
                required: true
            },
            errors: {
                type: Object,
                required: true
            },
            value: {
                type: Object,
                required: true
            }
        },
        computed: {
            fieldValue () {
                return this.dotGet(this.value, this.field.id);
            },
            isReadOnly () {
                return this.field.readOnly;
            },
            isDisabled () {
                return this.field.disabled;
            },
            isHidden () {
                return this.field.hidden;
            }
        },
        methods: {
            updateValue (value) {
                this.$emit('input', this.dotSet(this.value, this.field.id, value));
            }
        }
    }
</script>
