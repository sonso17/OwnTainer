<template>
    <div id="peuPaginaGeneral">
        <div id="peuPaginaC"><a href="https://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA</a> <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"> OwnTainer</a></div>
        <div id="peuPaginaC" @click="whoAmIRedirect()">Created by Aleix Poch</div>
    </div>
</template>

<script>
// import router from '@/router';
export default {
    name: "peuPagina",
    methods: {
        whoAmIRedirect() {
            this.$router.push("/whoAmI");
        }
    }
}
</script>

<style scoped>
#peuPaginaGeneral {
    color: #86dc3d;
    font-size: 20px;
    position: relative;
    bottom: 0px;
    height: 50px;
    width: 100%;
    margin-top: auto;
    /* top: 91%; */
    /* left: 0%; */
    background-color: #26580f;
}
</style>