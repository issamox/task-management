<template>
  <div class="container">
      <div class="row mt-3">
          <div class="col-md-8">
              <div class="row">
                  <div class="col-sm-4" v-for="project in projects.data" :key="project.id">
                      <div class="project-container position-relative my-2 mx-3">
                        <router-link :to="{ name: 'project.show', params: { id: project.id } }" class="h-100">
                          <div class="d-flex flex-column align-content-between h-100">
                              <div class="title">{{ project.title }}</div>
                              <button type="button" class="btn btn-primary position-relative mt-auto me-auto">
                                  Tasks
                                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ project.tasks.length }}</span>
                              </button>
                          </div>
                        </router-link>
                        <div class="btn-edit" @click="editProject(project.id)"><img src="/assets/icons/edit.svg" alt=""></div>
                        <div class="btn-delete" @click="deleteProject(project.id)"><img src="/assets/icons/trash.svg" alt=""></div>
                      </div>
                  </div>
                  <hr>
                  <div class='text-center'>
                      <Pagination class="d-inline-flex" :data="projects" @pagination-change-page="getAllProjects" />
                  </div>

              </div>
          </div>
          <div class="col-sm-4">
              <a href="#" class="add-new-project mb-2 mx-2 text-end" @click="showForm=true">Add new project</a>
              <div v-if="showForm">
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
        const errors       = ref('');
        const projects     = ref([]);
        const showForm     = ref(false);
        const showEditForm = ref(false);

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
        const getAllProjects = async (page) => {
            axios.defaults.headers.common['Authorization'] = "Bearer" + localStorage.getItem('userToken');
            let response = await axios.get('/api/project?page=' + page);
            projects.value = response.data.projects;
        };

        const editProject = async (id) => {
            swal.fire({
                title: 'Enter the new name',
                input: 'text',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: 'Update',
                showLoaderOnConfirm: true,
                preConfirm: (name) => {
                    return axios.put('/api/project/'+id, { title : name })
                        .then(response => {
                            getAllProjects();
                        })
                        .catch(error => {
                            swal.showValidationMessage(`Request failed: ${error}`);
                        })
                },
                allowOutsideClick: () => !swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    swal.fire('Title','Project updated successfully','success')
                }
            })
        }
        const deleteProject = async (id) => {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/project/'+id).then(respnose => {
                        if (respnose.data.status == 'success') {
                            swal.fire('Deleted!', respnose.data.message, 'success');
                            getAllProjects();
                        }
                    });
                }
            })
        };

        onMounted(getAllProjects)

        return {
            form,
            showForm,
            addNewProject,
            getAllProjects,
            editProject,
            deleteProject,
            projects,
        }
    }
}
</script>
<style scoped>
.project-container {
    padding: 8px 15px;
    background-color: #4a5568;
    width: 100%;
    height: 160px;
    background-image: url("https://trello-backgrounds.s3.amazonaws.com/SharedBackground/768x960/d2ca6722a7326ee167ceb8e3c79e01d6/photo-1677029907981-e9a44fb7409a.jpg");
    background-size: cover;
    background-position: center center;
    cursor: pointer;
    margin-right: 20px;
}
.project-container .title{
    color: #FFF;
    font-size: 20px;
    font-weight: bold;
}
.add-new-project{
    font-weight: bold;
    font-size: 20px;
    display: block;
}
.project-container .btn-edit,
.project-container .btn-delete{
    position: absolute;
    background-color: #FFF;
    padding: 6px;
    width: 40px;

}
.project-container .btn-edit{
    top: 0;
    right: 0;
}
.project-container .btn-delete{
    top: 30px;
    right: 0;
    background-color: red;
}

.project-container .btn-edit img,
.project-container .btn-delete img{
    height: 20px;
    display: block;
    margin: auto;
}
</style>
