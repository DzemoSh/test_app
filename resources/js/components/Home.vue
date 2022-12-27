<template>
  <div>
    <div class="flex bg-indigo-500 text-2xl"> Shifts Overview </div>
    <form @submit.prevent="uploadCSV" style="margin-left: 5px; display: flex; align-items: center;">
        <input type="file" @change="successUpload">
        <vs-button color="success" @click="uploadCSV" :disabled="!this.file"> Upload CSV </vs-button>
    </form>
    <vs-button @click="$refs.AddShiftPopup.activePopup = true"> New Shift</vs-button>
    <shifts-table ref="ShiftsTable" :shifts="shifts" @deleteShift="deleteShift" @updateShift="updateShift"></shifts-table>
    <employees-table :workers="workers"></employees-table>
    <add-shift-popup ref="AddShiftPopup" @createShift="createShift"></add-shift-popup>
  </div>
</template>

<script>
import AddShiftPopup from './AddShiftPopup.vue'
import ShiftsTable from './ShiftsTable.vue'
import EmployeesTable from './EmployeesTable.vue'

export default {
  components: { ShiftsTable, AddShiftPopup, EmployeesTable },
    data(){
        return {
            file: null,
            shifts:[],
            workers: []
        }
    },
    created() {
        // this.csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    },
    mounted(){
        this.getShifts()
        this.getWorkers()
    },
    methods: {
        successUpload(e){
            console.log(e.target.files[0])
            this.file = e.target.files[0]
        },
        uploadCSV(){
            let csv_file = new FormData();
            csv_file.append('csv', this.file);
            this.$http.post('/api/uploadCSV', csv_file).then(response => {
                console.log(response)
                this.responseNotification(response)
                this.getShifts()
                this.getWorkers()
            })
        },
        getWorkers(){
            this.$http.get('/api/getWorkers').then(response => {
            this.workers = response.data.workers
        })
        },
        getShifts(){
            this.$http.get('/api/getShifts').then(response => {
                this.shifts = response.data.shifts
            })
        },
        createShift(payload){
            this.$http.post('/api/createShift', payload).then(response => {
                if(response.data.status == 'success') this.shifts.push(response.data.shift)
                this.responseNotification(response)
            })    
        },
        updateShift(payload){
            this.$http.post('/api/updateShift', payload).then(response => {
                this.responseNotification(response)
            });
        },
        deleteShift(payload){
            this.$http.post('api/deleteShift', payload).then(response => {
                this.responseNotification(response)
                if(response.data.status == 'success') this.shifts.splice(this.shifts.indexOf(payload), 1);
            })
        },
        responseNotification(response){
            this.$vs.notify({
                title: response.data.status == 'success' ? 'Success' : 'Error',
                text: response.data.message,
                color: response.data.status == 'success' ? 'success' : 'danger'
            })
        }
    },
}
</script>

<style>

</style>