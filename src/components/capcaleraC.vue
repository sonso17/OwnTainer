<!-- 
      --Component Capçalera--

      Propietats que rep:
      - userID 
      - user APIKEY
      - user Email

      Funcionalitat del component:
      - Aquest component comprova de si ha rebut les dades de sessió d'un usuari mitjançant emits i, si les ha rebut, 
      Mostrarà el correu de l'usuari i el botó de log out i si no en té, mostrarà un botó per a iniciar sessió

-->

<template>
  <div id="generalHeader">
    <img src="@/assets/LogoFinal.png" id="capLogo" @click="GotoHome()" />
    <img src="@/assets/lletresOntainer.png" id="capNomP" />

    <div id="UserInfo" v-if="posardades">
      <div>
        <button id="capNomUsuari" @click="mostrarMenuu"> {{ email }}</button>
      </div>

      <div v-if="mostrarMenu" id="myDropdown" class="dropdown-content">
        <a @click="GoToUserInfo">Profile</a>
        <a href="#about">About</a><!--go to mycomponents-->
      </div>

      <img v-if="btnLogout" src="@/assets/logout.png" alt="" class="logout" @click="logout">

    </div>
    <button v-if="!btnLogout" @click="GoToLogIn" class="btLogIn">Log In / Register</button>

  </div>
</template>

<script>
export default {
  name: "capcaleraC",
  props: ["userID", "apikey", "email"],
  emits: ["logOut"],
  data() {
    return {
      mostrarMenu: false
    }
  },
  computed: {
    btnLogout() {
      return (this.userID != "" && this.apikey != "")
    }
  },
  methods: {
    /*
       Function: GotoHome

           funcio que quan es crida, t'envia a la vista principal
       */
    GotoHome() {
      this.$router.push("/");
    },
    GoToLogIn() {
      this.$router.push("/logIn");
    },
    GoToUserInfo() {
      // funció que t'envia a la pàgina de user info amb els paràmetres de l'usuari
      this.$router.push({ name: 'userInfo', params: { id: this.userID } });

    },
    /*
       Function: posardades()

           funcio que mira comproba si algú ha iniciat sessió i si és que si, guarda els valors en el data()
           
       */
    posardades() {

      if (sessionStorage.UserID && sessionStorage.APIKEY) {
        this.btnLogout = true;
        return true;
      }
      else {
        this.btnLogout = false;
        return false;
      }
    },
    /*
    Function: logOut()

      funció que deixa buides les variables de sessió i notifica amb un emit de que ja no hi ha cap sessió activa
    */
    logout() {
      sessionStorage.clear()
      this.$emit("logOut", { userID: "", apikey: "" });
      // this.btnLogout = false;
      window.location.reload();
      this.$router.push("/")
    },

    mostrarMenuu() {
      // Cambiar el estado para mostrar u ocultar el menú
      this.mostrarMenu = !this.mostrarMenu;
    },
  },
  created() {
    this.posardades()
  },
};
</script>

<style>
#generalHeader {
  position: relative;
  display: flex;
  flex-direction: row;
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
  width: 171px;
  font-size: 25px;
}

#capLogo:hover {
  cursor: pointer;
}

#capNomP {
  position: relative;
  height: 100%;
  width: 250px;
  left: 15%;
}

.btLogIn {
  position: relative;
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

.logout {
  width: 30px;
  height: 30px;
}

.logout:hover {
  cursor: pointer;
}

@media only screen and (max-width: 500px) {
  #capNomP {
    position: relative;
    height: 100%;
    width: 250px;
    left: 0%;
  }
}
</style>
