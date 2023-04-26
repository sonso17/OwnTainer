<template>
    register Component

    <select v-model="componentTypeSelect" @change="getComponentProperties" id="componentTypeSelect">
        <compTypeList v-for="(compType, i) in compTypesJSON" :key="i" :compType = "compType"></compTypeList>
    </select>

    <br>
    {{ compPropsJSON }}
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
            componentTypeSelect: "",
            compTypesJSON: {},
            compPropsJSON: {}
        }
    },
    methods: {
        getAllComponentType() {
            axios.get("http://owntainer.daw.institutmontilivi.cat/API/getAllComponentType")
                .then(resultat => {
                    this.compTypesJSON = resultat.data
                    console.log(resultat.data)
                });
        },
        getComponentProperties(){

            axios.get("http://owntainer.daw.institutmontilivi.cat/API/getComponentProperties/" + this.componentTypeSelect)
                .then(resultat => {
                    this.compPropsJSON = resultat.data
                    console.log(resultat.data)
                });
        },
        enviarDadesComponent() {
            
        }
    },
    created() {
        this.getAllComponentType()
    }
}
</script>