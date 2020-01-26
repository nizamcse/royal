<template>
    <div>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group search-form-group" >
                            <label>SALES ORDER (By System)</label>
                            <input  type="text" name="sales_order_id"  v-model="salesOrder.id"  id="select-sales-order" :class="salesOrder.id ? 'form-control': 'form-control text-danger'" @keyup="searchSalesOrderID" required>
                            <ul class="search-result" v-if="salesOrderIDResults.length">
                                <li v-for="searchResult in salesOrderIDResults" @click="selectSalesOrderId(searchResult)">{{ searchResult.id }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group search-form-group" >
                            <label>SALES ORDER (Manual Entry)</label>
                            <input type="text" name="so_no_manual_id" v-model="salesOrder.soNoManual" :class="salesOrder.soNoManual ? 'form-control': 'form-control text-danger'" @keyup="searchSalesOrder" required>
                            <ul class="search-result" v-if="salesOrderResults.length">
                                <li v-for="searchResult in salesOrderResults" @click="selectSalesOrder(searchResult)">{{ searchResult.so_no_manual }}</li>
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
                            <datepicker input-class="form-control" v-model="paymentDate" fillable :typeable="true"></datepicker>
                            <input type="hidden" name="payment_date" :value="dateOfPayment">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>AMOUNT</label>
                            <input type="text" name="amount" v-model="amount" :max="salesOrder.dueAmount" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4" v-for="(field,index) in fields">
                        <div class="form-group">
                            <label>{{ field.name }}</label>
                            <input type="text" :name="'fields[' + field.id + ']'" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group text-right" v-if="amount > 0 && amount <= salesOrder.dueAmount">
                    <button class="btn btn-success btn-sm" type="submit">CREATE</button>
                </div>
            </div>
        </div>
        <div class="box" v-if="salesOrder.customerName">
            <div class="box-header">
                <h4>CUSTOMER DETAILS</h4>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td><strong>Name: </strong>{{ salesOrder.customerName }}</td>
                        <td><strong>Address: </strong>{{ salesOrder.customerAddress }}</td>
                        <td><strong>Contact No.: </strong>{{ salesOrder.customerContactNo }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="box" v-if="salesOrder.id">
            <div class="box-header">
                <h4>SALES ORDER DETAILS</h4>
                <h5><strong>Type: </strong>{{ salesOrder.type }}</h5>
            </div>
            <div class="box-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td><strong>Sales Order No#(By system): </strong>{{ salesOrder.id }}</td>
                        <td><strong>Sales Order No#(Manual Entry): </strong>{{ salesOrder.soNoManual }}</td>
                        <td><strong>Sold Out Date:: </strong>{{ salesOrder.soldOutDate }}</td>
                    </tr>
                    <tr>
                        <td><strong>Total Payable: </strong>৳ {{ salesOrder.payableAmount }} BDT</td>
                        <td><strong>Paid Amount : </strong>৳ {{ salesOrder.paidAmount }} BDT</td>
                        <td><strong>Due Amount : </strong>৳ {{ salesOrder.dueAmount }} BDT</td>
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
        data: function() {

            return {
                paymentTypes: [],
                salesOrders: this.items.salesOrders ? this.items.salesOrders:[],
                fields: [],
                paymentTypeId: "",
                paymentDate: new Date(),
                salesOrderId: "",
                salesOrder: {
                    id:null,
                    soNoManual:"",
                    customerName: "",
                    customerContactNo: "",
                    customerAddress: "",
                    type: "",
                    soldOutDate: null,
                    payableAmount: null,
                    paidAmount: null,
                    dueAmount: null,
                },
                salesOrderResults: [],
                salesOrderIDResults: [],
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
                if(this.salesOrder.soNoManual.length){
                    this.salesOrderResults = this.salesOrders.filter((item) => {
                        if(!item.so_no_manual )
                            return false;
                        // if(item.so_no_manual.toUpperCase() == this.salesOrder.soNoManual.toUpperCase()){
                        //    return this.salesOrderResults;
                        //
                        // }
                        else{
                            return item.so_no_manual.toUpperCase().search(this.salesOrder.soNoManual.toUpperCase()) !== -1;
                        }
                    });

                }else{
                    this.salesOrderResults = [];
                    this.salesOrder.id= null,
                    this.salesOrder.soNoManual="";
                    this.salesOrder.customerName="";
                    this.salesOrder.customerContactNo="";
                    this.salesOrder.customerAddress="";
                    this.salesOrder.type= null;
                    this.salesOrder.soldOutDate= null;
                    this.salesOrder.payableAmount= null;
                    this.salesOrder.paidAmount= null;
                    this.salesOrder.dueAmount= null;
                }

            },
            selectSalesOrder(item){
                this.salesOrder.id= item.id;
                this.salesOrder.soNoManual= item.so_no_manual;
                this.salesOrder.customerName= item.customer_id ? item.customer.name : item.name;
                this.salesOrder.customerContactNo= item.customer_id ? item.customer.contact_no : item.contact_no;
                this.salesOrder.customerAddress= item.customer_id ? item.customer.address : item.address;
                this.salesOrder.type= item.type === 1 ? "Purchase Sales Order" : "Sales Order";
                this.salesOrder.soldOutDate= item.sold_out_date;
                this.salesOrder.payableAmount= item.payable_amount;
                this.salesOrder.paidAmount= item.paid_amount;
                this.salesOrder.dueAmount= item.due_amount;
                this.salesOrderResults=[];
            },
            searchSalesOrderID(){
                if(this.salesOrder.id.length){
                    this.salesOrderIDResults = this.salesOrders.filter((item) => {
                        if(!item.id )
                            return false;
                        if(item.id === this.salesOrder.id){
                          return this.salesOrderIDResults;
                        }
                        else{
                            const itemId = ""+item.id;
                            return itemId.search(this.salesOrder.id) !== -1;
                        }
                    });
                }else{
                    this.salesOrder.id= null,
                    this.salesOrder.soNoManual="";
                    this.salesOrder.customerName="";
                    this.salesOrder.customerContactNo="";
                    this.salesOrder.customerAddress="";
                    this.salesOrder.type= null;
                    this.salesOrder.soldOutDate= null;
                    this.salesOrder.payableAmount= null;
                    this.salesOrder.paidAmount= null;
                    this.salesOrder.dueAmount= null;
                    this.salesOrderIDResults =[];
                }

            },
            selectSalesOrderId(item){
                this.salesOrder.id= item.id;
                this.salesOrder.soNoManual= item.so_no_manual;
                this.salesOrder.customerName= item.customer_id ? item.customer.name : item.name;
                this.salesOrder.customerContactNo= item.customer_id ? item.customer.contact_no : item.contact_no;
                this.salesOrder.customerAddress= item.customer_id ? item.customer.address : item.address;
                this.salesOrder.type= item.type == 1 ? "Purchase Sales Order" : "Sales Order";
                this.salesOrder.soldOutDate= item.sold_out_date;
                this.salesOrder.payableAmount= item.payable_amount;
                this.salesOrder.paidAmount= item.paid_amount;
                this.salesOrder.dueAmount= item.due_amount;
                this.salesOrderIDResults=[];
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
        created: function() {
            this.paymentTypes = this.items.paymentTypes;
            this.salesOrders = this.items.salesOrders;
        },
        mounted() {

        },


    };
</script>
