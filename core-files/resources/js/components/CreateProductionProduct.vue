<template>
    <div>
        <div class="box">
            <div class="box-header">CREATE PRODUCTION PRODUCT</div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group search-form-group">
                            <label>Good Name</label>
                            <input type="text" v-model="good.name" :class="good.id ? 'form-control': 'form-control text-danger'" @keyup="searchGood">
                            <ul class="search-result" v-if="filteredGoods.length">
                                <li v-for="searchResult in filteredGoods" @click="selectGood(searchResult)">{{ searchResult.detail_name }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <label>Unit</label>
                        <input type="text" class="form-control" v-model="good.unit" disabled>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Produced Qty</label>
                            <input type="number" v-model="good.producedQuantity" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Released Qty</label>
                            <input type="number" v-model="good.releasedQuantity" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-danger" style="margin-top: 25px" @click="resetForm">RESET</button>
                            <button v-if="editingIndex > -1" type="button" class="btn warning" style="margin-top: 25px" @click="updateGood" :disabled="!good.id">UPDATE</button>
                            <button v-else type="button" class="btn btn-success" style="margin-top: 25px" @click="addGood" :disabled="!good.id">ADD</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <h4>PRODUCED PRODUCT LIST</h4>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SL#</th>
                        <th>Name</th>
                        <th>Thickness</th>
                        <th>Size</th>
                        <th>Unit</th>
                        <th>Produced Qty</th>
                        <th>Released Qty</th>
                        <th class="text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(productionGood,index) in productionGoods">
                        <td>{{ index+1 }} <input type="hidden" :name="'products['+ index +'][id]'" :value="productionGood.id"></td>
                        <td>{{ productionGood.name }}</td>
                        <td>{{ productionGood.thickness }}</td>
                        <td>{{ productionGood.size }}</td>
                        <td>{{ productionGood.unit }}</td>
                        <td>{{ productionGood.producedQuantity }}<input type="hidden" :name="'products['+ index +'][produced_qty]'" :value="productionGood.producedQuantity"></td>
                        <td>{{ productionGood.releasedQuantity }}<input type="hidden" :name="'products['+ index +'][released_qty]'" :value="productionGood.releasedQuantity"></td>
                        <td class="text-right">
                            <button type="button" class="btn btn-xs btn-warning" @click="editGood(index)">Edit</button>
                            <button type="button" class="btn btn-xs btn-danger" @click="removeAddedGood(index)">Remove</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group text-right" style="margin-top: 20px" v-if="productionGoods.length">
                    <button class="btn btn-success" type="submit">SAVE PRODUCTION PRODUCT</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props: ['items'],
        data: function () {
            return {
                goods: [],
                filteredGoods: [],
                good: {
                    id: null,
                    name: null,
                    producedQuantity: 0,
                    releasedQuantity: 0,
                    unit: null,
                    thickness: null,
                    size: null,
                },
                productionGoods: [],
                addedGoods: [],
                editingIndex: -1,
            }
        },

        computed: {

        },

        methods: {

            validateForm: function(){
                return this.good.id && this.good.producedQuantity;
            },
            searchGood: function(){
                this.resetForm();
                this.filteredGoods = [];
                if(this.good.name && this.good.name.length){
                    this.filteredGoods = this.goods.filter((item) => {
                        return item.name.toUpperCase().search(this.good.name.toUpperCase()) != -1
                    });
                }
            },

            selectGood: function(good){
                this.good.id = good.id;
                this.good.name = good.name;
                this.good.unit = good.unit_name;
                this.good.thickness = good.thickness;
                this.good.size = good.size;
                this.filteredGoods = [];
            },

            addGood: function() {
                this.productionGoods.push({
                    name: this.good.name,
                    id: this.good.id,
                    unit: this.good.unit,
                    releasedQuantity: this.good.releasedQuantity,
                    producedQuantity: this.good.producedQuantity,
                    thickness: this.good.thickness,
                    size: this.good.size,
                });
                this.good.name = "";
                this.resetGoods(this.good.id);
                this.resetForm();
            },
            updateGood(){
                this.productionGoods.splice(this.editingIndex,1,{
                    name: this.good.name,
                    id: this.good.id,
                    unit: this.good.unit,
                    releasedQuantity: this.good.releasedQuantity,
                    producedQuantity: this.good.producedQuantity,
                });
                this.resetForm();
                console.log("Update good");
            },

            editGood(index){
                let good = this.productionGoods[index];
                //this.productionGoods.splice(index,1);
                this.good.id = good.id;
                this.good.name = good.name;
                this.good.releasedQuantity = good.releasedQuantity;
                this.good.producedQuantity = good.producedQuantity;
                this.good.unit = good.unit;
                this.editingIndex = index;
            },
            resetForm(){
                this.good.id = null;
                this.good.releasedQuantity = 0;
                this.good.producedQuantity = 0;
                this.good.producedQuantity = 0;
                this.good.unit = null;
                this.editingIndex = -1;
                this.good.thickness = null;
                this.good.size = null;
            },
            resetGoods(id){
                for (let i=0; i<this.goods.length; i++){
                    if(id == this.goods[i].id){
                        this.addedGoods.push(this.goods[i]);
                        this.goods.splice(i,1);
                    }
                }
            },
            removeAddedGood(index){
                let good = this.productionGoods[index];
                this.productionGoods.splice(index,1);
                this.resetAddedGoods(good.id);
            },
            resetAddedGoods(id){
                for (let i=0; i<this.addedGoods.length; i++){
                    if(id == this.addedGoods[i].id){
                        this.goods.push(this.addedGoods[i]);
                        this.addedGoods.splice(i,1);
                    }
                }
            }

        },
        created: function () {
            this.goods = this.items.goods;
        },

        mounted() {
            console.log('Create Production product Component mounted.')
        }
    }
</script>
