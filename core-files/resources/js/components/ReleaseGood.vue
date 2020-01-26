<template>
    <div>
        <table class="table table-bordered table-striped" id="workorder_tbl" >
            <thead>
            <tr>
                <th>Goods Name</th>
                <th>Produced Quantity</th>
                <th>Released Quantity</th>
                <th>Release Quantity</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(product,index) in products">
                <td>
                    {{ product.title }}
                    <input type="hidden" :name="'chalan_details[' + index + '][item_type]'" :value="product.item_type" >
                    <input type="hidden" :name="'chalan_details[' + index + '][p_req_d_id]'" :value="product.p_req_d_id" >
                    <input type="hidden" :name="'chalan_details[' + index + '][item_id]'" :value="product.item_id" >
                    <input type="hidden" :name="'chalan_details[' + index + '][unit_id]'" :value="product.unit_id" >
                </td>
                <td>{{ product.unit }}</td>
                <td>{{ product.total_qty }}</td>
                <td>{{ product.total_qty - product.rem_qty }}</td>
                <td>{{ product.rem_qty - products[index].quantity }}</td>
                <td><input type="number" :name="'chalan_details[' + index + '][quantity]'"  v-model="products[index].quantity" class="form-control" v-if="product.rem_qty > 0" :max="product.rem_qty"></td>
            </tr>

            </tbody>
        </table>
    </div>
</template>

<script>

    export default {

        data: function() {

            return {
                products: [],
                total: 0,
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
                axios.get('/wirehouse/product-order/items/' + id)
                    .then(response => {
                        app.products = response.data.items;

                    })
                    .catch(e => {
                        this.errors.push(e)
                    });
            },


        },
        created: function() {

        },
        mounted() {

        },


    };
</script>