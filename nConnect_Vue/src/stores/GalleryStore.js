import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const UseGalleryStore = defineStore("gallery", {
        state: () => ({
            gallery: [],
            error_image: '',
            error_year: '',
            success: ''
        }),
        getters: {
            getGallery() {
                return this.gallery;
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
            async insertGallery(image, year) {
                try {
                    let formData = new FormData();
                    formData.append('image', image);
                    formData.append('year', year);
                    const response = await axios.post('gallery', formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    this.gallery.push(response.data);
                    this.success = "Added successfully";
                    await this.fetchGallery();
                } catch (error) {
                        if (error.response.data.errors.image) {
                            this.error_image = error.response.data.errors.image[0];
                        }
                        if (error.response.data.errors.year) {
                            this.error_year = error.response.data.errors.year[0];
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