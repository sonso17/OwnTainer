<template>
    <div id="componentsHardware">
        <Searcher @newSearch="updateSearch"> </Searcher>
        <div id="componentsUsuari" v-if="boolSessio">
            <div id="compUserTitol">Components Usuari</div>
                <hardwareComponent v-for="(HComponent, i) in componentsUserJSON" :key="i" :HComp="HComponent">

                </hardwareComponent>
        </div>

        <div id="componentsPublics">
            <div id="compPublicTitol">Components Publics</div>
                <hardwareComponent v-for="(HComponent, i) in componentsPublicsJSON" :key="i" :HComp="HComponent">

                </hardwareComponent>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import hardwareComponent from '../components/hardwareComponent.vue';
import Searcher from '@/components/searcher.vue';

export default {
    name: 'paginaPrincipal',
    components: { hardwareComponent, Searcher },
    data() {
        return {
            componentsPublicsJSON: {},
            componentsUserJSON: {},
            boolSessio: false,
            userID: "",
            apikey: "",
            searchTerm:""
        }
    },
    methods: {
        getPublicComponents() {
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/selectPublicComponents").then(resultat => {
                this.componentsPublicsJSON = resultat.data
                console.log(resultat.data)
            });
        },
        comprovarSessio() {
            if (sessionStorage.UserID && sessionStorage.APIKEY) {
                this.userID = sessionStorage.UserID;
                this.apikey = sessionStorage.APIKEY;

                this.boolSessio = true;
                // console.log("entra")
                this.getUserComponents();

                return true;
                //cridar getuserInfo
            }
            else {
                // console.log("entra")
                this.boolSessio = false;
                return false;
            }
        },
        getUserComponents() {
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/SelectUserComponents/" + this.userID)
                .then(resultat => {
                    this.componentsUserJSON = resultat.data
                    console.log(resultat.data)
                });
        },
        updateSearch(term){
            this.searchTerm = term;
            if(!this.comprovarSessio){
                this.getPublicComponents
            }
            else{
                this.getPublicComponents
                this.getUserComponents
            }


        }
    },
    created() {
        this.getPublicComponents(),
            this.comprovarSessio()
    }

}
</script>

<style scoped>
div {
    /* padding: 2rem; */
    /* display: flex; 
    flex-direction: column; 
    min-height: 100vh;
    min-height: 100svh; */
}
</style>