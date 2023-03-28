<template>
  
  <div  id="capcaleraGeneral">
    <img src="@/assets/LogoFinal.png" id="capLogo" @click="GotoHome()" />
    <!-- <img src="@/assets/girotaskLletres.png" id="capNomP" />  -->

    <div id="capInfoUsuari">
      <div>
        <div id="capNomUsuari"> {{ usuari }}</div>
        <div id="capRolUsuari">{{ Rol }}</div>
      </div>
      <img  :hidden="!(this.usuari)" src="@/assets/logout.png" alt="" class="logout" @click="logout()">
    </div>
  </div>
</template>

<script>
import router from "@/router";

export default {
  name: "capcaleraC",
  props: ["infoUsuari"],
  data(){
    return {
      Rol: "",
      usuari: ""
    }
  },
  methods: {
     /*
        Function: GotoHome

            funcio que quan es crida, t'envia a la vista de llistaTasques
        */
    GotoHome() {
      router.push("/LlistaTasques");
    },
     /*
        Function: posardades()

            funcio que mira si l'usuari que ha iniciat sessió és admin o gestor i guarda els valors en el data()
            
        */
    posardades(){
      if (sessionStorage.Rol && sessionStorage.usuari)
      {
      this.Rol=  sessionStorage.Rol;
      this.usuari = sessionStorage.usuari 
      }
    },
    /*
    Function:

      funcio que borra les dades de sessio del navegador i redirigeix a l'usuari al formulari de login
    */
    logout(){
      this.Rol = null
      this.usuari = null;
      sessionStorage.clear()
      
      router.push("/")
    },
  },
  created(){
    this.posardades()
  }
};
</script>

<style>
#capcaleraGeneral {
  position: relative;
  display: flex;
  /* padding: 22px; */
  justify-content: space-around;
  background: #fe7373;
  color: white;
  font-size: 25px;
  align-items: center;
}

#capLogo {
  position: relative;
  height: 90px;
  width: 90px;
  font-size: 25px;
}
#capLogo:hover {
  cursor: pointer;
}
#capNomP {
  position: relative;
  height: 100%;
  width: 250px;
}

#capInfoUsuari {
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
