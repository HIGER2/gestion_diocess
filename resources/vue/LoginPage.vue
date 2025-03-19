

<script setup>
import { reactive, ref } from 'vue';
import ButtonLoader from './components/ButtonLoader.vue';

const login = reactive({
    login: '',
    // login: 'doumaarmand@gmail.com',
    // login: 'admin@gmail.com',
    password: ''
    // password: 'Douma@123'
});

const pass = ref(false);


const isLoading=ref(false)
const errrMessage =ref('')

const authLogin = async () => {
    isLoading.value=true
    errrMessage.value = ""
   await axios.post('/auth/login',login)
    .then(response => {
        if (response.data.redirect) {
            window.location.href = response.data.redirect;
        }
    })
        .catch(error => {
            let mismatch = "CSRF token mismatch"
            if (errrMessage.value && errrMessage.value.trim() == mismatch.trim()) {

                alert('votre session à expiré ')

            } else {
            errrMessage.value = error.response?.data?.message + ""

            }
        // console.error('Error fetching user data:', error.response?.data?.message);
        });
    isLoading.value= false
};

</script>

<template>
    <main>
        <div class="container min-h-screen bg-zinc-50">
            <div class="card  ">
                <div class="content">
                    <h4 class="font-[900] text-4xl mb-6">Se connecter</h4>
                    <div v-if="errrMessage" class="p-4 w-full text-center bg-red-100 text-[12px] rounded-md text-red-800">
                        {{ errrMessage }}
                </div>
                    <form action="" @submit.prevent="authLogin">
                        <div class="groupeForm">
                            <label for=""  class="block text-[13px] font-medium text-gray-700">Téléphone ou Email</label>
                            <div class="forminput">
                                <input type="text" placeholder="Téléphone ou Email" v-model="login.login"  class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary " required>
                            </div>
                        </div>
                        <div class="groupeForm">
                            <label for=""  class="block text-[13px] font-medium text-gray-700 ">Mot de passe</label>
                            <div class="forminput">
                                <input placeholder="Mot de passe" :type="pass ? 'text': 'password'" v-model="login.password" cl class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-3 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-primary " required>
                            </div>
                        </div>
                        <div class="flex items-center gap-1">
                            <input type="checkbox" v-model="pass" name="pass" id="pass">
                            <label for="pass" class="cursor-pointer"> afficher le mot de passe</label>
                        </div>
                        <button type="submit" class="mt-6 bg-primary flex items-center justify-center w-full text-white py-2 px-4 rounded-xl ">
                            <ButtonLoader title="Connexion" :isLoading="isLoading" />
                        </button>
                    </form>
                    <!-- <span class="link">
                    Vous n'avez pas de compte ? <NuxtLink to="/auth/register">S'inscrire </NuxtLink>
                    </span> -->
                </div>
                </div>
        </div>
    </main>
</template>

<style lang="scss" scoped>
@import "../scss/_variable";
main {
    width: 100%;

    .container {
        width: 100%;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        .card{
        width: 400px;
        padding: 2rem;
        border-radius: 0.6rem;
        .content {
            .title{
            color: $accent;
            }

            form {
                width: 100%;
                margin-top: 1em;
                .grouperow {
                    display: flex;
                    gap: 10px;
                    align-items: center;
                }

                .groupeForm {
                display: flex;
                gap: 10px;
                margin-bottom: 2em;
                flex-direction: column;
                width: 100%;
                // label {
                //     width: max-content;
                //     font-size: 14px;
                //     // width: 100%;
                // }
                // select,input {
                //     padding: 10px 20px;
                //     width: 100%;
                //     border: 1px solid #6c6b6b;
                //     border-radius: 0.8em;

                //     &:focus{
                //     outline: 2px solid $primary;
                //     }
                // }
                }


            }
        }
        .link {
            display: block;
            text-align: center;
            margin: 10px 0;

            a {
                color: blue;
                text-decoration: underline;
            }
        }
        }




    }
}</style>
