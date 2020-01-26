<template>
    <div class="box-body">
        <h4>FILTER LEAVE REPORT <a :href="downloadUrl" class="btn btn-sm pull-right btn-warning flat" target="_blank"><i class="fa fa-download"></i> DOWNLOAD</a></h4>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group search-form-group">
                    <label>EMPLOYEE ID</label>
                    <input type="text" v-model="employeeId" class="form-control" @keyup="getLeaves">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>SELECT MONTH</label>
                    <select name="leave_type_id" class="form-control" v-model="monthId" v-on:change="getLeaves" required>
                        <option value="">-- Select Month --</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>YEAR</label>
                    <input type="text" name="year" class="form-control" v-on:keyup="getLeaves" v-model="year">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Employee Name</th>
                    <th>Date From</th>
                    <th>Date To</th>
                    <th>Allowed Days</th>
                    <th class="text-right">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(leave,i) in leaves">
                    <td>{{ i+1 }}</td>
                    <td>{{ leave.employee.name }}</td>
                    <td>{{ leave.from_date }}</td>
                    <td>{{ leave.to_date }}</td>
                    <td>{{ leave.allowed_days }}</td>
                    <td class="text-right">
                        <a :href="linkE + '/' + leave.id"
                                class="btn btn-info btn-xs flat btn-delete"><i class="fa fa-trash-o"></i> Edit
                        </a>
                        <button :data-url="linkD + '/' + leave.id"
                                class="btn btn-danger btn-xs flat btn-delete" data-toggle="modal"
                                data-target="#delete-content-modal"><i class="fa fa-trash-o"></i> Delete
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <pagination @select="paginateLeave" :currentPage="currentPage" :lastPage="lastPage" v-if="leaves.length"></pagination>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['items'],

        data: function() {

            return {
                month: "",
                year: "",
                leaves: [],
                linkE: null,
                linkD: null,
                employeeId: null,
                monthId: "",
                today: new Date(),
                downloadUrl: 'javascript:void(0)',
                apiUrl: null,
                currentPage:1,
                lastPage: 1,
                downloadUrl: 'javascript:void(0)',
            };
        },
        computed: {
            currentYear: function(){
                return moment(this.today).format('Y');
            }
        },

        methods: {
            getLeaves(){
                this.resetDownloadUrl();
                var app = this;
                let pageUrl = this.apiUrl;
                let data = {};
                if(this.employeeId){
                    data.employee_id = this.employeeId;
                }
                if(this.monthId){
                    data.month = this.monthId;
                }
                data.year = this.year ? this.year : this.currentYear;
                axios.post(pageUrl ,data)
                    .then(result => {
                        app.leaves = result.data.data;
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;

                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            paginateLeave(page){
                var app = this;
                let pageUrl = this.apiUrl + "?page=" + page;
                let data = {};
                if(this.employeeId){
                    data.employee_id = this.employeeId;
                }
                if(this.monthId){
                    data.month = this.monthId;
                }
                data.year = this.year ? this.year : this.currentYear;
                axios.post(pageUrl ,data)
                    .then(result => {
                        app.leaves = result.data.data;
                        app.currentPage = result.data.current_page;
                        app.lastPage = result.data.last_page;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            resetDownloadUrl(){
                this.downloadUrl = this.apiUrl + '?year=' + this.year + '&employee_id=' + this.employeeId + '&month=' + this.monthId;
            }
        },
        created: function() {
            this.linkE = this.items.linkE;
            this.linkD = this.items.linkD;
            this.apiUrl = this.items.apiUrl;
            this.year = this.currentYear;
            this.getLeaves();
        },
        mounted() {
            console.log('leave component mounted');
        },
    };
</script>
