<template>
    <div>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group search-form-group" >
                            <label>PURCHASE ORDER (By System)</label>
                            <input  type="text" name="purchase_order_id"  v-model="purchaseOrder.id"  id="select-sales-order" :class="purchaseOrder.id ? 'form-control': 'form-control text-danger'" @keyup="searchSalesOrderID" required>
                            <ul class="search-result" v-if="purchaseOrderIDResults.length">
                                <li v-for="searchResult in purchaseOrderIDResults" @click="selectSalesOrderId(searchResult)">{{ searchResult.id }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group search-form-group" >
                            <label>PURCHASE ORDER (Manual Entry)</label>
                            <input type="text" v-model="purchaseOrder.challan_no_mannual" :class="purchaseOrder.challan_no_mannual ? 'form-control': 'form-control text-danger'" @keyup="searchSalesOrder" required>
                            <ul class="search-result" v-if="purchaseOrderResults.length">
                                <li v-for="searchResult in purchaseOrderResults" @click="selectSalesOrder(searchResult)">{{ searchResult.challan_no_mannual }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>SELECT PAYMENT TYPE</label>
                            <select name="payment_type_id" class="form-control" v-model="paymentTypeId" v-on:change="changePaymentType" required>
                                <option value="">---Select Payment Type---</option>
                                <option v-for="paymentType in paymentTypes" :value="paymentType.id">{{ paymentType.name }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>PAYMENT DATE</label>
                            <datepicker input-class="form-control" v-model="paymentDate"></datepicker>
                            <input type="hidden" name="payment_date" :value="dateOfPayment">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>AMOUNT</label>
                            <input type="text" name="amount" v-model="amount" :max="purchaseOrder.due" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4" v-for="(field,index) in fields">
                        <div class="form-group">
                            <label>{{ field.name }}</label>
                            <input type="text" :name="'fields[' + field.id + ']'" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group text-right" v-if="amount > 0 && amount <= purchaseOrder.due">
                    <button class="btn btn-success btn-sm" type="submit">CREATE</button>
                </div>
            </div>
        </div>

        <div class="box" v-if="purchaseOrder.name">
            <div class="box-header">
                <h4>PURCHASE ORDER DETAILS</h4>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td><strong>Date : </strong>{{ purchaseOrder.date }}</td>
                        <td><strong>Vendor Name : </strong>{{ purchaseOrder.name }}</td>
                        <td><strong>Contact No : </strong>{{ purchaseOrder.contactNo }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Amount : </strong>{{ purchaseOrder.total }}</td>
                        <td><strong>Paid Amount : </strong>{{ purchaseOrder.paid }}</td>
                        <td><strong>Due Amount : </strong>{{ purchaseOrder.due }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['items'],
        data(){
            return {
                paymentTypes: this.items.paymentTypes ? this.items.paymentTypes:[],
                purchaseOrders: this.items.purchaseOrders ? this.items.purchaseOrders:[],
                fields: [],
                paymentTypeId: "",
                paymentDate: new Date(),
                purchaseOrderId: "",
                purchaseOrder: {
                    id:null,
                    challan_no_mannual:"",
                    date: null,
                    contactNo: null,
                    name: null,
                    total: null,
                    paid: null,
                    due: null,
                },
                purchaseOrderResults: [],
                purchaseOrderIDResults: [],
                sortPurchaseOrderResults:[],
                purchaseOrderChalanNoManual:[],
                amount: 0,
            };
        },
        computed: {
            dateOfPayment: function(){
                return this.paymentDate ? moment(this.paymentDate).format('YYYY-MM-DD') : '';
            },
        },
        methods: {
            searchSalesOrder(){
                if(this.purchaseOrder.challan_no_mannual.length){
                    this.purchaseOrderResults = this.purchaseOrders.filter((item) => {
                        if(!item.challan_no_mannual )
                            return false;
                        if(item.challan_no_mannual.toUpperCase() === this.purchaseOrder.challan_no_mannual.toUpperCase()){
                            return this.purchaseOrderResults;
                        }
                        else {
                            return item.challan_no_mannual.toUpperCase().search(this.purchaseOrder.challan_no_mannual.toUpperCase()) != -1;
                        }
                    });
                }else{
                    this.purchaseOrderResults = [];
                    this.purchaseOrder.id=null;
                    this.purchaseOrder.date=null;
                    this.purchaseOrder.name=null,
                    this.purchaseOrder.contactNo=null;
                    this.purchaseOrder.total=null;
                    this.purchaseOrder.paid=null;
                    this.purchaseOrder.due=null;
                    this.purchaseOrderIDResults=[];
                }
            },
            selectSalesOrder(item){
                this.purchaseOrder.challan_no_mannual = item.challan_no_mannual;
                this.purchaseOrder.id = item.id;
                this.purchaseOrder.name = item.vendor.name;
                this.purchaseOrder.date = item.purchase_date;
                this.purchaseOrder.contactNo = item.vendor.contact_no;
                this.purchaseOrder.total = item.amount;
                this.purchaseOrder.paid = item.paid_amount;
                this.purchaseOrder.due = item.due_amount;
                this.purchaseOrderResults = [];
            },
            searchSalesOrderID(){
                if(this.purchaseOrder.id.length){
                    this.purchaseOrderIDResults = this.purchaseOrders.filter((item) => {
                        if(!item.id )
                            return false;
                        if(item.id == this.purchaseOrder.id){
                           return this.purchaseOrderIDResults;
                        }
                        else{
                            const itemId = ""+item.id;
                            return itemId.search(this.purchaseOrder.id) != -1;
                        }
                    });
                }else{
                    this.purchaseOrderResults = [];
                    this.purchaseOrderIDResults=[];
                    this.purchaseOrder.challan_no_mannual="";
                    this.purchaseOrder.id=null;
                    this.purchaseOrder.date=null;
                    this.purchaseOrder.name=null;
                        this.purchaseOrder.contactNo=null;
                    this.purchaseOrder.total=null;
                    this.purchaseOrder.paid=null;
                    this.purchaseOrder.due=null;

                }
            },
            selectSalesOrderId(item){
                this.purchaseOrder.id = item.id;
                this.purchaseOrder.challan_no_mannual = item.challan_no_mannual;
                this.purchaseOrder.name = item.vendor.name;
                this.purchaseOrder.date = item.purchase_date;
                this.purchaseOrder.contactNo = item.vendor.contact_no;
                this.purchaseOrder.total = item.amount;
                this.purchaseOrder.paid = item.paid_amount;
                this.purchaseOrder.due = item.due_amount;
                this.purchaseOrderIDResults=[];
            },
            changePaymentType: function(){
                if(this.paymentTypeId){
                    this.fields = [];
                    for(let i=0; i<this.paymentTypes.length; i++){
                        if(this.paymentTypes[i].id == this.paymentTypeId){
                            this.fields = this.paymentTypes[i].fields;
                        }
                    }
                }
            },
        },
        created(){
            console.log(this.items);
            this.purchaseOrders = this.items.purchaseOrders;
            this.paymentTypes = this.items.paymentTypes;
            // console.log(this.purchaseOrders.length);
            // for(let i = 0 ; i < this.purchaseOrders.length;i++){
            //     const a = this.purchaseOrders[i].challan_no_mannual;
            //     this.purchaseOrderChalanNoManual=JSON.stringify(a);
            //     console.log(i,"chalan Numbers",this.purchaseOrderChalanNoManual);
            //     console.log("type",typeof this.purchaseOrderChalanNoManual);
            // }
        },
        mounted() {

        },
    };
</script>
