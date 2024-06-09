import { defineStore } from 'pinia';
import axios from 'axios';

axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const useContactFormStore = defineStore('contactForm', {
    state: () => ({
        error: '',
        success: '',
    }),

    actions: {
        async submitForm(formData) {
            try {
                const response = await axios.post('send-email', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.success = 'Email sent';
                return response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                    console.log(this.errors.value);
                    this.error='Email not sent';
                }
            }
        },
    },
});
