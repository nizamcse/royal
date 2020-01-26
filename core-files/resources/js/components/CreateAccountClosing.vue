<template>
    <div>
        <div class="box" v-if="alert.visibility">
            <div class="alert fade in" :class="alertStatuses[alert.status]" role="alert">
                <button type="button" class="close" @click="hideAlert"><span aria-hidden="true">×</span></button>
                <i class="fa fa-exclamation-triangle"></i> {{ alert.message }}
            </div>
        </div>
        <div class="box" v-if="!isSuccessfullyClosed">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>CLOSING STARTING MONTH</label>
                            <input type="text" v-model="startMonth" class="form-control"  readonly>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>CLOSING ENDING MONTH</label>
                            <input type="text" v-model="endMonth" class="form-control"  readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>YEAR</label>
                            <input type="text" v-model="closingYear" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="form-group text-right" v-if="!isValidated">
                    <button class="btn btn-success btn-xs flat" type="button" :disabled="validateEntry || isSubmitting" @click="checkClosingStatus">
                        <i class="fa fa-check" v-if="!isSubmitting"></i><i v-if="isSubmitting" class="fa fa-refresh fa-spin"></i> <span v-if="isSubmitting"> CHECKING</span> <span v-else> CLOSE ACCOUNTS</span></button>
                </div>
                <div class="form-group text-right" v-else>
                    <button class="btn btn-xs flat btn-danger" type="button" @click="onCancelClosing">
                        <i class="fa fa-close"> CANCEL</i>
                    </button>
                    <button class="btn btn-xs flat btn-success" type="button" @click="closeAccounts">
                        <i class="fa fa-check" v-if="!isClosing"></i><i v-if="isClosing" class="fa fa-refresh fa-spin"></i> CONFIRM CLOSING
                    </button>
                </div>
            </div>
        </div>
        <div class="box" v-else>
            <div class="box-body text-success">
                <strong>{{ alert.message }}</strong>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['items'],

        data: function() {

            return {
                startMonth: null,
                endMonth: null,
                alert:{
                    status: 0,
                    visibility: false,
                    message: ""
                },
                alertStatuses: ['alert-danger','alert-success','alert-warning'],
                closingYear: new Date().getFullYear(),
                isSubmitting: false,
                companyId: null,
                creatingUrl: null,
                checkingUrl: null,
                isValidated: false,
                isSuccessfullyClosed: false,
                isClosing: false,
            };
        },
        computed: {
            journalDate: function(){
                return this.journalEntryDate ? moment(this.journalEntryDate).format('YYYY-MM-DD') : '';
            },
            validateEntry: function(){
                if(this.closingYear && this.startMonth && this.endMonth && !this.formError){
                    return false;
                }
                return true;
            }
        },

        methods: {
            checkClosingStatus: function(){
                this.isSubmitting = true;
                var app = this;
                axios
                    .get(this.checkingUrl + "/" + this.closingYear)
                    .then(response => {
                        app.alert.status = response.data.status;
                        app.alert.message = response.data.message;
                        app.alert.visibility = true;
                        app.isSubmitting = false;
                        if(response.data.status == 1){
                            app.isValidated = true;
                        }else{
                            app.isValidated = false;
                        }
                    })
                    .catch(error => {
                        app.alert.status = 0;
                        app.alert.message = error.message;
                        app.alert.visibility = true;
                        app.isSubmitting = false;
                        app.isValidated = false;
                    });
            },
            closeAccounts: function(){
                var app = this;
                this.isClosing = true;
                axios
                    .post(this.creatingUrl + "/" + this.closingYear)
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        app.alert.status = 0;
                        app.alert.message = error.message;
                        app.alert.visibility = true;
                        app.isSubmitting = false;
                        app.isValidated = false;
                    });
            },
            hideAlert: function(){
                this.alert.visibility = false;
            },
            onCancelClosing: function(){
                this.isValidated = false;
            }
        },
        created: function() {
            this.startMonth = this.items.startMonth;
            this.endMonth = this.items.endMonth;
            this.creatingUrl = this.items.storingUrl;
            this.checkingUrl = this.items.checkingUrl;
            if(!this.startMonth && !this.endMonth)
            {
                this.alert.status = 0;
                this.alert.visibility = true;
                this.alert.message = "Please setup your account settings first.";
            }
        },
        mounted() {

        },


    };
</script>
