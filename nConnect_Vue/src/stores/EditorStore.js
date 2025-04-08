import axios from "axios";
import {defineStore} from "pinia";

export function stripHtmlTags(str) {
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = str;
    return tempDiv.textContent || tempDiv.innerText || '';
}
export const useEditorStore = defineStore("editor",{
    state:()=>({
        errors:[],
        pages: [],
        success: ''
    }),
    getters:{
        getPages(){
            return this.pages;
        }
    },

    actions:{
        async insertPage(name, content) {
            try {
                const response = await axios.post('pages', {
                    name: name,
                    content: content,
                });
                this.fetchPages();
                this.success = "Added successfully";
            } catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
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
        },
        async destroyPage(id) {
            try {
                const response = await axios.delete('pages/' + id);
                this.pages = this.pages.filter(page => page.id !== id);
                this.success = "Deleted successfully";
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors.value = error.response.data.errors;
                }
            }
        },
        async updatePage(page){
            try{
                const response = await axios.put("pages/" +page.id,{
                    name: page.name,
                    content: page.content,
                });
                this.success = "Updated successfully";
            }catch (error) {
                if(error.response.status === 422){
                    this.errors.value = error.response.data.errors;
                }
            }
        }
    }

});