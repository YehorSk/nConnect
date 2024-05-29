import axios from "axios";
import {defineStore} from "pinia";

axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";


export const useEditorStore = defineStore("editor",{
    state:()=>({
        errors:[],
    }),
    actions:{
        async insertPage(name, content) {
            console.log(name);
            console.log(content);
            try {
                const response = await axios.post('pages', {
                    name: name,
                    content: content,
                });

            } catch (error) {

            }
        }
    }

});