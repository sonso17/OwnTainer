<template>
    <div id="registerFormGeneral">
        <div id="FirstNameCamp">
            <div id="labelFN">
                <label for="FirstName">First Name</label>
            </div>
            <div id="inputFN">
                <input class="inputFirstName" id="inputFirstName" v-model="FirstName" type="text" name="FirstName">
            </div>
        </div>
        <div id="PasswdCamp">
            <div id="labelLN">
                <label for="LastName">Last Name</label>
            </div>
            <div id="inputLN">
                <input class="inputLastName" id="inputLastName" v-model="LastName" type="text" name="LastName">
            </div>
        </div>
        <div id="EmailCamp">
            <div id="labelE">
                <label for="Email">Email</label>
            </div>
            <div id="inputE">
                <input class="inputEmail" id="inputEmail" v-model="Email" type="email" name="Email">
            </div>
        </div>
        <div id="PasswdCamp1">
            <div id="labelP1">
                <label for="Passwd1">password</label>
            </div>
            <div id="inputP1">
                <input class="inputPasswd1" @change="verificarContrassenyes()" id="inputPasswd1" v-model="Passwd1" type="password" name="Passwd1">
            </div>
        </div>
        <div id="PasswdCamp2">
            <div id="labelP2">
                <label for="Passwd2">Re-type password</label>
            </div>
            <div id="inputP2">
                <input class="inputPasswd2" @change="verificarContrassenyes()" id="inputPasswd2" v-model="Passwd2" type="password" name="Passwd2">
            </div>
        </div>
        <div id="errorMessage"></div>
    </div>

    <div id="registerButtons">
        <button id="btRegister" @click="enviarDadesRegister">Register</button>
        <button id="btLogIn" @click="goToLogIn">Log In</button>
    </div>
</template>

<script>
import router from '@/router';
import axios from 'axios';

export default {
    name: 'userRegisterForm',
    data() {
        return {
            FirstName: "",
            LastName: "",
            Email: "",
            Passwd1: "",
            Passwd2: ""
        }
    },
    methods: {
        verificarContrassenyes() {
            this.Passwd1 = document.getElementById("inputPasswd1").value;
            this.Passwd2 = document.getElementById("inputPasswd2").value;
            if (this.Passwd1 == '' && this.Passwd2 == '' || this.Passwd1 != this.Passwd2) {
                document.getElementById("inputPasswd1").style.border = " 2px solid red";
                document.getElementById("inputPasswd2").style.border = "2px solid red";
                // console.log("false");
                return false;
            }
            else {
                document.getElementById("inputPasswd1").style.border = " 2px solid aquamarine";
                document.getElementById("inputPasswd2").style.border = "2px solid aquamarine";
                // console.log("true");
                return true;
            }
        },
        enviarDadesRegister() {
            if (this.verificarContrassenyes() === true) {
                this.FirstName = document.getElementById("inputFirstName").value;
                this.LastName = document.getElementById("inputLastName").value;
                this.Email = document.getElementById("inputEmail").value;
                axios.post('http://owntainer.daw.institutmontilivi.cat/API/register',
                    {
                        "data": [
                            {
                                "UserName": this.FirstName,
                                "UserLastName": this.LastName,
                                "UserEmail": this.Email,
                                "passwd": this.Passwd1
                            }
                        ]
                    }
                ).then((response) => {
                console.log(response.data);
                document.getElementById("errorMessage").innerHTML = response.data;
                    
                router.push('/');
                })
            }
            else {
                document.getElementById("errorMessage").innerHTML = "Something went wrong :("
            }
        },
        goToLogIn() {
            router.push('/logIn')
        }
    }
}
</script>

<style scoped></style>