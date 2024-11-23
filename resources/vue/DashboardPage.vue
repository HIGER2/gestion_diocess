
<script setup>

import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddDioceseComponent from './components/AddDioceseComponent.vue';
import { onMounted, ref } from 'vue';
const isModalOpen = ref(false)
const analytic_data =ref("")
const analytic = async () => {
    axios.get('/analytic')
    .then(response => {

        analytic_data.value =response?.data?.data
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
};
onMounted(() => {
    analytic()
});
</script>

<template>
    <div>
        <app-layout>
            <div class="w-full items-center justify-center flex">
                <div class="w-[900px]">
                    <h1 class="uppercase text-[16px] font-[800]">Tableau de bord</h1>
                    <div class="  flex items-center justify-center bg-white rounded-md my-auto p-5 mt-10">
                        <a style="width: calc(100% / 3 - 10px);" href="/diocese-manager" class=" bg-gray-100 h-[200px] flex flex-col items-center justify-center gap-3 p-2 cursor-pointer min-h-[100px] rounded-xl m-[5px]">
                            <div class="w-[80px] h-[80px] bg-yellow-100 items-center justify-center flex rounded-md">
                                <i class="fi fi-bs-church text-[20px] text-yellow-600"></i>
                            </div>
                            <div class="flex flex-col items-center justify-center">
                                <h2>Total diocèse</h2>
                                <h1 class="text-[30px] font-[600]">{{ analytic_data?.dio_count }}</h1>
                            </div>
                        </a>
                        <a style="width: calc(100% / 3 - 10px);" href="/prete-manager" class="h-[200px] bg-gray-100 flex flex-col items-center justify-center gap-3 p-2 cursor-pointer min-h-[100px]  rounded-xl m-[5px]">
                            <div class="w-[80px] h-[80px] bg-green-100 rounded-md items-center justify-center flex">
                                <i class="fi fi-rr-users-alt text-[20px] text-green-600"></i>
                            </div>
                            <div class="flex flex-col items-center justify-center">
                                <h2>Total prêtres</h2>
                                <h1 class="text-[30px] font-[600]">{{ analytic_data?.prete_count }}</h1>
                            </div>
                        </a>
                        <a style="width: calc(100% / 3 - 10px);" href="/utilisateur-manager" class="h-[200px] bg-gray-100 flex flex-col items-center justify-center gap-3 p-2 cursor-pointer min-h-[100px] rounded-xl m-[5px]">
                            <div class="w-[80px] h-[80px] bg-blue-100 rounded-md items-center justify-center  flex">
                                <i class="fi fi-rr-users-alt text-[20px] text-blue-600"></i>
                            </div>
                            <div class="flex flex-col items-center justify-center">
                                <h2>Total utilisateur</h2>
                                <h1 class="text-[30px] font-[600]">{{ analytic_data?.user_count }}</h1>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </app-layout>
    </div>
</template>

<!--
<style lang="scss" scoped>

</style> -->
