<template>
    <div>
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