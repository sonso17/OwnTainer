<template>
    <Searcher id="searcher" @newSearch="updateSearch"> </Searcher>
    <div id="componentsUsuari" v-if="boolSessio">

        <div id="grupBotons">
            <button id="btnGoToRegisterComponent" @click="goToRegisterComponent"> Register A new Component</button>
            <button @click="goToNewCompType">New Component Type</button><br>
        </div>
        <div id="compUserTitol">User Components</div>
        <hardwareComponent v-for="(HComponent, i) in componentsUserJSON" :key="i" :HComp="HComponent">

        </hardwareComponent>
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
            componentsUserJSON: {},
            boolSessio: false,
            userID: "",
            apikey: "",
            searchTerm: ""
        }
    },
    methods: {
        comprovarSessio() {
            if (sessionStorage.UserID && sessionStorage.APIKEY) {
                this.userID = sessionStorage.UserID;
                this.apikey = sessionStorage.APIKEY;
                this.boolSessio = true;
                this.getUserComponents();
                return true;
            }
            else {
                this.boolSessio = false;
                return false;
            }
        },
        getUserComponents() {
            axios.get("https://localhost/API/" + this.apikey + "." + this.userID + "/SelectUserComponents/" + this.userID)
                .then(resultat => {
                    this.componentsUserJSON = resultat.data
                    // console.log(resultat.data)
                });
        },
        updateSearch(term) {
            this.searchTerm = term;
            // console.log(this.searchTerm)
            if (this.comprovarSessio) {//si no hi ha seesió, cridar la funcio selectPublicComponentsByValue

                axios.post("https://localhost/API/" + this.apikey + "." + this.userID + "/selectUserComponentsByValue/",
                    {
                        "data": [
                            {
                                "SearchWord": this.searchTerm

                            }
                        ]
                    }
                ).then((response) => {
                    this.componentsUserJSON = response.data;
                    // console.log(response.data);
                }).catch(error => {
                    const message = error.response.data;
                    console.log(`Error message: ${message}`);
                })
            }
        },

    },
    created() {
        this.comprovarSessio(),
        this.getUserComponents()
    }


}

</script>