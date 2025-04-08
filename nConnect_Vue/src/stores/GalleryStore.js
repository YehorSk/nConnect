import {defineStore} from "pinia";
import axios from "axios";

export const UseGalleryStore = defineStore("gallery", {
        state: () => ({
            gallery: [],
            error_image: '',
            error_year: '',
            success: '',
            errors: ''
        }),
        getters: {
            getGallery() {
                return this.gallery;
            }
        },
        actions: {
            async fetchGallery(page = 1) {
                try {
                    const response = await axios.get('gallery?page=' + page);
                    this.gallery = response.data;
                } catch (error) {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                }
            },
            async fetchGalleryAll() {
                try {
                    const response = await axios.get('gallery-all');
                    this.gallery = response.data;
                } catch (error) {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
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
                    this.gallery.data.push(response.data);
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
                        console.error(error.response);
                    }

                }
            },

            async destroyGallery(id) {
                try {
                    const response = await axios.delete('gallery/' + id);
                    this.gallery.data = this.gallery.data.filter(gallery => gallery.id !== id);
                    this.success = "Deleted successfully";
                } catch (error) {
                    if (error.response.status === 422) {
                        this.errors.value = error.response.data.errors;
                    }
                }
            },

            async updateGallery(gallery, file) {
                try {
                    if (!gallery.year) {
                        this.errors = "Year cannot be empty";
                        return;
                    }
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
                    await this.fetchGallery();

                } catch (error) {
                    if (error.response && error.response.data && error.response.data.errors) {
                        this.errors = Object.values(error.response.data.errors).flat().join(' ');
                        }
                    }
                }
        }
    }
);