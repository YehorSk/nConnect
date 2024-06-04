import axios from "axios";
import {defineStore} from "pinia";
import {useStorage} from "@vueuse/core";


axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/";

export const UseAuthStore = defineStore("auth",{
    state:() =>({
        user: useStorage('user', {}),
        token: useStorage('token',null),
        errors:'',
        regular_users: [],
        admin_users:[],
        lectures:[],
        success: ''
    }),
    getters:{
        getUser(){
            return this.user;
        },
        getRegularUsers(){
            return this.regular_users;
        },
        getAdminUsers(){
            return this.admin_users;
        },
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
        async forgot_password(email){
            try {
                const response = await axios.post('forgot-password', {
                    email: email,
                });

                window.location.reload();
            } catch (error) {
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                }
            }
        },
        async reset_password(new_pwd,confirm_new_pwd,email,token){
            try {
                await this.getToken();
                const response = await axios.post('update-password', {
                    email: email,
                    token:token,
                    password: new_pwd,
                    password_confirmation:confirm_new_pwd
                });
                this.success = "Updated successfully";
            } catch (error) {
                if(error.response.status === 422){
                    this.errors = error.response.data.errors.password[0];
                }
            }
        },
        async fetchUser(){
            if(this.token !== null){
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
                        this.token = null;
                    }
                    if (error.response && error.response.status === 500) {
                    }
                }
            }
        },
        async fetchLectures(){
            if(this.token !== null){
                try{
                    // await this.getToken();
                    const response = await axios.get('user-lectures',{
                        headers: {
                            'Accept': 'application/vnd.api+json',
                            "Content-Type": "application/vnd.api+json",
                            "Access-Control-Allow-Origin":"*",
                            'Authorization': `Bearer `+this.token
                        }
                    });
                    this.lectures = response.data;
                }catch (error) {
                    if (error.response && error.response.status === 401) {

                    }
                }
            }
        },
        async addLecture(id){
            if(this.token !== null){
                try{
                    await this.getToken();
                    const response = await axios.post('user-add-lecture', {
                        id: id
                    }, {
                        headers: {
                            'Accept': 'application/vnd.api+json',
                            "Content-Type": "application/vnd.api+json",
                            "Access-Control-Allow-Origin":"*",
                            'Authorization': `Bearer ${this.token}`
                        }
                    });
                    await this.fetchLectures();
                }catch (error) {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data;
                    }
                }
            }
        },
        async deleteLecture(id){
            if(this.token !== null){
                try{
                    await this.getToken();
                    const response = await axios.post('user-remove-lecture', {
                        id: id
                    }, {
                        headers: {
                            'Accept': 'application/vnd.api+json',
                            "Content-Type": "application/vnd.api+json",
                            "Access-Control-Allow-Origin":"*",
                            'Authorization': `Bearer ${this.token}`
                        }
                    });
                    await this.fetchLectures();
                }catch (error) {
                    if (error.response && error.response.status === 401) {

                    }
                }
            }
        },
        async getToken(){
            await axios.get('/sanctum/csrf-cookie');
        },
        async fetchRegularUsers(){
            try {
                const response = await axios.get('users-regular');
                this.regular_users = response.data;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }

        },
        async fetchAdminUsers(){
            try {
                const response = await axios.get('users-admin');
                this.admin_users = response.data;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },

    }
});