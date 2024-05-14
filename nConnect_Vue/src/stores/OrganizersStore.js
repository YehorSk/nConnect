import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const UseOrganizersStore = defineStore("organizers",{
    state:()=>({
        organizers: [],
        available_organizers:[],
        current_organizers:[],
        error_name: '',
        error_email: '',
        error_phone_number: '',
        error_id: '',
        error_image: '',
        update_error_name:'',
        update_error_date:'',
        success: ''
    }),
    getters:{
        getOrganizers(){
            return this.organizers;
        },
        getAvailableOrganizers(){
            return this.available_organizers;
        },
        getCurrentOrganizers(){
            return this.current_organizers;
        },
    },
    actions: {
        async fetchOrganizers(){
            try{
                const response = await axios.get('organizers');
                this.organizers= response.data;
            } catch (error){
                console.log(error.response.data);
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }

        },
        async fetchCurrentConferenceOrganizers(){
            try {
                const response = await axios.get('get_current_conference_organizers');
                this.current_organizers = response.data;
            }  catch (error) {
                console.log(error.response.data);
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchAvailableOrganizers(){
            try{
                const response = await axios.get('get-available-organizers');
                this.available_organizers = response.data;
            }catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async addOrganizersToConference(id){
            try {
                const response = await axios.post('add-organizers-to-conference', {
                    id: id,
                });
                this.success = "Added successfully";
                await this.fetchCurrentConferenceOrganizers();
                await this.fetchAvailableOrganizers();
            } catch (error) {
                if(error.response.status === 422){
                    if(error.response.data.errors.id){
                        this.error_id = error.response.data.errors.id[0];
                    }
                }
            }
        },
        async deleteOrganizersFromConference(id) {
            try {
                const response = await axios.delete('delete-organizers-from-conference/' + id);
                await this.fetchCurrentConferenceOrganizers();
                await this.fetchAvailableOrganizers();
                this.success = "Deleted successfully";

            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async insertOrganizers(name,image,phone_number,email){
            try{
                let formData = new FormData();
                formData.append('name', name);
                formData.append('image', image);
                formData.append('phone_number', phone_number);
                formData.append('email', email);

                const response = await axios.post('organizers', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.organizers.push(response.data);
                this.success = "Added successfully";
                await this.fetchOrganizers();
            } catch (error) {
                console.log(error.response.data);
                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    if (errors.name) {
                        this.error_name = errors.name[0];
                    }
                    if (errors.phone_number) {
                        this.error_phone_number = errors.phone_number[0];
                    }
                    if (errors.email) {
                        this.error_email = errors.email[0];
                    }
                    if (errors.photo) {
                        this.error_image = errors.image[0];
                    }
                }

        }

    },
        async destroyOrganizers(id){
        try{
            const response = await axios.delete('organizers/'+id);
            this.organizers = this.organizers.filter(organizer => organizer.id !== id);
            this.success = "Deleted successfully";

        }catch (error) {
            if(error.response && error.response.status === 422){
                this.errors.value = error.response.data.errors;
            } else {
                console.error("Error deleting organizer:", error);
            }
        }
    },
        async updateOrganizer(organizers, file){
            try{
                let imagePath = null;
                if (file) {
                    const formData = new FormData();
                    formData.append('image', file);
                    const response = await axios.post("/upload-organizer-image", formData);
                    imagePath = response.data.image_path;
                }
                console.log('Image path:', imagePath);
                const updatedData={
                    name: organizers.name,
                    phone_number: organizers.phone_number,
                    email: organizers.email,
                };
                if (imagePath!==null){
                    updatedData.image = imagePath;
                }
                const updatedResponse = await axios.put("/organizers/" + organizers.id,updatedData);

                this.success = "Updated successfully";
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    const errors = error.response.data.errors;
                    if (errors) {
                        Object.keys(errors).forEach(key => {
                            if (key === 'name') {
                                this.error_name = errors[key][0];
                            } else if (key === 'file') {
                                this.error_image = errors[key][0];
                            } else if (key === 'phone_number') {
                                this.error_phone_number = errors[key][0];
                            } else if (key === 'email') {
                                this.error_email = errors[key][0];
                            }
                        });
                    }
                }
            }

            }
        }

    });