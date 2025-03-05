
<script setup>
import { onUnmounted, watch } from 'vue';

const {isActive ,onClose} = defineProps([ 'isActive', 'onClose' ]);

watch(() => isActive, () => {
    if (isActive) {
        document.querySelector('body').style.overflow = 'hidden';
    } else {
        document.querySelector('body').style.overflow = 'auto';
    }
});

onUnmounted(() => {
document.querySelector('body').style.overflow = 'auto';

});
</script>

<template>
  <div

    :class="['transition-opacity duration-300', isActive ? 'opacity-100' : 'opacity-0 hidden']"
    class=" transition-all cursor-pointer duration-300 fixed top-0 left-0   w-full h-screen bg-black bg-opacity-50 ">
        <div   class=" w-full h-full ">
           <div class=" mb-2 p-5 max-h-full overflow-y-auto items-center justify-center  h-screen" >
             <div class=" items-center justify-center flex min-h-screen" @click.self="onClose(false)" >

                <slot/>
             </div>
           </div>
        </div>
    </div>
</template>


<style lang="scss" scoped>

</style>
