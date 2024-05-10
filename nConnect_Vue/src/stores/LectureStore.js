import { defineStore } from "pinia";
import axios from "axios";
axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const useLectureStore = defineStore("lectures", {
    state: () => ({
        lectures: [],
        success: '',
        error_id: '',
    }),
    getters: {
        getLectures() {
            return this.lectures;
        },
        getCurrentLectures(){
            return this.current_lectures;
        }
    },
    actions: {
        async fetchLectures() {
            try {
                const response = await axios.get('lectures');
                this.lectures = response.data;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchCurrentConferenceLectures() {
            try {
                const response = await axios.get('get-current-conference-lectures');
                this.current_lectures= response.data;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async destroyLecture(id) {
            try {
                const response = await axios.delete('lectures/' + id);
                this.lectures = this.lectures.filter(lecture => lecture.id !== id);
                this.success = "Deleted successfully";
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async addSpeakerToLecture(id) {
            try {
                const response = await axios.post('add-speaker-to-lecture', {
                    id: id,
                });
                this.success = "Added successfully";
            } catch (error) {
                if (error.response.status === 422) {
                    if (error.response.data.errors.id) {
                        this.error_id = error.response.data.errors.id[0];
                    }
                }
            }
        },
        async addStageToLecture(id) {
            try {
                const response = await axios.post('add-stage-to-lecture', {
                    id: id,
                });
                this.success = "Added successfully";
            } catch (error) {
                if (error.response.status === 422) {
                    if (error.response.data.errors.id) {
                        this.error_id = error.response.data.errors.id[0];
                    }
                }
            }
        },
        async insertLecture(name, capacity, start_time, end_time, short_desc, long_desc) {
            try {
                const response = await axios.post('lectures', {
                    name: name,
                    capacity: capacity,
                    start_time: start_time,
                    end_time: end_time,
                    short_desc: short_desc,
                    long_desc: long_desc,
                });
                this.lectures.push(response.data);
                this.success = "Added successfully";
                await this.fetchCurrentConferenceLectures();
            } catch (error) {

            }
        },
        async updateLecture(lecture) {
            try {
                const response = await axios.put("lectures/" + lecture.id, {
                    name: lecture.name,
                    capacity: lecture.capacity,
                    start_time: lecture.start_time,
                    end_time: lecture.end_time,
                    short_desc: lecture.short_desc,
                    long_desc: lecture.long_desc,
                });
                const index = this.lectures.findIndex(l => l.id === lecture.id);
                if (index !== -1) {
                    this.lectures[index] = lecture;
                }
                this.success = "Updated successfully";
            } catch (error) {

            }
        },
    }
});
