import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const useSponsorsStore = defineStore("sponsors",{
    state:()=>({
       sponsors: [],
        available_sponsors: [],
        current_sponsors: [],
       error_name: '',
       error_link: '',
        error_id:'',
       error_image: '',
        update_error_name:'',
        update_error_date:'',
       success: '',
        errors: '',
        current_sponsors_all: [],
    }),
    getters:{
        getSponsors(){
            return this.sponsors;
        },
        getAvailableSponsors(){
            return this.available_sponsors;
        },
        getCurrentSponsors(){
            return this.current_sponsors;
        },
        getCurrentSponsorsAll(){
            return this.current_sponsors_all;
        }
    },
    actions:{
        async fetchSponsors(page = 1, search = '') {
            try {
                const response = await axios.get('sponsors?page=' + page, {
                    params: {
                        search: search
                    }
                });
                this.sponsors = response.data;
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchCurrentConferenceSponsors(page = 1, search = '') {
            try {
                const response = await axios.get('get-current-conference-sponsors?page=' + page, {
                    params: { search: search }
                });
                this.current_sponsors = response.data;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchCurrentConferenceSponsorsAll() {
            try {
                const response = await axios.get('get-current-conference-sponsors-all');
                this.current_sponsors_all = response.data;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchAvailableSponsors(){
            try {
                const response = await axios.get('get-available-sponsors');
                this.available_sponsors = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async addSponsorToConference(id){
            try {
                const response = await axios.post('add-sponsor-to-conference', {
                    id: id,
                });
                this.success = "Added successfully";
                await this.fetchCurrentConferenceSponsors();
                await this.fetchAvailableSponsors();
            } catch (error) {
                if(error.response.status === 422){
                    if(error.response.data.errors.id){
                        this.error_id = error.response.data.errors.id[0];
                    }
                }
            }
        },
        async deleteSponsorFromConference(id){
            try {
                const response = await axios.delete('delete-sponsor-from-conference/'+id);
                await this.fetchCurrentConferenceSponsors();
                await this.fetchAvailableSponsors();
                this.success = "Deleted successfully";
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async insertSponsor(name,link,image){
            try {
                let formData = new FormData();
                formData.append('name', name);
                formData.append('link', link);
                formData.append('image', image);

                await axios.post('sponsors', formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
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
                await axios.delete('sponsors/'+id);
                this.sponsors.data = this.sponsors.data.filter(sponsor => sponsor.id !== id);
                this.success = "Deleted successfully";
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async updateSponsors(sponsors, file){
            try {
                if (!sponsors.name || !sponsors.link) {
                    this.errors = "Name and link cannot be empty";
                    return;
                }
                let imagePath = null;
                if (file) {
                    const formData = new FormData();
                    formData.append('image', file);
                    const response = await axios.post("/upload-sponsor-image", formData);

                    imagePath = response.data.image_path;
                }
                const updatedData = {
                    name: sponsors.name,
                    link: sponsors.link,
                };

                if (imagePath !== null) {
                    updatedData.image = imagePath;
                }
                const updatedResponse = await axios.put("/sponsors/" + sponsors.id, updatedData);
                this.success = "Updated successfully";
            }catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors = Object.values(error.response.data.errors).flat().join(' ');
                }else {
                    console.error(error.response.data);
                }
            }
        },

    }
});