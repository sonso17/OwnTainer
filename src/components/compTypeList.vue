<!-- 
      --Component CompTypeList--

      Propietats que rep:
      - compType

      Funcionalitat del component:
      - Aquest component serveix per a quan es va a seleccionar de l'input select de tots els tipus diferents de component a la vista de registrar component
      El que fa aquest Component és ser un option per al imput select que faci amb un tipus de component

-->

<template>
    <option :value="compType.ComponentTypeID">{{ compType.ComponentType}}</option>
  </template>
  
  <script>
  export default {
    name: "CompType",
    props: ["compType"],
  };
  </script>