<template>
    <div class="fk-admin-table">
        <div v-if="$scopedSlots['table-header']" class="header-actions">
            <slot name="table-header" />
        </div>
        <table>
            <thead>
            <tr>
                <th v-for="column in columns" :key="column.id" :class="columnClasses(column)">{{ column.label }}</th>
            </tr>
            </thead>
            <tbody>
            <template v-if="rows.length">
                <tr v-for="row in rows" :key="getRowKey(row)">
                    <td v-for="column in columns" :key="column.id" :class="rowClasses(row, column)">
                        <slot
                            v-if="$scopedSlots[column.id]"
                            :name="column.id"
                            v-bind="{ row, column }"
                        />
                        <template v-else>
                            {{ row[column.id] }}
                        </template>
                    </td>
                </tr>
            </template>
            <tr v-else>
                <td class="no-results" :colspan="columns.length">
                    No Results
                </td>
            </tr>
            </tbody>
        </table>
        <div v-if="$scopedSlots['table-footer']" class="pagination">
            <slot name="table-footer" />
        </div>
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-table',
        props: {
            columns: {
                type: Array,
                default: () => ([])
            },
            rows: {
                type: Array,
                default: () => ([])
            },
            rowKey: {
                type: [String, Function],
                default: 'id'
            }
        },
        methods: {
            getRowKey (row) {
                if (typeof this.rowKey === 'function') return this.rowKey(row);

                return row[this.rowKey];
            },
            columnClasses ({ align = 'left', classes = [] }) {
                return [align, ...classes];
            },
            rowClasses (row, { align = 'left', classes = [] }) {
                return [align, ...classes];
            }
        }
    }
</script>

<style>
    .fk-admin-table {
        @apply .flex .flex-col;
    }

    .fk-admin-table > .header-actions {
        @apply .p-4 .shadow-md .bg-white .rounded-t .border-b;
    }

    .fk-admin-table table {
        @apply .table-auto .shadow-md .bg-white;
    }

    .fk-admin-table table tr {
        @apply .border-b;
    }

    .fk-admin-table table th {
        @apply .px-4 .py-2 .border-b .bg-gray-200 .text-left .text-xs .uppercase .font-semibold .text-gray-600;
    }

    .fk-admin-table table th.center {
        @apply .text-center;
    }

    .fk-admin-table table tbody tr:hover {
        @apply .bg-gray-100;
    }

    .fk-admin-table table td {
        @apply .px-4 .py-3;
    }

    .fk-admin-table table td.center {
        @apply .text-center;
    }

    .fk-admin-table table td.no-results {
        @apply .text-center;
    }

    .fk-admin-table table td.actions {
        @apply .flex .justify-end;
    }
    .fk-admin-table table .fk-admin-button {
        @apply .mb-0 .ml-2;
    }

    .fk-admin-table > .pagination {
        @apply .shadow-md .bg-gray-100 .rounded-b .flex;
    }

    .fk-admin-table > .pagination > .totals {
        @apply .py-3 .px-4 .text-gray-600 .text-sm .ml-auto;
    }
</style>
