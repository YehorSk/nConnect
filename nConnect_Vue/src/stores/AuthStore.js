import axios from "axios";
import {defineStore} from "pinia";


axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export const UseAuthStore = defineStore("auth",{
    state:() =>({

    }),
    getters:{

    },
    actions:{

    }
});