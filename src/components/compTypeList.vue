<template>
    <option :value="compType.ComponentTypeID">{{ compType.ComponentType}}</option>
  </template>
  
  <script>
  export default {
     /*
          Function: getUsuaris()
  
              agafa i per cada usuari genera un option passant-li el nom i l'ID
      */
    name: "CompType",
    props: ["compType"],
  };
  </script>