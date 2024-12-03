
<script setup>
import DetailPreteComponent from './DetailPreteComponent.vue';

const { liste_Prete,dioceses } = defineProps([ 'liste_Prete','dioceses' ]);
</script>

<template>
    <table class="min-w-full bg-white  rounded-lg">
        <thead>
            <tr class="bg-gray-100 text-gray-600 capitalize text-[11px] leading-normal">
                <th class="p-3 py-4 text-left">Nom</th>
                <th class="p-3 py-4 text-left">Prénoms</th>
                <th class="p-3 text-left">Matricule</th>
                <th class="p-3 text-left">Diocèse</th>
                <!-- <th class="p-3 text-left">Date de Naissance</th> -->
                <!-- <th class="p-3 text-left">Lieu de Naissance</th> -->
                <!-- <th class="p-3 text-left">Date Ordination Sacerdotale</th> -->
                <th class="p-3 text-left">Lieu Ordination</th>
                <!-- <th class="p-3 text-left">Diplôme Ecclésiastique</th> -->
                <!-- <th class="p-3 text-left">Diplôme Profane</th> -->
                <th class="p-3 text-left">Téléphone</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-[12px] font-light ">
            <tr v-for="(item,index) in liste_Prete" :key="index" class=" border-b cursor-pointer hover:bg-zinc-50 ">
                <td class="p-3 py-4 ">{{ item?.nom }}</td>
                <td class="p-3 py-4 ">{{ item?.prenoms }}</td>
                <td class="p-3 py-4 ">{{ item?.matricule }}</td>
                <td class="p-3 py-4 ">{{ item?.diocess?.diocese }}</td>
                <!-- <td class="p-3 py-4 ">{{ formatDate(item.date_naissance) }}</td> -->
                <!-- <td class="p-3 py-4 ">{{ item.lieu_naissance }}</td> -->
                <!-- <td class="p-3 py-4 ">{{ formatDate(item.date_ordination_sacerdotale) }}</td> -->
                <td class="p-3 py-4 ">{{ item.lieu_ordination_sacerdotale }}</td>
                <!-- <td class="p-3 py-4 ">{{ item.diplome_etude_ecclesiastique }}</td> -->
                <!-- <td class="p-3 py-4 ">{{ item.diplome_etude_profane }}</td> -->
                <td class="p-3 py-4 ">{{ item.numero_telephone }}</td>
                <td class="p-3 py-4 ">{{ item.adresse_electronique }}</td>
                <td class="p-3 py-4  flex gap-2 text-zinc-900">
                    <!-- <EditPreteComponent :item="item" :dioceses="dioceses"/> -->
                    <DetailPreteComponent :item="item" />
                    <!-- <PreteDeleteComponent :item="item"/> -->
                </td>
            </tr>
        </tbody>
    </table>
</template>


