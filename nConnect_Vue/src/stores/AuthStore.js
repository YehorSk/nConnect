import axios from "axios";
import {defineStore} from "pinia";
import {useStorage} from "@vueuse/core";

export const UseAuthStore = defineStore("auth",{
    state:() =>({
        user: useStorage('user', {}),
        token: useStorage('token',''),
        errors:'',
        credentials:'',
        success: ''
    }),
    actions:{
        async getToken(){
            await axios.get('/sanctum/csrf-cookie');
        },
        async register(name,email,password,password_confirmation){
            await this.getToken();
            try {
                const response = await axios.post('register', {
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation:password_confirmation
                });
                // this.user = response.data.data.user;
                // this.token = response.data.data.token;
                // window.location.reload();
                this.success = "Please confirm your email";
            } catch (error) {
                console.log(error.response)
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                }
            }
        },
        async login(email,password){
            await this.getToken();
            try {
                const response = await axios.post('login', {
                    email: email,
                    password: password,
                });
                console.log(response)
                this.user = response.data.data.user;
                this.token = response.data.data.token;
                window.location.reload();
            } catch (error) {
                console.log(error.response);
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                    console.log(this.errors);
                }
                else if(error.response.status === 401){
                    this.credentials = error.response.data.message;
                    console.log(this.credentials);
                }
            }
        },
        async logout() {
            await this.getToken();
            try {
                const response = await axios.post('logout', null);
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
            await this.getToken();
            try {
                const response = await axios.post('forgot-password', {
                    email: email,
                });
                this.success = "A link to reset your password has been sent to your email. Please check your inbox and follow the instructions to reset your password. If you do not see the email, please check your spam or junk folder.";
            } catch (error) {
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                }
            }
        },
        async reset_password(new_pwd,confirm_new_pwd,email,token){
            await this.getToken();
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

    }
});