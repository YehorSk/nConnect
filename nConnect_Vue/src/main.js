

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';


import App from './App.vue'
import router from './router'
import axios from "axios";
import {useStorage} from "@vueuse/core";

const app = createApp(App);

axios.defaults.baseURL = "https://api.nconnect.mojawebka.eu/nConnect-Laravel/public/api";

axios.interceptors.request.use((config) => {
    const token = useStorage('token',{}).value;
    config.headers.Authorization = `Bearer ${token}`;
    if (!config.headers["Content-Type"]) {
        config.headers["Content-Type"] = "application/json";
    }
    config.headers["Access-Control-Allow-Origin"] = "*";
    config.headers.Accept = "application/vnd.api+json";
    return config;
});

app.use(createPinia());
app.use(router);

const vuetify = createVuetify({
    components,
    directives,
});

app.use(vuetify);


app.mount('#app');
