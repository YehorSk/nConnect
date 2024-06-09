<script setup>
import NavigationComponent from "@/components/NavigationComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
</script>
<template>
  <NavigationComponent/>
  <br>
  <br>
  <br>
  <div id="stars"></div>
  <div id="stars2"></div>
  <div id="stars3"></div>
  <div class="section1">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="section pb-5 pt-5 pt-sm-2 text-center">
            <h6 style="color: #FF6600" class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
            <input @click="clearErrors" class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
            <label for="reg-log"></label>
            <div class="card-3d-wrap mx-auto">
              <div class="card-3d-wrapper">
                <div class="card-front">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 style="color: #FF6600" class="mb-4 pb-3">Log In</h4>
                      <div class="form-group mt-2">
                        <input type="email" v-model="email" class="form-style" :class="{'is-invalid':authStore.errors['email']}" placeholder="Email">
                        <i style="color: #FF6600" class="input-icon uil uil-at"></i>
                        <div v-if="authStore.errors['email']" class="invalid-feedback">
                          {{authStore.errors['email'][0]}}
                        </div>
                      </div>

                      <div class="form-group mt-2">
                        <input type="password" v-model="password" class="form-style" :class="{ 'is-invalid': authStore.errors['password'] || authStore.credentials }" placeholder="Password">
                        <i style="color: #FF6600" class="input-icon uil uil-lock-alt"></i>
                        <div v-if="authStore.errors['password']" class="invalid-feedback">
                          <p v-if="authStore.errors['password']">{{ authStore.errors['password'][0] }}</p>
                        </div>
                        <div v-if="authStore.credentials" class="invalid-feedback">
                          {{ authStore.credentials }}
                        </div>
                      </div>

                      <a href="#" @click="submitLogInForm" class="btn mt-4">Login</a>

                      <p class="mb-0 mt-4 text-center">
                        <router-link
                            to="/forgot-password" class="link">Forgot your password?<span></span>
                        </router-link>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="card-back">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 style="color: #FF6600" class="mb-3 pb-3">Sign Up</h4>
                      <form @submit.prevent>
                      <div class="form-group ">
                        <input type="text" v-model="name" class="form-style" :class="{'is-invalid':authStore.errors['name']}" placeholder="Full Name">
                        <i style="color: #FF6600" class="input-icon uil uil-user"></i>
                        <div v-if="authStore.errors['name']" class="invalid-feedback">
                          {{authStore.errors['name'][0]}}
                        </div>
                      </div>
                      <div class="form-group mt-2">
                        <input type="email" v-model="email" class="form-style" :class="{'is-invalid':authStore.errors['email']}" placeholder="Email">
                        <i style="color: #FF6600" class="input-icon uil uil-at"></i>
                        <div v-if="authStore.errors['email']" class="invalid-feedback">
                          {{authStore.errors['email'][0]}}
                        </div>
                      </div>
                      <div class="form-group mt-2">
                        <input type="password" v-model="password" class="form-style" :class="{'is-invalid':authStore.errors['password']}" placeholder="Password">
                        <i style="color: #FF6600" class="input-icon uil uil-lock-alt"></i>
                        <div v-if="authStore.errors['password']" class="invalid-feedback">
                          {{authStore.errors['password'][0]}}
                        </div>
                      </div>
                      <div class="form-group mt-2">
                        <input type="password" v-model="password_confirmation" class="form-style" placeholder="Confirm password">
                        <i style="color: #FF6600" class="input-icon uil uil-lock-alt"></i>
                      </div>
                      <a href="#" class="btn mt-4" @click="submitRegForm">Register</a>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <v-dialog v-model="success_dialog" width="auto" persistent>
    <v-card min-width="600" prepend-icon="mdi-update" title="Success">
      <v-card-text>
        <p>{{authStore.success}}</p>
      </v-card-text>
      <template v-slot:actions>
        <v-btn class="ms-auto" @click="closeSuccessDialog">Close</v-btn>
      </template>
    </v-card>
  </v-dialog>
  <FooterComponent/>
</template>
<script>

import {UseAuthStore} from "@/stores/AuthStore.js";
import {watch} from "vue";

export default{
  data(){
    return{
      name:'',
      email:'',
      password:'',
      password_confirmation:'',
      authStore: UseAuthStore(),
      success_dialog:false
    };
  },
  methods:{
    submitRegForm(){
      this.authStore.register(this.name,this.email,this.password,this.password_confirmation);
      this.name = '';
      this.email = '';
      this.password = '';
      this.password_confirmation = '';
      this.authStore.credentials= '';
      this.authStore.errors = [];
    },
    submitLogInForm(){
      this.authStore.login(this.email,this.password);
      this.email = '';
      this.password = '';
    },
    clearErrors(){
      this.authStore.credentials= '';
      this.authStore.errors = [];
    },
    callSuccessDialog(){
      this.success_dialog = true;
    },
    closeSuccessDialog(){
      this.success_dialog = false;
      this.authStore.success='';
    }

  },
  mounted() {
    watch(() => this.authStore.success, (newValue, oldValue) => {
      if (newValue && newValue.length !== 0) {
        this.callSuccessDialog();
      }
    });
  }
}
</script>
<style>
@import url('https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800,900');

