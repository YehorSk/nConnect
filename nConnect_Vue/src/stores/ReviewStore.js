import {defineStore} from "pinia";
import axios from "axios";

export const UseReviewStore = defineStore("reviews", {
        state: () => ({
            reviews: [],
            errors: '',
            error_name: '',
            error_text: '',
            error_photo: '',
            errors_update: [],
            success: '',
        }),
        getters: {
            getReviews() {
                return this.reviews;
            },
        },
        actions: {
            async fetchReviews(page = 1, search = '') {
                try {
                    const response = await axios.get('reviews?page=' + page, {
                        params: {
                            search: search
                        }
                    });
                    this.reviews = response.data;
                } catch (error) {
                    if (error.response.status === 422) {
                        this.errors.value = error.response.data.errors;
                    }
                }
            },
            async fetchViewReviews(page = 1){
                try {
                    const response = await axios.get('display-reviews?page='+page);
                    this.reviews = response.data;
                } catch (error) {
                    if (error.response.status === 422) {
            }
                }
                },
            async insertReviews(name, text, image) {
                try {
                    let formData = new FormData();
                    formData.append('name', name);
                    formData.append('text', text);
                    formData.append('image', image);
                    const response = await axios.post('reviews', formData,{
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                        });
                    this.reviews.data.push(response.data);
                    this.success = "Added successfully";
                    await this.fetchReviews();
                } catch (error) {
                    if (error.response && error.response.data && error.response.data.errors) {
                        if (error.response.data.errors.name) {
                            this.error_name = error.response.data.errors.name[0];
                        }
                        if (error.response.data.errors.text) {
                            this.error_text = error.response.data.errors.text[0];
                        }
                        if (error.response.data.errors.photo) {
                            this.error_photo = error.response.data.errors.photo[0];
                        } else {
                            console.error(error.response.data);
                        }
                    }

                }
            },
            async destroyReviews(id) {
                try {
                    const response = await axios.delete('reviews/' + id);
                    this.reviews.data = this.reviews.data.filter(review => review.id !== id);
                    this.success = "Deleted successfully";
                } catch (error) {
                    if (error.response.status === 422) {
                        this.errors.value = error.response.data.errors;
                    }
                }
            },
            async updateReview(reviews, file) {
                try {
                    if (!reviews.name || !reviews.text) {
                        this.errors = "Name and text cannot be empty";
                        return;
                    }

                    let imagePath = null;
                    if (file) {
                        const formData = new FormData();
                        formData.append('image', file);
                        const response = await axios.post("/upload-review-image", formData);
                        imagePath = response.data.image_path;
                    }
                    console.log('Image path:', imagePath);

                    const updatedData = {
                        name: reviews.name,
                        text: reviews.text,
                    };
                    if (imagePath !== null) {
                        updatedData.image = imagePath;
                    }

                    const updatedResponse = await axios.put("/reviews/" + reviews.id, updatedData);
                    this.success = "Updated successfully";
                    await this.fetchReviews();
                } catch (error) {
                    if (error.response.status === 422) {
                        this.errors_update = error.response.data.errors;
                    }
                }
            },
            async refreshReviews(){
                try{
                    await this.fetchReviews();
                } catch (error) {
                    if (error.response.status === 422) {
                        this.errors.value = error.response.data.errors;
                    }
                }
            }
        }
    }
);