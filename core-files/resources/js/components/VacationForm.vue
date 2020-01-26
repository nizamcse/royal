<template>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" v-model="name">
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Vacation From</label>
                        <datepicker input-class="form-control" v-model="vacationFrom"></datepicker>
                        <input type="hidden" name="from_date" :value="fromDate">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Vacation To</label>
                        <datepicker input-class="form-control" v-model="vacationTo"></datepicker>
                        <input type="hidden" name="to_date" :value="toDate">
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success btn-sm" type="submit" :disabled="validateEntry">{{ btnText }}</button>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['items'],

        data: function() {

            return {
                name: "",
                vacationFrom: null,
                vacationTo: null,
                btnText: 'Create Vacation'
            };
        },
        computed: {
            fromDate: function(){
                return this.vacationFrom ? moment(this.vacationFrom).format('YYYY-MM-DD') : '';
            },
            toDate: function(){
                return this.vacationTo ? moment(this.vacationTo).format('YYYY-MM-DD') : '';
            },
            validateEntry: function(){
                if(this.name.length && this.vacationFrom && this.vacationTo){
                    return false;
                }
                return true;
            }
        },

        methods: {
        },
        created: function() {
            if(this.items){
                let item = this.items.vacation;
                let fromDate = item.from_date.split('-');
                let toDate = item.to_date.split('-');
                this.name = item.name;
                this.vacationFrom = new Date(fromDate[0],fromDate[1] - 1,fromDate[2]);
                this.vacationTo = new Date(toDate[0],toDate[1] - 1,toDate[2]);
                this.btnText = 'Update Vacation'
            }
        },
        mounted() {

        },
    };
</script>
