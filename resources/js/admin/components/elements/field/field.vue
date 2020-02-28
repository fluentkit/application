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
            fieldConditions () {
                return this.field.conditions;
            },
            isReadOnly () {
                return this.field.readOnly;
            },
            isDisabled () {
                return this.isDisabledByCondition || this.field.disabled;
            },
            isDisabledByCondition () {
                return !!this.fieldConditions.filter(({ disableField }) => disableField)
                    .find(this.satisfiesCondition(this.value));
            },
            isHidden () {
                return this.isHiddenByCondition || this.field.hidden;
            },
            isHiddenByCondition () {
                return !!this.fieldConditions.filter(({ hideField }) => hideField)
                    .find(this.satisfiesCondition(this.value));
            }
        },
        created () {
            this.fieldConditions.filter(({ setFieldValue }) => setFieldValue)
                .forEach(condition => {
                    this.$watch(`value.${condition.attribute}`, value => {
                        if (this.satisfiesCondition(this.value)(condition)) {
                            this.updateValue(condition.fieldValue);
                        }
                    });
                });
        },
        methods: {
            satisfiesCondition (attributes) {
                return ({ attribute, operator, comparisonValue }) => {
                    switch (operator) {
                        case '=':
                            return `${this.dotGet(attributes, attribute)}` === `${comparisonValue}`;
                        case '!=':
                            return `${this.dotGet(attributes, attribute)}` !== `${comparisonValue}`;
                        case 'contains':
                            return `${this.dotGet(attributes, attribute)}`.includes(`${comparisonValue}`);
                        case 'includes':
                            return this.dotGet(attributes, attribute).includes(comparisonValue);
                        case 'between':
                            const value = Number(this.dotGet(attributes, attribute));
                            return value > comparisonValue[0] && value < comparisonValue[1];
                        case '>':
                            return Number(this.dotGet(attributes, attribute)) > comparisonValue;
                        case '<':
                            return Number(this.dotGet(attributes, attribute)) < comparisonValue;
                        default:
                            return false;
                    }
                }
            },
            updateValue (value) {
                this.$emit('input', this.dotSet(this.value, this.field.id, value));
            }
        }
    }
</script>
