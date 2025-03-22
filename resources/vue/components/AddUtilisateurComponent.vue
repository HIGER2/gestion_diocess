
<script setup>
import { computed, inject, onMounted, reactive, ref } from 'vue';
const { dioceses, callback, detail } = defineProps([ 'dioceses', 'callback', 'detail' ]);
import {useToast} from 'vue-toast-notification';
import ButtonLoader from './ButtonLoader.vue';
const auth = computed(()=>inject('user'))

const user = reactive({
    nom:"",
    prenoms:"",
    role:"",
    phone:"",
    email:"",
    password:"",
    diocese_id:"",
});
const pass = ref(false);
const isLoading =ref(false);

const errrMessage =ref('')

const createUser =async (data) => {

    errrMessage.value = ""
    isLoading.value = true

    await axios.post('/user',data)
        .then(async response => {

            if (callback) {
                await callback()
            }
            const $toast = useToast();

            $toast.success('Opération effectuée avec succès');
        // if (response.data.redirect) {
        //     window.location.href = response.data.redirect;
        // }
    })
        .catch(error => {
            if (error.response.data?.errors) {
            errrMessage.value = error.response.data?.errors
            }
        if (error.response.data?.message) {
            errrMessage.value = error.response.data?.message.split('.')[ 0 ]
        }

        console.error('Error fetching user data:', error.response.data?.errors);
        });

    isLoading.value = false

};

onMounted(() => {
    if (detail) {
        Object.assign(user,detail)
    }
});

</script>

<template>
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg w-[400px]" @click.stop>
            <h2 class="text-xl font-semibold text-zinc-900 mb-3">{{user?.id ? 'Modifier un utilisateur' : 'Ajouter un utilisateur'}}</h2>
                <div v-if="errrMessage" class="p-4 w-full bg-red-100 text-[12px] rounded-md text-red-800">
                    {{ errrMessage }}
            </div>
            <form action="" @submit.prevent="createUser(user)">
            <div class=" my-2">
                <div class="flex items-center justify-between gap-2">
                    <div class="w-full max-w-sm mb-3">
                        <label for="" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Nom
                        </label>
                        <input
                            v-model="user.nom"
                            type="text"
                            required
                            placeholder="Nom"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                    <div class="w-full max-w-sm mb-3">
                        <label for="" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Prénoms
                        </label>
                        <input
                            v-model="user.prenoms"
                            type="text"
                            required
                            placeholder="Prenoms"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <div class="w-full max-w-sm mb-3">
                        <label for="" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Téléphone
                        </label>
                        <input
                            v-model="user.phone"
                            type="text"
                            required
                            placeholder="Téléphone"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                    <div class="w-full max-w-sm mb-3">
                        <label for="" class="block text-[13px] font-medium text-gray-700 mb-2">
                            email
                        </label>
                        <input
                            v-model="user.email"
                            type="text"
                            placeholder="email"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                        />
                    </div>
                </div>

                <template v-if="auth.role =='super_admin'">
                    <div class="w-full  mb-3"  >
                        <label for="" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Selectionner le rôle
                        </label>
                        <select required v-model="user.role" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary ">
                            <option value="" class="cursor-pointer" disabled>Selectionner le rôle</option>
                            <option  value="super_admin"  class="cursor-pointer">Super administratreur</option>
                            <option  value="admin" class="cursor-pointer"> Administratreur</option>
                            <option value="modérateur" class="cursor-pointer"> Modérateur</option>
                        </select>
                    </div>
                      <div class="w-full  mb-3" >
                        <label for="" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Assingner à un diocèse
                        </label>
                        <select required v-model="user.diocese_id" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary  ">
                            <option value="" class="cursor-pointer" disabled>Selectionner une diocèse</option>
                            <option :value="item?.id" v-for="(item, index) in dioceses" :key="index">{{ item?.diocese }}</option>
                        </select>
                    </div>
                </template>

                <div class="" v-if="auth?.id!=user?.id">
                <div class="w-full  mb-3">
                    <label for="" class="block text-[13px] font-medium text-gray-700 mb-2">
                    {{ user?.id ? 'Modifier le mot de passe temporaire (falcutatif)' : 'Définir un mot de passe temporaire' }}
                    </label>
                    <input
                        v-model="user.password"
                        :type="pass ? 'text': 'password'"
                        :required="!user?.id"
                        placeholder="mot de passe temporaire"
                        class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary "
                    />
                </div>
                <div class="flex items-center gap-1">
                    <input type="checkbox" v-model="pass"  id="show">
                    <label for="show"> afficher le mot de passe</label>
                </div>
                </div>
            </div>
            <button class="mt-6 bg-primary w-full flex items-center justify-center text-white py-2 px-4 rounded-md ">
                <ButtonLoader title="Enregistrer" :isLoading="isLoading" />
            </button>
            </form>
        </div>
</template>


<style lang="scss" scoped>

</style>
