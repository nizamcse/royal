<template>
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Journal Date</label>
                        <datepicker input-class="form-control" v-model="journalEntryDate"></datepicker>
                        <input type="hidden" name="journal_date" :value="journalDate">
                    </div>
                </div>
                <div class="col-sm-9 col-xs-8 col-md-10">
                    <div class="form-group search-form-group">
                        <label>Debit Account</label>
                        <input type="hidden" name="debit_account_id" :value="debitAccountId">
                        <input type="text" v-model="debitAccountText" :class="debitAccountId ? 'form-control': 'form-control text-danger'" @keyup="searchAccount(0)" required>
                        <ul class="search-result" v-if="debitAccounts.length">
                            <li v-for="debitAccount in debitAccounts" @click="selectAccount(debitAccount)">{{ debitAccount.name }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4 col-md-2">
                    <div class="form-group">
                        <label>Debit Amount</label>
                        <input type="number" v-model="amount" class="form-control" name="debit" :readonly="disableAmount" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-9 col-xs-8 col-md-10">
                    <div class="form-group search-form-group">
                        <label>Credit Account</label>
                        <input type="hidden" name="credit_account_id" :value="creditAccountId">
                        <input type="text" v-model="creditAccountText" :class="creditAccountId ? 'form-control': 'form-control text-danger'" @keyup="searchAccount(1)" required>
                        <ul class="search-result" v-if="creditAccounts.length">
                            <li v-for="creditAccount in creditAccounts" @click="selectAccount(creditAccount)">{{ creditAccount.name }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3 col-xs-4 col-md-2">
                    <div class="form-group">
                        <label>Credit Amount</label>
                        <input type="text" class="form-control" v-model="amount" name="credit" :readonly="disableAmount" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Narration</label>
                <textarea name="narration" cols="30" rows="4" class="form-control">{{ narration }}</textarea>
            </div>
            <div class="form-group text-right">
                <button class="btn btn-success btn-sm" type="submit" :disabled="validateEntry">UPDATE JOURNAL</button>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['items'],

        data: function() {

            return {
                accounts: [],
                debitAccountId: null,
                creditAccountId: null,
                debitAccountText: "",
                creditAccountText: "",
                journalEntryDate: new Date(),
                debitAccounts: [],
                creditAccounts: [],
                accountType: 0,
                amount: 0,
                disableAmount: false,
                narration: "",
            };
        },
        computed: {
            journalDate: function(){
                return this.journalEntryDate ? moment(this.journalEntryDate).format('YYYY-MM-DD') : '';
            },
            validateEntry: function(){
                if(this.creditAccountId && this.debitAccountId){
                    return false;
                }
                return true;
            }
        },

        methods: {
            searchAccount(type){
                this.accountType = type;
                this.debitAccounts = [];
                this.creditAccounts = [];
                if(this.accountType){
                    this.creditAccountId = null;
                    if(this.creditAccountText.length){
                        this.creditAccounts = this.accounts.filter((item) => {
                            if(item.name.toUpperCase() == this.creditAccountText.toUpperCase()){
                                this.selectAccount(item);
                            }
                            else{
                                return item.name.toUpperCase().search(this.creditAccountText.toUpperCase()) != -1;
                            }
                        });
                    }
                }else{
                    this.debitAccountId = null;
                    if(this.debitAccountText.length){
                        this.debitAccounts = this.accounts.filter((item) => {
                            if(item.name.toUpperCase() == this.debitAccountText.toUpperCase()){
                                this.selectAccount(item);
                            }
                            else{
                                return item.name.toUpperCase().search(this.debitAccountText.toUpperCase()) != -1;
                            }
                        });
                    }
                }
            },
            selectAccount(account){
                this.debitAccounts = [];
                this.creditAccounts = [];
                if(this.accountType){
                    this.creditAccountText = account.name;
                    this.creditAccountId = account.id;
                }else{
                    this.debitAccountText = account.name;
                    this.debitAccountId = account.id;
                }
            }
        },
        created: function() {
            this.accounts = this.items.accounts;
            this.amount = this.items.amount;
            this.journalEntryDate = new Date(this.items.journal.journal_date);
            this.narration = this.items.journal.narration;
            this.debitAccountId = this.items.debit.id;
            this.creditAccountId = this.items.debit.id;
            this.debitAccountText = this.items.debit.name;
            this.creditAccountText = this.items.credit.name;

        },
        mounted() {

        },


    };
</script>
