
<script setup>
import { inject, onMounted, provide, ref } from 'vue';
import AppLayout from './layouts/AppLayout.vue';
import Modal from './components/Modal.vue';
import AddLinkComponent from './components/link/AddLinkComponent.vue';
import ContentLoading from './components/ContentLoading.vue';
import EditLinkComponent from './components/link/EditLinkComponent.vue';
import DeleteLinkComponent from './components/link/DeleteLinkComponent.vue';

const { dioceses } = defineProps([ 'dioceses' ]);
const links = ref()
const isModalOpen = ref(false)
const isLoading=ref(false)
const openModal = (state) => {
    isModalOpen.value = state
};

const hanldeliste = async () => {
    isLoading.value =true
    await axios.get('/register-links/all')
        .then(response => {

        if (response) {
            links.value = response?.data?.data
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
    isLoading.value =false
};

provide('liste_link',hanldeliste)

const user = inject('user',ref())
onMounted(async () => {
    hanldeliste()
});
</script>


<template>
    <div>
        <div class="w-full">
            <div class="flex justify-between items-center">
                <h1 class="uppercase text-[16px] font-[800]">Liens d'inscription</h1>
                <button type="button" v-if=" user?.role !=='admin'" @click="openModal(true)" class="bg-primary text-white p-2 rounded-md text-[14px] cursor-pointer">Créer un lien</button>
            </div>
            <ContentLoading v-if="isLoading"/>
            <div v-else class="w-full">
                <div class="rounded-md bg-white border min-h-[100px] mt-5">
                    <table class="min-w-full bg-white  rounded-lg">
                        <thead>
                            <tr class="bg-custom text-gray-600 capitalize text-[11px] leading-normal">
                                <th class="p-3 text-left">Lien</th>
                                <th class="p-3 text-left">Utilisateur</th>
                                <th class="p-3 text-left">diocesse</th>
                                <th class="p-3 text-left">Statut</th>
                                <th class="p-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-[12px] font-light   ">
                            <tr v-for="(item,index) in links" :key="index" class="border-b cursor-pointer hover:bg-gray-50">
                                <td class="p-3">
                                    <a :href="item?.link" target="_blank" class="hover:text-blue-500 hover:underline">
                                        {{ item?.link }}
                                    </a>
                                </td>
                                <td class="p-3 ">{{ item?.username }}</td>
                                <td class="p-3 ">{{ item?.diocese?.diocese || 'N/A' }}</td>
                                <td class="p-3 ">{{ item?.status }}</td>
                                <!-- <td class="p-3 ">{{ item?.role }}</td>
                                <td class="p-3 ">{{ item?.phone }}</td>
                                <td class="p-3 ">{{ item?.email }}</td> -->
                                <td class="p-3  flex gap-2">
                                    <EditLinkComponent  :item="item" :dioceses="JSON.parse(dioceses)"/>
                                    <template v-if=" user?.role !=='admin'" >
                                        <DeleteLinkComponent :item="item"/>
                                    </template>
                                    <!-- <a :href="`/prete-manager/${item?.id}`" class="bg-gray-100 px-3 rounded-md py-2"><i class="uil uil-ellipsis-h"></i></a> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
            </div>
        </div>
        <Modal :isActive="isModalOpen" :onClose="openModal">
            <div class=" mb-2 p-5 max-h-full">
                <AddLinkComponent :callback="hanldeliste" :dioceses="JSON.parse(dioceses)"/>
            </div>
        </Modal>
    </div>
</template>

<style lang="scss" scoped>

</style>
