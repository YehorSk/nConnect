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
                    const response = await axios.post('gallery', {
                        image: image,
                        year: year,
                    });
                    this.gallery.push(response.data);
                    this.success = "Added successfully";
                    await this.fetchGallery();
                } catch (error) {
                    if (error.response.status === 422) {
                        if (error.response.data.errors.image) {
                            this.error_image = error.response.data.errors.image[0];
                        }
                        if (error.response.data.errors.year) {
                            this.error_year = error.response.data.errors.year[0];
                        }
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
            async updateGallery(gallery) {
                try {
                    const response = await axios.put("gallery/" + gallery.id, {
                        image: gallery.image,
                        year: gallery.year,
                    });
                    const index = this.gallery.findIndex(g => g.id === gallery.id);
                    if (index !== -1) {
                        this.gallery[index] = gallery;
                    }
                    this.success = "Updated successfully";
                } catch (error){

                }

                }

        }
    }
);