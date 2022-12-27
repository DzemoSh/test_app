<template>
    <div>
        <vs-table max-items="10" pagination  :data="shiftDetails">
        <template slot="header">
            <h3 style="margin-left: 10px">
            Shifts
            </h3>
            <div style="margin-right: 10px">
                Show pays above: 
                <vs-input-number v-model="totalPayFilter"></vs-input-number>
            </div>
        </template>
        <template slot="thead">
            <vs-th>
            Date
            </vs-th>
            <vs-th>
            Worker
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
            <vs-th>
            Actions
            </vs-th>
        </template>

        <template slot-scope="{data}">
            <vs-tr :key="index" v-for="(tr, index) in data">
            <vs-td>
                {{tr.date}}
            </vs-td>
            <vs-td>
                {{tr.worker}}
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
                {{(tr.rate_per_hour * tr.hours).toFixed(2)}} $
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
                {{(tr.paid_at == '0000-00-00 00:00:00' || !tr.paid_at) ? 'Not paid yet' : tr.paid_at}}
            </vs-td>
            <vs-td>
                <vs-button color="success" size="small" icon="visibility" @click="showEmployeeInfo(tr)"></vs-button>
                <vs-button color="warning" size="small" icon="edit" @click="employee = tr; $refs.UpdateShift.activePopup = true"></vs-button>
                <vs-button color="danger" size="small" icon="delete" @click="deleteShift(tr)"></vs-button>
            </vs-td>
            </vs-tr>
        </template>
        </vs-table>

        <employee-overview ref="EmployeeOverview" :employee="employee"></employee-overview>
        <update-shift-popup ref="UpdateShift" :employee="employee" @updateShift="updateShift"></update-shift-popup>
    </div>
</template>

<script>
import EmployeeOverview from './EmployeeOverview.vue'
import UpdateShiftPopup from './UpdateShiftPopup.vue'
export default {
  components: { EmployeeOverview, UpdateShiftPopup },
    props: ['shifts'],
    data(){
        return{
            employee: null,
            totalPayFilter: 0
        }
    },
    computed: {
        shiftDetails() {
            return this.shifts.filter(shift => (shift.rate_per_hour * shift.hours) > this.totalPayFilter)
        }
    },
    methods: {
        showEmployeeInfo(data){
            this.employee = data
            this.$refs.EmployeeOverview.activePopup = true;
            this.$refs.EmployeeOverview.getEmployeeDetails(data)
        },
        deleteShift(data){
            this.$emit('deleteShift', data)
        },
        updateShift(payload){
            this.$emit('updateShift', payload)
        }
    }
}
</script>