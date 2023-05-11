<!-- 
      --Vista Principal--

      Propietats que rep:

      Emits que fa:

      Funcionalitat del component:
      - Fa una petició post dels components públic i els de l'usuari(si hi ha una sessió activa) i els mostra un per un en format fitxa

-->
<template>
    <div id="componentsHardware">
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

        <div id="componentsPublics">
            <div id="compPublicTitol">Public Components</div>
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
            searchTerm: ""
        }
    },
    methods: {
        //Funció que fa agafa la informació dels components públics
        getPublicComponents() {
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/selectPublicComponents").then(resultat => {
                this.componentsPublicsJSON = resultat.data
                console.log(resultat.data)
            });
        },
        //funció que comproba si hi ha una sessió activa
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
        //funció que fa una petició GET dels components d'aquell usuari
        getUserComponents() {
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/SelectUserComponents/" + this.userID)
                .then(resultat => {
                    this.componentsUserJSON = resultat.data
                    console.log(resultat.data)
                });
        },
        // funció que rep la cerca del component searcher i fa la petició de la combinacio de caràcters que hi hagi al cercador
        updateSearch(term) {
            this.searchTerm = term;
            console.log(this.searchTerm)

            axios.post('http://owntainer.daw.institutmontilivi.cat/API/selectPublicComponentsByValue',
                {
                    "data": [
                        {
                            "SearchWord": this.searchTerm

                        }
                    ]
                }
            ).then((response) => {
                this.componentsPublicsJSON = response.data;
                console.log(response.data);
            }).catch(error => {
                const message = error.response.data;
                console.log(`Error message: ${message}`);
            })

            if (this.comprovarSessio) {//si no hi ha seesió, cridar la funcio selectPublicComponentsByValue

                axios.post("http://owntainer.daw.institutmontilivi.cat/API/" + this.apikey + "." + this.userID + "/selectUserComponentsByValue/",
                    {
                        "data": [
                            {
                                "SearchWord": this.searchTerm

                            }
                        ]
                    }
                ).then((response) => {
                    this.componentsUserJSON = response.data;
                    console.log(response.data);
                }).catch(error => {
                    const message = error.response.data;
                    console.log(`Error message: ${message}`);
                })
            }
        },
        goToRegisterComponent() {
            this.$router.push("/registerComponent");
        },
        goToNewCompType() {
            this.$router.push("/newComponentType");
        }
    },
    created() {
        this.getPublicComponents(),
            this.comprovarSessio()
    }

}
</script>

<style scoped>
#searcher {}

#compUserTitol {
    font-size: 60px;
}

#compPublicTitol {
    font-size: 60px;

}

#grupBotons {
    position: relative;
    align-items: center;
    padding: 30px;
}

#btnGoToRegisterComponent {}

@media only screen and (max-width: 500px) {
    #grupBotons {}
}
</style>