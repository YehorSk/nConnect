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
import AdminSpeakersView from "@/views/admin/Speakers/AdminSpeakersView.vue";
import AdminCurConSpeakersView from "@/views/admin/Speakers/AdminCurConSpeakersView.vue";
import AdminLecturesView from "@/views/admin/AdminLecturesView.vue";
import AdminCurConOrganizersView from "@/views/admin/Organizers/AdminCurConOrganizersView.vue";
import AdminOrganizersView from "@/views/admin/Organizers/AdminOrganizersView.vue";
import {UseAuthStore} from "@/stores/AuthStore.js";
import NotFoundView from "@/views/NotFoundView.vue";
import AdminManageAdmins from "@/views/admin/AdminManageAdmins.vue";
import AdminManageUsers from "@/views/admin/AdminManageUsers.vue";

async function adminGuard(ro,from,next){
  const authStore = UseAuthStore();
  await authStore.fetchUser();
  if(authStore.user.is_admin !== 1){
    next({ name: 'home' });
  }else{
    next();
  }
}

async function userGuard(ro,from,next){
  const authStore = UseAuthStore();
  await authStore.fetchUser();
  if(authStore.user.id){
    next({ name: 'home' });
  }else{
    next();
  }
}

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
      path: '/single-speaker/:id',
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
      component: RegisterView,
      beforeEnter: userGuard
    },
      {
          path: '/notfound',
          name: 'NotFoundView',
          component: NotFoundView
      },
    {
      path: '/admin',
      name: 'admin',
      component: AdminView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-stages',
      name: 'admin-stages',
      component: AdminStagesView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-current-conference-stages',
      name: 'admin-current-conference-stages',
      component: AdminCurConStagesView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-time-slots/:id',
      name: 'admin-time-slots',
      component: AdminTimeSlots,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-gallery',
      name: 'admin-gallery',
      component: AdminGalleryView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-sponsors',
      name: 'admin-sponsors',
      component: AdminSponsorsView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-current-conference-sponsors',
      name: 'admin-current-conference-sponsors',
      component: AdminCurConSponsorsView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-reviews',
      name: 'admin-reviews',
      component: AdminReviewView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-speakers',
      name: 'admin-speakers',
      component: AdminSpeakersView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-lectures',
      name: 'admin-lectures',
      component: AdminLecturesView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-current-conference-speakers',
      name: 'admin-current-conference-speakers',
      component: AdminCurConSpeakersView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-organizers',
      name: 'admin-organizers',
      component: AdminOrganizersView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-current-conference-organizers',
      name: 'admin-current-conference-organizers',
      component: AdminCurConOrganizersView,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-manage-admins',
      name: 'admin-manage-admins',
      component: AdminManageAdmins,
      beforeEnter: adminGuard
    },
    {
      path: '/admin-manage-users',
      name: 'admin-manage-users',
      component: AdminManageUsers,
      beforeEnter: adminGuard
    },

  ]
})

export default router
