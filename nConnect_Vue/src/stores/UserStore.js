import axios from "axios";
import {defineStore} from "pinia";
import {useStorage} from "@vueuse/core";


axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/";

export const UseUserStore = defineStore("user",{
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
                    this.success = 'Ste zaregistrovaný/á!'
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
                    this.success = 'Ste odhlasený/á!'
                }catch (error) {
                    if (error.response && error.response.status === 401) {

                    }
                }
            }
        },
        async getToken(){
            await axios.get('/sanctum/csrf-cookie');
        },
        async fetchRegularUsers(page = 1, search = ''){
            try {
                const response = await axios.get('users-regular?page=' + page, {
                    params: {
                        search: search
                    }
                });
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
        async addAdminUser(id) {
            if (this.token !== null) {
                try {
                    await this.getToken();
                    const response = await axios.post('user-add-admin', { id: id }, {
                        headers: {
                            'Accept': 'application/vnd.api+json',
                            "Content-Type": "application/vnd.api+json",
                            "Access-Control-Allow-Origin": "*",
                            'Authorization': `Bearer ${this.token}`
                        }
                    });
                    this.success = response.data.message;
                    await this.fetchRegularUsers();
                    await this.fetchAdminUsers();
                } catch (error) {
                    console.log(error.response);
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                }
            }
        },
        async removeAdminUser(id){
            if (this.token !== null) {
                try {
                    await this.getToken();
                    const response = await axios.post('user-remove-admin', { id: id }, {
                        headers: {
                            'Accept': 'application/vnd.api+json',
                            "Content-Type": "application/vnd.api+json",
                            "Access-Control-Allow-Origin": "*",
                            'Authorization': `Bearer ${this.token}`
                        }
                    });
                    this.success = response.data.message;
                    await this.fetchRegularUsers();
                    await this.fetchAdminUsers();
                } catch (error) {
                    console.log(error.response);
                    if (error.response && error.response.status === 422 && error.response.data.message) {
                        this.errors = error.response.data.message;
                    }
                }
            }
        },

    }
});