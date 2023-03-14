<?php
include 'connexioBDD.php';

/*
        Function: userValidation()

            Funció que passant-li una API-KEY et retorna ture o flase si ha trobat un usuari o no amb aquesta

        Parameters:

            $APIKEY - API-KEY de l'usuari 

        Returns:

            Retorna TRUE si ha trobat un usuari amb la API-KEY passada

            Retorna FALSE si no ha trobat cap usuari amb l'API-KEY passada o algo de la cosulta ha fallat
 
    */
function UserValidation($UserApiKey)
        {
            $resultat = null;
            $baseDades = new BdD; //creo nova classe BDD

            try {
                $conn = new PDO("mysql:host=$baseDades->db_host;dbname=$baseDades->db_name", $baseDades->db_user, $baseDades->db_password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $senteciSQL = "SELECT UserID, APIKEY FROM users WHERE `APIKEY` = :APIKEY";

                $bdd = $conn->prepare($senteciSQL);
                $bdd->bindParam("APIKEY", $UserApiKey); //aplico els parametres necessaris
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
    $resultat = null;
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

        if (count($resultat) == 1){// si ha trobat un usuari
            return $resultat;
        }
        else {
            return false;
            header('HTTP/1.1 405 Method Not Allowed');

        }
    } 
    catch (PDOException $e) {
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
    function selectOneUser($APIKEY, $UserID){
        $resultat = null;
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
    
            if (count($resultat) == 1){// si ha trobat un usuari
                return $resultat;
            }
            else {//no ha trobat cap usuari
                return false;
            }
        } 
        catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            // echo "error insercio 1";
            return false;
            header('HTTP/1.1 405 Method Not Allowed');

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

    function modifyUser($Firstname, $LastName, $UserEmail, $passwd, $identificador){
        $baseDades = new BdD; //creo nova classe BDD

        try {
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
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }



