<template>
    <div id="registerFormGeneral">
        <div id="FirstNameCamp">
            <div id="labelFN">
                <label for="FirstName">First Name</label>
            </div>
            <div id="inputFN">
                <input class="inputFirstName" id="inputFirstName" v-model="FirstName" type="text" name="FirstName">
            </div>
        </div>
        <div id="PasswdCamp">
            <div id="labelLN">
                <label for="LastName">Last Name</label>
            </div>
            <div id="inputLN">
                <input class="inputLastName" id="inputLastName" v-model="LastName" type="text" name="LastName">
            </div>
        </div>
        <div id="EmailCamp">
            <div id="labelE">
                <label for="Email">Email</label>
            </div>
            <div id="inputE">
                <input class="inputEmail" id="inputEmail" v-model="Email" type="email" name="Email">
            </div>
        </div>
        <div id="PasswdCamp1">
            <div id="labelP1">
                <label for="Passwd1">password</label>
            </div>
            <div id="inputP1">
                <input class="inputPasswd1" id="inputPasswd1" v-model="Passwd1" type="password" name="Passwd1">
            </div>
        </div>
        <div id="PasswdCamp2">
            <div id="labelP2">
                <label for="Passwd2">Re-type password</label>
            </div>
            <div id="inputP2">
                <input class="inputPasswd2" id="inputPasswd2" v-model="Passwd" type="password" name="Passwd2">
            </div>
        </div>
    </div>
</template>

<script>

</script>