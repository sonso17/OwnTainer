<template>
    register Component
    <div v-if="boolSessio">
        <select v-model="componentTypeSelect" @change="getComponentProperties" id="componentTypeSelect">
            <compTypeList v-for="(compType, i) in compTypesJSON" :key="i" :compType="compType"></compTypeList>
        </select>
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
        <button @click="enviarDadesComponent">Submit</button>
        <div id="divError"></div>
    </div>
    <button @click="goToInici">Go to the main page</button>
</template>

<script>
import axios from 'axios';
import compTypeList from '@/components/compTypeList.vue';
export default {
    name: "registerComponent",
    components: {
        compTypeList
    },
    data() {
        return {
            userID: "",
            apikey: "",
            boolSessio: false,
            componentTypeSelect: "",
            compTypesJSON: {},
            compPropsJSON: {},
            compName: "",
            privacy: false,
            arrDadesForm: []
        }
    },
    methods: {
        getAllComponentType() {
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/getAllComponentType")
                .then(resultat => {
                    this.compTypesJSON = resultat.data
                    console.log(resultat.data)
                });
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
        this.getAllComponentType()
        this.comprovarSessio()
    }
}
</script>