<template>
    <div class="box">
        <div class="box-header">
            <h3>
                ACCOUNTS CLOSING
            </h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <label>OPENING MONTH NAME</label>
                    <input type="text" class="form-control" :value="openingMonthName" readonly>
                </div>
                <div class="col-md-4">
                    <label>YEAR</label>
                    <input type="text" class="form-control" name="opening_year" v-model="openingYear">
                </div>
                <div class="col-md-4">
                    <label>OPENING MONTH NAME</label>
                    <input type="text" class="form-control" :value="openingMonthName" readonly>
                </div>
                <div class="col-md-4">
                    <label>YEAR</label>
                    <input type="text" class="form-control" name="closing_year" :value="closingYear" readonly>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['items'],

        data: function() {

            return {
                openingMonthId: null,
                openingMonthName: null,
                closingMonthId: null,
                closingMonthName: null,
                openingYear: new Date().getFullYear(),
                salaryReports: [],
                apiUrl: null,
                downloadUrl: null,
                downloadingUrl: null,
                filledData: {
                    month: '01',
                    year: new Date().getFullYear()
                },
                prevMonth: 0,
                months: [
                    "January",
                    "February",
                    "March",
                    "April",
                    "May",
                    "June",
                    "July",
                    "August",
                    "September",
                    "October",
                    "November",
                    "December",
                ]
            };
        },
        computed: {
            closingYear(){
                if(this.openingMonthId && this.closingMonthId){
                    let difference = this.openingMonthId - this.closingMonthId;
                    if(difference == 1){
                        return this.openingYear + 1;
                    }else if(difference == 11){
                        return this.openingYear;
                    }
                }
                return null;
            }
        },

        methods: {

        },
        created: function() {
            if(items.openingMonth && items.closingMonth){
                this.openingMonthId = items.openingMonth;
                this.openingMonthName = this.months[items.openingMonth - 1];
                this.closingMonthId = items.closingMonth;
                this.openingMonthName = this.months[items.closingMonth - 1];
            }
        },
        mounted() {

        },
    };
</script>
