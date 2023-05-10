<template>
    <div id="btnLogInRegister" v-if="!boolSessio">
        <button @click="goToLogIn">LogIn/Register</button>
    </div>

    <div v-if="boolSessio">
        <div id="userInfoBox1">
            FirstName: {{ userInfoJSON.FirstName }}<br>
            LastName: {{ userInfoJSON.LastName }}<br>
        </div>
        <div id="userInfoBox2">
            Email: {{ userInfoJSON.email }}<br>
            Password: {{ userInfoJSON.passwd }}<br>
            <!-- {{ userInfoJSON.UserID }} -->
        </div>
        <div id="buttonsModificarEliminar">
            <button id="deleteUserBTN" @click="deleteUser">Delete User</button>
            <button @click="goToModifyUser">Modify User</button>
        </div>
        <div id="divError"></div>
    </div>
</template>

<script>
// import router from '@/router';
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
        comprovarSessio() {
            if (sessionStorage.UserID && sessionStorage.APIKEY) {
                this.userID = sessionStorage.UserID;
                this.apikey = sessionStorage.APIKEY;

                this.getUserInfo()
                this.boolSessio = true;
                return true;
                //cridar getuserInfo
            }
            else {
                console.log("entra")
                this.boolSessio = false;
                return false;
            }
        },
        getUserInfo() {
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/UserInfo/" + this.userID)
                .then(resultat => {
                    this.userInfoJSON = resultat.data[0]
                    console.log(resultat.data)
                    // console.log(this.userInfoJSON.UserID)
                });
        },
        deleteUser() {
            if (this.boolSessio && this.userID == this.userInfoJSON.UserID) {
                axios.get("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/DeleteUser/" + this.userID)
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
</style>