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
      userEmail:"",
      boolSessio: false
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
    },
    
      comprovarSessio() {
            if (sessionStorage.UserID && sessionStorage.APIKEY && sessionStorage.userEmail) {
                this.userID = sessionStorage.UserID;
                this.apikey = sessionStorage.APIKEY;
                this.userEmail = sessionStorage.userEmail;
                this.boolSessio = true;
                var logInDades = { userID: this.userID, apikey: this.apikey, email: this.userEmail }
                this.notifica(logInDades)
            }
            else {
                console.log("entra")
                this.boolSessio = false;
            }
        }
  },
  created(){
    this.comprovarSessio()
  }
}

</script>

<style>
button {
  background-color: #4CAF50; /* Green */
  border: 2px solid black;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}

button:hover{
  background-color: #26580f;
}

html {
  /* min-height: 100%; */
}

body {
  /* background-color: #86dc3d; */
  margin: 0;
  height: 100%;
}

label{
  font-family: 'Roboto', sans-serif;
  font-size: 1.2rem;
  margin-left: 2rem;
  margin-top: 0.7rem;
  display: block;
  transition: all 0.3s;
  transform: translateY(0rem);
}

input{
  font-family: 'Roboto', sans-serif;
  color: #333;
  font-size: 1.2rem;
	margin: 0 auto;
  padding: 1.5rem 2rem;
  border-radius: 0.2rem;
  background-color: rgb(255, 255, 255);
  border: 2px solid black;
  width: 70%;
  display: block;
  border-bottom: 0.3rem solid transparent;
  transition: all 0.3s;
}
input::placeholder{
  opacity: 0;
  visibility: hidden;
  -webkit-transform: translateY(-4rem);
  transform: translateY(-4rem);
}

select{
  background-color: #4CAF50;
  color: white;
  padding: 12px;
  width: 200px;
  border: 2px solid black;
  font-size: 20px;
  box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
  -webkit-appearance: button;
  appearance: button;
  outline: none;
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
