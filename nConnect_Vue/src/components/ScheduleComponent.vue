<template>
  <section class="section schedule">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-title">
            <h3>Program</h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <div class="schedule-tab">
            <ul class="nav nav-pills text-center">
              <li v-for="(stage, index) in stageStore.getCurrentStages" class="nav-item">
                <a class="nav-link" href="#nov20" @click="lectureStore.fetchLecturesByStage(stage.name)" data-toggle="pill" :class="{ 'active': index === 0 }">
                  {{ stage.name }}
                  <span>{{ stage.date }}</span>
                </a>
              </li>
            </ul>
          </div>
          <div class="schedule-contents bg-schedule">
            <div class="tab-content" id="pills-tabContent">
              <div class="tab-pane fade show active schedule-item" id="nov20">
                <!-- Headings -->
                <ul class="m-0 p-0">
                  <li class="headings">
                    <div class="time">Čas</div>
                    <div class="speaker">Speaker</div>
                    <div class="subject">Prednaška</div>
                    <div class="venue">Miestnosť</div>
                  </li>
                  <!-- Schedule Details -->
                  <template v-for="lecture in lectureStore.getMainLectures">
                    <li v-if="lecture.is_lecture === 1"  @click="showDetails(lecture)" class="schedule-details">
                      <div class="block">
                        <!-- time -->
                        <div class="time">
                          <i class="fa fa-clock-o"></i>
                          <span class="time">{{ lecture.start_time +" - "+lecture.end_time }}</span>
                        </div>
                        <!-- Speaker -->
                        <div class="speaker">
                          <img v-if="lecture.speaker_image!==null" :src="'http://127.0.0.1:8000/storage/' + lecture.speaker_image" width="50px" height="50px" alt="speaker-thumb-one">
                          <span v-if="lecture.speaker_name!==null" class="name">{{lecture.speaker_name + " " + lecture.speaker_lastname}}</span>
                        </div>
                        <!-- Subject -->
                        <div class="subject">{{lecture.name}}</div>
                        <!-- Venue -->
                        <div class="venue">{{lecture.stage_name}}</div>
                      </div>
                    </li>
                    <li v-else class="schedule-details ">
                      <div class="block">
                        <!-- time -->
                        <div class="time">
                          <i class="fa fa-clock-o"></i>
                          <span class="time">{{ lecture.start_time +" - "+lecture.end_time }}</span>
                        </div>
                        <!-- Speaker -->
                        <div class="speaker">
                          <img v-if="lecture.speaker_image!==null" :src="'http://127.0.0.1:8000/storage/' + lecture.speaker_image" width="50px" height="50px" alt="speaker-thumb-one">
                          <span v-if="lecture.speaker_name!==null" class="name">{{lecture.speaker_name + " " + lecture.speaker_lastname}}</span>
                        </div>
                        <!-- Subject -->
                        <div class="subject">{{lecture.name}}</div>
                        <!-- Venue -->
                        <div class="venue">{{lecture.stage_name}}</div>
                      </div>
                    </li>
                  </template>
                </ul>
              </div>

            </div>
          </div>
          <v-dialog v-model="dialog" min-width="400px" min-height="400px" width="600px" height="600px">
            <v-card
                class="mx-auto text-black"
                color="white"
                max-width="800"
                title="Details"
            >
              <v-card-text class="text-h5 py-2">
                {{ show_lecture.short_desc }}
              </v-card-text>

              <v-card-actions>
                <v-list-item class="w-200">
                  <template v-slot:prepend>
                    <v-avatar
                        color="grey-darken-3"
                        :image="'http://127.0.0.1:8000/storage/' + show_lecture.speaker_image"
                    ></v-avatar>
                  </template>

                  <v-list-item-title>{{ show_lecture.speaker_name }} {{ show_lecture.speaker_lastname }}</v-list-item-title>

                  <v-list-item-subtitle>{{ show_lecture.speaker_company }}</v-list-item-subtitle>

                </v-list-item>
                <v-divider :thickness="8" color="info"></v-divider>
                <v-btn color="black" @click="dialog = false" text="Close"></v-btn>
                <v-btn v-if="user.email_verified_at" color="green" text="Register"></v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>


        </div>
      </div>
    </div>
  </section>

</template>
<script>
import {useStageStore} from "@/stores/StageStore.js";
import {useLectureStore} from "@/stores/LectureStore.js";
import {UseAuthStore} from "@/stores/AuthStore.js";

export default {
  data(){
    return{
      stageStore: useStageStore(),
      lectureStore: useLectureStore(),
      dialog: false,
      show_lecture:[],
      authStore: UseAuthStore(),
      user: {}
    };
  },
created(){
  this.stageStore.fetchCurrentConferenceStages();
  this.lectureStore.fetchCurrentConferenceLectures();
  this.lectureStore.fetchLecturesByStage("SOFT DEV STAGE");
  this.user = this.authStore.getUser;
},
  methods:{
    showDetails(lecture){
      this.show_lecture = lecture;
      this.dialog=true;
    }
  }
}
</script>