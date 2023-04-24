<template>
    <div class="HComponent" @click="goToComponentInfo">
        <div>{{ HComp.componentName }}</div>
        <!-- <div>{{ HComp.componentId }}</div> -->

        <div> {{ HComp.props[0].value }}</div>
        <div> {{ HComp.props[1].value }}</div>

    </div>
</template>

<script>
export default {
    name: "hardwareComp",
    props: ["HComp"],
    methods: {
        goToComponentInfo(){
            this.$router.push("/oneComponent/" + this.HComp.componentId);
        }
    }
}
</script>

<style>
.HComponent {
    position: relative;
    border: 1px solid black;
    padding: 2em 1em;
    margin: 1em;
    top: 0px;
    left: 0px;
    height: 200px;
    width: 300px;
    text-align: center;
    border-radius: 20px;
    display: inline-block;
    background: rgb(2, 0, 36);
    background: linear-gradient(90deg, rgb(108, 209, 124) 0%, rgb(161, 26, 87) 51%, rgba(0, 212, 255, 1) 100%);
    cursor: pointer;
    transition: all 250ms;
}

.HComponent:hover {
    top: -10px;
    left: -10px;
    box-shadow: 15px 15px 15px lightgrey;
}
</style>