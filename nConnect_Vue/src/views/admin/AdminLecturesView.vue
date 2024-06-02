<style scoped>
@import '/src/assets/main.css';
</style>
<template>
  <AdminNavComponent/>

  <div class="p-4 sm:ml-64 ">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 mt-14">


      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

        <v-sheet class="max-w-sm ">
          <v-form fast-fail @submit.prevent>
            <v-text-field
                v-model="name"
                label="Name"
            ></v-text-field>
            <div v-if="lectureStore.errors['name']">
              <span class="text-sm text-red-400">
                {{lectureStore.errors['name'][0]}}
              </span>
            </div>
            <v-text-field
                :disabled="!is_lecture"
                v-model="capacity"
                label="Capacity"
                type="number"
            ></v-text-field>
            <div v-if="lectureStore.errors['capacity']">
              <span class="text-sm text-red-400">
                {{lectureStore.errors['capacity'][0]}}
              </span>
            </div>
            <v-text-field
                v-model="start_time"
                label="Start time"
                type="time"
            ></v-text-field>
            <div v-if="lectureStore.errors['start_time']">
              <span class="text-sm text-red-400">
                {{lectureStore.errors['start_time'][0]}}
              </span>
            </div>
            <v-text-field
                v-model="end_time"
                label="End time"
                type="time"
            ></v-text-field>
            <div v-if="lectureStore.errors['end_time']">
              <span class="text-sm text-red-400">
                {{lectureStore.errors['end_time'][0]}}
              </span>
            </div>
            <v-text-field
                v-model="short_desc"
                label="Short Description"
            ></v-text-field>
            <div v-if="lectureStore.errors['short_desc']">
              <span class="text-sm text-red-400">
                {{lectureStore.errors['short_desc'][0]}}
              </span>
            </div>
            <v-textarea
                :disabled="!is_lecture"
                v-model="long_desc"
                label="Long Description"
                row-height="25"
                rows="4"
                variant="outlined"
                auto-grow
                shaped
            ></v-textarea>
            <div v-if="lectureStore.errors['long_desc'] && is_lecture">
              <span class="text-sm text-red-400">
                {{lectureStore.errors['long_desc'][0]}}
              </span>
            </div>
            <v-checkbox
                v-model="is_lecture"
                color="orange"
                label="Is lecture"
                hide-details
            ></v-checkbox>
            <v-select :item-props="itemStages" v-model="stage" :items="stageStore.getCurrentStages" label="Available Stages"></v-select>
            <div v-if="lectureStore.errors['stage_id']">
              <span class="text-sm text-red-400">
                {{lectureStore.errors['stage_id'][0]}}
              </span>
            </div>
            <v-select :disabled="!is_lecture" :item-props="itemSpeakers" v-model="speaker" :items="speakerStore.getCurrentSpeakers" label="Available Speakers"></v-select>
            <div v-if="lectureStore.errors['speaker_id'] && is_lecture">
              <span class="text-sm text-red-400">
                {{lectureStore.errors['speaker_id'][0]}}
              </span>
            </div>
            <v-btn class="mt-2" type="submit" @click="submitForm()" block>Save</v-btn>
          </v-form>
        </v-sheet>

        <br>
        <div class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <div class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 items-center">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3">
                  Name
                </th>
                <th scope="col" class="px-6 py-3">
                  Capacity
                </th>
                <th scope="col" class="px-6 py-3">
                  Start Time
                </th>
                <th scope="col" class="px-6 py-3">
                  End Time
                </th>
                <th scope="col" class="px-6 py-3">
                  Is Lecture
                </th>
                <th scope="col" class="px-6 py-3">
                  Users
                </th>
                <th scope="col" class="px-6 py-3">
                  Show/Update
                </th>
                <th scope="col" class="px-6 py-3">
                  Delete
                </th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="lecture in lectureStore.getCurrentLectures" :key="lecture.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-normal dark:text-white">
                  {{lecture.name}}
                </td>
                <td class="px-6 py-4">
                  {{lecture.capacity}}
                </td>
                <td class="px-6 py-4">
                  {{lecture.start_time}}
                </td>
                <td class="px-6 py-4">
                  {{lecture.end_time}}
                </td>
                <td class="px-6 py-4">
                  {{lecture.is_lecture}}
                </td>
                <td class="px-6 py-4">
                  <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block" @click="users_dialog = true,lectureStore.getLectureUsers(lecture.id)">
                    Users
                  </v-btn>

                  <v-dialog v-model="users_dialog" width="auto">
                    <v-card min-width="600" prepend-icon="mdi-update" title="Users">
                      <v-card-text>
                        <v-list lines="one">
                          <v-list-item
                              v-for="user in lectureStore.current_users"
                              :key="user.id"
                              :title="'Name: ' + user.name"
                              :subtitle="'Email: ' + user.email"
                          ></v-list-item>
                        </v-list>
                      </v-card-text>
                      <template v-slot:actions>
                        <v-btn class="ms-auto" text="Close" @click="users_dialog = false"></v-btn>
                      </template>
                    </v-card>
                  </v-dialog>
                </td>
                <td class="px-6 py-4">
                  <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline inline-block" @click="dialog = true,editLecture(lecture)">
                    Show/Update
                  </v-btn>

                  <v-dialog v-model="dialog" width="auto" persistent>
                    <v-card min-width="600" prepend-icon="mdi-update" title="Update Lecture">
                      <v-card-text>
                        <v-text-field
                            v-model="edit_lecture.name"
                            label="Name"
                        ></v-text-field>

                        <v-text-field
                            :disabled="!edit_lecture.is_lecture"
                            v-model="edit_lecture.capacity"
                            label="Capacity"
                            type="number"
                        ></v-text-field>

                        <v-text-field
                            v-model="edit_lecture.start_time"
                            label="Start time"
                            type="time"
                        ></v-text-field>
                        <v-text-field
                            v-model="edit_lecture.end_time"
                            label="End time"
                            type="time"
                        ></v-text-field>
                        <v-text-field
                            v-model="edit_lecture.short_desc"
                            label="Short Description"
                        ></v-text-field>
                        <v-textarea
                            :disabled="!edit_lecture.is_lecture"
                            v-model="edit_lecture.long_desc"
                            label="Long Description"
                            row-height="25"
                            rows="4"
                            variant="outlined"
                            auto-grow
                            shaped
                        ></v-textarea>
                        <v-select :item-props="itemStages" item-value="id" v-model="edit_lecture.stage_id" :items="stageStore.getCurrentStages" label="Available Stages"></v-select>
                        <v-select :disabled="!edit_lecture.is_lecture" item-value="id" :item-props="itemSpeakers" v-model="edit_lecture.speaker_id" :items="speakerStore.getCurrentSpeakers" label="Available Speakers"></v-select>
                      </v-card-text>
                      <template v-slot:actions>
                        <v-btn class="ms-auto" text="Close" @click="dialog = false, lectureStore.refreshLectures()"></v-btn>
                        <v-btn class="font-medium text-green-600 dark:text-green-500 hover:underline" text="Update" @click="dialog = false,updateForm(edit_lecture)"></v-btn>
                      </template>
                    </v-card>
                  </v-dialog>
                </td>
                <td class="px-6 py-4">
                  <form @submit.prevent class="inline-block">
                    <button class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block" type="submit" @click="lectureStore.destroyLecture(lecture.id)">DELETE</button>
                  </form>
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div v-if="lectureStore.success" id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
      <SuccessAlertComponent :message="lectureStore.success"/>
    </div>
    <v-dialog v-model="error_dialog" width="auto" persistent>
      <v-card min-width="600" prepend-icon="mdi-update" title="We couldn't perform the update. Please check the data you've entered and try again.">
        <v-card-text>
          <ul>
            <li v-for="(errors, fieldName) in lectureStore.errors_update" :key="fieldName">
              <ul>
                <li v-for="error in errors" :key="error">{{ error }}</li>
              </ul>
            </li>
          </ul>
        </v-card-text>
        <template v-slot:actions>
          <v-btn class="ms-auto" text="Close" @click="closeErrorDialog"></v-btn>
        </template>
      </v-card>
    </v-dialog>
  </div>



