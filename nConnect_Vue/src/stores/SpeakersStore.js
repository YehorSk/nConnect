import {defineStore} from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const useSpeakersStore = defineStore("speakers", {
    state: () => ({
        speakers: [],
        available_speakers: [],
        current_speakers: [],
        error_first_name: '',
        error_last_name: '',
        error_short_desc: '',
        error_long_desc: '',
        error_company: '',
        error_instagram: '',
        error_linkedIn: '',
        error_facebook: '',
        error_twitter: '',
        error_id: '',
        error_image: '',
        update_error_name: '',
        update_error_date: '',
        success: '',
        errors_update: [],
        current_speakers_all: [],
    }),
    getters: {
        getSpeakers() {
            return this.speakers;
        },
        getAvailableSpeakers() {
            return this.available_speakers;
        },
        getCurrentSpeakers() {
            return this.current_speakers;
        },
        getCurrentSpeakersAll() {
            return this.current_speakers_all;
        },
    },
    actions: {
        async fetchSpeakers(page = 1, search = '') {
            try {
                const response = await axios.get('speakers?page=' + page, {
                    params: {
                        search: search
                    }
                });
                this.speakers = response.data;
            } catch (error) {
                if (error.response && error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchCurrentConferenceSpeakers(page = 1, search = '') {
            try {
                const response = await axios.get('get-current-conference-speakers?page=' + page, {
                    params: { search: search }
                });
                this.current_speakers = response.data;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchCurrentConferenceSpeakersAll() {
            try {
                const response = await axios.get('get-current-conference-speakers-all');
                this.current_speakers_all = response.data;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchAvailableSpeakers() {
            try {
                const response = await axios.get('get-available-speakers');
                this.available_speakers = response.data;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async addSpeakersToConference(id) {
            try {
                const response = await axios.post('add-speakers-to-conference', {
                    id: id,
                });
                this.success = "Added successfully";
                await this.fetchCurrentConferenceSpeakers();
                await this.fetchAvailableSpeakers();
            } catch (error) {
                if (error.response.status === 422) {
                    if (error.response.data.errors.id) {
                        this.error_id = error.response.data.errors.id[0];
                    }
                }
            }
        },
        async deleteSpeakersFromConference(id) {
            try {
                const response = await axios.delete('delete-speakers-from-conference/' + id);
                await this.fetchCurrentConferenceSpeakers();
                await this.fetchAvailableSpeakers();
                this.success = "Deleted successfully";
            } catch (error) {
                if (error.response.status === 422) {
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

                const response = await axios.post('/speakers', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });

                this.success = "Added successfully";
                await this.fetchSpeakers();
            } catch (error) {
                if (error.response && error.response.data && error.response.data.errors) {
                    const errors = error.response.data.errors;
                    this.error_first_name = errors.first_name ? errors.first_name[0] : '';
                    this.error_last_name = errors.last_name ? errors.last_name[0] : '';
                    this.error_short_desc = errors.short_desc ? errors.short_desc[0] : '';
                    this.error_long_desc = errors.long_desc ? errors.long_desc[0] : '';
                    this.error_company = errors.company ? errors.company[0] : '';
                    this.error_instagram = errors.instagram ? errors.instagram[0] : '';
                    this.error_linkedIn = errors.linkedIn ? errors.linkedIn[0] : '';
                    this.error_facebook = errors.facebook ? errors.facebook[0] : '';
                    this.error_twitter = errors.twitter ? errors.twitter[0] : '';
                    this.error_image = errors.image ? errors.image[0] : '';
                }
            }
        },
        async destroySpeakers(id) {
            try {
                await axios.delete('speakers/' + id);
                this.speakers.data = this.speakers.data.filter(speaker => speaker.id !== id);
                this.success = "Deleted successfully";
            } catch (error) {
                if (error.response && error.response.status === 422) {
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
        async updateSpeakers(speakers, file) {
            try {
                if (!speakers.first_name || !speakers.last_name || !speakers.short_desc || !speakers.long_desc || !speakers.company) {
                    this.errors_update = {
                        general: ["first_name, last_name, short_desc, long_desc and company cannot be empty"]
                    };
                    return;
                }
                let imagePath = null;
                if (file) {
                    const formData = new FormData();
                    formData.append('image', file);

                    const response = await axios.post("/upload-image", formData);
                    imagePath = response.data.image_path;
                }
                const updatedData = {
                    first_name: speakers.first_name,
                    last_name: speakers.last_name,
                    short_desc: speakers.short_desc,
                    long_desc: speakers.long_desc,
                    Company: speakers.company,
                    Instagram: speakers.instagram,
                    LinkedIn: speakers.linkedIn,
                    Facebook: speakers.facebook,
                    Twitter: speakers.twitter,
                };
                if (imagePath !== null) {
                    updatedData.picture = imagePath;
                }

                const updatedResponse = await axios.put("/speakers/" + speakers.id, updatedData);

                this.success = "Updated successfully";
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors_update = error.response.data.errors;
                    await this.fetchSpeakers();
                }
            }
        },
        async refreshSpeakers() {
            try {
                await this.fetchSpeakers();
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        }
    }
});
