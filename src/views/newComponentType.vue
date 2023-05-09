<template>
    register new component Type
    <div v-if="boolSessio" id="fromGeneral">
        <label for="CompTypeName">Property Name</label><br>
        <input type="text" name="CompTypeName" id="CompTypeName"><br>
        <div id="contenidorProps"></div>
        <button @click="AddNewPropAndUnit">New Property</button>
        <button @click="comprobarCamps">Submit</button>
    </div>
    <div id="divError"></div>
    <button @click="goToMainPage">Go back</button>
</template>

<script>
import axios from 'axios';

// import axios from 'axios';
export default {
    name: "registerComponentType",
    data() {
        return {
            boolSessio: false,
            userID: "",
            apikey: "",
            compTypeName: ""
        }
    },
    methods: {
        comprobarCamps() {
            var compName = document.getElementById("CompTypeName").value;
            if (compName != "") {
                this.enviarDadesNewCompType()
            }
            else {
                document.getElementById("divError").innerHTML = 'please name the new component type ;)'
                document.getElementById("CompTypeName").style.border = " 2px solid red";
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
        AddNewPropAndUnit() {
            const inputNou = document.createElement("input");
            // inputNou.innerHTML += "<br>"
            inputNou.className = "inputProp";
            document.getElementById("contenidorProps").appendChild(inputNou);
            // let saltLinia = document.createElement("br")
            // inputNou.appendChild(saltLinia.lastChild);
        },
        enviarDadesNewCompType() {
            this.compTypeName = document.getElementById("CompTypeName").value;
            var PropsArray = [];
            var PropsArrayJSON = [];

            for (let i = 0; i < (document.getElementsByClassName("inputProp")).length; i++) {// faig tantes voltes com elements amb el mateix classname hi hagi
                PropsArray.push(document.getElementsByClassName("inputProp")[i].value);
            }

            for (let i = 0; i < (PropsArray).length; i++) {// faig tantes voltes com elements amb el mateix classname hi hagi
                console.log(PropsArray[i]);
                PropsArrayJSON.push(
                    {
                        prop_Name: PropsArray[i],
                        prop_Unit: ""
                    }
                );
            }

            axios.post("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/AddComponentType/",
                {
                    "data":
                    {
                        "ComponentType": this.compTypeName,
                        "props": PropsArrayJSON
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
        goToMainPage() {
            this.$router.push("/")
        }

    },
    created() {
        this.comprovarSessio()
    }
}

</script>

<style scoped>
#contenidorProps{
    display: flex;
    flex-direction: column;
}
.inputProp{
    position: relative;
    padding: 15px;
    height: 10%;
}
</style>