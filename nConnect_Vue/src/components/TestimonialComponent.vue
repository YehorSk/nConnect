<template>
  <section class="section testimonial">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="section-title">
            <h3>Povedali o <span class="alternate">nás</span></h3>
          </div>
        </div>
      </div>
      <div class="row mt-20">
        <div v-for="(review, index) in reviewStore.getReviews" :key="index" class="col-lg-4 col-md-6 mb-20">
          <!-- Testimonial -->
          <div class="testimonial-item">
            <!-- Given Comment -->
            <div class="comment">
              <p>{{ review.text }}</p> <!-- Use the 'text' property from the store -->
            </div>
            <div class="person">
              <div class="media">
                <!-- Person Image -->
                <img :src="'http://127.0.0.1:8000/storage/' + review.photo" alt="person-image"> <!-- Use the 'photo' property from the store -->
                <div class="media-body">
                  <!-- Person Name -->
                  <div class="name"><p>{{ review.name }}</p></div> <!-- Use the 'name' property from the store -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { UseReviewStore } from "@/stores/ReviewStore.js";

export default {
  data() {
    return {
      reviewStore: UseReviewStore(),
    };
  },
  created() {
    this.reviewStore.fetchReviews();
  }
};
</script>
