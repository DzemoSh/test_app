<template>
<div class="centerx">
    <vs-popup class="holamundo" fullscreen title="Employee Details" :active.sync="activePopup">
        <div v-if="employee">
            <p> Name and Surname:  {{ employee.worker }}</p>
            <p> Average Rate per hour: {{ average_rate.toFixed(2) }} $</p>
            <p> Average Total pay: {{ (average_rate * total_hours).toFixed(2) }} $</p>
        </div>
        <div style="margin-top: 10px">
            <h4> Last 5 Payments: </h4>
            <vs-table :data="shifts">
                <template slot="thead">
                    <vs-th>
                    Date
                    </vs-th>
                    <vs-th>
                    Company
                    </vs-th>
                    <vs-th>
                    Hours
                    </vs-th>
                    <vs-th>
                    Rate per Hour
                    </vs-th>
                    <vs-th>
                    Total Pay
                    </vs-th>
                    <vs-th>
                    Taxable
                    </vs-th>
                    <vs-th>
                    Shift type
                    </vs-th>
                    <vs-th>
                    Status
                    </vs-th>
                    <vs-th>
                    Paid at
                    </vs-th>
                </template>
                <template slot-scope="{data}">
                    <vs-tr :key="index" v-for="(tr, index) in data">
                    <vs-td>
                        {{tr.date}}
                    </vs-td>
                    <vs-td>
                        {{tr.company}}
                    </vs-td>
                    <vs-td>
                        {{tr.hours}}
                    </vs-td>
                    <vs-td>
                        {{tr.rate_per_hour}} $
                    </vs-td>
                    <vs-td>
                        {{tr.rate_per_hour * tr.hours}} $
                    </vs-td>
                    <vs-td>
                        {{tr.taxable ? 'Yes' : 'No'}}
                    </vs-td>
                    <vs-td>
                        {{tr.shift_type}}
                    </vs-td>
                    <vs-td>
                        {{tr.status}}
                    </vs-td>
                    <vs-td>
                        {{tr.paid_at}}
                    </vs-td>
                    </vs-tr>
                </template>
            </vs-table>
        </div>
    </vs-popup>
</div>
</template>

<script>

export default {
    props: ['employee'],
    data(){
        return{
            activePopup: false,
            shifts: [],
            average_rate: 0,
            total_hours: 0
        }
    },
    methods: {
        getEmployeeDetails(employee){
            this.$http.post('/api/getEmployeeDetails', employee).then(response => {
                this.shifts = response.data.shifts
                this.average_rate = parseFloat(response.data.average_rate)
                this.total_hours = parseInt(response.data.total_hours)
            })
        }
    }
}
</script>