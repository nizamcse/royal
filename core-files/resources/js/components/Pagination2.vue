<template>
    <div class="pagination text-center">
        <ul class="pagination overflow-auto">
            <li class="pagination-item">
                <a href="#" @click="onClickFirstPage" :disabled="isInFirstPage" aria-label="Go to first page">
                    <small class="text-primary">First page</small>
                </a>
            </li>

            <li
                class="pagination-item"
            >
                <a
                    @click="onClickPreviousPage"
                    :disabled="isInFirstPage"
                    aria-label="Go to previous page"
                    href="#"
                >
                   <small>Prev</small>
                </a>
            </li>
            <li v-for="page in pages" class="pagination-item">
                <a
                    href="#"
                    @click="onClickPage(page.name)"
                    :disabled="page.isDisabled"
                    :class="{ active: isPageActive(page.name) }"
                    :aria-label="`Go to page number ${page.name}`"

                >
                    {{ page.name }}
                </a>
            </li>
            <li class="pagination-item">
                <a
                    href="#"
                    @click="onClickNextPage"
                    :disabled="isInLastPage"
                    aria-label="Go to next page"
                >
                    <small>Next</small>
                </a>
            </li>

            <li class="pagination-item">
                <a
                    href="#"
                    @click="onClickLastPage"
                    :disabled="isInLastPage"
                    aria-label="Go to last page"
                >
                   <small class="text-primary">Last page</small>
                </a>
            </li>
        </ul>
    </div>
</template>

<script>

    export default {
        props: {
            currentPage: {
                type: Number,
                default: 1,
            },
            lastPage: {
                type: Number,
                default: 1
            },
            maxVisibleButtons: {
                type: Number,
                required: false,
                default: 5
            },
            totalPages: {
                type: Number,
                required: true
            },
            total: {
                type: Number,
                required: true
            },
        },
        data: function() {
            return {
            };
        },
        methods:{
            onClickFirstPage() {
                this.$emit('pagechanged', 1);
            },
            onClickPreviousPage() {
                this.$emit('pagechanged', this.currentPage - 1);
            },
            onClickPage(page) {
                this.$emit('pagechanged', page);
            },
            onClickNextPage() {
                if(this.currentPage != this.lastPage) this.$emit('pagechanged', this.currentPage + 1);
            },
            onClickLastPage() {
                this.$emit('pagechanged', this.totalPages);
            },
            isPageActive(page) {
                return this.currentPage === page;
            },
        },
        computed: {
            startPage() {
                if (this.currentPage === 1) {
                    return 1;
                }

                if (this.currentPage === this.totalPages) {
                    return this.totalPages - this.maxVisibleButtons + 1;
                }

                return this.currentPage - 1;

            },
            endPage() {
                return Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);

            },
            pages() {
                const range = [];

                for (let i = this.startPage; i <= this.endPage; i+= 1 ) {
                    range.push({
                        name: i,
                        isDisabled: i === this.currentPage
                    });
                }
                console.log(range);
                return range;
            },
            isInFirstPage() {
                return this.currentPage === 1;
            },
            isInLastPage() {
                return this.currentPage === this.lastPage;
            },
        },
        created(){

        },
        mounted() {

        },
    };
</script>
<style scoped>
    .pagination {
        list-style-type: none;
    }
    .pagination-item {
        display: inline-block;
    }

    .active {
        background-color: #367FA9;
        color: #ffffff;
    }
</style>

