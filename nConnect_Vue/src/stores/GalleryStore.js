import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const UseGalleryStore = defineStore("gallery", {
        state: () => ({
            gallery: [],
            error_image: '',
            error_year: '',
            success: '',

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
                    } else {
                        console.error(error.response.data);
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

            async updateGallery(gallery, file) {
                try {
                    let imagePath = null;
                    if (file) {
                        const formData = new FormData();
                        formData.append('image', file);
                        const response = await axios.post("/upload-gallery-image", formData);
                        imagePath = response.data.image_path;
                    }
                    console.log('Image path:', imagePath);
                    const updatedData = {
                        year: gallery.year,
                    };
                    if (imagePath !== null) {
                        updatedData.image = imagePath;
                    }
                    const updatedResponse = await axios.put("/gallery/" + gallery.id, updatedData);

                    this.success = "Updated successfully";
                } catch (error) {
                    if (error.response && error.response.status === 422) {
                        const errors = error.response.data.errors;

                        }
                    }
                }
        }
    }
);