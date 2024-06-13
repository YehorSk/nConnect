import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const useStageStore = defineStore("stages",{
    state:()=>({
        stages: [],
        available_stages: [],
        current_stages: [],
        error_id:'',
        error_name:'',
        error_date:'',
        update_error_name:'',
        update_error_date:'',
        success: ''
    }),
    getters:{
        getStages(){
            return this.stages;
        },
        getAvailableStages(){
            return this.available_stages;
        },
        getCurrentStages(){
            return this.current_stages;
        }
    },
    actions:{
         async fetchStages(page=1,search){
             try {
                 const response = await axios.get('stages?page='+page,{
                     params:{
                         search:search
                     }
                 });
                 this.stages = response.data;
             } catch (error) {
                 if(error.response.status === 422){
                     this.errors.value = error.response.data.errors;
                 }
             }
        },
        async fetchCurrentConferenceStages(page=1,search){
            try {
                const response = await axios.get('get-current-conference-stages?page='+page,{
                    params:{
                        search:search
                    }
                });
                this.current_stages = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchAvailableStages(){
            try {
                const response = await axios.get('get-available-stages');
                this.available_stages = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async insertStage(name,date){
            try {
                const response = await axios.post('stages', {
                    name: name,
                    date: date,
                });
                this.stages.push(response.data);
                this.success = "Added successfully";
                await this.fetchStages();
            } catch (error) {
                if(error.response.status === 422){
                    if(error.response.data.errors.name){
                        this.error_name = error.response.data.errors.name[0];
                    }
                    if(error.response.data.errors.date){
                        this.error_date = error.response.data.errors.date[0];
                    }
                }
            }
        },
    async addStageToConference(id,date){
        try {
            const response = await axios.post('add-stages-to-conference', {
                id: id,
                date: date
            });
            this.success = "Added successfully";
            await this.fetchCurrentConferenceStages();
            await this.fetchAvailableStages();
        } catch (error) {
            if(error.response.status === 422){
                if(error.response.data.errors.id){
                    this.error_id = error.response.data.errors.id[0];
                }
            }
        }
    },
        async destroyStage(id){
            try {
                const response = await axios.delete('stages/'+id);
                this.stages = this.stages.filter(stage => stage.id !== id);
                this.success = "Deleted successfully";
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async deleteStageFromConference(id){
            try {
                const response = await axios.delete('delete-stage-from-conference/'+id);
                await this.fetchCurrentConferenceStages();
                await this.fetchAvailableStages();
                this.success = "Deleted successfully";
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                    console.log(this.errors.value);
                }
            }
        },
        async updateStage(stage){
             try{
                 const response = await axios.put("stages/" +stage.id,{
                     name: stage.name,
                     date: stage.date,
                 });
                 const index = this.stages.findIndex(s => s.id === stage.id);
                 if (index !== -1) {
                     this.stages[index] = stage;
                 }
                 this.success = "Updated successfully";
             }catch (error) {
                 if(error.response.status === 422){
                     if(error.response.data.errors.name){
                         this.update_error_name = error.response.data.errors.name[0];
                     }
                     if(error.response.data.errors.date){
                         this.update_error_date = error.response.data.errors.date[0];
                     }
                 }
             }
        },
        async updateStageInConference(stage){
            try{
                const response = await axios.put("update-stage-in-conference/" +stage.id,{
                    date: stage.pivot.date,
                });
                // const index = this.stages.findIndex(s => s.id === stage.id);
                // if (index !== -1) {
                //     this.stages[index] = stage;
                // }
                this.success = "Updated successfully";
            }catch (error) {
                if(error.response.status === 422){
                    if(error.response.data.errors.date){
                        this.update_error_date = error.response.data.errors.date[0];
                    }
                }
            }
        }
    }

});