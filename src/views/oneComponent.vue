<template>
    <div id="divGeneral">
        <div id="infoComponent">
            <div id="compTitle">
                <div id="compName">Component Name:</div>
                <div class="compInfo">{{ compInfoJSON.componentName }}</div>
            </div>
            <div id="componentInfo" v-for="(prop, p) in compInfoJSON.props" :key="p" :item="prop">
                <div class="compProp">{{ prop.name }} :</div>
                <div class="compInfo">{{ prop.value }}</div>
            </div>
            <div id="compPrivacy">
                <div class="compProp">Component privacy:</div>
                <div class="compInfo" v-if="compInfoJSON.privacy == 'true'"> Private</div>
                <div class="compInfo" v-if="compInfoJSON.privacy == 'false'"> Public</div>
            </div>

        </div>
        <img id="compImage" src="../assets/toddyDaddy.png">

    </div>
    <div id="grupButtonsModifyDeleteComp" v-if="userID == compInfoJSON.userID"><!-- -->
        <button id="updateCompBTN" @click="goToModifyComponent">ModifyComponent</button>
        <button id="deleteCompBTN" @click="deleteComponent">Delete component</button>
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
            compInfoJSON: "",
            componentID: ""
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
                        this.compInfoJSON = resultat.data[0];
                        this.componentID = this.compInfoJSON.componentId;
                        // console.log(resultat.data)
                        // console.log(this.componentID)
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
                        this.compInfoJSON = resultat.data[0];
                        this.componentID = this.compInfoJSON.componentId;
                        // console.log(resultat.data)
                        // console.log(this.componentID)
                    })
                    .catch(error => {
                        const message = error.response.data;
                        document.getElementById("divError").innerHTML = message;
                        console.log(`Error message: ${message}`);
                    })
            }
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

<style scoped>
#divGeneral {
    display: flex;
    flex-direction: row;
    align-items: center;
}

#compName {
    font-size: 50px;
}

.compInfo {
    font-size: 25px;
}

.compProp {
    font-size: 30px;
}

#infoComponent {
    padding: 80px;
}

#compImage {
    height: 450px;
    width: auto;
}

#deleteCompBTN {
    background-color: #ff0000;
}

#deleteCompBTN:hover {
    background-color: #960018;
}

/* #updateCompBTN {
    background-color: cyan;
}

#updateCompBTN:hover {
    background-color: blue;
} */


#grupButtonsModifyDeleteComp {}
</style>