<template>
    <div class="fk-admin-pagination">
        <a
            :disabled="page === 1"
            @click.prevent="goToPage(1)"
        >
            <i class="fa fa-angle-double-left" />
        </a>
        <a
            :disabled="page === 1"
            @click.prevent="goToPage(page - 1)"
        >
            <i class="fa fa-angle-left" />
        </a>
        <a
            v-for="p in visiblePages"
            :key="p"
            :class="{ active: p === page }"
            @click.prevent="goToPage(p)"
        >
            {{ p }}
        </a>
        <a
            :disabled="page === pages"
            @click.prevent="goToPage(page + 1)"
        >
            <i class="fa fa-angle-right" />
        </a>
        <a
            :disabled="page === pages"
            @click.prevent="goToPage(pages)"
        >
            <i class="fa fa-angle-double-right" />
        </a>
    </div>
</template>

<script>
    export default {
        name: 'fk-admin-pagination',
        props: {
            page: {
                type: Number,
                required: true
            },
            pages: {
                type: Number,
                default: 0
            }
        },
        computed: {
            visiblePages() {
                const middlePage = Math.min(Math.max(3, this.page), this.pages - 2),
                    fromPage = Math.max(middlePage - 2, 1),
                    toPage = Math.min(middlePage + 2, this.pages);

                const pages = [];

                for (let n = fromPage; n <= toPage; ++n) {
                    if (n > 0) pages.push(n);
                }

                return pages;
            }
        },
        methods: {
            goToPage (page) {
                if (page < 1 || page === this.page || page > this.pages) return;

                this.$emit('click', page);
            }
        }
    }
</script>

<style>
    .fk-admin-pagination {
        @apply .flex;
    }
    .fk-admin-pagination a {
        @apply .inline-block .px-4 .py-3 .border-r .text-sm .font-semibold .text-blue-500 .cursor-pointer;
    }
    .fk-admin-pagination a:hover {
        @apply .bg-gray-200;
    }
    .fk-admin-pagination a.active {
        @apply .text-gray-600;
    }
    .fk-admin-pagination a[disabled] {
        @apply .text-gray-400;
    }
</style>
