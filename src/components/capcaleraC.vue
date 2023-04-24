<template>
  <div id="generalHeader">
    <img src="@/assets/LogoFinal.png" id="capLogo" @click="GotoHome()" />
    <img src="@/assets/lletresOntainer.png" id="capNomP" />

    <div id="UserInfo" v-if="posardades">
      <div>
        <div id="capNomUsuari" @click="GoToUserInfo"> {{ email }}</div>
        <!-- <div id="capRolUsuari">{{ apikey }}</div> -->
      </div>

      <img v-if="btnLogout" src="@/assets/logout.png" alt="" class="logout" @click="logout">

    </div>
    <button v-if="!btnLogout" @click="GoToLogIn" class="btLogIn">Log In / Register</button>

  </div>
</template>

<script>
// import router from "@/router";

export default {
  name: "capcaleraC",
  props: ["userID", "apikey", "email"],
  emits: ["logOut"],
  data() {
    return {
      // btnLogout: false
    }
  },
  computed: {
    btnLogout(){
      return (this.userID !="" && this.apikey!="")
    }
  },
  methods: {
    /*
       Function: GotoHome

           funcio que quan es crida, t'envia a la vista de llistaTasques
       */
    GotoHome() {
      this.$router.push("/");
    },
    GoToLogIn() {
      this.$router.push("/logIn");
    },
    GoToUserInfo() {
      // this.$router.push("/userInfo/" + this.userID);
      this.$router.push({ name: 'userInfo', params: { id: this.userID } });

    },
    /*
       Function: posardades()

           funcio que mira comproba si algú ha iniciat sessió i si és que si, guarda els valors en el data()
           
       */
    posardades() {
      // console.log(this.userID)
      if (sessionStorage.UserID  && sessionStorage.APIKEY) {
        this.btnLogout = true;
        // document.getElementById("capNomUsuari").innerHTML = sessionStorage.UserID;
        // console.log(this.btnLogout)
        return true;
      }
      else {
        this.btnLogout = false;
        return false;
      }
    },
    /*
    Function:

      funcio que borra les dades de sessio del navegador i redirigeix a l'usuari al formulari de login
    */
    logout() {
      sessionStorage.clear()
      this.$emit("logOut", { userID: "", apikey: "" });
      // this.btnLogout = false;
      this.$router.push("/")
    },
  },
  created() {
    // this.posardades()
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
  width: 171px;
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

.btLogIn {
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

.logout {
  width: 30px;
  height: 30px;
}

.logout:hover {
  cursor: pointer;
}

#capRolUsuari {
  /* margin: 10px; */
}
</style>
