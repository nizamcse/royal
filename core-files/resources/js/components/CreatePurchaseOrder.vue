<template>
    <div class="search-form p-15">
        <div class="row cyan-bg">
            <div class="col-md-3">
                <div class="form-group search-form-group" style="color: #000;">
                    <label>Supplier Name</label>
                    <input type="text" v-model="vendor.name" :class="vendor.id ? 'form-control': 'form-control text-danger'" @keyup="searchVendor" required>
                    <ul class="search-result" v-if="vendorResults.length">
                        <li v-for="searchResult in vendorResults" @click="selectVendor(searchResult)">{{ searchResult.name }}</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Supplier Contact No</label>
                    <input type="text" class="form-control" v-model="vendor.contactNo" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Supplier Address</label>
                    <input type="text" class="form-control" v-model="vendor.address" readonly>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="product-type">Product Type</label>
                    <select id="product-type" class="form-control" v-model="productType">
                        <option value="1">Log</option>
                        <option value="2">Row Material</option>
                        <option value="3">Other Material</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group" style="color:#000">
                    <label>Purchase Date</label>
                    <datepicker input-class="form-control" :format="formatDate"></datepicker>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Chalan No# (Manual Entry)</label>
                    <input type="text" class="form-control" v-model="purchaseChalanNo">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Additional Chalan No# (Extra Manual)</label>
                    <input type="text" class="form-control" v-model="additionalPurchaseChalanNo">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Category</label>
                    <select v-model="categoryId" class="form-control" v-on:change="changeGrade">
                        <option value="">Select Category</option>
                        <option v-for="category in categories"  :value="category.id">{{ category.name }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row" v-if="productType == 2">
            <form action="#" method="post" v-on:submit.prevent="addRowMaterialItem" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                <div class="col-md-4">
                    <div class="form-group search-form-group">
                        <label>Material Name</label>
                        <input type="text" v-model="rawMaterial.name" :class="rawMaterial.id ? 'form-control': 'form-control text-danger'" @keyup="searchRawMaterial" required>
                        <ul class="search-result" v-if="searchResults.length">
                            <li v-for="searchResult in searchResults" @click="selectRawMaterial(searchResult)">{{ searchResult.name }}</li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" class="form-control" v-model="rawMaterial.quantity" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unit</label>
                        <input type="text" v-model="rawMaterial.unit" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Price/Unit</label>
                        <input type="text" class="form-control" v-model="rawMaterial.price" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" class="form-control" :value="price" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 25px">
                        <button class="btn btn-block btn-info" type="submit" :disabled="!rawMaterial.id">+ ADD</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row" v-else-if="productType == 3">
            <form action="#" v-on:submit.prevent="addOtherItem" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                <div class="col-md-4">
                    <div class="form-group search-form-group">
                        <label>Material Name</label>
                        <input type="text" v-model="otherItem.name" :class="otherItem.id ? 'form-control': 'form-control text-danger'" @keyup="searchOtherItem" required>
                        <ul class="search-result" v-if="otherItemResults.length">
                            <li v-for="searchResult in otherItemResults" @click="selectOtherItem(searchResult)">{{ searchResult.name }}</li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Thickness</label>
                        <input type="text" v-model="otherItem.thickness" class="form-control">
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Size</label>
                        <input type="text" v-model="otherItem.size" class="form-control">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="text" v-model="otherItem.quantity" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Unit</label>
                        <input type="text" v-model="otherItem.unit" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Price/Unit</label>
                        <input type="text" class="form-control" v-model="otherItem.price" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="text" class="form-control" :value="totalAmount" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 25px">
                        <button class="btn btn-block btn-info" type="submit">+ ADD</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="row" v-else>
            <form action="#" v-on:submit.prevent="addLogItem" @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Radius</label>
                        <input type="number" class="form-control" placeholder="Radius" v-model="logRadius" v-on:keyup="changeGrade" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Height</label>
                        <input type="text" class="form-control" v-model="logHeight" placeholder="Height" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Quantity(Area)</label>
                        <input type="text" class="form-control" v-model="area" placeholder="Area" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Grade</label>
                        <input type="text" class="form-control" placeholder="Grade" v-model="logGrade" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Unit Price</label>
                        <input type="text" class="form-control" placeholder="Grade" v-model="logAmount" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Amount</label>
                        <input type="number" class="form-control" :value="amount" placeholder="Amount" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group" style="margin-top: 25px">
                        <button class="btn btn-block btn-info" type="submit">+ ADD</button>
                    </div>
                </div>
            </form>
        </div>

        <form :action="formUrl" method="post"  @keydown="$event.keyCode === 13 ? $event.preventDefault() : false">
            <input type="hidden" name="_token"  :value="_token">
            <input type="hidden" name="vendor_id" :value="vendor.id">
            <input type="hidden" name="purchase_date" :value="purchaseDate">
            <input type="hidden" name="challan_no_mannual" :value="purchaseChalanNo">
            <input type="hidden" name="additional_challan_no_mannual" :value="additionalPurchaseChalanNo">
            <div class="row" v-if="rawMaterialItems.length">
                <div class="col-md-12">
                    <table class="table table-bordered list-table">
                        <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Unit</th>
                            <th class="w-100">Unit Price</th>
                            <th class="w-100">Quantity</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(rawMaterialItem,index) in rawMaterialItems">
                            <th>{{ rawMaterialItem.name }} <input type="hidden" :name="'raw_material['+ index +'][raw_material_id]'" :value="rawMaterialItem.id"></th>
                            <th>{{ rawMaterialItem.unit }}</th>
                            <th>{{ rawMaterialItem.price }} <input type="hidden" :name="'raw_material['+ index +'][price]'" :value="rawMaterialItem.price"></th>
                            <th>{{ rawMaterialItem.quantity }}<input type="hidden" :name="'raw_material['+ index +'][quantity]'" :value="rawMaterialItem.quantity"></th>
                            <th>
                                {{ rawMaterialItem.amount }}
                                <input type="hidden" :name="'raw_material['+ index +'][amount]'" :value="rawMaterialItem.amount">
                                <input type="hidden" :name="'raw_material['+ index +'][thickness]'">
                                <input type="hidden" :name="'raw_material['+ index +'][size]'">
                                <input type="hidden" :name="'raw_material['+ index +'][type]'" value="1">
                            </th>
                            <th class="text-right"><button class="btn btn-xs btn-danger" @click="removeRowMaterialItem(index)">-</button></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row" v-if="otherMaterialItems.length">
                <div class="col-md-12">
                    <table class="table table-bordered list-table">
                        <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Thickness</th>
                            <th>Size</th>
                            <th>Unit</th>
                            <th class="w-100">Unit Price</th>
                            <th class="w-100">Quantity</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(rawMaterialItem,index) in otherMaterialItems">
                            <th>{{ rawMaterialItem.name }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][raw_material_id]'" :value="rawMaterialItem.id"></th>
                            <th>{{ rawMaterialItem.thickness }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][thickness]'" :value="rawMaterialItem.thickness"></th>
                            <th>{{ rawMaterialItem.size }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][size]'" :value="rawMaterialItem.size"></th>
                            <th>{{ rawMaterialItem.unit }}</th>
                            <th>{{ rawMaterialItem.price }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][price]'" :value="rawMaterialItem.price"></th>
                            <th>{{ rawMaterialItem.quantity }}<input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][quantity]'" :value="rawMaterialItem.quantity"></th>
                            <th>
                                {{ rawMaterialItem.amount }}
                                <input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][amount]'" :value="rawMaterialItem.amount">
                                <input type="hidden" :name="'raw_material['+ (index + rawMaterialItems.length) +'][type]'" value="2">
                            </th>

                            <th class="text-right"><button class="btn btn-xs btn-danger" @click="removeOtherItem(index)">-</button></th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row" v-if="logItems.length">
                <div class="col-md-12">
                    <table class="table table-bordered list-table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Grade</th>
                            <th>Radius</th>
                            <th>Height</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th class="w-100">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="(item,index) in logItems">
                            <td>{{ index+1 }}</td>
                            <td>{{ getCategoryName(item.category) }}</td>
                            <td>
                                {{ item.radius }}
                                <input type="hidden" :name="'log['+ index +'][radius]'" :value="item.radius">
                                <input type="hidden" :name="'log['+ index +'][category_id]'" :value="item.category">
                            </td>
                            <td>{{ item.height }} <input type="hidden" :name="'log['+ index +'][height]'" :value="item.height"></td>
                            <td>{{ item.grade }} <input type="hidden" :name="'log['+ index +'][grade]'" :value="item.grade"></td>
                            <td>{{ item.area }}</td>
                            <td>
                                {{ item.amount }}
                                <input type="hidden" :name="'log['+ index +'][price_per_unit]'" :value="item.price">
                            </td>
                            <td class="text-right"><button class="btn btn-xs btn-danger" @click="removeLogItem(index)">-</button></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-sm btn-success" :disabled="!logItems.length && !otherMaterialItems.length && !rawMaterialItems.length ">CREATE PURCHASE</button>
                </div>
            </div>
        </form>

    </div>
