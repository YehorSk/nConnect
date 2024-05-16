import axios from "axios";
import {defineStore} from "pinia";


axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const UseAuthStore = defineStore("auth",{
    state:() =>({
        user:[],
        errors:[]
    }),
    getters:{
        getUser(){
            return this.user;
        }
    },
    actions:{
        async register(name,email,password,password_confirmation){
            try {
                const response = await axios.post('register', {
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation:password_confirmation
                });
                this.user = response.data;
            } catch (error) {
                console.log(error.response.data.errors);
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                }
            }
        }
    }
});