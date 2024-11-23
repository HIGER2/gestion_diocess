
<script setup>
import { onMounted, reactive, ref } from 'vue';
const { dioceses ,callback} = defineProps([ 'dioceses','callback' ]);
const user = reactive({
    nom:"",
    prenoms:"",
    role:"super_admin",
    phone:"",
    email:"",
    password:"",
    diocese_id:"",
});

const createUser =async (data) => {

    await axios.post('/user',data)
        .then(async response => {

            await callback()
      
        // if (response.data.redirect) {
        //     window.location.href = response.data.redirect;
        // }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
};
</script>

<template>
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-[450px]" @click.stop>
                <h2 class="text-xl font-semibold mb-3">Ajouter un utilisateur</h2>
                <form action="" @submit.prevent="createUser(user)">
                <div class=" my-2">
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Nom
                            </label>
                            <input
                                v-model="user.nom"
                                type="text"
                                id="diocese"
                                placeholder="Nom"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Prenoms
                            </label>
                            <input
                                v-model="user.prenoms"
                                type="text"
                                id="diocese"
                                placeholder="Prenoms"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Téléphone
                            </label>
                            <input
                                v-model="user.phone"
                                type="text"
                                id="diocese"
                                placeholder="Téléphone"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                email
                            </label>
                            <input
                                v-model="user.email"
                                type="text"
                                id="diocese"
                                placeholder="email"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                    </div>
                       <div class="w-full  mb-2">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Selectionner le role
                        </label>
                        <select v-model="user.role" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500">
                            <option value="super_admin" class="cursor-pointer">Super administratreur</option>
                            <option value="admin" class="cursor-pointer"> Administratreur</option>
                        </select>
                    </div>
                    <div class="w-full  mb-2">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Selectionner une diocèse
                        </label>
                        <select v-model="user.diocese_id" name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500">
                            <option value="" class="cursor-pointer" disabled>Selectionner une diocèse</option>
                            <option :value="item?.id" v-for="(item, index) in dioceses" :key="index">{{ item?.diocese }}</option>
                        </select>
                    </div>
                        <div class="w-full  mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Définir un mot de passe temporaire
                            </label>
                            <input
                                v-model="user.password"
                                type="text"
                                id="diocese"
                                placeholder="mot de passe temporaire"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                </div>
                <button  class="mt-6 bg-blue-950 w-full text-white py-2 px-4 rounded-md ">Enregistrer</button>
                </form>
        </div>
</template>


<style lang="scss" scoped>

</style>