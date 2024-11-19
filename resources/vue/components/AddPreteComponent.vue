
<script setup>
import { onMounted, ref } from 'vue';
const { dioceses } = defineProps([ 'dioceses' ]);

</script>

<template>
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-[460px]" @click.stop>
                <h2 class="text-xl font-semibold mb-3">Ajouter un prete</h2>
                <div class=" my-2">
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Nom
                            </label>
                            <input
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
                                type="text"
                                id="diocese"
                                placeholder="Prenoms"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                    </div>
                    <div class="w-full  mb-2">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Selectionner une diocèse
                        </label>
                        <select name="" id=""  class="cursor-pointer block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500">
                            <option value="" class="cursor-pointer" disabled>Selectionner une diocèse</option>
                            <option :value="item?.id" v-for="(item, index) in dioceses" :key="index">{{ item?.diocese }}</option>
                        </select>
                    </div>
                  
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Téléphone 
                            </label>
                            <input
                                type="text"
                                id="diocese"
                                placeholder="Téléphone"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                               Email
                            </label>
                            <input
                                type="text"
                                id="diocese"
                                placeholder="Email"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Lieu de naissance 
                            </label>
                            <input
                                type="text"
                                id="diocese"
                                placeholder="Lieu de naissance"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Date de Naissance
                            </label>
                            <input
                                type="text"
                                id="diocese"
                                placeholder=" Date de Naissance"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                    </div>

                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Date ordination sacerdotale
                            </label>
                            <input
                                type="date"
                                id="diocese"
                                placeholder="Date ordination sacerdotale"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Lieu ordination sacerdotale
                            </label>
                            <input
                                type="text"
                                id="diocese"
                                placeholder="Lieu ordination sacerdotale"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                    </div>
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Diplome etude ecclesiastique
                            </label>
                            <input
                                type="text"
                                id="diocese"
                                placeholder="Diplome etude ecclesiastique"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                        <div class="w-full max-w-sm mb-2">
                            <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                                Diplome etude profane
                            </label>
                            <input
                                type="text"
                                id="diocese"
                                placeholder="Diplome etude profane"
                                class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                            />
                        </div>
                    </div>
                    
                    
                </div>
                <button class="mt-6 bg-blue-950 w-full text-white py-2 px-4 rounded-md ">Enregistrer</button>
        </div>
</template>


<style lang="scss" scoped>

</style>