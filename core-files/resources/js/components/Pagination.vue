<template>
    <div class="pagination">
        <ul class="pagination">
            <li><a href="#" @click="onClickPreviousPage" :disabled="currentPage == 1">Prev</a></li>
            <li v-for="(n,index) in range(1,lastPage)" :class="n==currentPage ? 'active' : ''"><a href="#" class="active" @click="paginate(n)">{{ n }}</a></li>
            <li><a href="#"  @click="onClickNextPage">Next</a></li>
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
                default: 10,
            },

        },
        data: function() {
            return {
            };
        },
        computed: {

        },

        methods: {
            paginate: function(page){
                this.$emit('select', page);
            },
            range: function(start,end){
                let array = [];
                for(let i=start; i<=end; i++){
                    array.push(i);
                }
                return array;
            },
            onClickNextPage() {
                this.$emit('pagechanged',this.currentPage+1);
                console.log("next page:",this.currentPage +1);
                console.log("success next");
            },
            onClickPreviousPage() {
                console.log("prev page", this.currentPage-1);
               return this.$emit('pagechanged', this.currentPage - 1);
            },
        },
        created: function() {

        },
        mounted() {

        },
    };
</script>
