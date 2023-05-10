<template>
    <div id="contenidor">
        <h1>Log In</h1>
        <label class="labelLogin" for="emailUsuari">Email</label>
        <br>
        <input class="inputlogin" id="emailUsuariinput" v-model="emailUsuari" type="email" name="emailUsuari">
        <br>
        <br>
        <label class="labelLogin" for="passwd">Password</label>
        <br>
        <input class="inputlogin" type="password" id="passwdinput" v-model="passwd" name="passwd">
        <br>
        <br>
        <button id="buttonlogin" @click="enviarDadesLogIn()" :capcalera-c="isLogin" value="Log In">Log in</button>
        <button id="buttonregister" @click="goToRegister()">Register</button>
        <div id="divError"></div>
    </div>
</template>
<script>
import axios from 'axios';
// import { response } from 'express';

export default {
    name: 'logIn',
    emits: ["logInOk"],

    data() {
        return {
            emailUsuari: "",
            passwd: "",
            isLogin: false,
            userID: "",
            apikey: "",
            emailLogged: ""

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
                sessionStorage.setItem('userEmail', response.data[0].email)
                this.userID = response.data[0].UserID;
                this.apikey = response.data[0].APIKEY;
                this.emailLogged = response.data[0].email;
                this.$emit("logInOk", { userID: this.userID, apikey: this.apikey, email: this.emailLogged })
                this.isLogin = true;
                this.$router.push('/')
            }).catch(error => {
                const message = error.response.data;
                document.getElementById("divError").innerHTML = message;
                console.log(`Error message: ${message}`);
            })
        },
        goToRegister() {
            this.$router.push('/register')
        }
    }
}

</script>

<style scoped>
#contenirdor {
    height: 100%;
}

#buttonlogin {
    background-color: #00ff4c;
    color: black;
}

#buttonlogin:hover {
    background-color: #00964b;
}

#buttonregister{
    color: black;
}
</style>