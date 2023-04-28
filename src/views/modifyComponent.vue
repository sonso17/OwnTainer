<template>
    modify Component
    -- {{ this.compID }}
    <div v-if="potModificar">
        <br>
        <!-- {{ compPropsJSON }}<br> -->
        <label class="labelLogin" for="compName">Component Name</label>
        <br>
        <input class="inputlogin" id="compNameinput" v-model="compName" type="email" name="compName">
        <br>
        <p>Do you want your component to be <b>Public</b> or <b>Private</b>:</p>
        <select id="compPrivacy">
            <option value="true">Public</option>
            <option value="false">Private</option>
        </select>
        <br>
        <div>Component Info:</div><br>
        <div id="RegisterCompForm" v-for="(compProp, a) in compPropsJSON.props" :key="a" :compProp="compProp">
            <label class="labelLogin" for="{{ compProp['PropertyName'] }}">{{ compProp['PropertyName'] }}</label>
            <br>
            <input class="inputlogin" id="{{ compProp['PropertyName'] }}Input" type="email"
                name="{{ compProp['PropertyName'] }}">
            <br>
        </div>
        <br>
        <button @click="enviarDadesComponent">Update Component</button>
        <button>Delete Component</button>
        <div id="divError"></div>
    </div>
    <button @click="goToInici">Go to the main page</button>
</template>
<script>
import axios from 'axios';
export default {
    name: "registerComponent",
    props: ["compID"],
    data() {
        return {
            userID: "",
            userCompID: "",
            apikey: "",
            potModificar: false,
            boolSessio: false,
            componentTypeSelect: "",
            compInfoJSON: {},
            compPropsJSON: {},
            compName: "",
            privacy: false,
            arrDadesForm: [],
            compTypeID: ""
        }
    },
    methods: {
        getUserComponent() {
            console.log(this.compID)
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/selectOneComponent/" + this.compID + "/" + this.userID)
                    .then(resultat => {
                        //fer condicional per veure si el user del component és el mateix que el de la session
                        this.compInfoJSON = resultat.data[0]
                        console.log(resultat.data)
                    })
                    .catch(error => {
                        const message = error.response.data;
                        document.getElementById("divError").innerHTML = message;
                        console.log(`Error message: ${message}`);
                    })
        },
        getComponentProperties() {

            axios.get("http://owntainer.daw.institutmontilivi.cat/API/getComponentProperties/" + this.componentTypeSelect)
                .then(resultat => {
                    this.compPropsJSON = resultat.data
                    console.log(resultat.data)
                });
        },
        enviarDadesComponent() {
            this.compName = document.getElementById("compNameinput").value;
            this.privacy = document.getElementById("compPrivacy").value;
            axios.post("http://owntainer.daw.institutmontilivi.cat/API/ " + this.apikey + "." + this.userID + "/RegisterComponent",
                {
                    "data":
                    {
                        "ComponentName": this.compName,
                        "ComponentType": this.compPropsJSON.componentTypeID,
                        "privacy": this.privacy,
                        "props": [

                        //  for(i =0; i< this.compPropsJSON.props; i++){

                        //  }
                        ]
                    }
                }
            ).then((response) => {
                console.log(response.data);
                this.$router.push('/')
            }).catch(error => {
                const message = error.response.data;
                document.getElementById("divError").innerHTML = message;
                console.log(`Error message: ${message}`);
            })
        },
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
        goToInici() {
            this.$router.push("/")
        }
    },
    created() {
        this.comprovarSessio()
        this.getUserComponent()

    }
}
</script>
<style></style>