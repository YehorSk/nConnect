import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const useSponsorsStore = defineStore("sponsors",{
    state:()=>({
       sponsors: [],
       error_name: '',
       error_link: '',
       error_image: '',
       success: ''
    }),
    getters:{
        getSponsors(){
            return this.sponsors;
        }
    },
    actions:{
        async fetchSponsors(){
            try {
                const response = await axios.get('sponsors');
                this.sponsors = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async insertSponsor(name,link,image){
            try {
                console.log(image);
                let formData = new FormData();
                formData.append('name', name);
                formData.append('link', link);
                formData.append('image', image);

                const response = await axios.post('sponsors', formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.sponsors.push(response.data);
                this.success = "Added successfully";
                await this.fetchSponsors();
            } catch (error) {
                if(error.response.data.errors.name){
                    this.error_name = error.response.data.errors.name[0];
                }
                if(error.response.data.errors.link){
                    this.error_link = error.response.data.errors.link[0];
                }
                if(error.response.data.errors.image){
                    this.error_image = error.response.data.errors.image[0];
                }
            }
        },
        async destroySponsor(id){
            try {
                const response = await axios.delete('sponsors/'+id);
                this.sponsors = this.sponsors.filter(sponsor => sponsor.id !== id);
                this.success = "Deleted successfully";
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
    }
});