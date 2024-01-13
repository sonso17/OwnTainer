<!-- 
      --Vista registerComponent--

      Funcionalitat del component:
      - fa una petició de un tipus de component(l'usuari pot escollir) i rep les seves propietats i a partir d'aqui es genera el formulari. 
      un cop els camps omplerts, es fa una petició POSt a L'api

-->

<template>
    <div id="titol">register Component</div>
    <div v-if="boolSessio">
        <select v-model="componentTypeSelect" @change="getComponentProperties" id="componentTypeSelect">
            <compTypeList v-for="(compType, i) in compTypesJSON" :key="i" :compType="compType"></compTypeList>
        </select>
        <br>
        <label class="labelLogin" for="compName">Component Name</label>
        <br>
        <input class="inputlogin" id="compNameinput" v-model="compName" type="email" name="compName">
        <br>
        <p>Do you want your component to be <b>Public</b> or <b>Private</b>:</p>
        <select id="compPrivacy">
            <option value="true">Private</option>
            <option value="false">Public</option>
        </select>
        <br>
        <div>Component Info:</div><br>
        <div id="RegisterCompForm" v-for="(compProp, a) in compPropsJSON.props" :key="a" :compProp="compProp">
            <label class="labelProps" :for="compProp['PropertyName']">{{ compProp['PropertyName'] }}</label>
            <br>
            <input class="inputProps" :id="compProp['propertyID']" type="email" :name="compProp['PropertyName']">
            <br>
        </div>
        <br>
        <button @click="comprobarCamps">Submit</button>
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

        }
    },
    methods: {
        //funció que comproba que coma minim hi hagi uel nom i un tipus de component plè
        comprobarCamps() {
            var selectCompType = document.getElementById("componentTypeSelect").value;
            var compName = document.getElementById("compNameinput").value;
            if (selectCompType != "" && compName != "") {
                this.enviarDadesComponent()
            }
            else {
                document.getElementById("divError").innerHTML = 'please select a component type and then put a name on it ;)'
                document.getElementById("componentTypeSelect").style.border = " 2px solid red";
                document.getElementById("compNameinput").style.border = " 2px solid red";
            }
        },
        //funció que agafa els diferents tipus de components
        getAllComponentType() {
            axios.get("https://localhost/API/getAllComponentType")
                .then(resultat => {
                    this.compTypesJSON = resultat.data
                });
        },
        //funció que a partir del tipus sel.leccionat, agafa les seves propietats
        getComponentProperties() {

            axios.get("https://localhost/API/getComponentProperties/" + this.componentTypeSelect)
                .then(resultat => {
                    this.compPropsJSON = resultat.data
                });
        },
        //funció que agafa les dades del formulari i les envia a l'api
        enviarDadesComponent() {
            var totsInputPropsId = [];
            var totsInputPropsValue = [];
            var arrayPropsJSON = [];

            for (let i = 0; i < (this.compPropsJSON.props).length; i++) {//extrec els IDs de les propietsts i els values i els guardo en arrays separats
                totsInputPropsId.push(document.getElementsByClassName("inputProps")[i].id);
                totsInputPropsValue.push(document.getElementsByClassName("inputProps")[i].value);
            }

            for (let i = 0; i < (this.compPropsJSON.props).length; i++) {//vaig generant un objecte per cada iteracio amb la seva informacio
                arrayPropsJSON.push(
                    {
                        prop_id: totsInputPropsId[i],
                        prop_val: totsInputPropsValue[i]
                    }
                );
            }

            this.compName = document.getElementById("compNameinput").value;
            this.privacy = document.getElementById("compPrivacy").value;
            axios.post("https://localhost/API/" + this.apikey + "." + this.userID + "/RegisterComponent/",
                {
                    "data":
                    {
                        "ComponentName": this.compName,
                        "ComponentType": this.compPropsJSON.componentTypeId,
                        "privacy": this.privacy,
                        "props": arrayPropsJSON
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
            }
            else {
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

<style>
#titol{
    font-size: 50px;
}
</style>