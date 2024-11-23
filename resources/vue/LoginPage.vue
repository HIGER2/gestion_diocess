

<script setup>
import { reactive } from 'vue';

const login = reactive({
    login: 'admin@gmail.com',
    password: 'password'
});

const authLogin = async () => {

    axios.post('/auth/login',login)
    .then(response => {
        if (response.data.redirect) {
            window.location.href = response.data.redirect;
        }
    })
    .catch(error => {
        console.error('Error fetching user data:', error.response.data);
    });
};

</script>

<template>
    <main>
        <div class="container bg-zinc-100 min-h-screen">
            <div class="card bg-white">
                <div class="content">
                    <h4 class="font-[900] text-[18px]">Se connecter</h4>
                    <form action="" @submit.prevent="authLogin">
                        <div class="groupeForm">
                            <label for=""  class="block text-[13px] font-medium text-gray-700 mb-2">Téléphone ou Email</label>
                            <div class="forminput">
                                <input type="text" v-model="login.login"  class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="groupeForm">
                            <label for=""  class="block text-[13px] font-medium text-gray-700 mb-2">Mot de passe</label>
                            <div class="forminput">
                                <input type="text" v-model="login.password" cl class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 text-[13px] shadow-sm focus:outline-none focus:ring-1 focus:ring-blue-950 focus:border-blue-500">
                            </div>
                        </div>
                        <button type="submit" class="mt-6 bg-blue-950 w-full text-white py-2 px-4 rounded-xl ">
                            Connexion
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
