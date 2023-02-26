<template>
  <div class="container">
      <div class="row mt-3">
          <div class="col-md-8">
              <div class="row">
                  <div class="col-sm-4" v-for="project in projects" :key="project.id">
                      <div class="project-container my-2 mx-3" >{{ project.title }}</div>
                  </div>
              </div>
          </div>
          <div class="col-sm-4">
              <a href="#" class="add-new-project mb-2 mx-2 text-end" @click="showInput=true">Add new project</a>
              <div v-if="showInput">
                  <input  v-model="form.title" type="text" class="form-control mb-2" placeholder="Enter the project name" required>
                  <textarea v-model="form.description" class="form-control mb-2"></textarea>
                  <button class="btn btn-primary" @click="addNewProject">Save</button>
              </div>
          </div>
      </div>
  </div>
</template>

<script>
import {reactive, ref} from "vue";
import { onMounted } from "vue";

import swal from 'sweetalert2';

//import useProjects from "../composables/project";
export default {
    setup() {
        const form = reactive({
            'title': '',
            'description': '',
        });
        const errors   = ref('');
        const projects = ref([]);
        const showInput = ref(false);

        const addNewProject = async () => {
            if ( form.title ){
              errors.value = ''
              try {
                  axios.defaults.headers.common['Authorization'] = "Bearer" + localStorage.getItem('userToken');
                  const project =  await axios.post('/api/project',form);
                  swal.fire('Good job!',project.data.message, 'success')
                  form.title = '';
                  form.description = '';
                  await getAllProjects();
              } catch (e) {
                  if (e.response.status === 422) {
                      errors.value = e.response.data.message;
                      swal.fire('Oops...',errors.value, 'error')
                  }
              }
          }
        };
        const getAllProjects = async () => {
            axios.defaults.headers.common['Authorization'] = "Bearer" + localStorage.getItem('userToken');
            let response = await axios.get('/api/project');
            projects.value = response.data.projects;
        };

        onMounted(getAllProjects)

        return {
            form,
            showInput,
            addNewProject,
            getAllProjects,
            projects,
        }
    }
}
</script>
<style scoped>
.project-container {
    padding: 8px 15px;
    background-color: #4a5568;
    color: #FFF;
    font-size: 20px;
    font-weight: bold;
    width: 100%;
    height: 120px;
    background-image: url("https://trello-backgrounds.s3.amazonaws.com/SharedBackground/768x960/d2ca6722a7326ee167ceb8e3c79e01d6/photo-1677029907981-e9a44fb7409a.jpg");
    background-size: cover;
    background-position: center center;
    cursor: pointer;
    margin-right: 20px;
}
.add-new-project{
    font-weight: bold;
    font-size: 25px;
    display: block;
}
</style>
