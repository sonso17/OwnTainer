<template>
  <capcalera-c :userID="userID" :apikey="apikey" :email="userEmail"  @logOut="notifica"/> <!--l'emit logout vé de la capçalera-->
  <div id="contenidorGeneral">
    <router-view @logInOk="notifica"/><!--l'emit login vé de la vista log in-->
  </div>

  <peuPagina />
</template>
<script>
import CapcaleraC from './components/capcaleraC.vue';
import peuPagina from './components/peuPagina.vue';
export default {
  name: "App",
  components: { CapcaleraC, peuPagina },
  data() {
    return {
      userID: "",
      apikey: "",
      userEmail:""
    }
  },
  methods: {
    notifica(logInDades) {
      this.userID = logInDades.userID
      this.apikey = logInDades.apikey
      this.userEmail = logInDades.email
      console.log(this.userID)
      console.log(this.apikey)
      console.log(this.userEmail)
    }
  }
}

</script>

<style>
html {
  /* min-height: 100%; */
}

body {
  /* background-color: #86dc3d; */
  margin: 0;
  height: 100%;
}

#contenidorGeneral {
  /* height: 100%; */
  /* min-height: 100%;
  height: auto !important;
  height: 100%; */
  /* height:100vh; 
  margin:0; 
  display:flex; 
  flex-direction:column; */
  /* margin: 0 auto -4em; */
  /* padding-bottom: 50px; */
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  background-color: #86dc3d;
  display: flex;
  flex-direction: column;
  /* display: grid;
    grid-template-rows: auto 1fr auto;
    grid-template-columns: 100%; */
  min-height: 100vh;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
