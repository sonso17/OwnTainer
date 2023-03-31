<template>
    <div id="contenidor">
        <h1>Log In</h1>
        <label class="labelLogin" for="emailUsuari">Correu</label>
        <input class="inputlogin" id="emailUsuariinput" v-model="emailUsuari" type="email" name="emailUsuari">
        <br>
        <br>
        <label class="labelLogin" for="passwd">Contrassenya</label>
        <br>
        <input class="inputlogin" type="password" id="passwdinput" v-model="passwd" name="passwd">
        <br>
        <br>
        <button id="buttonlogin" @click="enviarDadesLogIn()" :capcalera-c="isLogin" value="Log In">Log in</button>
        <button id="buttonlogin" @click="goToRegister()">Register</button>
    </div>
</template>
<script>
import router from '@/router';
import axios from 'axios';
// import { response } from 'express';

export default {
    name: 'logIn',
    data() {
        return {
            emailUsuari: "",
            passwd: "",
            isLogin: false,
            userID: "",
            apikey: ""
        }
    },
    methods: {
        enviarDadesLogIn() {
            this.emailUsuari = document.getElementById("emailUsuariinput").value;
            this.passwd = document.getElementById("passwdinput").value;

            axios.post('http://owntainer.daw.institutmontilivi.cat/API/LogIn',
                {
                    data: [
                        {
                            "UserEmail": this.emailUsuari,
                            "passwd": this.passwd
                        }
                    ]
                }
            ).then((response) => {
                console.log(response.data);
                sessionStorage.setItem('UserID', response.data[0].UserID);
                sessionStorage.setItem('APIKEY', response.data[0].APIKEY);
                this.userID = response.data[0].UserID;
                this.apikey = response.data[0].APIKEY;
                this.$emit("userID", this.userID)
                this.$emit("apikey", this.apikey)
                this.isLogin = true;
                router.push('/')
            })
            // console.log(response);
        },
        goToRegister(){
            router.push('/register')
        }
    }
}


</script>

<style scoped>
#contenirdor{
    height: 100%;
}
</style>