<?php
include 'connexioBDD.php';

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
        }
    } 
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        // echo "error insercio 1";
        return false;
    }
}

