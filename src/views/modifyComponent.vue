<template>
    modify Component

    <div v-if="potModificar">
        <br>
        <label class="labelLogin" for="compName">Component Name</label>
        <br>
        <input class="inputlogin" id="compNameinput" :value="compName" name="compName">
        <br>
        <p>Do you want your component to be <b>Public</b> or <b>Private</b>:</p>
        <select id="compPrivacy" :value="compPrivacy">
            <option value="true">Private</option>
            <option value="false">Public</option>
        </select>
        <br>
        <div>Component Info:</div><br>
        <div id="modifyCompForm" v-for="(compProp, a) in compPropsJSON.props" :key="a" :compProp="compProp">
            <label class="labelProps" for="{{ compProp['PropertyName'] }}">{{ compProp['PropertyName'] }}</label>
            <br>
            <input class="inputProps" :value="compProps[a]" :id="compProp['propertyID']"
            :name="compProp['PropertyName']">
            <br>
        </div>
        <br>
        <button @click="enviarDadesComponent">Update Component</button>
        <button @click="deleteComponent">Delete Component</button>
        <div id="divError"></div>
    </div>
    <button @click="goToInici">Go to the main page</button>
</template>
<script>
import axios from 'axios';
export default {
    name: "modifyComponent",
    props: ["compID"],
    data() {
        return {
            userID: "",
            apikey: "",
            potModificar: false,
            boolSessio: false,
            compInfoJSON: {},
            compPropsJSON: {},
            compName: "",
            privacy: false,
            componentID : "",
            arrDadesForm: [],
            compTypeID: "",
            compPrivacy: "",
            compProps: []
        }
    },
    methods: {
        getUserComponent() {
            if (this.boolSessio) {
                console.log(this.compID)
                axios.get("http://owntainer.daw.institutmontilivi.cat/API/selectOneComponent/" + this.compID + "/" + this.userID)
                    .then(resultat => {
                        //fer condicional per veure si el user del component és el mateix que el de la session
                        this.compInfoJSON = resultat.data[0]
                        console.log(resultat.data)
                        if (this.userID == this.compInfoJSON.userID) {//si l'suari del session es el mateix que el del component
                            this.potModificar = true;
                            this.compTypeID = this.compInfoJSON.componentTypeID;
                            this.compName = this.compInfoJSON.componentName;
                            this.compPrivacy = this.compInfoJSON.privacy;
                            this.componentID = this.compInfoJSON.componentId;

                            for (let i = 0; i < (this.compInfoJSON.props).length; i++) {//vaig guardant les propietats en un array per despres mostrar-loal formulari
                                this.compProps.push(this.compInfoJSON.props[i].value);
                            }

                            this.getComponentProperties()
                        }
                        else {
                            this.potModificar = false;
                        }
                    })
                    .catch(error => {
                        const message = error.response.data;
                        document.getElementById("divError").innerHTML = message;
                        console.log(`Error message: ${message}`);
                    })
            }
        },
        getComponentProperties() {
            // console.log(this.compTypeID)
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/getComponentProperties/" + this.compTypeID)
                .then(resultat => {
                    this.compPropsJSON = resultat.data
                    console.log(resultat.data)
                });
        },
        enviarDadesComponent() {
            var totsInputPropsId = [];
            var totsInputPropsValue = [];
            var arrayPropsJSON = [];

            for (let i = 0; i < (this.compPropsJSON.props).length; i++) {//extrec els IDs de les propietsts i els values i els guardo en arrays separats
                totsInputPropsId.push(document.getElementsByClassName("inputProps")[i].id);
                totsInputPropsValue.push(document.getElementsByClassName("inputProps")[i].value);
            }

            for (let i = 0; i < (this.compPropsJSON.props).length; i++) {//aig generant un objecte per cada iteracio amb la seva informacio
                arrayPropsJSON.push(
                    {
                        prop_id: totsInputPropsId[i],
                        prop_val: totsInputPropsValue[i]
                    }
                );
            }

            this.compName = document.getElementById("compNameinput").value;
            this.privacy = document.getElementById("compPrivacy").value;
            axios.post("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/ModifyComponent/" + this.componentID,
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
        deleteComponent() {
            if (this.boolSessio && this.userID == this.compInfoJSON.userID) {
                axios.delete("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/DeleteComponent/" + this.componentID)
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
                document.getElementById("divError").innerHTML = "component cannot be deleted";
            }
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
        this.comprovarSessio()
        this.getUserComponent()
        // this.getComponentProperties()

    }
}
</script>
<style></style>