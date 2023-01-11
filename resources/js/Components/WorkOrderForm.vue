<template>
    <form class="space-y-5 w-full" enctype="multipart/form-data" @submit.prevent="submitWorkOrderForm">
        <div class="lg:flex">
            <div class="w-full lg:w-3/5 space-y-3 p-2">
                <img :src="formPhotoPreview" class="border mx-auto w-2/3 border-none rounded-xl" alt="photo" v-if="formPhotoPreview">
                <img :src="workOrderForm.image_path" class="border mx-auto w-2/3 border-none rounded-xl" alt="photo"
                     v-else-if="workOrderForm.image_path !== null">
                <div class="w-full flex">
                    <input class="mx-auto" type="file" ref="formPhotoUploadField" @change="updatePhotoPreview">
                    <div v-if="formPhotoPreview !== null || workOrderForm.image_path !== null"
                         @click="workOrderForm.image_path = null; formPhotoPreview = null"
                         class="border border-red-600 rounded-xl py-1 px-3 cursor-pointer bg-white text-red-600 hover:text-white hover:bg-red-600">
                        Remove
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-2/5 flex p-2">
                <div class="w-full m-auto space-y-3">
                    <h1 class="text-gray-700">Title :</h1>
                    <input v-model="workOrderForm.title" class="w-full border-gray-400 border rounded-xl" type="text">
                </div>
            </div>
        </div>
        <h1 class="text-gray-700">Description :</h1>
        <textarea v-model="workOrderForm.description" class="w-full border-gray-400 border rounded-xl"></textarea>
        <div class="flex space-x-5">
            <PrimaryButton>{{workOrderForm.id ? 'Update' : 'Create'}}</PrimaryButton>
            <SecondaryButton v-if="workOrderForm.id" @click="destroyWorkOrder(workOrderForm.id)">Delete</SecondaryButton>
        </div>
    </form>
</template>

<script>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {Inertia} from "@inertiajs/inertia";
import SecondaryButton from "@/Components/SecondaryButton.vue";


export default {
    name: "WorkOrderForm",
    components: {SecondaryButton, PrimaryButton},
    props:{
        workOrder: Boolean|Object
    },
    data(){
      return{
          formPhotoPreview: null,
          workOrderForm:{
              id: this.workOrder.id || null,
              title: this.workOrder.title || '',
              description: this.workOrder.description || '',
              image_path: this.workOrder.image_path || null
          }
      }
    },
    methods:{
        updatePhotoPreview(){
            const reader = new FileReader();

            reader.onload = (e) => {
                this.formPhotoPreview = e.target.result;
            };

            this.workOrderForm.image_path = this.$refs.formPhotoUploadField.files[0];
            reader.readAsDataURL(this.$refs.formPhotoUploadField.files[0]);
        },
        submitWorkOrderForm(){
            if(this.workOrderForm.id !== null){
                Inertia.put(route('workorder.update', this.workOrderForm.id), this.workOrderForm, {
                    preserveState: false
                })
            }else{
                Inertia.post(route('workorder.store'), this.workOrderForm, {
                    preserveState: false
                })
            }
        },
        destroyWorkOrder(id){
            Inertia.delete(route('workorder.destroy', id), {
                preserveState: false
            })
        }
    }
}
</script>

