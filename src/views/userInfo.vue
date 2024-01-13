<!-- 
      --Vista UserInfo--

      Propietats que rep:
        - userInfo

      Funcionalitat del component:
      - A partir d'un user id, fa una petició GET a l'api i mostra la seva informació

-->

<template>
    <div id="titol"> User Info </div>
    <div id="btnLogInRegister" v-if="!boolSessio">
        <button @click="goToLogIn">LogIn/Register</button>
    </div>

    <div id="userInfoGeneral" v-if="boolSessio">
        <div id="userInfoBox1">
            First Name: <b>{{ userInfoJSON.FirstName }}</b><br>
            Last Name: <b>{{ userInfoJSON.LastName }}</b><br>
        </div>
        <div id="userInfoBox2">
            Email: <b>{{ userInfoJSON.email }}</b><br>
            Password: <b>{{ userInfoJSON.passwd }}</b><br>
        </div>
        <div id="buttonsModificarEliminar">
            <button id="deleteUserBTN" @click="deleteUser">Delete User</button>
            <button @click="goToModifyUser">Modify User</button>
        </div>
        <div id="divError"></div>
    </div>
</template>

<script>

import axios from 'axios';

export default {
    name: "userInfo",
    props: ["userInfo"],
    data() {
        return {
            userID: "",
            apikey: "",
            userInfoJSON: {},
            boolSessio: false
        }
    },
    methods: {
        //Funció que comprova la sessió de l'usuari
        comprovarSessio() {
            if (sessionStorage.UserID && sessionStorage.APIKEY) {
                this.userID = sessionStorage.UserID;
                this.apikey = sessionStorage.APIKEY;

                this.getUserInfo()
                this.boolSessio = true;
                return true;
            }
            else {
                console.log("entra")
                this.boolSessio = false;
                return false;
            }
        },
        //Funció que fa una peticióa l'api i rep la informació d'aquell usuari
        getUserInfo() {
            axios.get("http://localhost/API/" + this.apikey + "." + this.userID + "/UserInfo/" + this.userID)
                .then(resultat => {
                    this.userInfoJSON = resultat.data[0]
                });
        },
        //Funció que elimina un usuari i tots els seus components
        deleteUser() {
            if (this.boolSessio && this.userID == this.userInfoJSON.UserID) {
                axios.get("http://localhost/API/" + this.apikey + "." + this.userID + "/DeleteUser/" + this.userID)
                    .then(resultat => {
                        console.log(resultat.data)
                        this.$router.push("/");
                    })
                    .catch(error => {
                        const message = error.response.data;
                        document.getElementById("divError").innerHTML = message;
                        console.log(`Error message: ${message}`);
                    })
            }
            else {
                document.getElementById("divError").innerHTML = "user cannot be deleted";
            }
        },
        goToLogIn() {
            this.$router.push('/login')
        },
        goToModifyUser(){
            this.$router.push('/modifyUser/' + this.userID)
        }
    },
    created() {
        this.comprovarSessio()
    }
}
</script>
<style scoped>
#deleteUserBTN{
    background-color: red;
}
#deleteUserBTN:hover{
    background-color: #960018;

}

#userInfoGeneral{
    font-size: 30px;
}
</style>