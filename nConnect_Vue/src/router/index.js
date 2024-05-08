import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ScheduleView from "@/views/ScheduleView.vue";
import SpeakersView from "@/views/SpeakersView.vue";
import SponsorsView from "@/views/SponsorsView.vue";
import SingleSpeakerView from "@/views/SingleSpeakerView.vue";
import GalleryView from "@/views/GalleryView.vue";
import ContactView from "@/views/ContactView.vue";
import RegisterView from "@/views/RegisterView.vue";
import AdminView from "@/views/admin/AdminView.vue";
import AdminStagesView from "@/views/admin/Stages/AdminStagesView.vue";
import AdminTimeSlots from "@/views/admin/AdminTimeSlots.vue";
import AdminGalleryView from "@/views/admin/AdminGalleryView.vue";
import AdminSponsorsView from "@/views/admin/Sponsors/AdminSponsorsView.vue";
import AdminReviewView from "@/views/admin/AdminReviewView.vue";
import AdminCurConStagesView from "@/views/admin/Stages/AdminCurConStagesView.vue";
import AdminCurConSponsorsView from "@/views/admin/Sponsors/AdminCurConSponsorsView.vue";

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
      path: '/gallery',
      name: 'gallery',
      component: GalleryView
    },
    {
      path: '/contact',
      name: 'contact',
      component: ContactView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/admin',
      name: 'admin',
      component: AdminView
    },
    {
      path: '/admin-stages',
      name: 'admin-stages',
      component: AdminStagesView
    },
    {
      path: '/admin-current-conference-stages',
      name: 'admin-current-conference-stages',
      component: AdminCurConStagesView
    },
    {
      path: '/admin-time-slots/:id',
      name: 'admin-time-slots',
      component: AdminTimeSlots
    },
    {
      path: '/admin-gallery',
      name: 'admin-gallery',
      component: AdminGalleryView
    },
    {
      path: '/admin-sponsors',
      name: 'admin-sponsors',
      component: AdminSponsorsView
    },
    {
      path: '/admin-current-conference-sponsors',
      name: 'admin-current-conference-sponsors',
      component: AdminCurConSponsorsView
    },
    {
      path: '/admin-reviews',
      name: 'admin-reviews',
      component: AdminReviewView
    }

  ]
})

export default router
