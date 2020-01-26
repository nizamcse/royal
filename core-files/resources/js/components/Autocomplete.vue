<template>
    <div class="form-group">
        <label>{{ inputLabel }}</label>
        <div class="autocomplete">
            <input type="text" v-model="searchedText" @onfocus="displayItems" @keyup="displayItems" class="form-control" :required="isRequired">
            <ul class="option-list" v-if="displayList">
                <li v-for="(item,index) in filteredItems" @click="selectItem(item)">{{ item[displayText] }}</li>
            </ul>
        </div>
        <input type="hidden" :name="name" :value="selectedItem">
    </div>
</template>

<script>
    import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

    export default {
        props: ['items','displayText','value','name','label','isRequired','initialValue'],
        data: function() {
            return {
                inputLabel: "",
                itemCollections: [],
                filteredItems: [],
                searchedText: "",
                displayList: false,
                selectedValue: null,
                selectedItem: null,
                inputLabel: '',
            }
        },
        methods: {
            displayItems: function(){
                this.displayList = true;
                this.filterItems();
            },
            filterItems: function(){
                this.selectedItem = null;
                this.filteredItems = this.itemCollections.filter((item) => {
                    if(item[this.displayText].toUpperCase() == this.searchedText.toUpperCase()){
                        this.selectItem(item);
                    }
                    else{
                        return item[this.displayText].toUpperCase().search(this.searchedText.toUpperCase()) != -1;
                    }
                });
            },
            hideItems: function(){
                this.displayList = false;
            },
            selectItem: function(item){
                this.selectedItem = item[this.value]
                this.searchedText = item[this.displayText]
                this.displayList = false;
                console.log(this.displayList)
            }
        },
        created(){
            this.itemCollections = this.items;
            this.inputLabel = this.label;
            if(this.initialValue){
                this.selectedItem = this.initialValue;
                this.searchedText = this.initialValue;
            }
        },
        mounted() {
            console.log('Autocomplete Component mounted.')
        }
    }
</script>

<style>
    .custom-input{
        background-color: #00adef;
    }
</style>

