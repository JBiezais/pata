<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="text-2xl text-gray-700 font-bold">WorkOrder</h1>
                        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-3 border border-green-700 rounded-xl p-3 w-full">
                            <div class="border border-green-700 rounded-xl p-3 space-y-5 cursor-pointer" v-for="workOrder in workOrders.work_orders" @click="activeWorkOrder = workOrder">
                                <img v-if="workOrder.image_path" class="rounded-xl h-56 w-auto max-w-full mx-auto" :src="workOrder.image_path" :alt="workOrder.title">
                                <h1 class="text-center font-semibold italic text-xl">{{workOrder.title}}</h1>
                                <p>{{workOrder.description}}</p>
                            </div>
                            <div class="border border-gray-700 rounded-xl p-3 space-y-5 flex flex-col bg-gray-100 cursor-pointer" @click="activeWorkOrder = true">
                                <div class="m-auto">
                                    <div class="border border-gray-700 rounded-full p-4 h-16 w-16 mx-auto">
                                        <h1 class=" text-3xl font-semibold mx-auto text-center">+</h1>
                                    </div>
                                    <h1 class="text-xl font-semibold">Create new</h1>
                                </div>
                            </div>
                            <div class="md:col-span-2 xl:col-span-3 space-x-5 flex w-full" v-if="workOrders.work_orders.length">
                                <div class="flex mx-auto">
                                    <img v-if="Number(workOrdersOffset) > 0" class="h-8 cursor-pointer trasnform rotate-180" src="/image/img.png" alt="back" @click="getProps('workOrder',Number(workOrdersOffset)-10)">
                                    <h1 class="my-auto">{{Number(workOrdersOffset)+1}} - {{Number(workOrdersOffset) + workOrders.work_orders.length}}</h1>
                                    <img class="h-8 cursor-pointer" src="/image/img.png" alt="forward" @click="getProps('workOrder', Number(workOrdersOffset)+10)">
                                </div>
                            </div>
                        </div>
                        <h1 class="text-2xl text-gray-700 font-bold">Users</h1>
                        <div class="border border-green-700 rounded-xl p-3 w-full">
                            <div class="border-b border-green-700 py-2 px-5 bg-gray-100 rounded-t-xl grid grid-cols-3">
                                <h1>Name, Last name</h1>
                                <h1 class="hidden md:block">Email</h1>
                            </div>
                            <div v-for="user in users">
                                <div class="grid grid-cols-3 border-b border-green-700 py-2 px-5" v-if="user.id !== $page.props.auth.user.id">
                                    <h1 class="my-auto">{{user.name}}, {{user.lastName}}</h1>
                                    <h1 class="my-auto hidden md:block">{{user.email}}</h1>
                                    <div class="flex space-x-4">
                                        <div class="flex-grow"></div>
                                        <h1 class="border border-red-600 rounded-xl py-1 px-3 cursor-pointer bg-white text-red-600 hover:text-white hover:bg-red-600" @click="deleteUser(user.id)">Delete</h1>
                                        <h1 class="border border-blue-600 rounded-xl py-1 px-3 cursor-pointer bg-white text-blue-600 hover:text-white hover:bg-blue-600" @click="activeUserForm = user">Edit</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full bg-gray-100 flex rounded-b-xl py-2 cursor-pointer" @click="activeUserForm = true">
                                <h1 class="mx-auto">Create new</h1>
                            </div>
                            <div class="w-full flex rounded-b-xl py-2" v-if="users.length">
                                <div class="flex mx-auto">
                                    <img v-if="Number(usersOffset) > 0" class="h-8 cursor-pointer trasnform rotate-180" src="/image/img.png" alt="back" @click="getProps('user', Number(usersOffset)-10)">
                                    <h1 class="my-auto">{{Number(usersOffset)+1}} - {{Number(usersOffset) + users.length}}</h1>
                                    <img class="h-8 cursor-pointer" src="/image/img.png" alt="forward" @click="getProps('user', Number(usersOffset)+10)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed z-10 top-0 h-screen" v-if="activeWorkOrder || activeUserForm">
            <div class="w-screen h-screen flex bg-gray-900 opacity-60 relative" @click="activeWorkOrder = false; activeUserForm = false">
            </div>
            <div class="absolute inset-y-1/8 md:inset-1/4 h-3/4 md:h-1/2 w-full md:w-1/2 rounded-xl bg-gray-200 p-10 flex overflow-hidden overflow-scroll">
                <WorkOrderForm :workOrder="activeWorkOrder" v-if="activeWorkOrder"></WorkOrderForm>
                <div class="m-auto space-y-5" v-if="activeUserForm === true">
                    <ApplicationLogo class="mx-auto"></ApplicationLogo>
                    <CreateUserForm></CreateUserForm>
                </div>
                <div v-if="typeof(activeUserForm) === 'object'" class="m-auto">
                    <UpdateProfileInformationForm :user="activeUserForm"></UpdateProfileInformationForm>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import WorkOrderForm from "@/Components/WorkOrderForm.vue";
import {Inertia} from "@inertiajs/inertia";
import CreateUserForm from "@/Components/CreateUserForm.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";

export default {
    components:{
        UpdateProfileInformationForm,
        ApplicationLogo,
        CreateUserForm,
        WorkOrderForm,
        AuthenticatedLayout, Head
    },
    props:{
        workOrders: Array,
        users: Array,
        workOrdersOffset: Number,
        usersOffset: Number
    },
    data(){
        return{
            activeWorkOrder: false,
            activeUserForm: false,
            offset:{
                user: this.usersOffset || 0,
                workOrder: this.workOrdersOffset || 0
            }
        }
    },
    methods:{
        deleteUser(id){
            Inertia.visit('/profile', {
                method: 'delete',
                data: {id: id},
            })
        },
        getProps(key, value){
            switch (key){
                case 'user':
                    this.offset.user = value
                    break
                case 'workOrder':
                    this.offset.workOrder = value
                    break
            }

            Inertia.get(route('dashboard'), this.offset, {
                preserveState: false
            })
        }
    }
}

</script>
