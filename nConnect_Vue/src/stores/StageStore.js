import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/backend/nConnect/nConnect-Laravel/public/api/";

export const useStageStore = defineStore("stages",{
    state:()=>({
        stages: []
    }),
    getters:{
        getStages(){
            return this.stages;
        }
    },
    actions:{
         async fetchStages(){
             try {
                 const response = await axios.get('stages');
                 this.stages = response.data;
             } catch (error) {
                 console.error('Error', error);
             }
        },
        async insertStage(name,date){
            try {
                const response = await axios.post('stages', {
                    name: name,
                    date: date,
                });
                this.stages.push(response.data);
                await this.fetchStages();
            } catch (error) {
                console.error('Error inserting stage:', error);
            }
        },
        async destroyStage(id){
            try {
                const response = await axios.delete('stages/'+id);
                this.stages = this.stages.filter(stage => stage.id !== id);
            } catch (error) {
                console.error('Error deleting stage:', error);
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
             }catch (error) {
                 console.error('Error Updating stage:', error);
             }
        }
    }

});