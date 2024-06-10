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
              <li v-for="(stage, index) in stageStore.getCurrentStages" :key="stage.name" class="nav-item">
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
                  <template v-if="waiting" class="items-center">
                    <v-progress-circular
                        :size="70"
                        :width="7"
                        color="primary"
                        indeterminate
                    ></v-progress-circular>
                  </template>
                  <template v-else v-for="lecture in lectureStore.getMainLectures" :key="lecture.id">
                    <li @click="showDetails(lecture)" class="schedule-details">
                      <div class="block">
                        <!-- time -->
                        <div class="time">
                          <i class="fa fa-clock-o"></i>
                          <span class="time">{{ lecture.start_time +" - "+lecture.end_time }}</span>
                        </div>
                        <!-- Speaker -->
                        <div class="speaker">
                          <img v-if="lecture.speaker_image !== null" :src="'http://127.0.0.1:8000/storage/' + lecture.speaker_image" width="50px" height="50px" alt="speaker-thumb-one">
                          <span v-if="lecture.speaker_name !== null" class="name">{{lecture.speaker_name + " " + lecture.speaker_lastname}}</span>
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
            <v-card class="mx-auto text-black" color="white" max-width="800" title="Details">
              <v-card-text class="text-p py-2">
                {{ show_lecture.short_desc }}
              </v-card-text>
              <v-card-actions>
                <v-list-item class="w-200" v-if="show_lecture.is_lecture === 1">
                  <template v-slot:prepend>
                    <v-avatar color="grey-darken-3" :image="'http://127.0.0.1:8000/storage/' + show_lecture.speaker_image"></v-avatar>
                  </template>
                  <v-list-item-title>{{ 'Voľné miesta: ' + remainingSpots }}</v-list-item-title>
                  <v-list-item-title>{{ show_lecture.speaker_name }} {{ show_lecture.speaker_lastname }}  {{ show_lecture.overlapping }}</v-list-item-title>
                  <v-list-item-subtitle>{{ show_lecture.speaker_company }}</v-list-item-subtitle>
                </v-list-item>
                <v-divider :thickness="8" color="info"></v-divider>
                <v-btn color="black" @click="dialog = false" text>Close</v-btn>
                <template v-if="!user.is_admin && show_lecture.is_lecture === 1">
                  <v-btn v-if="user.email_verified_at && !authStore.lectures.some(lecture => lecture.id === show_lecture.id)" @click="registerLecture" color="green" text>Register</v-btn>
                  <v-btn v-if="user.email_verified_at && authStore.lectures.some(lecture => lecture.id === show_lecture.id)" @click="removeLecture" color="red" text>Remove</v-btn>
                </template>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <v-dialog v-model="error_dialog" width="auto" persistent>
            <v-card min-width="600" prepend-icon="mdi-update" title="We couldn't perform the operation.">
              <v-card-text>
                <p>{{authStore.errors.message}}</p>
              </v-card-text>
              <template v-slot:actions>
                <v-btn class="ms-auto" @click="closeErrorDialog">Close</v-btn>
              </template>
            </v-card>
          </v-dialog>
          <!-- Success Alert -->
            <div v-if="authStore.success" role="alert">
              <v-alert  dismissible v-model="successVisible">
                {{ authStore.success }}
              </v-alert>
            </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { useStageStore } from "@/stores/StageStore.js";
import { useLectureStore } from "@/stores/LectureStore.js";
import { UseAuthStore } from "@/stores/AuthStore.js";
import { watch } from "vue";

export default {
  data() {
    return {
      stageStore: useStageStore(),
      lectureStore: useLectureStore(),
      authStore: UseAuthStore(),
      dialog: false,
      error_dialog: false,
      action_type: "",
      show_lecture: null,
      user: {},
      waiting:false,
      successVisible: false,
    };
  },
  computed: {
    remainingSpots() {
      if (this.show_lecture) {
        return this.show_lecture.capacity - this.show_lecture.taken_spots;
      } else {
        return 0;
      }
    }

  },
  created() {
    this.stageStore.fetchCurrentConferenceStages().then(() => {
      this.fetchLecturesByStage();
    });
    this.lectureStore.fetchCurrentConferenceLectures();
    this.user = this.authStore.getUser;
  },
  mounted() {
    watch(() => this.authStore.errors, (newValue, oldValue) => {
      if (newValue && newValue.length !== 0) {
        this.callErrorDialog();
      }
    });
    watch(() => this.authStore.success, (newValue, oldValue) => {
      if (newValue) {
        this.successVisible = true;
        setTimeout(() => {
          this.successVisible = false;
        }, 4000);
      }
    });
  },
  methods: {
    showDetails(lecture) {
      this.show_lecture = lecture;
      this.dialog = true;
    },
    callErrorDialog() {
      this.error_dialog = true;
    },
    closeErrorDialog() {
      this.error_dialog = false;
      this.authStore.errors = [];
    },
    registerLecture() {
      this.dialog = false;
      this.authStore.addLecture(this.show_lecture.id).then(() => {
        if (this.authStore.errors.length === 0) {
          this.show_lecture.taken_spots++;
        }
      });
    },
    removeLecture() {
      this.dialog = false;
      this.authStore.deleteLecture(this.show_lecture.id).then(() => {
        this.show_lecture.taken_spots--;
      });
    },
    async fetchLecturesByStage(stageName = null) {
      this.waiting = true;
      if (stageName) {
        await this.lectureStore.fetchLecturesByStage(stageName);
        this.waiting = false;
      } else {
        const stages = this.stageStore.getCurrentStages;
        if (stages.length > 0) {
          await this.lectureStore.fetchLecturesByStage(stages[0].name);
          this.waiting = false;
        }
      }
    }
  }
}
</script>
