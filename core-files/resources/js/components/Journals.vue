<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title d-block">
                    LIST OF JOURNAL ENTRIES
                    <a :href="createUrl" class="btn btn-sm pull-right btn-info flat"><i class="fa fa-plus-circle"></i> CREATE NEW</a>
                    <a :href="downloadUrl" class="btn btn-sm pull-right btn-warning flat" target="_blank"><i class="fa fa-download"></i> DOWNLOAD</a>
                </h3>
                <div class="row">
                    <div class="col-md-1">
                        <div class="form-group">
                            <label>Show</label>
                            <select v-model="filterProperty.itemPerPage" @change="resetUrl" class="form-control">
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Narration</label>
                            <input type="text" v-model="filterProperty.narration" @keyup="resetUrl" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box">
            <div class="box-body">
                <table id="po-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>ID</th>
                        <th>Narration</th>
                        <th>Account</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th class="text-right">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <template v-for="(journal,index) in journals">
                        <tr>
                            <td rowspan="2">{{ journal.journal_date }}</td>
                            <td rowspan="2">{{ journal.id }}</td>
                            <td rowspan="2">{{ journal.narration }}</td>
                            <td>{{ journal.debit.account }}</td>
                            <td class="text-right">{{ journal.debit.amount }}</td>
                            <td></td>
                            <td rowspan="2" class="text-right" style="vertical-align: middle">
                                <a :href="editJournal.url + '/' + journal.id " class="btn btn-success btn-xs" v-if="editJournal.can"> <i class="fa fa-edit"></i> Edit</a>
                                <button :data-url="deleteJournal.url + '/' + journal.id " class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal" data-target="#delete-content-modal" v-if="deleteJournal.can"><i class="fa fa-trash-o"></i>Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ journal.credit.account }}</td>
                            <td></td>
                            <td class="text-right">{{ journal.credit.amount }}</td>
                        </tr>
                    </template>
                    </tbody>
                </table>
                <pagination @select="paginatePurchaseOrders" :currentPage="currentPage" :lastPage="lastPage" v-if="journals.length"></pagination>
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
                journals: [],
                apiUrl: "",
                downloadUrl: '#',
                createUrl: '#',
                fromDate: null,
                toDate: null,
                filterProperty: {
                    narration: null,
                    date_from: null,
                    date_to: null,
                    itemPerPage: 10,
                },
                filledData: {},
                lastPage: 1,
                currentPage: 1,
                deleteJournal: {},
                editJournal: {},
                download: {},
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
            getJournals: function(){
                var app =this;
                axios.post(app.apiUrl ,app.filledData)
                    .then(result => {
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;
                        app.journals = result.data.data;

                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            resetUrl: function(){
                this.filledData = {};
                const entries = Object.entries(this.filterProperty);
                this.downloadUrl = null;
                for (let i=0; i<entries.length; i++) {
                    const [key,value] = entries[i];
                    if(value){
                        this.filledData[key] = value;
                        let param = this.downloadUrl ? '&' + key + '=' + value : this.download.url + '?' + key + '=' + value;
                        this.downloadUrl =  this.downloadUrl ? this.downloadUrl + param : param;
                    }
                }
                if(this.fromDate){
                    this.filledData['date_from'] = this.fromDate;
                    let param = this.downloadUrl ? '&from_date=' + this.fromDate : this.download.url + '?from_date=' + this.fromDate;
                    this.downloadUrl =  this.downloadUrl ? this.downloadUrl + param : param;
                }
                if(this.toDate){
                    this.filledData['date_to'] = this.toDate;
                    let param = this.downloadUrl ? '&to_date=' + this.toDate : this.download.url + '?to_date=' + this.toDate;
                    this.downloadUrl =  this.downloadUrl ? this.downloadUrl + param : param;
                }

                this.getJournals();
            },
            paginatePurchaseOrders: function(page){
                var app = this;
                let pageUrl = this.apiUrl + "?page=" + page;
                axios.post(pageUrl ,app.filledData)
                    .then(result => {
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;
                        app.journals = result.data.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            }
        },
        created: function() {
            this.apiUrl = this.items.apiUrl;
            this.createUrl = this.items.createUrl;
            this.deleteJournal = this.items.deleteJournal;
            this.editJournal = this.items.editJournal;
            this.getJournals();
            this.download.url = this.items.downloadUrl;
            this.downloadUrl = this.items.downloadUrl;
            console.log(this.items);
        },
        mounted() {

        },
    };
</script>
