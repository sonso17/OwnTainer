<template>
    <div id="compTitle"> Component Name: {{ compInfoJSON.componentName }}</div>
    <div id="componentInfo" v-for="(prop, p) in compInfoJSON.props" :key="p" :item="prop">
        {{ prop.name }} : {{ prop.value }}
    </div>
    <div id="compPrivacy">Component privacy:
        <div v-if="compInfoJSON.privacy == 'true'"> Private</div>
        <div v-if="compInfoJSON.privacy == 'false'"> Public</div>
    </div>
    <div v-if="userID == compInfoJSON.userID"><!-- -->
        <button @click="goToModifyComponent">ModifyComponent</button>
        <button>Delete component</button>
    </div>
    <div id="divError"></div>
</template>
<script>
import axios from 'axios';

export default {
    name: 'OneComponent',
    props: ['id'],
    data() {
        return {
            boolSessio: false,
            apikey: "",
            userID: "",
            compInfoJSON: ""
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
        getComponentInfo() {
            if (this.boolSessio) {//si hi ha sessio
                axios.get("http://owntainer.daw.institutmontilivi.cat/API/selectOneComponent/" + this.id + "/" + this.userID)
                    .then(resultat => {
                        this.compInfoJSON = resultat.data[0]
                        console.log(resultat.data)
                    })
                    .catch(error => {
                        const message = error.response.data;
                        document.getElementById("divError").innerHTML = message;
                        console.log(`Error message: ${message}`);
                    })
            }
            else {
                axios.get("http://owntainer.daw.institutmontilivi.cat/API/selectOneComponent/" + this.id)
                    .then(resultat => {
                        this.compInfoJSON = resultat.data[0]
                        console.log(resultat.data)
                    })
                    .catch(error => {
                        const message = error.response.data;
                        document.getElementById("divError").innerHTML = message;
                        console.log(`Error message: ${message}`);
                    })
            }
        },
        goToModifyComponent() {
            this.$router.push('/modifyComponent/' + this.id)
        }
    },
    created() {
        this.comprovarSessio()
        this.getComponentInfo()
    }

}
</script>