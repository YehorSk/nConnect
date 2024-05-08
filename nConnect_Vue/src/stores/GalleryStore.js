import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const UseGalleryStore = defineStore("gallery", {
        state: () => ({
            gallery: [],
            current_gallery: [],
            available_gallery: [],
            error_image: '',
            error_year: '',
            success: '',

        }),
        getters: {
            getGallery() {
                return this.gallery;
            },
            getAvailableGallery(){
                return this.available_gallery;
            },
            getCurrentGallery(){
                return this.current_gallery;
            }
        },
        actions: {
            async fetchGallery() {
                try {
                    const response = await axios.get('gallery');
                    this.gallery = response.data;
                } catch (error) {
                    if (error.response.status === 422) {
                        this.errors.value = error.response.data.errors;
                    }
                }
            },
            async fetchCurrentConferenceGallery(){
                try {
                    const response = await axios.get('get-current-conference-gallery');
                    this.current_gallery = response.data;
                } catch (error) {
                    if(error.response.status === 422){
                        this.errors.value = error.response.data.errors;
                    }
                }
            },
            async fetchAvailableGallery(){
                try {
                    const response = await axios.get('get-available-gallery');
                    this.available_gallery = response.data;
                } catch (error) {
                    if(error.response.status === 422){
                        this.errors.value = error.response.data.errors;
                    }
                }
            },
            async insertGallery(image, year) {
                try {
                    let formData = new FormData();
                    formData.append('image', image);
                    formData.append('year', year);
                    const response = await axios.post('gallery', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    this.gallery.push(response.data);
                    this.success = "Added successfully";
                    await this.fetchGallery();
                } catch (error) {
                    if (error.response && error.response.data && error.response.data.errors) {
                        if (error.response.data.errors.image) {
                            this.error_image = error.response.data.errors.image[0];
                        }
                        if (error.response.data.errors.year) {
                            this.error_year = error.response.data.errors.year[0];
                        }
                    }  else {
                    this.error_image = "Unexpected error occurred";
                    console.error("Unexpected error:", error);
                }

            }
            },
            async addGalleryToConference(id){
                try {
                    const response = await axios.post('add-gallery-to-conference', {
                        id: id,
                    });
                    this.success = "Added successfully";
                    await this.fetchCurrentConferenceGallery();
                    await this.fetchAvailableGallery();
                } catch (error) {
                    if(error.response.status === 422){
                        if(error.response.data.errors.id){
                            this.error_id = error.response.data.errors.id[0];
                        }
                    }
                }
            },
            async deleteGalleryFromConference(id){
                try {
                    const response = await axios.delete('delete-gallery-from-conference/'+id);
                    await this.fetchCurrentConferenceGallery();
                    await this.fetchAvailableGallery();
                    this.success = "Deleted successfully";
                } catch (error) {
                    if(error.response.status === 422){
                        this.errors.value = error.response.data.errors;
                    }
                }
            },

            async destroyGallery(id) {
                try {
                    const response = await axios.delete('gallery/' + id);
                    this.gallery = this.gallery.filter(gallery => gallery.id !== id);
                    this.success = "Deleted successfully";
                } catch (error) {
                    if (error.response.status === 422) {
                        this.errors.value = error.response.data.errors;
                    }
                }
            },

        }
    }
);