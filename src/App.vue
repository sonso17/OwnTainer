<template>
  <capcalera-c />
  <router-view>

  </router-view>
  <peuPagina />
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/about">About</router-link>
  </nav>
</template>
<script>
import CapcaleraC from './components/capcaleraC.vue';
import peuPagina from './components/peuPagina.vue';
export default {
  name: "App",
  components: { CapcaleraC, peuPagina}
  // data() {
  //   return {
  //     diaList: {}
  //   }
  // },
  // methods: {
  //   getDia() {
  //     axios.get("http://localhost/API/server.php")
  //       .then(resultat => this.diaList = resultat.data)
  //   }
  // },
  // created() {
  // }
}

</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
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
