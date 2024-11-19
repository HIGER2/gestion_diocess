
<script setup>
const {isActive ,onClose} = defineProps([ 'isActive', 'onClose' ]);
</script>

<template>
  <div
        @click="onClose(false)"
                :class="['transition-opacity duration-300', isActive ? 'opacity-100' : 'opacity-0 hidden']"
                class=" transition-all cursor-pointer duration-300 fixed top-0 left-0 right-0  w-full h-screen bg-black bg-opacity-50 ">
                    <div class="overflow-y-auto w-full h-full items-center justify-center flex">
                        <slot/>
                    </div>
                </div>
</template>


<style lang="scss" scoped>

</style>