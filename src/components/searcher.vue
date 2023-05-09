<template>
    <div>
        <input type="text" id="search" v-model="search">
    </div>
</template>

<script>
export default {
    name: "searchBar",
    data() {
        return {
            search: ""
        }
    },
    watch: {
        search() {
            this.$emit("newSearch", this.search)//un cop es modifica l'input, es va emitint per el newSearch
        }
    }
}
</script>

<style>
#search {
    font-size: 1.5em;
    padding: 0.5em;
    text-align: center;
    border-radius: 1em;
    border: 2px black solid;
    width: 55%;
}
</style>