<script setup>
import axios from 'axios';
import { onMounted, reactive, ref } from 'vue';
import { Form, Field } from 'vee-validate';
import * as yup from 'yup';
import { useToastr } from '../../toastr';
import { error } from 'jquery';

const toastr = useToastr();
const users = ref([]);
const editing = ref(false);
const formValues = ref({
    id: '',
    name: '',
    email: ''
});
const form = ref(null);
const schema = ref(null);
// const form = reactive({
//     name: '',
//     email: '',
//     password: ''
// });

const getUsers = () => {
    axios.get('/api/users')
        .then((response) => {
            users.value = response.data
        })
}

const createUserSchema = yup.object({
    name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().required().min(8)
});

const editUserSchema = yup.object({
    name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().when((password,schema) => {
        return password ? schema.required().min(8) : schema;
    })
});

const handleSubmit = (values) => {
    if(editing.value) {
        updateUser(values);
    } else {
        createUser(values);
    }
}

const createUser = (values , {resetForm}) => {
    axios.post('/api/users', values)
        .then((response) => {
            users.value.unshift(response.data);
            $('#userFormModal').modal('hide');
            resetForm();
            toastr.success('User Created Successfully!');
        });
}

const addUser = () => {
    editing.value = false;
    $('#userFormModal').modal('show');
    formValues.value = {
        id: '',
        name: '',
        email: '',
    };
}

const editUser = (user) => {
    editing.value = true;
    form.value.resetForm();
    $('#userFormModal').modal('show');
    formValues.value = {
        id: user.id,
        name: user.name,
        email: user.email,
    };
}

const updateUser = (values) => {
    axios.put('/api/users/' + formValues.value.id, values)
        .then((response) => {
            const index = users.value.findIndex(user => user.id === response.data.id);
            users.value[index] = response.data;
            $('#userFormModal').modal('hide');
        }).catch((error) => {
            console.log(error);
        }).finally(() => {
            form.value.resetForm();
        });
}
// const createUser = () => {
//     axios.post('/api/users', form)
//         .then((response) => {
//             users.value.unshift(response.data);
//             form.name = '',
//                 form.email = '',
//                 form.password = '',
//                 $('#userFormModal').modal('hide');
//         });
// }

onMounted(() => {
    getUsers();
});
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>


    <div class="content">
        <div class="container-fluid">
            <button type="button" @click.prevent="addUser()" class="mb-2 btn btn-primary">
                Add New User
            </button>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered Date</th>
                                <th>Role</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <a href="#" @click.prevent="editUser(user)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="userFormModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Edit User</span>
                        <span v-else>Add New User</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="editing ? editUserSchema : createUserSchema" v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <Field name="name" type="text" class="form-control" :class="{ 'is-invalid': errors.name }" :model-value="formValues.name"
                                id="name" aria-describedby="nameHelp" placeholder="Enter full name" />
                            <span class="invalid-feedback">{{ errors.name }}</span>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <Field name="email" type="email" class="form-control" :class="{ 'is-invalid': errors.email }" :model-value="formValues.email"
                                id="email" aria-describedby="nameHelp" placeholder="Enter email address" />
                            <span class="invalid-feedback">{{ errors.email }}</span>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <Field name="password" type="password" class="form-control"
                                :class="{ 'is-invalid': errors.password }" id="password" aria-describedby="nameHelp"
                                placeholder="Enter password" />
                            <span class="invalid-feedback">{{ errors.password }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <span v-if="editing">Update</span>
                            <span v-else>Save</span>
                        </button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
</template>