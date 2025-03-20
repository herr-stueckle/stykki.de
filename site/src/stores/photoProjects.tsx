import { defineStore } from "pinia";

interface Image {
  id: number;
  name: string; // Ensure this aligns with the actual structure of your images
}

interface Project {
  id: number;
  name: string;
  name_en: string;
  pro_ratio: string;
  camera: string;
  year: number;
  description: string;
  description_en: string;
  images: Image[];
}

interface ProjItem {
  pro_id: number;
  pro_name: string;
  pro_name_en: string;
  pro_ratio: string;
  pro_camera: string;
  pro_year: number;
  pro_description: string;
  images: Image[];
}

export const usePhotoProjects = defineStore("photoProjects", {
  state: () => ({
    projectList: [] as Project[],
    currentProject: 0,
    currentSlide:-1
  }),
  actions: {
    init(pros: ProjItem[]) {
      // Clear existing projects to avoid duplication
      this.projectList = pros.map(proItem => {
        // Validate proItem properties
        return {
          id: proItem.pro_id,
          name: proItem.pro_name,
          name_en: proItem.pro_name_en,
          pro_ratio: proItem.pro_ratio,
          camera: proItem.pro_camera,
          year: proItem.pro_year,
          description: proItem.pro_description,
          description_en: proItem.pro_description,
          images: proItem.images
        } as Project;
      });
    },
    setCurrentProject(index: number) {
      if (index >= 0 && index < this.projectList.length) {
        this.currentProject = index;
      } else {
        console.error("Invalid project index:", index);
      }
    },
    getCurrentProject(): Project | null {
      return this.projectList[this.currentProject] || null;
    },
    getCurrentSlide(): number | null {
      return this.currentSlide;
    },
  },
});