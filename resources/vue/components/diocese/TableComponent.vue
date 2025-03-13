
<script setup>
const {dioceses } = defineProps(['dioceses' ]);

</script>

<template>
    <table class="min-w-full bg-white  rounded-lg">
        <thead>
            <tr class="bg-custom text-gray-600 capitalize text-[11px] leading-normal">
                <th class="p-3 py-4 text-left">Image</th>
                <th class="p-3 py-4 text-left">Nom</th>
                <th class="p-3 py-4 text-left">Emplecement</th>
                <th class="p-3 text-left">Abreviation </th>
                <th class="p-3 text-left">Action </th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-[12px] font-light ">
            <tr v-for="(item,index) in dioceses?.data" :key="index" class=" border-b cursor-pointer hover:bg-zinc-50 ">
                <td class="p-3 py-4 ">
                    <div class="w-[60px] h-[60px] rounded overflow-hidden">
                        <img class="w-full h-full object-cover" :src="`${item?.url_image ?  '/storage/'+item?.url_image :  'https://cdn.pixabay.com/photo/2016/11/18/22/37/cathedral-1837206_1280.jpg'} `" alt="">
                    </div>
                </td>
                <td class="p-3 py-4 ">{{ item?.diocese }}</td>
                <td class="p-3 py-4 ">{{ item?.emplacement }}</td>
                <td class="p-3 py-4 ">{{ item?.abreviation || 'N/A' }}</td>
                <td class="p-3 py-4   text-zinc-900">
                    <a :href="`/diocese-manager/${item?.id}`" class="max-w-max block bg-custom px-4 hover:bg-zinc-200 rounded-md py-2">
                        <i class="uil uil-info-circle"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</template>


