<template>
    <div id="easterGeneral">
        <div id="t1">Congratulations!!</div>
        <div id="t2">You found an</div>
        <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ">
            <img src="../assets/easterEgg.gif">
        </a>
        
        <div id="t3">EASTER EGG!!</div>

        <button @click="GotoHome"> Go back</button>
    </div>
</template>
<script>
export default {
    name: "easterEgg",
    methods: {
        GotoHome() {
            this.$router.push("/");
        }
    }}
</script>
<style scoped>
#easterGeneral {
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: 100px;
}
</style>