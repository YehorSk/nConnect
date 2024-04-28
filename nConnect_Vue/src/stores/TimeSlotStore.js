import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const useTimeSlotStore = defineStore("timeslots",{
    state:()=>({
        slots:[],
        success: null,
        update_error_name: null,
        update_error_date: null,
    }),
    actions:{
        async fetchTimeSlotsByStageId(id){
            try {
                const response = await axios.get(`get-time-slots/${id}`);
                this.slots = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchStages(){
            try {
                const response = await axios.get('slots');
                this.slots = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async saveTimeSlot(stageId, time) {
            try {
                const response = await axios.post('slots', {
                    stage_id: stageId,
                    time: time,
                });
                this.slots.push(response.data);
                this.success = "Added successfully";
                await this.fetchStages();
            } catch (error) {
                if (error.response.status === 422) {
                    if (error.response.data.errors && error.response.data.errors.time) {
                        this.error_time = error.response.data.errors.time[0];
                    }
                } else {
                    console.error(error);
                }
            }
        },
        async deleteTimeSlot(slotId) {
            try {
                await axios.delete(`slots/${slotId}`);
                this.slots = this.slots.filter(slot => slot.id !== slotId);
                this.success = "Deleted successfully";
            } catch (error) {
                console.error(error);
                this.error = "Failed to delete time slot";
            }
        },
        async updateTimeSlot(slotId, updatedTime) {
            try {
                const response = await axios.patch(`slots/${slotId}`, { time: updatedTime });
                const index = this.slots.findIndex(slot => slot.id === slotId);
                if (index!== -1) {
                    this.slots[index] = response.data;
                }
                this.success = "Updated successfully";

            } catch (error) {
                if (error.response) {
                    if (error.response.status === 422) {
                        if (error.response.data.errors) {
                            if (error.response.data.errors.time) {
                                this.update_error_time = error.response.data.errors.time[0];
                            }
                        }
                    } else {
                        console.error(error);
                    }
                } else {
                    console.error(error);
                }
            }
        }

    }
});