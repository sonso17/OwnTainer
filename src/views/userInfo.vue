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
        </div>
        <div id="buttonsModificarEliminar">
            <button>Delete User</button>
            <button @click="goToModifyUser">Modify User</button>
        </div>
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
                });
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
<style scoped></style>