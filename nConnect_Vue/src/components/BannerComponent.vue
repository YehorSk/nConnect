<template>
  <section class="banner bg-banner-one overlay">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <!-- Content Block -->
          <div class="block">
            <!-- Countdown Timer -->
            <!-- <div class="timer"></div> -->
            <h1>{{ conferenceStore.getCurrentConference.name }}</h1>
            <h2>TECH KONFERENCIA PRE ŠTUDENTOV V NITRE</h2>
            <h6>{{ conferenceStore.getCurrentConference.year }}</h6>
            <!-- Action Button -->
            <div v-if="user.id">
              <div v-if="user.email_verified_at">
                <v-btn class="btn btn-white-md" @click="conference_dialog = true">Moje konferencie</v-btn>
                <v-dialog v-model="conference_dialog" width="auto">
                  <v-card min-width="600" prepend-icon="mdi-update" title="Moje konferencie">
                    <v-card-text>
                      <v-list lines="one">
                        <v-list-item
                            v-for="lecture in authStore.lectures"
                            :key="lecture.id"
                        >
                          <v-list-item-content>
                            <v-list-item-title>{{ 'Name: ' + lecture.name }}</v-list-item-title>
                            <v-list-item-subtitle>{{ 'Time: ' + lecture.start_time + ' - ' + lecture.end_time }}</v-list-item-subtitle>
                            <v-list-item-subtitle>{{ 'Voľné miesta: ' + (lecture.capacity - lecture.remaining_spots) }}</v-list-item-subtitle>
                          </v-list-item-content>
                          <v-btn color="black" @click="removeLecture(lecture.id)">
                            Odhlásiť sa
                          </v-btn>
                        </v-list-item>
                      </v-list>
                    </v-card-text>
                    <v-alert v-model="showRemovalAlert" type="error" dismissible>
                      Ste odhlásený/á!
                    </v-alert>
                    <template v-slot:actions>
                      <v-btn class="ms-auto" text="Close" @click="conference_dialog = false"></v-btn>
                    </template>
                  </v-card>
                </v-dialog>
              </div>
              <div v-else-if="!user.email_verified_at">
                <h2>Please verify your email</h2>
              </div>

              <div v-if="user.is_admin === 1">
                <router-link to="/admin" class="btn btn-white-md">Admin</router-link>
              </div>
              <div>
                <button @click="authStore.logout" class="btn btn-white-md">Logout</button>
              </div>
            </div>
            <div v-else>
              <router-link to="/register" class="btn btn-white-md">Registrácia</router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { UseAuthStore } from "@/stores/AuthStore.js";
import { initFlowbite } from 'flowbite';
import { UseConferenceStore } from "@/stores/ConferenceStore.js";
import { useLectureStore } from "@/stores/LectureStore.js";
export default {
  data() {
    return {
      authStore: UseAuthStore(),
      user: {},
      conference_dialog: false,
      lectureStore: useLectureStore(),
      conferenceStore: UseConferenceStore(),
      showRemovalAlert: false,
    };
  },
  created() {
    this.user = this.authStore.getUser;
    this.conferenceStore.fetchCurrentConference();
    this.authStore.fetchLectures();
  },
  mounted() {
    initFlowbite();
  },
  methods: {
    removeLecture(lectureId) {
      this.authStore.deleteLecture(lectureId).then(() => {
        this.showRemovalAlert = true;
        setTimeout(() => {
          this.showRemovalAlert = false;
        }, 3000);
      });
    },
  },
};
</script>
