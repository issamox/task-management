<template>
  <div class="project-container">
      <div class="container">
          <div class="row">
              <div class="col-sm-7">
                  <div class="row">
                      <div class="col-sm-12"><h2 class="my-4">{{ project.title }}</h2></div>
                      <div class="col-sm-4" v-for="task in tasks" :key="task.id">
                          <div class="task-container my-2" :class="{ 'completed' : task.isCompleted }">
                              <div class="title">{{ task.title }}</div>
                              <hr>
                              <div class="assign_to"> Assigned to : {{ task.assigned.name }} </div>
                              <button v-if="currentUser.id === task.user_id || currentUser.id === task.assign_to"   :class="[task.isCompleted ? 'btn-success' : 'btn-danger',]" class="btn w-100 mt-auto action-btn" @click="toggleStatus(task.id)">
                                   {{ task.isCompleted ? 'Mark as not completed' : 'Mark as completed' }}
                              </button>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="col-sm-5">
                  <a href="#" class="add-new-task my-4 mx-2 text-end" @click="showForm=true">Add new task</a>
                  <div v-if="showForm">
                      <input  v-model="form.title" type="text" class="form-control mb-2" placeholder="Enter the task name" required>
                      <select class="form-control my-2" v-model="form.assign_to">
                          <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
                      </select>
                      <button class="btn btn-primary w-100" @click="createTask">Save</button>
                  </div>
                  <hr>
                  <div class="d-flex justify-content-between align-items-center">
                      <div>Sort by task status :</div>
                      <button class="btn btn-success" @click="sortByStatus(true)">Get completed first</button>
                      <button class="btn btn-danger" @click="sortByStatus(false)">Get uncompleted first</button>
                  </div>
              </div>
          </div>
      </div>
  </div>
</template>
<script>
import {reactive, ref} from 'vue';
import {onMounted} from "vue";
import swal from "sweetalert2";

export default {
    props: {
        id: {
            required: true,
            type: String
        }
    },

    setup(props){
        const form = reactive({
            'title': '',
            'assign_to': '',
            'project_id' : props.id
        });
        const errors   = ref('');
        const project  = ref('');
        const users    = ref('');
        const showForm = ref(false);
        const currentUser = ref('');
        const tasks      = ref();
        const getProjectTask = async () => {
            axios.defaults.headers.common['Authorization'] = "Bearer" + localStorage.getItem('userToken');
            const response = await axios.get('/api/project/'+props.id);
            project.value = response.data.project;
            tasks.value  = project.value.tasks;
        }
        const getAllUsers = async () => {
            axios.defaults.headers.common['Authorization'] = "Bearer" + localStorage.getItem('userToken');
            const response = await axios.get('/api/users/');
            users.value = response.data.users;
        }

        const createTask = async () => {
            if ( form.title ){
                errors.value = ''
                try {
                    axios.defaults.headers.common['Authorization'] = "Bearer" + localStorage.getItem('userToken');
                    const task =  await axios.post('/api/task',form);
                    swal.fire('Good job!',task.data.message, 'success')
                     await getProjectTask();
                } catch (e) {
                    if (e.response.status === 422) {
                        errors.value = e.response.data.message;
                        swal.fire('Oops...',errors.value, 'error')
                    }
                }
            }
        }

        const toggleStatus = async (id) => {
            try {
                axios.defaults.headers.common['Authorization'] = "Bearer" + localStorage.getItem('userToken');
                const task =  await axios.post('/api/task/'+id+'/updateStatus');
                swal.fire('Good job!',task.data.message, 'success');
                await getProjectTask();
            } catch (e) {
                if (e.response.status === 422) {
                    errors.value = e.response.data.message;
                    swal.fire('Oops...',errors.value, 'error')
                }
            }
        };

        const getLoggedUser = async (id) => {
            axios.defaults.headers.common['Authorization'] = "Bearer" + localStorage.getItem('userToken');
            const response = await axios.get('/api/loggedUser/');
            currentUser.value = response.data.user;
        }

        const sortByStatus = async (status) =>{
          if (status){
              tasks.value.sort((a, b) => (b.isCompleted - a.isCompleted));
          }else {
              tasks.value.sort((a, b) => (a.isCompleted - b.isCompleted));
          }

        }


        onMounted(() => {
            getProjectTask();
            getAllUsers();
            getLoggedUser();
        });

        return{
            errors,
            project,
            showForm,
            form,
            users,
            currentUser,
            tasks,
            getProjectTask,
            createTask,
            getAllUsers,
            toggleStatus,
            getLoggedUser,
            sortByStatus
        }
    }
}
</script>
<style scoped>
.add-new-task{
    font-weight: bold;
    font-size: 20px;
    display: block;
}
.task-container {
    background: #1a202c;
    color: #FFF;
    border-bottom: 8px solid crimson;
    padding: 15px;
    height: 200px;
    display: flex;
    flex-direction: column;

}
.task-container.completed{
    border-bottom: 8px solid green;
}
.task-container .title{
    font-size: 20px;
}
.task-container hr{
    margin: .5rem 0;
}
.task-container .assign_to{
    font-size: 12px;
}

</style>
