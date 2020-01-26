<template>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group search-form-group" >
                <label>SALES ORDER (By System)</label>
                <input  type="text" name="sales_order_id"  v-model="salesOrder.id"  id="select-sales-order" :class="salesOrder.id ? 'form-control': 'form-control text-danger'" @keyup="searchSalesOrderID" required>
                <ul class="search-result" v-if="salesOrderIDResults.length">
                    <li v-for="searchResult in salesOrderIDResults" @click="selectSalesOrderId(searchResult)">{{ searchResult.id }}</li>
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group search-form-group" >
                <label>SALES ORDER (Manual Entry)</label>
                <input type="text" v-model="salesOrder.so_no_manual" :class="salesOrder.so_no_manual ? 'form-control': 'form-control text-danger'" @keyup="searchsalesOrder" required>
                <ul class="search-result" v-if="salesOrderResults.length">
                    <li v-for="searchResult in salesOrderResults" @click="selectsalesOrder(searchResult)">{{ searchResult.so_no_manual}}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['items'],
        data: function () {
            return {
                salesOrders: this.items.salesOrders ? this.items.salesOrders:[],
                salesOrder: {
                    so_no_manual:"",
                    id:null
                },
                salesOrderResults: [],
                salesOrderIDResults: []
            }
        },
        methods:{
            searchsalesOrder(){
                if(this.salesOrder.so_no_manual.length){

                    this.salesOrderResults = this.salesOrders.filter((item) => {
                        if(!item.so_no_manual )
                            return false;
                        if(item.so_no_manual.toUpperCase() == this.salesOrder.so_no_manual.toUpperCase()){
                          return this.salesOrderResults;
                        }
                        else{
                            return item.so_no_manual.toUpperCase().search(this.salesOrder.so_no_manual.toUpperCase()) != -1;
                        }
                    });

                }else{
                    this.salesOrderResults = [];
                    this.salesOrder.id=null;
                }

            },
            selectsalesOrder(item){
                this.salesOrder.so_no_manual = item.so_no_manual;
                this.salesOrder.id = item.id;
                this.$root.$refs.getSalesOrderItem.loadItems(this.salesOrder.id);
                this.salesOrderResults=[];
            },
            searchSalesOrderID(){
                if(this.salesOrder.id.length){
                    this.salesOrderIDResults=
                        this.salesOrders.filter((item) =>{
                            if(!item.id )
                                return false;
                            if(item.id == this.salesOrder.id){
                                this.selectSalesOrderId(item);
                            }
                            else{
                                const itemId = ""+item.id;
                                return itemId.search(this.salesOrder.id) != -1;
                            }
                        });
                }else{
                    this.salesOrderIDResults = [];
                    this.salesOrder.so_no_manual="";
                }
                return  this.salesOrderIDResults;
            },
            selectSalesOrderId(item){
                this.salesOrder.id = item.id;
                this.salesOrder.so_no_manual = item.so_no_manual;
                this.$root.$refs.getSalesOrderItem.loadItems(this.salesOrder.id);
                this.salesOrderIDResults=[];
            }
        },
        computed:{

        },
        created(){
            this.salesOrders= this.items.salesOrders;
            console.log(this.salesOrders);
        }
    }
</script>
