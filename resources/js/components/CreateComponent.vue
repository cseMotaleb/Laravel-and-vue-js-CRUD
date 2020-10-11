<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Create New Student</div>
                    <div class="card-body">
                        <form  method="post">
                             <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" v-model="name" class="form-control" id="name" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" v-model="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>

                             <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="number" v-model="phone" class="form-control" id="phone" placeholder="Enter Phone">
                            </div>
                            <button type="submit" @click.prevent="saveStudent" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
              <div class="col-md-6">
                <div class="card">
                    <div class="card-header">All Student</div>

                    <div class="card-body">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                <th scope="col">Sl</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for= "(student,index) in students.data" :key="student.id">
                                    <th scope="row">{{index + 1 }}</th>
                                    <td>{{student.name}}</td>
                                    <td>{{student.email}}</td>
                                    <td>@{{student.phone}}</td>
                                    <td>
                                <!-- Button trigger modal -->
                                <button type="button" @click = "editStudent(student.id)"  data-toggle="modal" data-target="#exampleModalLong">
                                <i class="fa fa-pencil-square-o"></i>
                                </button>
                                <button type="button" @click= "deleteStudent(student.id)">
                                <i class="fa fa-trash"></i>
                                </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <pagination :data="students" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                          <form  method="post">
                             <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" v-model="editname" class="form-control" id="name" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" v-model="editemail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">

                            </div>

                             <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="number" v-model="editphone" class="form-control" id="phone" placeholder="Enter Phone">
                            </div>

                            <button type="submit" @click.prevent="updateStudent" data-dismiss="modal" class="btn btn-success">Update</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>

                    </div>
                    </div>
                </div>
             </div><!-- Modal -->

        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                students: {},
                students_edit:{},
                id: '',
                name: '',
                email: '',
                phone: '',
                editname: '',
                editemail: '',
                editphone: ''

            }
        },

        mounted() {
            console.log('Component mounted.')
            this.getResults();
        },

        methods: {
            saveStudent(){
                axios.post('save-student',{
                   name: this.name,
                   email: this.email,
                   phone: this.phone
              })
                .then(response => {
                   location.reload();
                   console.log(response)
                })
                .catch(error=>{
                    if(error.response.status==422){
                        this.errors = error.response.data.errors
                    }
                })

            },


            getResults(page = 1) {
            axios.get('all-students?page=' + page)
				.then(response => {
                    console.log(response.data);
					this.students = response.data;
				});
            },
            editStudent(id){
                axios.get('edit-students/'+id)
                .then(response => {
                    console.log(response.data);
                    this.id = response.data.id
                    this.editname = response.data.name;
                    this.editemail = response.data.email;
                    this.editphone = response.data.phone;
                });
            },
            updateStudent(){
                axios.put('update-student', {
                    id    : this.id,
                    name  : this.editname,
                    email : this.editemail,
                    phone : this.editphone,
                })
                .then(response => {
                    this.getResults();
                })
                .catch(error=>{
                    if(error.response.status==422){
                        this.errors = error.response.data.errors
                    }
                })
            },

            deleteStudent(id,index){
                axios.get('delete-student/'+id)
                .then(response=> {
                    this.getResults();
                    this.student.splice(index,1)})
            },


        }
    }
</script>
<style>

    button {
        background: none;
        border: none;
        float: left;
        padding: 4px;
    }

    i.fa.fa-pencil-square-o {
        color: green;
    }

</style>
