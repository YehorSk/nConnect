import { createRouter, createWebHistory } from 'vue-router';
import { UseAuthStore } from '@/stores/AuthStore.js';

const HomeView = () => import(/* webpackChunkName: "home" */ '../views/HomeView.vue');
const ScheduleView = () => import(/* webpackChunkName: "schedule" */ '@/views/ScheduleView.vue');
const SpeakersView = () => import(/* webpackChunkName: "speakers" */ '@/views/SpeakersView.vue');
const SponsorsView = () => import(/* webpackChunkName: "sponsors" */ '@/views/SponsorsView.vue');
const SingleSpeakerView = () => import(/* webpackChunkName: "single-speaker" */ '@/views/SingleSpeakerView.vue');
const GalleryView = () => import(/* webpackChunkName: "gallery" */ '@/views/GalleryView.vue');
const ContactView = () => import(/* webpackChunkName: "contact" */ '@/views/ContactView.vue');
const RegisterView = () => import(/* webpackChunkName: "register" */ '@/views/RegisterView.vue');
const ForgotPasswordView = () => import(/* webpackChunkName: "forgot-password" */ '@/views/ForgotPasswordView.vue');
const ResetPasswordView = () => import(/* webpackChunkName: "reset-password" */ '@/views/ResetPasswordView.vue');
const CustomPagesView = () => import(/* webpackChunkName: "pages" */ '@/views/CustomPagesView.vue');
const SinglePageView = () => import(/* webpackChunkName: "get-page" */ '@/views/SinglePageView.vue');
const AdminView = () => import(/* webpackChunkName: "admin" */ '@/views/admin/AdminView.vue');
const AdminStagesView = () => import(/* webpackChunkName: "admin-stages" */ '@/views/admin/Stages/AdminStagesView.vue');
const AdminGalleryView = () => import(/* webpackChunkName: "admin-gallery" */ '@/views/admin/AdminGalleryView.vue');
const AdminSponsorsView = () => import(/* webpackChunkName: "admin-sponsors" */ '@/views/admin/Sponsors/AdminSponsorsView.vue');
const AdminReviewView = () => import(/* webpackChunkName: "admin-reviews" */ '@/views/admin/AdminReviewView.vue');
const AdminCurConStagesView = () => import(/* webpackChunkName: "admin-cur-con-stages" */ '@/views/admin/Stages/AdminCurConStagesView.vue');
const AdminCurConSponsorsView = () => import(/* webpackChunkName: "admin-cur-con-sponsors" */ '@/views/admin/Sponsors/AdminCurConSponsorsView.vue');
const AdminSpeakersView = () => import(/* webpackChunkName: "admin-speakers" */ '@/views/admin/Speakers/AdminSpeakersView.vue');
const AdminCurConSpeakersView = () => import(/* webpackChunkName: "admin-cur-con-speakers" */ '@/views/admin/Speakers/AdminCurConSpeakersView.vue');
const AdminLecturesView = () => import(/* webpackChunkName: "admin-lectures" */ '@/views/admin/AdminLecturesView.vue');
const AdminCurConOrganizersView = () => import(/* webpackChunkName: "admin-cur-con-organizers" */ '@/views/admin/Organizers/AdminCurConOrganizersView.vue');
const AdminOrganizersView = () => import(/* webpackChunkName: "admin-organizers" */ '@/views/admin/Organizers/AdminOrganizersView.vue');
const AdminManageAdmins = () => import(/* webpackChunkName: "admin-manage-admins" */ '@/views/admin/AdminManageAdmins.vue');
const AdminManageUsers = () => import(/* webpackChunkName: "admin-manage-users" */ '@/views/admin/AdminManageUsers.vue');
const AdminEditorView = () => import(/* webpackChunkName: "admin-editor" */ '@/views/admin/AdminEditorView.vue');
const NotFoundView = () => import(/* webpackChunkName: "not-found" */ '@/views/NotFoundView.vue');

// Guards
async function checkAuth(roleCheck, next) {
  const authStore = UseAuthStore();
  // await authStore.fetchUser();
  if (roleCheck(authStore.user)) {
    next();
  } else {
    next({ name: 'home' });
  }
}

const adminGuard = (to, from, next) => checkAuth(user => user.is_admin === 1, next);
const userGuard = (to, from, next) => checkAuth(user => !user.id, next);

// Route configuration
const routes = [
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
    path: '/pages',
    name: 'pages',
    component: CustomPagesView
  },
  {
    path: '/get-page/:id',
    name: 'get-page',
    component: SinglePageView
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
    beforeEnter: userGuard
  },
  {
    path: '/forgot-password',
    name: 'forgot-password',
    component: ForgotPasswordView,
    beforeEnter: userGuard
  },
  {
    path: '/reset-password/:token',
    name: 'reset-password',
    component: ResetPasswordView,
    beforeEnter: userGuard
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
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
  {
    path: '/admin-editor',
    name: 'admin-editor',
    component: AdminEditorView,
    beforeEnter: adminGuard
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { top: 0 };
    }
  },
});

export default router;
