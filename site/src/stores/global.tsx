import { defineStore } from "pinia";

export const useGlobalStore = defineStore("global", {
  state: () => {
    return { 
      menuIsActive: false,
      subMenuIsActive: false,
      projectViewIsActive: false,
      breadCrumb: '',
      currentPage: ''
    };
  },
  actions: {
    toggle() {
      this.menuIsActive = !this.menuIsActive
    },
    setActive(){
      this.menuIsActive = true
    },
    setInActive(){
      this.menuIsActive = false
      this.subMenuIsActive = true
    }
  },
});
