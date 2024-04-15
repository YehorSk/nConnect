import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ScheduleView from "@/views/ScheduleView.vue";
import SpeakersView from "@/views/SpeakersView.vue";
import SponsorsView from "@/views/SponsorsView.vue";
import SingleSpeakerView from "@/views/SingleSpeakerView.vue";
import FAQView from "@/views/FAQView.vue";
import GalleryView from "@/views/GalleryView.vue";
import TestimonialVuew from "@/views/TestimonialVuew.vue";
import ContactView from "@/views/ContactView.vue";
import AboutUsView from "@/views/AboutUsView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/schedule',
      name: 'schedule',
      component: ScheduleView
    },
    {
      path: '/speakers',
      name: 'speakers',
      component: SpeakersView
    },
    {
      path: '/sponsors',
      name: 'sponsors',
      component: SponsorsView
    },
    {
      path: '/single-speaker',
      name: 'single-speaker',
      component: SingleSpeakerView
    },
    {
      path: '/faq',
      name: 'faq',
      component: FAQView
    },
    {
      path: '/gallery',
      name: 'gallery',
      component: GalleryView
    },
    {
      path: '/testimonial',
      name: 'testimonial',
      component: TestimonialVuew
    },
    {
      path: '/contact',
      name: 'contact',
      component: ContactView
    },
    {
      path: '/aboutus',
      name: 'aboutus',
      component: AboutUsView
    }
  ]
})

export default router
