<template>
    <div>
        <table class="table table-bordered table-striped" id="workorder_tbl" >
            <thead>
            <tr>
                <th>Product Title</th>
                <th>Unit</th>
                <th> Ordered Qty </th>
                <th> Delivered Qty </th>
                <th> Returned Qty </th>
                <th> Return Qty </th>
                <th> Unit Price </th>
                <th> Sub Total</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product,index) in products">
                <td v-if="product.good">{{ product.good.name }} <input type="hidden" :name="'sales_od[' + index +'][sales_od_id]'" :value="product.id" ></td>
                <td v-else>{{ product.inventory_item.name }} <input type="hidden" :name="'sales_od[' + index +'][sales_od_id]'" :value="product.id" ></td>
                <td>{{ product.unit ? product.unit.name : '' }}</td>
                <td>{{ product.quantity }}</td>
                <td>{{ product.delivered_quantity }}</td>
                <td>{{ product.returned_quantity }}</td>
                <td>
                    <input type="number"
                           :name="'sales_od[' + index + '][quantity]'"
                           class="form-control"
                           v-model="products[index].return_quantity"
                           :max="product.delivered_quantity - product.returned_quantity"
                           v-if="(product.delivered_quantity - product.returned_quantity) > 0"
                           @keyup="calculateSubtotal(index)"
                    >
                </td>
                <td>{{ product.unit_price }}</td>
                <td>{{ product.unit_price * (products[index].return_quantity ? products[index].return_quantity : 0 ) }}</td>
            </tr>
            <tr>
                <td colspan="7">Grand Total</td>
                <td>{{ total }}</td>
            </tr>

            </tbody>
        </table>
        <div class="form-group text-right">
            <button class="btn btn-sm btn-success" type="submit">Create Sales Return Chalan</button>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['uri'],
        data: function() {

            return {
                products: [],
                total: 0,
                apiUrl: null,
            };
        },

        methods: {
            loadItems: function(id){

                if(!id){
                    this.products = [];
                    return;
                }

                console.log(id);

                var app =this;
                axios.get(this.apiUrl + '/' + id)
                    .then(response => {
                        app.products = response.data;

                    })
                    .catch(e => {
                        this.errors.push(e)
                    });
            },
            calculateSubtotal: function(index){
                let t = this.products[index];
                console.log(index,t);
                let q = t.return_quantity;
                let p = t.unit_price;
                let delivered_amount = parseFloat(p) * parseInt(q);
                t.delivered_amount = delivered_amount;
                this.products.splice(index,1,t);
                this.grandTotal();
            },
            grandTotal: function () {

                this.total = 0;

                for (let i=0; i<this.products.length; i++){
                    this.total += parseFloat(this.products[i].unit_price * (this.products[i].return_quantity ? this.products[i].return_quantity : 0));
                }

            }

        },
        created: function() {
            this.apiUrl = this.uri;
        },
        mounted() {

        },


    };
</script>