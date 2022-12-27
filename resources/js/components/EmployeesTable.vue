<template>
    <div>
        <vs-table style="width: 500px" :data="workers">
        <template slot="header">
            <h3 style="margin-left: 10px">
            Employees
            </h3>
        </template>
        <template slot="thead">
            <vs-th>
            Worker
            </vs-th>
            <vs-th>
            Actions
            </vs-th>
        </template>

        <template slot-scope="{data}">
            <vs-tr :key="index" v-for="(tr, index) in data">
            <vs-td>
                {{tr.worker}}
            </vs-td>
            <vs-td>
                <vs-button color="success" size="small" icon="visibility" @click="showEmployeeInfo(tr)"></vs-button>
            </vs-td>
            </vs-tr>
        </template>
        </vs-table>

        <employee-overview ref="EmployeeOverview" :employee="employee"></employee-overview>
    </div>
</template>

<script>
import EmployeeOverview from './EmployeeOverview.vue'
export default {
  components: { EmployeeOverview },
    props: ['workers'],
    data(){
        return{
            employee: null
        }
    },
    methods: {
        showEmployeeInfo(data){
            this.employee = data
            this.$refs.EmployeeOverview.activePopup = true;
            this.$refs.EmployeeOverview.getEmployeeDetails(data)
        },
    }
}
</script>