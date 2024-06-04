import axios from "axios";
import {defineStore} from "pinia";


axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const UseConferenceStore = defineStore("conferences",{
   state:() =>({
       conferences: [],
       current_store:[],
       error_name:'',
       error_year:'',
       update_error_name:'',
       update_error_year:'',
       update_error_current:'',
       error:'',
       success: ''
   }) ,
    getters:{
       getConferences(){
           return this.conferences;
       },
        getCurrentConference(){
           return this.current_store;
        }
    },
    actions:{
       async fetchConferences(){
           try{
               const response = await axios.get('conferences');
               this.conferences = response.data;
           }catch(error){
               if (error.response.status === 422) {
                   this.errors.value = error.response.data.errors;
               }
           }
       },
        async fetchCurrentConference(){
            try{
                const response = await axios.get('get-active-conference');
                this.current_store = response.data;
            }catch(error){
                if (error.response.status === 422) {
                    if(error.response.data.errors.name){
                        this.error_name = error.response.data.errors.name[0];
                    }
                    if(error.response.data.errors.date){
                        this.error_year = error.response.data.errors.year[0];
                    }
                }
            }
        },
        async insertConference(name,date){
            try {
                const response = await axios.post('conferences', {
                    name: name,
                    year: date,
                });
                this.conferences.push(response.data);
                this.success = "Added successfully";
                await this.fetchConferences();
            } catch (error) {
                if(error.response.data.errors.name){
                    this.error_name = error.response.data.errors.name[0];
                }
                if(error.response.data.errors.year){
                    this.error_year = error.response.data.errors.year[0];
                }
            }
        },
        async updateConference(conference){
            try{
                console.log(conference);
                const response = await axios.put("conferences/" +conference.id,{
                    name: conference.name,
                    year: conference.year,
                    is_current: conference.is_current
                });


                await this.fetchConferences();
                this.success = "Updated successfully";
            }catch (error) {
                if(error.response.status === 422){
                    if(error.response.data.errors.name){
                        this.update_error_name = error.response.data.errors.name[0];
                    }
                    if(error.response.data.errors.date){
                        this.update_error_year = error.response.data.errors.year[0];
                    }
                    if(error.response.data.message){
                        this.update_error_year = error.response.data.message;
                    }
                }
            }
        },
        async destroyConference(id){
            try {
                const response = await axios.delete('conferences/'+id);
                this.conferences = this.conferences.filter(conference => conference.id !== id);
                this.success = "Deleted successfully";
            } catch (error) {
                if(error.response.status === 422){
                    if(error.response.data.message){
                        this.error = error.response.data.message;
                    }
                }
            }
        },
    }
});