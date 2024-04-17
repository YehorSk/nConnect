<script setup>
import NavigationComponent from "@/components/NavigationComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";
</script>
<template>
  <NavigationComponent/>
  <div id="stars"></div>
  <div id="stars2"></div>
  <div id="stars3"></div>
  <div class="section">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="section pb-5 pt-5 pt-sm-2 text-center">
            <h6 style="color: #FF6600" class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
            <label for="reg-log"></label>
            <div class="card-3d-wrap mx-auto">
              <div class="card-3d-wrapper">
                <div class="card-front">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 style="color: #FF6600" class="mb-4 pb-3">Log In</h4>
                      <div class="form-group">
                        <input type="email" class="form-style" placeholder="Email">
                        <i style="color: #FF6600" class="input-icon uil uil-at"></i>
                      </div>
                      <div class="form-group mt-2">
                        <input type="password" class="form-style" placeholder="Password">
                        <i style="color: #FF6600" class="input-icon uil uil-lock-alt"></i>
                      </div>
                      <a href="#" class="btn mt-4">Login</a>
                      <p class="mb-0 mt-4 text-center"><a href="#" class="link">Forgot your password?</a></p>
                    </div>
                  </div>
                </div>
                <div class="card-back">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 style="color: #FF6600" class="mb-3 pb-3">Sign Up</h4>
                      <div class="form-group">
                        <input type="text" class="form-style" placeholder="Full Name">
                        <i style="color: #FF6600" class="input-icon uil uil-user"></i>
                      </div>
                      <div class="form-group mt-2">
                        <input type="tel" class="form-style" placeholder="Phone Number">
                        <i style="color: #FF6600" class="input-icon uil uil-phone"></i>
                      </div>
                      <div class="form-group mt-2">
                        <input type="email" class="form-style" placeholder="Email">
                        <i style="color: #FF6600" class="input-icon uil uil-at"></i>
                      </div>
                      <div class="form-group mt-2">
                        <input type="password" class="form-style" placeholder="Password">
                        <i style="color: #FF6600" class="input-icon uil uil-lock-alt"></i>
                      </div>
                      <a href="#" class="btn mt-4">Register</a>
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
  <FooterComponent/>
</template>
<style>
.btn{
  border-radius: 4px;
  height: 44px;
  font-size: 13px;
  font-weight: 600;
  text-transform: uppercase;
  -webkit-transition : all 200ms linear;
  transition: all 200ms linear;
  padding: 0 30px;
  letter-spacing: 1px;
  display: -webkit-inline-flex;
  display: -ms-inline-flexbox;
  display: inline-flex;
  align-items: center;
  background-color: #FF6600;
  color: #000000;
}
.btn:hover {
  background-color: #000000;
  color: #FF6600;
  box-shadow: 0 8px 24px 0 rgba(16,39,112,.2);
}
</style>
