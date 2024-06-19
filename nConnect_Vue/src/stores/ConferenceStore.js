import axios from "axios";
import {defineStore} from "pinia";
import {useStorage} from "@vueuse/core";
import {UseUserStore} from "@/stores/UserStore.js";


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
       success: '',
       token: useStorage('token',null),
       has_current: useStorage('has_current',false),
       userStore: UseUserStore()
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
        async addConference(){
           try{
               await this.getToken();
               const response = await axios.post('user-add-conference',{},{
                   headers: {
                       'Accept': 'application/vnd.api+json',
                       "Content-Type": "application/vnd.api+json",
                       "Access-Control-Allow-Origin":"*",
                       'Authorization': `Bearer ${this.token}`
                   }
               });
               this.success = 'Ste zaregistrovaný/á!'
               await this.checkConference();
           }catch(error){
               if(error.response.status === 422){

               }
           }
        },
        async removeConference(){
            try{
                await this.getToken();
                const response = await axios.post('user-remove-conference',{},{
                    headers: {
                        'Accept': 'application/vnd.api+json',
                        "Content-Type": "application/vnd.api+json",
                        "Access-Control-Allow-Origin":"*",
                        'Authorization': `Bearer ${this.token}`
                    }
                });
                this.success = 'Ste odhlasený/á!'
                await this.checkConference();
                await this.userStore.fetchLectures();
            }catch(error){
                if(error.response.status === 422){

                }
            }
        },
        async checkConference(){
            try{
                await this.getToken();
                const response = await axios.post('user-has-conference',{},{
                    headers: {
                        'Accept': 'application/vnd.api+json',
                        "Content-Type": "application/vnd.api+json",
                        "Access-Control-Allow-Origin":"*",
                        'Authorization': `Bearer ${this.token}`
                    }
                });
                this.has_current = response.data.has_current_conference;
            }catch(error){
                if(error.response.status === 422){
                    console.log(error.response.data);
                }
                if(error.response.status === 500){
                    console.log(error.response.data);
                }
            }
        },
        async getToken(){
            await axios.get('/sanctum/csrf-cookie');
        },
        async getConferenceUsers(conference_id){
           try{
               await this.getToken();
               const response = await axios.get(`get-conference-users/${conference_id}`);
               this.current_users = response.data.users;
               this.total_users = response.data.total_users;
           } catch (error){
               if (error.response.status === 422) {
                   this.errors.value = error.response.data.errors;
               }
           }
        }
    }
});