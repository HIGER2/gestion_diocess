
<script setup>

</script>

<template>
        <div class="bg-white p-4 rounded-lg shadow-lg max-w-lg w-[400px]" @click.stop>
                <h2 class="text-xl font-semibold mb-3">Ajouter une diocèse</h2>
                <div class=" my-2">
                    <div class="w-full max-w-sm mb-2">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                           Ajouter une image
                        </label>
                        <input
                            type="file"
                            id="diocese"
                            accept="image/*"
                            placeholder="Entrez le nom de la diocèse"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                        />
                    </div>
                    <div class="w-full max-w-sm mb-2">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Nom de la diocèse
                        </label>
                        <input
                            type="text"
                            id="diocese"
                            placeholder="Entrez le nom de la diocèse"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                        />
                    </div>
                    <div class="w-full max-w-sm mb-2">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Abreviation de la diocèse
                        </label>
                        <input
                            type="text"
                            id="diocese"
                            placeholder="Entrez l'abreviation de la diocèse"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                        />
                    </div>
                    <div class="w-full max-w-sm mb-2">
                        <label for="diocese" class="block text-[13px] font-medium text-gray-700 mb-2">
                            Ville ou emplacement
                        </label>
                        <input
                            type="text"
                            id="diocese"
                            placeholder="Entrez la  Ville ou emplacement de la diocèse"
                            class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500"
                        />
                    </div>
                </div>
                <button class="mt-6 bg-blue-950 w-full text-white py-2 px-4 rounded-md ">Enregistrer</button>
        </div>
</template>


<style lang="scss" scoped>

</style>