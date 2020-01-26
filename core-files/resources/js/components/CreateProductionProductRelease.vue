<template>
    <div>
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
                        <th>Produced Qty</th>
                        <th>Remaining Qty</th>
                        <th>Release Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(productionGood,index) in productionGoods">
                        <td>{{ index+1 }} <input v-if="productionGood.remaining_quantity > 0" type="hidden" :name="'products['+ index +'][id]'" :value="productionGood.id"></td>
                        <td>{{ productionGood.good ? productionGood.good.name : '' }}</td>
                        <td>{{ productionGood.thickness }}</td>
                        <td>{{ productionGood.size }}</td>
                        <td>{{ productionGood.produced_quantity }}</td>
                        <td>{{ productionGood.remaining_quantity }}</td>
                        <td><input v-if="productionGood.remaining_quantity > 0" type="text" :name="'products['+ index +'][released_qty]'" :max="productionGood.remaining_quantity"></td>
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
                productionGoods: [],
            }
        },

        computed: {

        },

        methods: {


        },
        created: function () {
            this.productionGoods = this.items.goods;
            console.log(this.items.goods);
        },

        mounted() {
            console.log('Create Production product Component mounted.')
        }
    }
</script>
