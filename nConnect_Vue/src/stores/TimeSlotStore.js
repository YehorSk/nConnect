import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nconnect/nConnect-Laravel/public/api/";

export const useTimeSlotStore = defineStore("timeslots",{
    state:()=>({
        slots:[]
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
    }
});