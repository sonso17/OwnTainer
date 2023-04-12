<template>
    <div id="componentsHardware">
        <hardwareComponent v-for="(HComponent, i) in componentsJSON" :key="i" :HComp="HComponent">
        
        </hardwareComponent>
    </div>
</template>
<script>
import axios from 'axios';
import hardwareComponent from '../components/hardwareComponent.vue';

export default {
    name: 'paginaPrincipal',
    components: {hardwareComponent},
    data() {
        return {
            componentsJSON: {},
        }
    },
    methods: {
        getPublicComponents() {
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/selectPublicComponents").then(resultat => {
                this.componentsJSON = resultat.data
                console.log(resultat.data)
            });
        }

    },
    created() {
        this.getPublicComponents();
    }

}
</script>

<style scoped>
div{
    /* padding: 2rem; */
    /* display: flex; 
    flex-direction: column; 
    min-height: 100vh;
    min-height: 100svh; */
}
</style>