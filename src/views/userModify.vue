<!-- 
      --Vista userModify--


      Funcionalitat del component:
      - Genera un formulari amb les dades de l'usuari i a partir d'aqui l'usuari pot canviar el que desitji i un cop estigui, fa una petició POST cap al backend i s'actualitzen a la BDD

-->

<template>
    <div id="titol">Modify User</div>
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
        <button id="deleteUserBTN" @click="deleteUser">Delete User</button>
        <div id="divError"></div>
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
    //Funció que comproba si hi ha una sessió activa
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
        //Funció que verifica que tots els camps estiguin plens
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
        //funció que verifica que les contrassenyes coincideixin
        verificarContrassenyes() {
            this.Passwd1 = document.getElementById("inputPasswd1").value;
            this.Passwd2 = document.getElementById("inputPasswd2").value;
            if (this.Passwd1 == '' && this.Passwd2 == '' || this.Passwd1 != this.Passwd2) {
                document.getElementById("inputPasswd1").style.border = " 2px solid red";
                document.getElementById("inputPasswd2").style.border = "2px solid red";
                return false;
            }
            else {
                document.getElementById("inputPasswd1").style.border = " 2px solid aquamarine";
                document.getElementById("inputPasswd2").style.border = "2px solid aquamarine";
                return true;
            }
        },
        // funció que a partir de l'ID usuari fa una petició a l'api i mostra la informació al formulari
        rebreDadesUser() {

            if (this.boolSessio) {
                axios.get("https://localhost/API/" + this.apikey + "." + this.userID + "/UserInfo/" + this.userID)
                    .then(resultat => {
                        this.userInfoJSON = resultat.data[0]
                        console.log(resultat.data)
                        this.FirstName = this.userInfoJSON.FirstName;
                        this.LastName = this.userInfoJSON.LastName;
                        this.Email = this.userInfoJSON.email;
                        this.Passwd1 = this.userInfoJSON.passwd;
                        this.Passwd2 = this.userInfoJSON.passwd;
                        document.getElementById("inputPasswd2").value = this.passwd;
                    });
            }
            else {
                this.boolSessio = false;
            }
        },
        // Funció que envia les dades actualitzades a l'api 
        enviarDadesModifyUser() {
            if (this.verificarCamps() === true && this.verificarContrassenyes() === true) {
                axios.post("https://localhost/API/" + this.apikey + "." + this.userID + "/ModifyUser/" + this.userID,
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
        // funció que elimina l'usuari, si ell ho desitja
        deleteUser() {
            if (this.boolSessio && this.userID == this.userInfoJSON.UserID) {
                axios.delete("https://localhost/API/" + this.apikey + "." + this.userID + "/DeleteUser/" + this.userID)
                    .then(resultat => {
                        console.log(resultat.data);
                        sessionStorage.clear();

                        this.$router.push("/");
                    })
                    .catch(error => {
                        const message = error.response.data;
                        document.getElementById("divError").innerHTML = message;
                        console.log(`Error message: ${message}`);
                    })
            }
            else {
                document.getElementById("divError").innerHTML = "User cannot be deleted";
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

<style scoped>
#deleteUserBTN{
    background-color: #ff0000;
}

#deleteUserBTN:hover{
    background-color: #ff000042;
}
</style>