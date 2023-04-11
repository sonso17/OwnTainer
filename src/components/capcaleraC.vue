<template>
  
  <div  id="generalHeader">
    <img src="@/assets/LogoFinal.png" id="capLogo" @click="GotoHome()" />
    <img src="@/assets/lletresOntainer.png" id="capNomP" /> 

    <div id="UserInfo">
      <div>
        <div id="capNomUsuari"> {{ userID }}</div>
        <div id="capRolUsuari">{{ apikey }}</div>
      </div>

      <img v-if="this.btnLogout === true" src="@/assets/logout.png" alt="" class="logout" @click="logout()">
      <button v-if="this.btnLogout === false" @click="GoToLogIn()" class="btLogIn">Log In / Register</button>
      
    </div>
  </div>
</template>

<script>
import router from "@/router";

export default {
  name: "capcaleraC",
  props: ["infoUsuari", "userID", "apikey"],
  data(){
    return {
      btnLogout: false
    }
  },
  methods: {
     /*
        Function: GotoHome

            funcio que quan es crida, t'envia a la vista de llistaTasques
        */
    GotoHome() {
      router.push("/");
    },
    GoToLogIn() {
      router.push("/logIn");
    },
     /*
        Function: posardades()

            funcio que mira comproba si algú ha iniciat sessió i si és que si, guarda els valors en el data()
            
        */
    posardades(){
      if (sessionStorage.UserID && sessionStorage.APIKEY)
      {
      this.btnLogout = true;
      console.log(this.btnLogout)
      }
    },
    /*
    Function:

      funcio que borra les dades de sessio del navegador i redirigeix a l'usuari al formulari de login
    */
    logout(){
      sessionStorage.clear()
      this.$emit("userID", "")
      this.$emit("apikey", "")
      this.btnLogout = false;
      router.push("/")
    },
  },
  created(){
    this.posardades()
  },
  

};
</script>

<style>
#generalHeader {
  position: relative;
  display: flex;
  /* padding: 22px; */
  justify-content: space-around;
  background: #26580f;
  color: white;
  font-size: 25px;
  align-items: center;
  height: 120px;
}

#capLogo {
  position: relative;
  height: 90px;
  width:171px;
  font-size: 25px;
  left: -9%;
}
#capLogo:hover {
  cursor: pointer;
}
#capNomP {
  position: relative;
  height: 100%;
  width: 250px;
  left: -20%;
}
.btLogIn{
  position: relative;
  left: -10%;
}

#UserInfo {
  position: relative;
  height: 100%;
  width: 250px;
  font-size: 25px;
  display: flex;
  justify-content: center;
  text-align: center;
  align-items: center;
  align-content: center;
  justify-content: space-around;
}
.logout{
width:30px;
height: 30px;
}
.logout:hover{
  cursor: pointer;
}
#capRolUsuari{
/* margin: 10px; */
}
</style>
