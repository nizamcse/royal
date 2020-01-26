<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title d-block">
                    ACCOUNT STATEMENTS
                    <a :href="downloadUrl" class="btn btn-sm pull-right btn-info flat" target="_blank"><i class="fa fa-download"></i> DOWNLOAD</a>
                </h3>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Account Type</label>
                            <select name="type" class="form-control" v-model="accountId" v-on:change="resetUrl">
                                <option value="">Select Account Type</option>
                                <option value="OE">Owners Equity</option>
                                <option value="A">Asset</option>
                                <option value="L">Liability</option>
                                <option value="E">Expense</option>
                                <option value="R">Revenue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date From</label>
                            <datepicker input-class="form-control" v-model="dateFrom" @selected="resetFromDate"></datepicker>
                            <input id="from-date" type="hidden" name="from_date" :value="fromDate">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Date To</label>
                            <datepicker input-class="form-control" v-model="dateTo" @selected="resetToDate"></datepicker>
                            <input id="to-date" type="hidden" name="to_date" :value="toDate">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Date</th>
                        <th>Account</th>
                        <th>Debit (Dr)</th>
                        <th>Credit (Cr)</th>
                        <th>Balance</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="statements.length" v-for="(statement,i) in statements">
                        <td>{{ i+1 }}</td>
                        <td>{{ statement.journal_date }}</td>
                        <td>{{ statement.account }}[ {{ statement.narration }} ]</td>
                        <td class="text-right">{{ statement.debit }}</td>
                        <td class="text-right">{{ statement.credit }}</td>
                        <td :class="statement.status ? 'text-success text-right' : 'text-danger text-right'">{{ statement.balance }}</td>
                    </tr>
                    <tr v-else>
                        <td colspan="6">Not data found</td>
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
                dateFrom: null,
                dateTo: null,
                accountId: "",
                statements: [],
                apiUrl: "",
                downloadUrl: '#',
                fromDate: null,
                toDate: null,
            };
        },
        computed: {

        },

        methods: {
            resetFromDate: function(date){
                this.fromDate = moment(date).format('YYYY-MM-DD');
                this.resetUrl();
            },
            resetToDate: function(date){
                this.toDate = moment(date).format('YYYY-MM-DD');
                this.resetUrl();
            },
            getStatements: function(){
                var app =this;
                this.salaryDetails = null;
                if(this.fromDate && this.toDate && this.accountId){
                    let data = {
                        from_date : this.fromDate,
                        to_date: this.toDate,
                        account_type: this.accountId
                    };
                    axios.post(app.apiUrl ,data)
                        .then(result => {
                            app.statements = result.data;
                        })
                        .catch(e => {
                            console.log(e);
                        });
                }
            },
            resetUrl: function(){
                this.statements = [];
                this.downloadUrl = '#';
                if(this.fromDate && this.toDate && this.accountId){
                    this.downloadUrl = this.apiUrl + '?' + 'from_date=' + this.fromDate + '&to_date=' + this.toDate + '&account_type=' + this.accountId;
                    this.getStatements();
                }
            }
        },
        created: function() {
            this.apiUrl = this.items.apiUrl;
        },
        mounted() {

        },
    };
</script>
