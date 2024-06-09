<template>
  <section class="cta-subscribe bg-subscribe overlay-dark">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mr-auto">
          <div class="content">
            <h3>Máte otázky? <span class="alternate">Feedback?</span></h3>
            <p>Napíšte nám správu, radi Vám odpovieme :)</p>
          </div>
        </div>
        <div class="col-md-6 ml-auto align-self-center">
          <form @submit.prevent="handleSubmit" class="p-4 rounded-lg shadow-lg">
            <div class="row justify-content-center">
              <div class="col-lg-8 col-md-12 mb-3">
                <input v-model="name" type="text" class="form-control form-control-lg mb-3" placeholder="Name" required>
                <input v-model="email" type="email" class="form-control form-control-lg mb-3" placeholder="Email" required>
                <textarea v-model="message" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 form-control form-control-lg mb-3" placeholder="Leave a message..."></textarea>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-lg-4 col-md-12">
                <button type="submit" class="btn btn-main-md btn-block btn-lg">Send</button>
                <br>
                <div v-if="contactFormStore.error" class="text-danger">{{ contactFormStore.error }}</div>
                <div v-if="contactFormStore.success" class="text-success">{{ contactFormStore.success }}</div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { useContactFormStore } from '@/stores/ContactFormStore';

export default {
  data() {
    return {
      contactFormStore: useContactFormStore(),
      name: '',
      email: '',
      message: '',
    };
  },
  methods: {
    handleSubmit() {
      const formData = new FormData();
      formData.append('name', this.name);
      formData.append('email', this.email);
      formData.append('message', this.message);
      this.contactFormStore.submitForm(formData);
      this.name = '';
      this.email = '';
      this.message = '';
    }
  },
};
</script>





<style>
.form-control-lg {
  height: calc(1.5em + 1rem + 2px);
  padding: 0.5rem 1rem;
  font-size: 1.25rem;
  line-height: 1.5;
  border-radius: 0.3rem;
}

.btn-main-md {
  background-color: #ff5900;
  color: white;
  font-size: 1.25rem;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 0.3rem;
  transition: background-color 0.3s ease;
}

.btn-main-md:hover {
  background-color: #0056b3;
}

.form-control {
  border: 1px solid #ced4da;
  border-radius: 0.10rem;
  transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.form-control:focus {
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>
