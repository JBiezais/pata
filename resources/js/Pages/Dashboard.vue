<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h1 class="text-2xl text-gray-700 font-bold">WorkOrder</h1>
                        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-3 border border-green-700 rounded-xl p-3 w-full">
                            <div class="border border-green-700 rounded-xl p-3 space-y-5 cursor-pointer" v-for="workOrder in workOrders" @click="activeWorkOrder = workOrder">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed z-10 top-0 h-screen" v-if="activeWorkOrder">
            <div class="w-screen h-screen flex bg-gray-900 opacity-60 relative" @click="activeWorkOrder = false">
            </div>
            <div class="absolute inset-y-1/8 md:inset-1/4 h-3/4 md:h-1/2 w-full md:w-1/2 rounded-xl bg-gray-200 p-10 flex overflow-hidden overflow-scroll">
                <WorkOrderForm :workOrder="activeWorkOrder"></WorkOrderForm>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import WorkOrderForm from "@/Components/WorkOrderForm.vue";

export default {
    components:{
        WorkOrderForm,
        AuthenticatedLayout, Head
    },
    props:{
        workOrders: Array,
        users: Array
    },
    data(){
        return{
            activeWorkOrder: false
        }
    }
}

</script>
