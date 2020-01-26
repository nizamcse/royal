<template>
    <div>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title d-block">
                    ATTENDANCE REPORT
                    <a :href="downloadUrl" class="btn btn-sm pull-right btn-warning flat" target="_blank"><i class="fa fa-download"></i> DOWNLOAD</a>
                </h3>
                <div class="row">
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
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Employee Id (Default All)</label>
                            <input type="text" class="form-control" v-model="employeeId" @keyup="resetUrl">
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
                        <th>Date</th>
                        <th>Employee ID</th>
                        <th>Employee</th>
                        <th>In Time</th>
                        <th>Exit Time</th>
                        <th>Total Hour/Quantity</th>
                        <th>Overtime</th>
                        <th>Total Wage</th>
                        <th>Overtime Wage</th>
                        <th>Net Wage</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(attendance,i) in attendances">
                        <td>{{ attendance.attendance_date }}</td>
                        <td>{{ attendance.employee.id }}</td>
                        <td>{{ attendance.employee.name }}</td>
                        <td>{{ attendance.in_time }}</td>
                        <td>{{ attendance.exit_time }}</td>
                        <td>{{ attendance.measurement_quantity }}</td>
                        <td>{{ attendance.overtime }}</td>
                        <td>{{ attendance.total_wage }}</td>
                        <td>{{ attendance.overtime_wage }}</td>
                        <td>{{ attendance.net_wage }}</td>
                    </tr>
                    </tbody>
                </table>
                <pagination @select="paginateAttendance" :currentPage="currentPage" :lastPage="lastPage" v-if="attendances.length"></pagination>
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
                employeeId: "",
                attendances: [],
                apiUrl: "",
                downloadUrl: 'javascript:void(0)',
                fromDate: null,
                toDate: null,
                lastPage: 1,
                currentPage: 1,
            };
        },
        computed: {
            totalItems: function(){
                return this.attendances
            }
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
            getAttendances: function(){
                var app = this;
                let pageUrl = this.apiUrl;
                let data = {};
                if(this.fromDate){
                    data.from_date = this.fromDate;
                }
                if(this.toDate){
                    data.to_date = this.toDate;
                }
                if(this.employeeId){
                    data.employee_id = this.employeeId;
                }
                this.attendances = [];
                axios.post(pageUrl ,data)
                    .then(result => {
                        let response = result.data;
                        app.attendances = response.data;
                        app.currentPage = response.current_page;
                        app.lastPage = response.last_page;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            paginateAttendance(page){
                var app = this;
                let pageUrl = this.apiUrl + "?page=" + page;
                let data = {};
                if(this.fromDate){
                    data.from_date = this.fromDate;
                }
                if(this.toDate){
                    data.to_date = this.toDate;
                }
                if(this.employeeId){
                    data.employee_id = this.employeeId;
                }
                axios.post(pageUrl ,data)
                    .then(result => {
                        app.attendances = result.data.data;
                    })
                    .catch(e => {
                        console.log(e);
                    });
            },
            resetUrl: function(){
                this.statements = [];
                this.downloadUrl = 'javascript:void(0)';
                if(this.fromDate && this.toDate){
                    this.downloadUrl = this.apiUrl + '?' + 'from_date=' + this.fromDate + '&to_date=' + this.toDate ;
                    if(this.employeeId.length){
                        this.downloadUrl = this.downloadUrl + '&employee_id=' + this.employeeId;
                    }
                    this.getAttendances();
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