a:hover {
  text-decoration: none;
}
.link {
  color: #FF6600;
}
.link:hover {
  color: #c4c3ca;
}
p {
  font-weight: 500;
  font-size: 14px;
}
h4 {
  font-weight: 600;
}
h6 span{
  padding: 0 20px;
  font-weight: 700;
}

.section1 {
  position: relative;
  width: 100%;
  display: block;
  background-color: #1f2029;
  overflow: hidden;
  height: 100vh;
  background: radial-gradient(ellipse at bottom, #1B2735 0%, #12141d 100%);
}
.full-height{
  min-height: 100vh;
}
[type="checkbox"]:checked,
[type="checkbox"]:not(:checked){
  display: none;
}
.checkbox:checked + label,
.checkbox:not(:checked) + label{
  position: relative;
  display: block;
  text-align: center;
  width: 60px;
  height: 16px;
  border-radius: 8px;
  padding: 0;
  margin: 10px auto;
  cursor: pointer;
  background-color: #FF6600;
}
.checkbox:checked + label:before,
.checkbox:not(:checked) + label:before{
  position: absolute;
  display: block;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  color: #FF6600;
  background-color: #020305;
  font-family: 'unicons';
  content: '\eb4f';
  z-index: 20;
  top: -10px;
  left: -10px;
  line-height: 36px;
  text-align: center;
  font-size: 24px;
  transition: all 0.5s ease;
}
.checkbox:checked + label:before {
  transform: translateX(44px) rotate(-270deg);
}
.card-3d-wrap {
  position: relative;
  width: 440px;
  max-width: 100%;
  height: 500px;
  -webkit-transform-style: preserve-3d;
  transform-style: preserve-3d;
  perspective: 800px;
  margin-top: 60px;
}
.card-3d-wrapper {
  width: 100%;
  height: 100%;
  position:absolute;
  -webkit-transform-style: preserve-3d;
  transform-style: preserve-3d;
  transition: all 600ms ease-out;
}
.card-front, .card-back {
  width: 100%;
  height: 100%;
  background-color: #2b2e38;
  background-image: url('/img/pattern_japanese-pattern-2_1_2_0-0_0_1__ffffff00_000000.png');
  position: absolute;
  border-radius: 6px;
  -webkit-transform-style: preserve-3d;
}
.card-back {
  transform: rotateY(180deg);
}
.checkbox:checked ~ .card-3d-wrap .card-3d-wrapper {
  transform: rotateY(180deg);
}
.center-wrap{
  position: absolute;
  width: 100%;
  padding: 0 35px;
  top: 50%;
  left: 0;
  transform: translate3d(0, -50%, 35px) perspective(100px);
  z-index: 20;
  display: block;
}
.form-group{
  position: relative;
  display: block;
  margin: 0;
  padding: 0;
}
.form-style {
  padding: 13px 20px;
  padding-left: 55px;
  height: 48px;
  width: 100%;
  font-weight: 500;
  border-radius: 4px;
  font-size: 14px;
  line-height: 22px;
  letter-spacing: 0.5px;
  outline: none;
  color: #c4c3ca;
  background-color: #1f2029;
  border: none;
  -webkit-transition: all 200ms linear;
  transition: all 200ms linear;
  box-shadow: 0 4px 8px 0 rgba(21,21,21,.2);
}
.form-style:focus,
.form-style:active {
  border: none;
  outline: none;
  box-shadow: 0 4px 8px 0 rgba(21,21,21,.2);
}
.input-icon {
  position: absolute;
  top: 0;
  left: 18px;
  height: 48px;
  font-size: 24px;
  line-height: 48px;
  text-align: left;
  -webkit-transition: all 200ms linear;
  transition: all 200ms linear;
}
.btn {
  border-radius: 4px;
  height: 44px;
  font-size: 13px;
  font-weight: 600;
  text-transform: uppercase;
  transition: all 200ms linear;
  padding: 0 30px;
  letter-spacing: 1px;
  display: inline-flex;
  align-items: center;
  background-color: #FF6600;
  color: #000000;
}
.btn:hover {
  background-color: #000000;
  color: #FF6600;
  box-shadow: 0 8px 24px 0 rgba(16, 39, 112, .2);
}
.btn:active,
.btn:focus {
  background-color: #FF6600;
  color: #000000;
  outline: none;
  box-shadow: none;
}
.btn:hover:active,
.btn:hover:focus {
  background-color: #000000;
  color: #FF6600;
}
@keyframes animStar {
  from {
    transform: translateY(0px); }
  to {
    transform: translateY(-2000px); } }

</style>
