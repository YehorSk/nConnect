import axios from "axios";
import {defineStore} from "pinia";
import {useStorage} from "@vueuse/core";


axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/";

export const UseAuthStore = defineStore("auth",{
    state:() =>({
        user: useStorage('user', {}),
        token: useStorage('token',null),
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
                this.user = response.data.data.user;
                this.token = response.data.data.token;
                window.location.reload();
            } catch (error) {
                console.log(error.response.data.errors);
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                }
            }
        },
        async login(email,password){
            try {
                const response = await axios.post('login', {
                    email: email,
                    password: password,
                });
                this.user = response.data.data.user;
                this.token = response.data.data.token;
                window.location.reload();
            } catch (error) {
                console.log(error.response);
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                }
            }
        },
        async logout() {
            try {
                await this.getToken();
                const response = await axios.post('logout', null, {
                    headers: {
                        'Accept': 'application/vnd.api+json',
                        "Content-Type": "application/json",
                        "Access-Control-Allow-Origin":"*",
                        'Authorization': `Bearer ${this.token}`
                    }
                });
                this.user = {};
                this.token = null;
                window.location.reload();
            } catch (error) {
                console.log(error.response.data.errors);
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
            }
        },
        async fetchUser(){
            try{
                await this.getToken();
                const response = await axios.get('fetchuser',{
                    headers: {
                        'Accept': 'application/vnd.api+json',
                        "Content-Type": "application/vnd.api+json",
                        "Access-Control-Allow-Origin":"*",
                        'Authorization': `Bearer `+this.token
                    }
                });
                this.user = response.data;
            }catch (error) {
                if (error.response && error.response.status === 401) {
                    this.user = {};
                }
            }
        },
        async getToken(){
            await axios.get('/sanctum/csrf-cookie');
        }

    }
});