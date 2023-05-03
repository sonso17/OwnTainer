<template>
    <div id="btnLogInRegister" v-if="!boolSessio">
        <button @click="goToLogIn">LogIn/Register</button>
    </div>

    <div id="modifyUserFormGeneral" v-if="boolSessio">
        <div id="FirstNameCamp">
            <div id="labelFN">
                <label for="FirstName">First Name</label>
            </div>
            <div id="inputFN">
                <input class="inputFirstName" id="inputFirstName" v-model="FirstName" type="text" name="FirstName">
            </div>
        </div>
        <div id="LastName">
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
                <input class="inputPasswd1" @change="verificarContrassenyes()" id="inputPasswd1" v-model="Passwd1"
                    type="password" name="Passwd1">
            </div>
        </div>
        <div id="PasswdCamp2">
            <div id="labelP2">
                <label for="Passwd2">Re-type password</label>
            </div>
            <div id="inputP2">
                <input class="inputPasswd2" @change="verificarContrassenyes()" id="inputPasswd2" v-model="Passwd2"
                    type="password" name="Passwd2">
            </div>
        </div>
        <div id="errorMessage"></div>
        <button @click="enviarDadesModifyUser">Update User</button>
        <button>Delete User</button>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name: 'userModificationForm',
    data() {
        return {
            FirstName: "",
            LastName: "",
            Email: "",
            Passwd1: "",
            Passwd2: "",
            flagFN: false,
            flagLN: false,
            flagE: false,
            userID: "",
            apikey: "",
            boolSessio: false,
            userInfoJSON: "",

        }
    },
    methods: {
        comprovarSessio() {
            if (sessionStorage.UserID && sessionStorage.APIKEY) {
                this.userID = sessionStorage.UserID;
                this.apikey = sessionStorage.APIKEY;

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
        verificarCamps() {
            this.FirstName = document.getElementById("inputFirstName").value;
            this.LastName = document.getElementById("inputLastName").value;
            this.Email = document.getElementById("inputEmail").value;

            if (this.FirstName != '') {
                document.getElementById("inputFirstName").style.border = " 2px solid aquamarine";
                this.flagFN = true;
            }
            else {
                document.getElementById("inputFirstName").style.border = " 2px solid red";
                this.flagFN = false;
            }

            if (this.LastName != '') {
                document.getElementById("inputLastName").style.border = " 2px solid aquamarine";
                this.flagLN = true;
            }
            else {
                document.getElementById("inputLastName").style.border = " 2px solid red";
                this.flagLN = false;
            }

            if (this.Email != '') {
                document.getElementById("inputEmail").style.border = " 2px solid aquamarine";
                this.flagE = true;
            }
            else {
                document.getElementById("inputEmail").style.border = " 2px solid red";
                this.flagE = false;
            }

            if (this.flagFN == true && this.flagLN == true && this.flagE == true) {
                return true;
            }
            else {
                return false;
            }

        },
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
        rebreDadesUser() {
            // this.comprovarSessio();

            if (this.boolSessio) {
                axios.get("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/UserInfo/" + this.userID)
                    .then(resultat => {
                        this.userInfoJSON = resultat.data[0]
                        console.log(resultat.data)
                        document.getElementById("inputFirstName").value = this.userInfoJSON.FirstName;
                        document.getElementById("inputLastName").value = this.userInfoJSON.LastName;
                        document.getElementById("inputEmail").value = this.userInfoJSON.email;
                        document.getElementById("inputPasswd1").value = this.passwd;
                        document.getElementById("inputPasswd2").value = this.passwd;
                        // this.userID = this.userInfoJSON
                    });
            }
            else {
                this.boolSessio = false;
            }

        },
        enviarDadesModifyUser() {
            if (this.verificarCamps() === true && this.verificarContrassenyes() === true) {
                this.FirstName = document.getElementById("inputFirstName").value;
                this.LastName = document.getElementById("inputLastName").value;
                this.Email = document.getElementById("inputEmail").value;
                axios.post("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/ModifyUser/" + this.userID,
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

                    this.$router.push('/');
                })
            }
            else {
                document.getElementById("errorMessage").innerHTML = "Something went wrong :("
            }
        },
        deleteUser() {
            if (this.boolSessio && this.userID == this.compInfoJSON.userID) {
                axios.delete("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/DeleteUser/" + this.userID)
                    .then(resultat => {
                        console.log(resultat.data);
                        sessionStorage.clear();
                        // this.$emit("logOut", { userID: "", apikey: "" });

                        this.$router.push("/");
                    })
                    .catch(error => {
                        const message = error.response.data;
                        document.getElementById("divError").innerHTML = message;
                        console.log(`Error message: ${message}`);
                    })
            }
            else {
                document.getElementById("divError").innerHTML = "component cannot be deleted";
            }
        },
        goToLogIn() {
            this.$router.push('/logIn')
        }
    },
    created() {
        this.comprovarSessio(),
            this.rebreDadesUser()

    }
}

</script>