</template>
<script>
import {onMounted, watch} from 'vue'
import { initFlowbite } from 'flowbite'
import {useLectureStore} from "@/stores/LectureStore.js";
import {useStageStore} from "@/stores/StageStore.js";
import {useSpeakersStore} from "@/stores/SpeakersStore.js";
import AdminNavComponent from "@/components/AdminNavComponent.vue";
import SuccessAlertComponent from "@/components/alerts/SuccessAlertComponent.vue";
import ErrorAlertComponent from "@/components/alerts/ErrorAlertComponent.vue";


export default {
  components: {ErrorAlertComponent, SuccessAlertComponent, AdminNavComponent},
  data(){
    return {
      name: '',
      capacity: '',
      start_time: '',
      end_time: '',
      short_desc: '',
      long_desc:'',
      lectures:[],
      errors:[],
      stage:[],
      speaker:[],
      is_lecture:false,
      edit_lecture:[],
      dialog:false,
      error_dialog:false,
      users_dialog:false,
      lectureStore: useLectureStore(),
      stageStore: useStageStore(),
      speakerStore: useSpeakersStore()
    };
  },
  created(){
    this.lectureStore.fetchCurrentConferenceLectures();
    this.stageStore.fetchCurrentConferenceStages();
    this.speakerStore.fetchCurrentConferenceSpeakers();
  },
  mounted() {
    initFlowbite();
    watch(() => this.lectureStore.errors_update, (newValue, oldValue) => {
      if (newValue && newValue.length !== 0) {
        this.callErrorDialog();
      }
    });
  },
  methods:{
    editLecture(lecture){
      this.edit_lecture = lecture;
    },
    submitForm() {
      this.lectureStore.insertLecture(this.name, this.capacity, this.start_time, this.end_time, this.short_desc,this.long_desc,this.is_lecture,this.stage,this.speaker);
      this.name = '';
      this.capacity = '';
      this.start_time='';
      this.end_time='';
      this.short_desc='';
      this.long_desc='';
      this.is_lecture=false;
      this.stage = [];
      this.speaker = [];
    },
    updateForm(lecture) {
      this.lectureStore.updateLecture(lecture);
    },
    itemStages (item) {
      return {
        title: item.name,
        subtitle: item.date,
      }
    },
    itemSpeakers (item) {
      return {
        title: item.first_name,
        subtitle: item.short_desc,
      }
    },
    callErrorDialog(){
      this.error_dialog = true;
    },
    closeErrorDialog(){
      this.error_dialog = false;
      this.lectureStore.errors_update=[];
      this.lectureStore.fetchCurrentConferenceLectures();
    }
  }
}
</script>
