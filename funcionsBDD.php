<?php
include 'connexioBDD.php';
// $resultat = null;
// $baseDades = new BdD;

/*
        Function: userValidation()

            Funció que passant-li una API-KEY et retorna ture o flase si ha trobat un usuari o no amb aquesta

        Parameters:

            $APIKEY - API-KEY de l'usuari 

        Returns:

            Retorna TRUE si ha trobat un usuari amb la API-KEY passada

            Retorna FALSE si no ha trobat cap usuari amb l'API-KEY passada o algo de la cosulta ha fallat
 
    */
function UserValidation($UserApiKey, $userID)
{
    $baseDades = new BdD; //creo nova classe BDD

    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $senteciSQL = "SELECT UserID, APIKEY FROM users WHERE `APIKEY` = :APIKEY AND `UserID` = :UserID";

        $bdd = $conn->prepare($senteciSQL);
        $bdd->bindParam("APIKEY", $UserApiKey); //aplico els parametres necessaris
        $bdd->bindParam("UserID", $userID); //aplico els parametres necessaris
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $resultat = $bdd->fetchAll(); //guardo els resultats

        if (count($resultat) == 1) { // si ha trobat un usuari
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

/*
        Function: registerUser()

            Funcio que amb els paràmetres passats, els guarda a la taula d'usuaris creant un nou usuari

        Parameters:

            $UserName - nom d'usuari

            $UserLastName - cognom d'usuari
    
            $UserEmail - email d'usuari

            $passwd - password usuari
 
    */
function registerUser($Firstname, $LastName, $UserEmail, $passwd)
{
    $baseDades = new BdD; //creo nova classe BDD

    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $ApikeyG = generarApiKey();

        $sentenciaSQL = "INSERT INTO users (FirstName, LastName, email, passwd, APIKEY)
    VALUES (:FirstName, :LastName, :email, :passwd, :APIKEY);";

        $bdd = $conn->prepare($sentenciaSQL);
        $bdd->bindParam("FirstName", $Firstname);
        $bdd->bindParam("LastName", $LastName);
        $bdd->bindParam("email", $UserEmail);
        $bdd->bindParam("passwd", $passwd);
        $bdd->bindParam("APIKEY", $ApikeyG);

        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        // $resultat = $bdd->fetchAll(); //guardo els resultats
        // echo $resultat;
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

/*
        Function: generarApiKey()

            Funció que genera una api key a partir de valors aleatoris

        Parameters:

            $length - aquesta variable es la que diu de quants caràcters serà l'APIkey

        Returns:

            retorna l'apiKey generada

    */
function generarApiKey($length = 15) // Funciona OK
{
    //combinació de caràcters 0-9Aa
    $caracters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0987654321';
    //guardo el nombre de caràcters
    $numCaracters = strlen($caracters);
    $apiKey = '';
    //faig un bucle on va escollint caracters aleatoris fins arribar a 15 caracters total
    for ($i = $length; $i > 0; $i--) {
        $apiKey .= $caracters[rand(0, $numCaracters - 1)];
    }
    //retorno l'apiKey
    return $apiKey;
}

/*
        Function: LogIn()

            Funció que passant-li un usuari i una contrassenya et retorna el seu ID i API-KEY

        Parameters:

            $UserEmail - Variable amb el valor del correu de l'usuari

            $passwd - Variable amb la contrassenya de l'usuari

        Returns:

            Retorna l'Ud d'usuari i la seva API-KEY

    */
function LogIn($UserEmail, $passwd)
{

    $baseDades = new BdD; //creo nova classe BDD

    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $senteciSQL = "SELECT UserID, APIKEY FROM users WHERE `email` = :email AND `passwd` = :passwd";

        $bdd = $conn->prepare($senteciSQL);
        $bdd->bindParam("email", $UserEmail); //aplico els parametres necessaris
        $bdd->bindParam("passwd", $passwd);
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $resultat = $bdd->fetchAll(); //guardo els resultats

        if (count($resultat) == 1) { // si ha trobat un usuari
            return $resultat;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

/*
        Function: selectOneUser()

            Funció que passant-li una API-KEY et retorna ture o flase si ha trobat un usuari o no amb aquesta

        Parameters:

            $UserID - Identificador d'aquell usuari

            $APIKEY - API-KEY d'aquell Usuari

        Returns:

            Retorna tota la informació d'aquell usuari

            Si no ha trobat cap usuari retornarà un missatge d'error
 
    */
function selectOneUser($APIKEY, $UserID)
{

    $baseDades = new BdD; //creo nova classe BDD

    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $senteciSQL = "SELECT * FROM users WHERE `UserID` = :UserID AND `APIKEY` = :APIKEY";

        $bdd = $conn->prepare($senteciSQL);
        $bdd->bindParam("UserID", $UserID); //aplico els parametres necessaris
        $bdd->bindParam("APIKEY", $APIKEY);
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $resultat = $bdd->fetchAll(); //guardo els resultats

        if (count($resultat) == 1) { // si ha trobat un usuari
            return $resultat;
        } else { //no ha trobat cap usuari
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

/*
        Function: modifyUser()

            Funcio que amb els paràmetres passats, modifica l'usuari que tingui l'identificador passat

        Parameters:

            $UserName - nom d'usuari

            $UserLastName - cognom d'usuari
    
            $UserEmail - email d'usuari

            $passwd - password usuari

            $identificador - UserID

        Returns:

            Retorna true si el update s'ha fet correctament i false si algo ha fallat
 
    */

function modifyUser($Firstname, $LastName, $UserEmail, $passwd, $identificador, $apikey)
{
    $baseDades = new BdD; //creo nova classe BDD

    try {
        // var_dump(selectOneUser($apikey, $identificador));
        if (UserValidation($apikey, $identificador)) { //valido de que la modificació de l'usuari, sigui el mateix usuari a modificar
            $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sentenciaSQL = "UPDATE users
            SET FirstName = :FirstName, LastName = :LastName, email = :email, passwd = :passwd WHERE UserID = :UserID";

            $bdd = $conn->prepare($sentenciaSQL);
            $bdd->bindParam("FirstName", $Firstname);
            $bdd->bindParam("LastName", $LastName);
            $bdd->bindParam("email", $UserEmail);
            $bdd->bindParam("passwd", $passwd);
            $bdd->bindParam("UserID", $identificador);

            $bdd->execute(); //executola sentencia
            $bdd->setFetchMode(PDO::FETCH_ASSOC);
            // $resultat = $bdd->fetchAll(); //guardo els resultats
            // echo $resultat;
            return true;
        } else { //retorna aixo si un usuari amb id 5 intenta modificar un altre amb
            echo "this user is not yours, cannot modify it ";
        }
        // $selectUser = selectOneUser($apikey,$identificador);
        // var_dump($selectUser);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

/*
        Function: getComponentProperties()

            Funcio que passant-li un identificador de tipus de component, et retorna totes les propietats que necessita

        Parameters:

            $ComponentTypeID - Identificador de tipus de component

        Returns:

            Retorna totes les propietats que té aquell component
 
    */
function getComponentProperties($componentTypeID)
{

    $baseDades = new BdD; //creo nova classe BDD

    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //faig una sentencia on selecciono per cada propietat el id de tipus, nom tipus component, idPropietat, nomPropietat i propietat tipus fent 2 joins, un a cada taula on haig d'extreure la informacio
        $sentencia = "
                    SELECT componenttype.ComponentTypeID, componenttype.ComponentType, properties.propertyID, properties.PropertyName, properties.UnitType
                    FROM componenttypexproperties
                    RIGHT JOIN componenttype ON componenttypexproperties.ComponentTypeID = componenttype.ComponentTypeID
                    LEFT JOIN properties on componenttypexproperties.PropertyID = properties.PropertyID
                    WHERE componenttype.ComponentTypeID = :ComponentTypeID;
            ";

        $bdd = $conn->prepare($sentencia);
        $bdd->bindParam("ComponentTypeID", $componentTypeID); //aplico els parametres necessaris
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $resultat = $bdd->fetchAll(); //guardo els resultats

        return $resultat;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

/*
        Function: selectOneComponent()

            Funcio que passant-li un identificador d'un component et retorna tota la seva informació

        Parameters:

            $ComponentTypeID - Identificador de tipus de component

        Returns:

            Retorna totes les propietats que té aquell component
 
    */
function selectOneComponent($componentID, $UserID)
{

    $baseDades = new BdD; //creo nova classe BDD
    // echo $componentID;
    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //faig una sentencia on selecciono per cada propietat el id de tipus, nom tipus component, idPropietat, nomPropietat i propietat tipus fent 2 joins, un a cada taula on haig d'extreure la informacio
        $sentencia = "
            SELECT components.UserID, components.Privacy, components.ComponentName, components.ComponentID, properties.PropertyID,properties.PropertyName, propertiesxcomponents.Valuee
            FROM propertiesxcomponents
            RIGHT JOIN components ON propertiesxcomponents.ComponentID =  components.ComponentID
            LEFT JOIN properties ON propertiesxcomponents.PropertyID = properties.PropertyID
            WHERE components.componentID = :ComponentID;
            ";

        $bdd = $conn->prepare($sentencia);
        $bdd->bindParam("ComponentID", $componentID); //aplico els parametres necessaris
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $resultat = $bdd->fetchAll(); //guardo els resultats


        $UserIdComponent = $resultat[0]['UserID'];
        $ComponentPrivacy = $resultat[0]['Privacy'];

        if ($UserIdComponent == $UserID || $ComponentPrivacy == 'false') { //si el usuari és propietari del component o el component és públic
            return $resultat;
        } else {
            return false;
        }
        // echo $resultat[];


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

/*
        Function: selectPublicComponents()

            Funcio que ens retorna tots els components que son públics

        Returns:

            Retorna tots els components públics en format JSON ordenat i estructurat
 
    */
function selectPublicComponents()
{

    $baseDades = new BdD; //creo nova classe BDD

    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sentencia = "
            SELECT components.UserID, components.Privacy, components.ComponentName, components.ComponentID, properties.PropertyID,properties.PropertyName, propertiesxcomponents.Valuee
            FROM propertiesxcomponents
            RIGHT JOIN components ON propertiesxcomponents.ComponentID =  components.ComponentID
            LEFT JOIN properties ON propertiesxcomponents.PropertyID = properties.PropertyID
            WHERE components.Privacy = 'false'
            ORDER BY components.ComponentID ASC;
            ";

        $bdd = $conn->prepare($sentencia);
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $resultat = $bdd->fetchAll(); //guardo els resultats

        //carrego dos arrays buits 
        $arrAllComp = []; //en aquest hi guardaré tota la informació de cada component que hi vagi guardant(array general)
        $arrComProp = []; //en aquest hi guardare totes les propietats de cada component
        $arrIdsComps = []; //array unicament d'IDs

        foreach ($resultat as $i) { //aquest foreach serveix unicament per a guardar els IDs de cada component

            $idCom = $i['ComponentID']; //agafo l'id

            if (!in_array($idCom, $arrIdsComps)) { //comprovo de que el id no estigui repetit, in_array ens diu si el valor passat està a dins de l'array
                array_push($arrIdsComps, $idCom); //si no esta repetit, el guardo
            }
        }

        $lenId = sizeof($arrIdsComps); //aquest lenID de lengthID, ens guarda la longitud de tots els IDs guardats 
        for ($i = 0; $i < $lenId; $i++) { //iterem tots els IDs 

            $privacy = ''; //resetejo tots els valors buits per no anar acumulant el seguent component
            $componentName = '';
            $arrayTotUnComponent = [];
            $arrComProp = [];

            foreach ($resultat as $el) { //iterem tota la consulta(ja que hi han moltes files amb el mateix componentID)

                $idCom = $el['ComponentID']; //ectrec el idComponent de l'iteració del moment
                if ($idCom == $arrIdsComps[$i]) { //si el idCom és igual al valor de la posició de l'array d'IDs

                    $arrayProp = array( //guarden les propietats del ID trobat a l'array indexat
                        "name" => $el['PropertyName'],
                        "value" => $el['Valuee']
                    );

                    array_push($arrComProp, $arrayProp); //guardem les propietats de cada component
                    $privacy = $el['Privacy']; //extrec la privacitat i componentNom
                    $componentName = $el['ComponentName'];
                }
            }
            $arrayTotUnComponent = array( //agafo les propietats no variables de cada component a l'array indexat i els hi aplico
                "componentId" => $arrIdsComps[$i],
                "componentName" => $componentName,
                "privacy" => $privacy,
                "props" => $arrComProp
            );
            +array_push($arrAllComp, $arrayTotUnComponent); //aquest array.push representa un push de tot un component
        }

        return $arrAllComp;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

/*
        Function: selectUserComponents()

            Funcio que passant-li un identificador d'un usuari et retorna tots els seus components

        Parameters:

            $UserID - Identificador d'usuari

        Returns:

            Retorna tots els components d'aquell usuari
 
    */
function selectUserComponents($userID)
{
    $baseDades = new BdD; //creo nova classe BDD
    // echo $userID;
    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sentencia = "
            SELECT components.UserID, components.Privacy, components.ComponentName, components.ComponentID, properties.PropertyID,properties.PropertyName, propertiesxcomponents.Valuee
            FROM propertiesxcomponents
            RIGHT JOIN components ON propertiesxcomponents.ComponentID =  components.ComponentID
            LEFT JOIN properties ON propertiesxcomponents.PropertyID = properties.PropertyID
            WHERE components.UserID = :UserID
            ORDER BY components.ComponentID ASC;
            ";

        $bdd = $conn->prepare($sentencia);
        $bdd->bindParam("UserID", $userID); //aplico els parametres necessaris
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $resultat = $bdd->fetchAll(); //guardo els resultats

        // return $resultat;
        //carrego dos arrays buits 
        $arrAllComp = []; //en aquest hi guardaré tota la informació que hi vagi guardant(array general)
        $arrComProp = []; //en aquest hi guardare totes les propietats de cada component

        $arrIdsComps = []; # iterar valors query sql

        foreach ($resultat as $i) { //aquest foreach serveix unicament per a guardar els IDs de cada component

            $idCom = $i['ComponentID']; //agafo l'id

            if (!in_array($idCom, $arrIdsComps)) { //comprovo de que el id no estigui repetit

                array_push($arrIdsComps, $idCom); //si no esta repetit, el guardo
            }
        }

        $lenId = sizeof($arrIdsComps); //aquest lenID ens guarda la longitud de tots els IDs guardats 
        for ($i = 0; $i < $lenId; $i++) { //iterem tots els IDs

            $privacy = ''; //resetejo tots els valors buits per el seguent component
            $componentName = '';
            $arrayTotUnComponent = [];
            $arrComProp = [];

            foreach ($resultat as $el) { //iterem tota la consulta(ja que hi han moltes files amb el mateix componentID)

                $idCom = $el['ComponentID'];
                if ($idCom == $arrIdsComps[$i]) { //si el idCom és igual al valor de la posició de l'array d'IDs
                    // 
                    $arrayProp = array( //guarden les propietats del ID trobat a l'array indexat
                        "name" => $el['PropertyName'],
                        "value" => $el['Valuee']
                    );

                    array_push($arrComProp, $arrayProp); //guardem les propietats de cada component
                    $privacy = $el['Privacy'];
                    $componentName = $el['ComponentName'];
                }
            }
            $arrayTotUnComponent = array( //agafo les propietats no variables de cada component a l'array indexat
                "componentId" => $arrIdsComps[$i],
                "componentName" => $componentName,
                "privacy" => $privacy,
                "props" => $arrComProp
            );
            array_push($arrAllComp, $arrayTotUnComponent); //aquest array.push representa tot un component
        }

        return $arrAllComp;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

/*
        Function: registerComponent()

            Funcio que amb els valors passats, registra un component a la BDD

        Parameters:

            Propietats dels components + els valors a inserir

        Returns:

            Retorna true si el component s'ha inserit correctament o false si algo ha fallat
 
    */
function registerComponent($componentDades, $userID)
{
    // var_dump($componentDades);
    // echo $userID;
    //separo les dades a inserir a la taula Components
    $componentName = $componentDades['data']['ComponentName'];
    $componentType = $componentDades['data']['ComponentType'];
    $componentPrivacy = $componentDades['data']['privacy'];

    $componentProps = []; //array on vaig guardant els valors de les propietats dels components
    $componentPropsNumber = []; //array on hi vaig guardant els IDs de les propietats dels components

    $dataArrayLength = sizeof($componentDades['data']['props']);

    for ($i = 0; $i < $dataArrayLength; $i++) { //Bucle on vaig guardant cada informació al seu lloc
        array_push($componentProps, $componentDades['data']['props'][$i]['prop_val']);
        array_push($componentPropsNumber, $componentDades['data']['props'][$i]['prop_id']);
    }

    //inserció de dades a la taula de components
    $baseDades = new BdD; //creo nova classe BDD
    try {
        $boolEstat = true;
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sentenciaTComponent =
            "
        INSERT INTO components (UserID, ComponentName, ComponentTypeID, privacy)
        VALUES (:UserID, :ComponentName, :ComponentTypeID, :privacy);
        ";

        $bdd = $conn->prepare($sentenciaTComponent);
        $bdd->bindParam("UserID", $userID); //aplico els parametres necessaris
        $bdd->bindParam("ComponentName", $componentName);
        $bdd->bindParam("ComponentTypeID", $componentType);
        $bdd->bindParam("privacy", $componentPrivacy);
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $resultatTC = $bdd->fetchAll(); //guardo els resultats

        if ($boolEstat == true) { //si la inserció s'ha fet correctament, farem un select del component recent incerit
            $senteciaCompID =
                "
            SELECT ComponentID 
            FROM components 
            WHERE UserID = :UserID AND ComponentName = :ComponentName AND ComponentTypeID = :ComponentTypeID AND Privacy = :privacy
            ";
            $bdd = $conn->prepare($senteciaCompID);
            $bdd->bindParam("UserID", $userID); //aplico els parametres necessaris
            $bdd->bindParam("ComponentName", $componentName);
            $bdd->bindParam("ComponentTypeID", $componentType);
            $bdd->bindParam("privacy", $componentPrivacy);
            $bdd->execute(); //executola sentencia
            $bdd->setFetchMode(PDO::FETCH_ASSOC);
            $resultatCompID = $bdd->fetchAll(); //guardo els resultats
            $componentID = $resultatCompID[0]['ComponentID'];
            // echo $componentID;

            for ($a = 0; $a < $dataArrayLength; $a++) {
                $sentenciaCompProps =
                    "
                INSERT INTO propertiesxcomponents (PropertyID, ComponentID, Valuee)
                VALUES (:PropertyID, :ComponentID, :Valuee);
                ";
                $bdd = $conn->prepare($sentenciaCompProps);
                $bdd->bindParam("PropertyID", $componentPropsNumber[$a]); //aplico els parametres necessaris
                $bdd->bindParam("ComponentID", $componentID);
                $bdd->bindParam("Valuee", $componentProps[$a]);
                $bdd->execute(); //executola sentencia
                $bdd->setFetchMode(PDO::FETCH_ASSOC);
                $resultatCompID = $bdd->fetchAll(); //guardo els resultats
            }
            return $boolEstat; //ha anat tot bé
        } else {
            //algo ha fallat
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

/*
        Function: modifyComponent()

            Funcio que actualitza les dades del component passat

        Parameters:

            Propietats dels components + els valors a modificar

        Returns:

            Retorna true si el component s'ha inserit correctament o false si algo ha fallat
 
    */
function modifyComponent($componentDades, $componentID, $userID)
{
    $baseDades = new BdD; //creo nova classe BDD

    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //comprovar de que el component sigui de l'usuari
        $senteciaVerificacioCompUser =
            "
            SELECT UserID FROM `components` where ComponentID = :ComponentID;
            ";
        $bdd = $conn->prepare($senteciaVerificacioCompUser);
        $bdd->bindParam("ComponentID", $componentID); //aplico els parametres necessaris
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $UserCompID = $bdd->fetchAll(); //guardo els resultats
        $UserCompIDBaseDades = $UserCompID[0]['UserID'];

        //Comprovem de que el userID passat per parametre sigui el mateix usuariID que el del component de la BDD que es vol modificar
        if ($userID == $UserCompIDBaseDades) {
            //extreiem la informació que anirà a la taula de components
            $componentName = $componentDades['data']['ComponentName'];
            $componentPrivacy = $componentDades['data']['privacy'];

            //tornem a separar la informació, el valor de les propietats en un array(componentProps) i els IDs de les propietats en un altre(componentPropsNumber)
            $componentProps = []; //array on vaig guardant els valors de les propietats dels components
            $componentPropsNumber = []; //array on hi vaig guardant els IDs de les propietats dels components

            $dataArrayLength = sizeof($componentDades['data']['props']);

            for ($i = 0; $i < $dataArrayLength; $i++) { //Bucle on vaig guardant cada informació al seu lloc
                array_push($componentProps, $componentDades['data']['props'][$i]['prop_val']);
                array_push($componentPropsNumber, $componentDades['data']['props'][$i]['prop_id']);
            }

            //Extrect totes les claus primàries dels registres dels valors del component(PKPXC)
            $senteciaExtreurePKPXC =
                "
            SELECT PKPXC 
            FROM `propertiesxcomponents`
            WHERE ComponentID = :ComponentID;
            ";
            $bdd = $conn->prepare($senteciaExtreurePKPXC);
            $bdd->bindParam("ComponentID", $componentID);
            $bdd->execute(); //executola sentencia
            $bdd->setFetchMode(PDO::FETCH_ASSOC);
            $resultatPKPXC = $bdd->fetchAll(); //guardo els resultats

            $idPKPXC = [];
            //vaig guardant totes les claus primàries de la taula componentxproperties 
            //per aixi saber quines posicions haig de modificar i que tots els registres no acabin amb el mateix valor
            for ($e = 0; $e < sizeof($resultatPKPXC); $e++) {
                array_push($idPKPXC, $resultatPKPXC[$e]['PKPXC']);
            }
            //Actualitzo els valors a la taula components
            $sentenciaUpdateTComponent =
                "
                UPDATE `components` 
                SET ComponentName = :ComponentName, Privacy = :privacy
                WHERE ComponentID = :ComponentID AND UserID = :UserID;
            ";

            $bdd = $conn->prepare($sentenciaUpdateTComponent);
            $bdd->bindParam("ComponentName", $componentName);
            $bdd->bindParam("privacy", $componentPrivacy);
            $bdd->bindParam("ComponentID", $componentID);
            $bdd->bindParam("UserID", $userID); //aplico els parametres necessaris
            $bdd->execute(); //executola sentencia
            $bdd->setFetchMode(PDO::FETCH_ASSOC);
            $resultatTC = $bdd->fetchAll(); //guardo els resultats

            for ($a = 0; $a < $dataArrayLength; $a++) {
                $sentenciaTCompProps =
                    "
                        UPDATE `propertiesxcomponents`
                        SET PropertyID = :PropertyID, Valuee = :Valuee
                        WHERE PKPXC = :PKPXC AND ComponentID = :ComponentID;
                    ";

                $bdd = $conn->prepare($sentenciaTCompProps);
                $bdd->bindParam("PropertyID", $componentPropsNumber[$a]); //aplico els parametres necessaris
                $bdd->bindParam("Valuee", $componentProps[$a]);
                $bdd->bindParam("PKPXC", $idPKPXC[$a]);
                $bdd->bindParam("ComponentID", $componentID);
                $bdd->execute(); //executola sentencia
                $bdd->setFetchMode(PDO::FETCH_ASSOC);
                $resultatCompID = $bdd->fetchAll(); //guardo els resultats
            }

            // si l'actualització del component s'ha fet correctament
            return true;
        } else { //si el component és d'un altre usuari
            return false;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

/*
        Function: deleteComponent()

            Funcio que elimina el component que tingui l'ID passat

        Parameters:

            $componentID - Identificador del coponent

        Returns:

            Retorna true si el component s'ha eliminat correctament o false si algo ha fallat
 
    */
function deleteComponent($componentID, $userID)
{
    $baseDades = new BdD; //creo nova classe BDD

    try {
        $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //varificar de que el IDusuari passat per paràmetre sigui el mateix 
        //comprovar de que el component sigui de l'usuari
        $senteciaVerificacioCompUser =
            "
            SELECT UserID FROM `components` where ComponentID = :ComponentID;
            ";
        $bdd = $conn->prepare($senteciaVerificacioCompUser);
        $bdd->bindParam("ComponentID", $componentID); //aplico els parametres necessaris
        $bdd->execute(); //executola sentencia
        $bdd->setFetchMode(PDO::FETCH_ASSOC);
        $UserCompID = $bdd->fetchAll(); //guardo els resultats
        $UserCompIDBaseDades = $UserCompID[0]['UserID'];

        // si els usuaris coincideixen
        if ($userID == $UserCompIDBaseDades) {
            //anar eliminant les taules, Començaré per propertiesxcomponents i despres el registre de la taula components
            $sentenciaDeleteTCXP =
                "
            DELETE FROM `propertiesxcomponents` WHERE ComponentID = :ComponentID;
            ";
            $bdd = $conn->prepare($sentenciaDeleteTCXP);
            $bdd->bindParam("ComponentID", $componentID); //aplico els parametres necessaris
            $bdd->execute(); //executola sentencia
            $bdd->setFetchMode(PDO::FETCH_ASSOC);

            $sentenciaDeleteTComponents = 
            "
            DELETE FROM `components` WHERE ComponentID = :ComponentID AND UserID = :UserID;
            ";
            $bdd = $conn->prepare($sentenciaDeleteTComponents);
            $bdd->bindParam("ComponentID", $componentID); //aplico els parametres necessaris
            $bdd->bindParam("UserID", $userID);
            $bdd->execute(); //executola sentencia
            $bdd->setFetchMode(PDO::FETCH_ASSOC);

        } else {
            return false;
        }

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

/*
        Function: deleteUser()

            Funcio que elimina l'usuari que tingui l'ID passat

        Parameters:

            $userID - Identificador de l'usuari

        Returns:

            Retorna true si l'usuari s'ha eliminat correctament o false si algo ha fallat
 
    */
function deleteUser($identificador,$userID,$apikey)
{
//consulta per extreure els ID dels components de l'usuari passat
// Select ComponentID from components where UserID = 12;
}

/*
        Function: addProperties()

            Funcio que afegeix les porpietats per a crear un cou component (ex vull registrar una gràfica i encara no hi han les seves propietats posades)

        Parameters:

            $userID - Identificador de l'usuari

        Returns:

            Retorna true si les propietats s'han inserit correctament o false si algo ha fallat
 
    */
function addProperties()
{
}
