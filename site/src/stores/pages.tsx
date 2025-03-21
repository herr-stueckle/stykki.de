import { defineStore } from "pinia";

interface Page {
  title: string;
  title_en: string; 
  content: string;
  content_en: string;
}

interface Pages {
  pages: Page[];
}

export const usePages = defineStore("pages", {
  state: () => ({
    pageList: [] as Page[],
  }),
  actions: {
    init(pros: Pages) {
     this.pageList = JSON.parse(JSON.stringify(pros));
    },
    getPage(title: string): Page | null {
      
      const page = this.pageList.find((page) => page.title === title);
      return page || null;
    },
  },
});