</template>

<script>
    export default {

        props: ['items'],
        data: function () {
            return {
                productType: 1,
                categories: [],
                formUrl: null,
                // Log Properties
                grades: [],
                logHeight: 0,
                logRadius: 0.0,
                logGrade: "",
                logItems: [],
                logAmount: 0,
                categoryId: "",
                // Row Material Properties
                rawMaterial: {
                    id: null,
                    name: "",
                    unit: "",
                    quantity: null,
                    price: null
                },
                rawMaterials: [],
                searchResults: [],

                rawMaterialItems: [],
                // Other Item Properties
                otherItem:{
                    id: null,
                    name: "",
                    unit: "",
                    quantity: null,
                    price: null,
                    thickness: null,
                    size: null
                },

                otherItemResults: [],
                otherMaterialItems: [],
                // Vendor
                vendors: [],
                vendor: {
                    name: "",
                    contactNo: "",
                    address: "",
                    id: null
                },
                vendorResults: [],
                _token: "",
                purchaseDate: "",
                purchaseChalanNo: "",
            };
        },

        computed: {
            // Log Methods
            area: function(){
                let r = this.logRadius ? parseFloat(this.logRadius) : 0;
                let h = this.logHeight ? parseFloat(this.logHeight) : 0;
                return parseFloat((r*r*h)/2304).toFixed(2);
            },
            amount: function () {
                return parseFloat(this.logAmount*this.area).toFixed(2);
            },
            price: function(){
                let p = this.rawMaterial.price ? parseFloat(this.rawMaterial.price) : 0;
                let q = this.rawMaterial.quantity ? parseFloat(this.rawMaterial.quantity) : 0;
                return parseFloat(p*q).toFixed(2);
            },
            totalAmount: function () {
                let p = this.otherItem.price ? parseFloat(this.otherItem.price) : 0;
                let q = this.otherItem.quantity ? parseFloat(this.otherItem.quantity) : 0;
                return parseFloat(p*q).toFixed(2);
            }
        },

        methods: {

            formatDate: function (date) {
                this.purchaseDate = moment(date).format('DD-MM-YYYY');
                return this.purchaseDate;
            },
            /**
             * Log methods
             */

            changeGrade: function(){

                this.logGrade = "";
                this.logAmount = 0;

                if(!this.logRadius){
                    return;
                }

                let lr = parseFloat(this.logRadius);

                for (let i=0; i<this.grades.length; i++){
                    //console.log(this.categoryId,this.grades[i].category_id,this.grades[i]);
                    if((lr >= this.grades[i].min_radius && lr <= this.grades[i].max_radius) && this.grades[i].category_id == this.categoryId ){
                        this.logGrade = this.grades[i].name;
                        this.logAmount = this.grades[i].price_per_unit;
                        return;
                    }
                }
            },
            addLogItem(){
                this.logItems.push({
                    radius: this.logRadius,
                    height: this.logHeight,
                    area: this.area,
                    grade: this.logGrade,
                    amount: this.amount,
                    price: this.logAmount,
                    category: this.categoryId,
                });

                this.logRadius = 0;
                this.logHeight = 0;
                this.logGrade = "";
                this.logAmount = 0;
            },
            removeLogItem(i){
                this.logItems.splice(i,1);
            },


            /**
             * Raw Material Methods
             */

            searchRawMaterial(){
                this.searchResults = [];
                this.rawMaterial.id = null;
                this.rawMaterial.unit = "";
                if(this.rawMaterial.name.length){
                    this.searchResults = this.rawMaterials.filter((item) => {
                        if(item.name.toUpperCase() == this.rawMaterial.name.toUpperCase()){
                            this.selectRawMaterial(item);
                        }
                        else{
                            return item.name.toUpperCase().search(this.rawMaterial.name.toUpperCase()) != -1;
                        }
                    });
                }

            },
            selectRawMaterial(item){
                this.rawMaterial.id = item.id;
                this.rawMaterial.name = item.name;
                this.rawMaterial.unit = item.unit_name;
                this.rawMaterial.quantity = null;
                this.rawMaterial.price = null;
                this.searchResults = [];
            },

            addRowMaterialItem(){
                let item = this.rawMaterial;
                item.amount = this.price;
                this.rawMaterialItems.push(item);
                this.rawMaterial = {
                    id: null,
                    name: "",
                    unit: "",
                    quantity: null,
                    price: null
                };
            },

            removeRowMaterialItem(i){
                this.rawMaterialItems.splice(i,1);
            },

            /**
             * Other Material Methods
             */
            searchOtherItem(){
                this.otherItemResults = [];
                this.otherItem.id = null;
                this.otherItem.unit = "";
                if(this.otherItem.name.length){
                    this.otherItemResults = this.rawMaterials.filter((item) => {
                        if(item.name.toUpperCase() == this.otherItem.name.toUpperCase()){
                            this.selectOtherItem(item);
                        }
                        else{
                            return item.name.toUpperCase().search(this.otherItem.name.toUpperCase()) != -1;
                        }
                    });
                }

            },
            selectOtherItem(item){
                this.otherItem.id = item.id;
                this.otherItem.name = item.name;
                this.otherItem.unit = item.unit_name;
                this.otherItem.quantity = null;
                this.otherItem.price = null;
                this.otherItemResults = [];
            },

            addOtherItem(){
                let item = this.otherItem;
                item.amount = this.totalAmount;
                this.otherMaterialItems.push(item);
                this.otherItem = {
                    id: null,
                    name: "",
                    unit: "",
                    quantity: null,
                    price: null,
                    thickness: null,
                    size: null
                };
            },

            removeOtherItem(i){
                this.otherMaterialItems.splice(i,1);
            },

            searchVendor(){
                this.vendorResults = [];
                this.vendor.id = null;
                this.vendor.contactNo = "";
                this.vendor.address = "";

                if(this.vendor.name.length){
                    this.vendorResults = this.vendors.filter((item) => {
                        if(item.name.toUpperCase() == this.vendor.name.toUpperCase()){
                            this.selectVendor(item);
                        }
                        else{
                            return item.name.toUpperCase().search(this.vendor.name.toUpperCase()) != -1;
                        }
                    });
                }

            },
            selectVendor(item){
                this.vendor.id = item.id;
                this.vendor.name = item.name;
                this.vendor.contactNo = item.contact_no;
                this.vendor.address = item.address;
                this.vendorResults = [];
            },
            getCategoryName(id){
                for (let i=0; i<this.categories.length; i++){
                    if(this.categories[i].id == id){
                        return this.categories[i].name;
                    }
                }
                return "";
            }

        },
        created: function() {
            this.grades = this.items.grades;
            this.rawMaterials = this.items.rawMaterials;
            this.vendors = this.items.vendors;
            this.categories = this.items.categories;
            this._token = this.items.token;
            this.formUrl = this.items.formUrl;
        },
        mounted() {
            console.log('Create Purchase Order Component mounted.')
        }
    }
</script>
