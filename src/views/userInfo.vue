<template>
    <div id="btnLogInRegister" v-if="this.comprovarSessio() == false">
        <button @click="goToLogIn()">LogIn/Register</button>
    </div>

    <div v-if="this.comprovarSessio() != false">
        <div id="userInfoBox1">
            FirstName: {{ userInfoJSON[0].FirstName }}<br>
            LastName: {{ userInfoJSON[0].LastName }}<br>
        </div>
        <div id="userInfoBox2">
            Email: {{ userInfoJSON[0].email }}<br>
            Password: {{ userInfoJSON[0].passwd }}<br>
        </div>
    </div>
</template>

<script>
import router from '@/router';
import axios from 'axios';

export default {
    name: "userInfo",
    props: ["userInfo"],
    data() {
        return {
            userID: "",
            apikey: "",
            userInfoJSON: ""
        }
    },
    methods: {
        comprovarSessio() {
            if (sessionStorage.UserID && sessionStorage.APIKEY) {
                this.userID = sessionStorage.UserID;
                this.apikey = sessionStorage.APIKEY;

                this.getUserInfo()
                //cridar getuserInfo
            }
            else {
                // console.log("entra")
                return false;
            }
        },
        getUserInfo() {
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/UserInfo/" + this.userID).then(resultat => {
                this.userInfoJSON = resultat.data
                console.log(resultat.data)
            });
        },
        goToLogIn() {
            router.push('/login')
        }

    },
    created() {
        this.comprovarSessio()
    }
}
</script>
<style scoped></style>