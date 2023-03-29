<template>
    <div id="peuPaginaGeneral">
        <div id="peuPaginaC"><a href="https://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA</a> OwnTainer</div>
        <div id="peuPaginaC" @click="whoAmIRedirect()">Created by Aleix Poch</div>
    </div>
</template>

<script>
import router from '@/router';
export default {
    name: "peuPagina",
    methods: {
        whoAmIRedirect() {
            router.push("/whoAmI");
        }
    }
}
</script>

<style>
#peuPaginaGeneral {
    color: #86dc3d;
    font-size: 20px;
    position: relative;
    height: 28%;
    width: 100%;
    /* top: 91%; */
    left: 0%;
    background-color: #26580f;
}
</style>