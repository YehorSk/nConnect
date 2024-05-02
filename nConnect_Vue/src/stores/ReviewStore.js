import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const UseReviewStore = defineStore("reviews", {
        state: () => ({
            reviews: [],
            error_name: '',
            error_text: '',
            error_photo: '',
            success: ''
        }),
        getters: {
            getReviews() {
                return this.reviews;
            }
        },
        actions: {
            async fetchReviews() {
                try {
                    const response = await axios.get('reviews');
                    this.reviews = response.data;
                } catch (error) {
                    if (error.response.status === 422) {
                        this.errors.value = error.response.data.errors;
                    }
                }
            },
            async insertReviews(name, text, photo) {
                try {
                    let formData = new FormData();
                    formData.append('name', name);
                    formData.append('text', text);
                    formData.append('photo', photo);
                    const response = await axios.post('reviews', formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    });
                    this.reviews.push(response.data);
                    this.success = "Added successfully";
                    await this.fetchReviews();
                } catch (error) {
                    if (error.response.data.errors.name) {
                        this.error_name = error.response.data.errors.name[0];
                    }
                    if (error.response.data.errors.text) {
                        this.error_text = error.response.data.errors.text[0];
                    }
                    if (error.response.data.errors.photo) {
                        this.error_photo = error.response.data.errors.photo[0];
                    }

                }
            },
            async destroyReviews(id) {
                try {
                    const response = await axios.delete('reviews/' + id);
                    this.reviews = this.reviews.filter(review => review.id !== id);
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