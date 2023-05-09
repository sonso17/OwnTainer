<template>
    <div class="HComponent" @click="goToComponentInfo">
        <div>Component Name: {{ HComp.componentName }}</div>
        <!-- <div>{{ HComp.componentId }}</div> -->

        <div> {{ HComp.props[0].name }}: {{ HComp.props[0].value }}</div>
        <div> {{ HComp.props[1].name }}: {{ HComp.props[1].value }}</div>
        <img id="imatgeTodd" @click.stop="goToEasterEgg" :src="randomImage()" alt="imatge">
    </div>
</template>

<script>
export default {
    name: "hardwareComp",
    props: ["HComp"],
    methods: {
        goToComponentInfo() {
            this.$router.push("/oneComponent/" + this.HComp.componentId);
        },
        goToEasterEgg() {
            this.$router.push("/easterEgg");
        },
        randomImage() {
            var arrayMemes = ['shrekmeme.jpg'
                , 'meme2.jpg', 'meme3.jpg', 'meme4.jpg', 'meme5.jpg', 'meme6.jpg', 'meme7.jpg']
            var memeRNd = arrayMemes[Math.floor(Math.random() * arrayMemes.length)];
            console.log(memeRNd)
            var memeRND1 = require("@/assets/memes/" + memeRNd);
            return memeRND1;
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
    background: linear-gradient(90deg, #26580f 0%, rgb(108, 209, 124) 51%, #26580f 100%);
    cursor: pointer;
    transition: all 250ms;
}

.HComponent:hover {
    top: -10px;
    left: -10px;
    box-shadow: 15px 15px 15px lightgrey;
}

#imatgeTodd {
    height: 159px;
    width: 261px;
}
</style>