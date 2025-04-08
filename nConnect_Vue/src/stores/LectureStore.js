import {defineStore} from "pinia";
import axios from "axios";

export const useLectureStore = defineStore("lectures", {
    state: () => ({
        lectures: [],
        success: '',
        error_id: '',
        errors:[],
        errors_update:[],
        main_lectures:[],
        current_lectures:[],
        current_users:[]
    }),
    getters: {
        getLectures() {
            return this.lectures;
        },
        getCurrentLectures(){
            return this.current_lectures;
        },
        getErrorsUpdate(){
            return this.errors_update !==[];
        },
        getMainLectures(){
            return this.main_lectures;
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
        async fetchLecturesByStage(name) {
            await this.fetchCurrentConferenceLectures();
            this.main_lectures = this.current_lectures.filter(lecture => lecture.stage_name === name);
        },
        async destroyLecture(id) {
            try {
                const response = await axios.delete('lectures/' + id);
                this.lectures = this.lectures.filter(lecture => lecture.id !== id);
                this.success = "Deleted successfully";
                await this.fetchCurrentConferenceLectures();
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async insertLecture(name, capacity, start_time, end_time, short_desc, long_desc,is_lecture,stage,speaker) {
            try {
                if(is_lecture){
                    const response = await axios.post('lectures', {
                        name: name,
                        capacity: capacity,
                        start_time: start_time,
                        end_time: end_time,
                        short_desc: short_desc,
                        long_desc: long_desc,
                        is_lecture:is_lecture,
                        stage_id: stage.id,
                        speaker_id: speaker.id
                    });
                }else{
                    const response = await axios.post('lectures', {
                        name: name,
                        start_time: start_time,
                        end_time: end_time,
                        short_desc: short_desc,
                        is_lecture:is_lecture,
                        stage_id: stage.id,
                    });
                }

                this.success = "Added successfully";
                await this.fetchCurrentConferenceLectures();
            } catch (error) {
                if(error.response.status === 422){
                    this.errors = error.response.data.errors;
                }
            }
        },
        async updateLecture(lecture) {
            try {

                let startTime = lecture.start_time;
                let endTime = lecture.end_time;
                if (startTime !== '' && startTime.split(':').length !== 3) {
                    startTime = startTime + ':00';
                }
                if (endTime !== '' && endTime.split(':').length !== 3) {
                    endTime = endTime + ':00';
                }
                if(lecture.is_lecture===1){
                    const response = await axios.put("lectures/" + lecture.id, {
                        name: lecture.name,
                        capacity: lecture.capacity,
                        start_time: startTime,
                        end_time: endTime,
                        short_desc: lecture.short_desc,
                        long_desc: lecture.long_desc,
                        stage_id: lecture.stage_id,
                        speaker_id: lecture.speaker_id
                    });
                }else{
                    const response = await axios.put("lectures/" + lecture.id, {
                        name: lecture.name,
                        start_time: startTime,
                        end_time: endTime,
                        short_desc: lecture.short_desc,
                        stage_id: lecture.stage_id,
                    });
                }
                this.success = "Updated successfully";
                await this.fetchCurrentConferenceLectures();
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors_update = error.response.data.errors;
                    console.log(this.errors_update);
                }
            }
        },
        async refreshLectures() {
            try {
                await this.fetchCurrentConferenceLectures();
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }   
        },
        async getLectureUsers(lecture_id){
            try{
                const response = await axios.get(`get-lecture-users/${lecture_id}`);
                this.current_users = response.data;
                console.log(response.data);
            }catch (error){
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        }
    }
});
