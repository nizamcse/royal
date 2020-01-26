<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h4>CUSTOMER DETAILS</h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Customer Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" v-model="customer.name" @keyup="searchCustomer" placeholder="Example: Mr. Alam | Alam Enterprise" required>
                            <input type="hidden" v-model="customer.id" :name="'customer_id'">
                            <ul class="search-result" v-if="customerCollections.length">
                                <li v-for="customerResult in customerCollections" @click="selectCustomer(customerResult)">{{ customerResult.name }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Customer Address</label>
                            <input type="text" class="form-control" v-model="customer.address" readonly>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" class="form-control"  v-model="customer.contactNo" readonly>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="so_no_manual">Sales Order No# (Manual Entry)</label>
                            <input type="text" :name="'so_no_manual'" id="so_no_manual" class="form-control" placeholder="Example: 1000">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="so_no_manual_extra">Additional Sales Order No# (Extra Manual)</label>
                            <input type="text" :name="'additional_so_no_manual'" id="so_no_manual_extra" class="form-control" placeholder="If more than one, separate by comma.">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Delivery Date <span class="text-danger">*</span></label>
                            <datepicker :name="'sold_out_date'" v-model="soldOutDate" input-class="form-control" :required="true" :typeable="true" :placeholder="'Select a Date. Example: 1 Jan 2000'"></datepicker>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="box" style="min-height: 495px">
                    <div class="box-header">
                        <h4>SEARCH PRODUCT <button type="button" class="btn btn-sm btn-warning " @click="getJsonGoodsRefresh()" ><i class="fa fa-refresh" id="btn-get-json-goods"></i></button></h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search Product" v-model="searchedText" v-on:keyup="searchItem">
                        </div>
                        <table class="table table-bordered">
                            <tbody>
                            <tr v-if="itemCollections.length" v-for="(product,index) in itemCollections">
                                <td v-on:click="selectProduct(index)" v-if="index < 10">{{ product.detail_name }}</td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box" style="min-height: 495px">
                    <div class="box-header"><h4>SALES DETAILS</h4></div>
                    <div class="box-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>PRODUCT NAME</th>
                                <th>PRICE</th>
                                <th>UNIT</th>
                                <th>QTY</th>
<!--                                <th>DISCOUNT(%)</th>-->
                                <th>TOTAL</th>
                                <th>X</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(soldProduct,index) in soldProducts">
                                <td>
                                    {{ soldProduct.detail_name }}
                                    <input type="hidden" :name="'goods['+ index +'][id]'" v-model="soldProducts[index].id">
                                </td>
                                <td>{{ soldProduct.price }}</td>
                                <td>{{ soldProduct.unit_name }}</td>
                                <td>
                                    <input type="text" class="form-control input-sm" :name="'goods['+ index +'][quantity]'" v-model="soldProducts[index].quantity" v-on:keyup="changeQuantity(index)" style="width: 100px">
                                </td>
<!--                                <td>-->
                                    <input type="hidden" class="form-control input-sm" :name="'goods['+ index +'][discount]'" v-model="soldProducts[index].discount" v-on:keyup="changeQuantity(index)" style="width: 100px">
<!--                                </td>-->
                                <td>{{ soldProduct.subTotal }}</td>
                                <td><button class="btn-remove" type="button" @click="deSelectProduct(index)">-</button></td>

                            </tr>
                            <tr v-if="!soldProducts.length">
                                <td colspan="6">No product </td>
                            </tr>
                            <tr v-for="ocField in otherChargeField">
                                <td colspan="4">
                                    <input type="text" :name="'other_charge_details['+ocField+'][charge_description]'" class="form-control" placeholder="Other Charge Description" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control input-sm" :name="'other_charge_details['+ocField+'][charge_amount]'" v-model="otherChargeAmounts[ocField]" v-on:keyup="calculateOtherCharge()" style="width: 100px" required>
                                </td>
                                <td>
                                    <button class="btn-remove" type="button" @click="subOtherChargeField(ocField)">-</button>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th colspan="4">
                                    <span>Total Other Charge</span>
                                    <a type="button" class="btn btn-sm btn-success" @click="addOtherChargeField()">Add Field</a>
                                </th>
                                <th colspan="2"><input type="text" class="form-control input-sm" :name="'other_charge'" v-model="otherCharge" style="width: 100px" readonly></th>
                            </tr>
                            <tr>
                                <th colspan="4">Total Discount</th>
                                <th colspan="2"><input type="text" class="form-control input-sm" :name="'total_discount'" v-model="totalDiscount" v-on:keyup="calculateTotal()" style="width: 100px"></th>
                            </tr>
                            <tr class="bg-info">
                                <th colspan="4">Grand Total</th>
                                <th colspan="2">৳ {{ this.soldTotal }} BDT</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="form-group text-right" style="margin: 15px;">
                    <button class="btn btn-sm flat btn-success" type="submit" v-if="soldProducts.length">CREATE SALES ORDER</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['routes'],

        data: function() {

            return {
                getJsonGoodsRoute: "",
                getJsonCustomersRoute: "",
                customers: [],
                customerCollections: [],
                customer: {
                    id: null,
                    name: "",
                    address: "",
                    contactNo: "",
                },

                products: [],
                itemCollections: [],
                soldProducts: [],
                units: [],
                searchedText: "",
                soldTotal: 0,
                otherCharge: 0,
                totalDiscount: 0,
                otherChargeField: 0,
                otherChargeAmounts: [],
                soldOutDate:  "",
                btnJsonGoodsRefresh: [],
            };
        },

        methods: {
            initGoods(){
                axios.get(this.getJsonGoodsRoute).then((response) => {
                    this.itemCollections = response.data;
                    this.products = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            initCustomers(){
                axios.get(this.getJsonCustomersRoute).then((response) => {
                    this.customers = response.data;
                }).catch((error) => {
                    console.log(error);
                });
            },
            searchCustomer(){
                if (this.customer.name.length){
                    this.customerCollections = this.customers.filter((item) => {
                        return item.name.toUpperCase().search(this.customer.name.toUpperCase()) != -1;
                    });
                } else{
                    this.customerCollections = [];
                    this.customer.id= null;
                    this.customer.address = "";
                    this.customer.contactNo = "";
                }
            },
            selectCustomer(obj){
                this.customer.id = obj.id;
                this.customer.name = obj.name;
                this.customer.address = obj.address;
                this.customer.contactNo = obj.contact_no;
                this.customerCollections = [];
            },
            selectProduct: function (index) {
                let item = this.itemCollections[index];
                this.itemCollections.splice(index,1);
                item.quantity = 0;
                item.subTotal = 0;
                item.discount = 0;
                this.soldProducts.push(item);
                this.removeProduct(item.id);
                this.searchItem();
                this.calculateTotal();
            },
            removeProduct: function (id) {
                for (let i=0; i<this.products.length; i++){
                    if(this.products[i].id == id){
                        this.products.splice(i,1);
                        break;
                    }
                }
            },
            deSelectProduct: function (index) {
                let item = this.soldProducts[index];
                delete item.quantity;
                delete item.subTotal;
                delete item.discount;
                this.products.push(item);
                this.soldProducts.splice(index,1);
                this.searchItem();
                this.calculateTotal();
            },
            searchItem: function () {
                this.itemCollections = [];
                if(this.searchedText.length){
                    this.itemCollections = this.products.filter((item) => {
                        return item.name.toUpperCase().search(this.searchedText.toUpperCase()) != -1;
                    });
                }else{
                    this.itemCollections = this.products;
                }
            },
            changeQuantity: function (index) {
                let item = this.soldProducts[index];
                let discount = (parseFloat(item.discount ? item.discount : 0) / 100 );
                let st = parseFloat(item.quantity ? item.quantity : 0) * parseFloat(item.price);
                let total_discount = st * discount;
                st = st - parseFloat(total_discount).toFixed(2);
                item.subTotal = st.toFixed(2);
                this.soldProducts.splice(index,1,item);
                this.calculateTotal();
            },
            calculateTotal: function () {
                this.soldTotal = 0.0;
                for (let i=0; i<this.soldProducts.length; i++){
                    this.soldTotal += parseFloat(this.soldProducts[i].subTotal);
                }
                this.soldTotal += parseFloat(this.otherCharge ? this.otherCharge : 0);
                this.soldTotal -= parseFloat(this.totalDiscount ? this.totalDiscount : 0);
                this.soldTotal.toFixed(2);
            },
            addOtherChargeField(){
                this.otherChargeField = this.otherChargeField +1 ;
            },
            calculateOtherCharge(){
                this.otherCharge = 0.0;
                for(let i=0; i<this.otherChargeAmounts.length; i++){
                    this.otherCharge += parseFloat(this.otherChargeAmounts[i] ? this.otherChargeAmounts[i] : 0);
                }
                this.calculateTotal();
            },
            reCalculateOtherCharge(index){
                this.otherCharge -= parseFloat(this.otherChargeAmounts[index] ? this.otherChargeAmounts[index] : 0);
                this.otherChargeAmounts.splice(index, 1);
                this.calculateTotal();
            },
            subOtherChargeField(index){
                this.reCalculateOtherCharge(index);
                this.otherChargeField = this.otherChargeField -1 ;
            },
            getJsonGoodsRefresh() {
                this.btnJsonGoodsRefresh = document.getElementById('btn-get-json-goods');
                this.btnJsonGoodsRefresh.setAttribute('class', 'fa fa-refresh fa-spin');
                axios.get(this.getJsonGoodsRoute).then((response) => {
                    if (!response) {
                        return;
                    } else {
                        this.refreshItemCollections(response.data);
                    }
                    return;
                }).catch((error) => {
                    console.log(error);
                });
            },
            refreshItemCollections(data){
                this.products = data;
                for(let i=0; i<this.soldProducts.length; i++){
                    for (let j=0; j<this.products.length; j++){
                        if (this.products[j].id == this.soldProducts[i].id){
                            this.products.splice(j,1);
                            break;
                        }
                    }
                }
                this.searchItem();
                this.btnJsonGoodsRefresh.setAttribute('class', 'fa fa-refresh');
            },
        },
        created: function() {
            this.getJsonGoodsRoute = this.routes.getJsonGoodsRoute;
            this.getJsonCustomersRoute = this.routes.getJsonCustomersRoute;
            this.initGoods();
            this.initCustomers();
        },
        mounted() {
        },
    };
</script>
