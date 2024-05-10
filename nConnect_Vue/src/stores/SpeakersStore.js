import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const useSpeakersStore = defineStore("speakers",{
    state:()=>({
        speakers: [],
        available_speakers: [],
        current_speakers: [],
       error_name: '',
       error_link: '',
        error_id:'',
       error_image: '',
        update_error_name:'',
        update_error_date:'',
       success: '',
    }),
    getters:{
        getSpeakers(){
            return this.speakers;
        },
        getAvailableSpeakers(){
            return this.available_speakers;
        },
        getCurrentSpeakers(){
            return this.current_speakers;
        },
    },
    actions:{
        async fetchSpeakers(){
            try {
                const response = await axios.get('speakers');
                this.speakers = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },

        async fetchCurrentConferenceSpeakers(){
            try {
                const response = await axios.get('get-current-conference-speakers');
                this.current_speakers = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchAvailableSpeakers(){
            try {
                const response = await axios.get('get-available-speakers');
                this.available_speakers = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async addSpeakersToConference(id){
            try {
                const response = await axios.post('add-speakers-to-conference', {
                    id: id,
                });
                this.success = "Added successfully";
                await this.fetchCurrentConferenceSpeakers();
                await this.fetchAvailableSpeakers();
            } catch (error) {
                if(error.response.status === 422){
                    if(error.response.data.errors.id){
                        this.error_id = error.response.data.errors.id[0];
                    }
                }
            }
        },
        async deleteSpeakersFromConference(id){
            try {
                const response = await axios.delete('delete-speakers-from-conference/'+id);
                await this.fetchCurrentConferenceSpeakers();
                await this.fetchAvailableSpeakers();
                this.success = "Deleted successfully";
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async insertSpeakers(first_name, last_name, short_desc, long_desc, company, instagram, linkedIn, facebook, twitter, image) {
            try {
                let formData = new FormData();
                formData.append('first_name', first_name);
                formData.append('last_name', last_name);
                formData.append('short_desc', short_desc);
                formData.append('long_desc', long_desc);
                formData.append('company', company);
                formData.append('instagram', instagram);
                formData.append('linkedIn', linkedIn);
                formData.append('facebook', facebook);
                formData.append('twitter', twitter);
                formData.append('image', image);

                const response = await axios.post('speakers', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                this.speakers.push(response.data);
                this.success = "Added successfully";
                await this.fetchSpeakers();
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    if (errors.first_name) {
                        this.error_first_name = errors.first_name[0];
                    }
                    if (errors.last_name) {
                        this.error_last_name = errors.last_name[0];
                    }
                    if (errors.short_desc) {
                        this.error_short_desc = errors.short_desc[0];
                    }
                    if (errors.long_desc) {
                        this.error_long_desc = errors.long_desc[0];
                    }
                    if (errors.company) {
                        this.error_company = errors.company[0];
                    }
                    if (errors.instagram) {
                        this.error_link = errors.instagram[0];
                    }
                    if (errors.linkedIn) {
                        this.error_link = errors.linkedIn[0];
                    }
                    if (errors.facebook) {
                        this.error_link = errors.facebook[0];
                    }
                    if (errors.twitter) {
                        this.error_link = errors.twitter[0];
                    }
                    if (errors.image) {
                        this.error_image = errors.image[0];
                    }
                } else if (error.response && error.response.status === 422) {
                } else {
                }
            }

        },

        async destroySpeakers(id){
            try {
                const response = await axios.delete('speakers/'+id);
                this.speakers = this.speakers.filter(speaker => speaker.id !== id);
                this.success = "Deleted successfully";
            } catch (error) {
                if(error.response && error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                } else {
                    console.error("Error deleting speaker:", error);
                }
            }
        },
        async fetchSpeakerById(id) {
            try {
                const response = await axios.get(`single-speaker/${id}`);
                return response.data;
            } catch (error) {
                console.error("Error fetching single speaker:", error);
                return null;
            }
        },


    }
});