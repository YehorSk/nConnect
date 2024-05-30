import axios from "axios";
import {defineStore} from "pinia";

axios.defaults.baseURL = "http://localhost/nConnect/nConnect-Laravel/public/api/";

export function stripHtmlTags(str) {
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = str;
    return tempDiv.textContent || tempDiv.innerText || '';
}
export const useEditorStore = defineStore("editor",{
    state:()=>({
        errors:[],
        pages: []
    }),
    getters:{
        getPages(){
            return this.pages;
        }
    },

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
        },
        async fetchPages(){
            try{
                const response = await axios.get('pages');
                this.pages = response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async fetchPageById(id){
            try{
                const response = await axios.get(`get-current-page/${id}`);
                return response.data;
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        }
    }

});