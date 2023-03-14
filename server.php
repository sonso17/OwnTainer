<?php
include 'funcionsBDD.php';
// echo "hola";
class Server
{
    /*
  Function: serve()
    Funcio que retalla la URL i agafa els valors per després dirigir a la funcionalitat de l'API adequada
  */
    public function serve()
    {



        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        $paths = explode('/', $uri);
        array_shift($paths); // Hack; get rid of initials empty string
        array_shift($paths);
        // echo '<pre>'; print_r($paths); echo '</pre>';

        $recurs1 = array_shift($paths);
        // echo $recurs1;
        $recurs2 = array_shift($paths);
        $identificador = array_shift($paths);

        // http://owntainer.daw.institutmontilivi.cat/API/recurs1/recurs2/identificador
        // part pública ex. http://owntainer.daw.institutmontilivi.cat/API/register
        // part pública ex. http://owntainer.daw.institutmontilivi.cat/API/getPublicComponent/1
        //                                                                    //recurs1 //recurs2

        // part privada ex. http://owntainer.daw.institutmontilivi.cat/API/API-KEY/modifyUser/1
        //                                                               //recurs1  recurs2   identificador

        //aqui anar posant endpoints publics
        if ($recurs1 == "register") {
            if ($method == 'POST') // validem que sigui per GET
            { //agafo tota la info de l'usuari en JSON
                $put = json_decode(file_get_contents('php://input'), true);
                //separo tot els valors JSON en diferents variables
                $Firstname = $put["data"][0]["UserName"];
                $LastName = $put["data"][0]["UserLastName"];
                $UserEmail = $put["data"][0]["UserEmail"];
                $passwd = $put["data"][0]["passwd"];
                //registro la funcio i agafo el resultat
                $missatge = registerUser($Firstname, $LastName, $UserEmail, $passwd);

                if ($missatge == true) {
                    echo "user inserted correctly";
                    header('HTTP/1.1 200 OK');
                } else {
                    echo "user registration failed";
                    header('HTTP/1.1 417 EXPECTATION FAILED');
                }
            } else { //si el mètode es qualsevol altre cosa que POST
                header('HTTP/1.1 405 Method Not Allowed');
            }
        } 
        else if ($recurs1 == "LogIn") {
            if ($method == 'POST') // validem que sigui per GET
            {
                $put = json_decode(file_get_contents('php://input'), true);

                $UserEmail = $put["data"][0]["UserEmail"];
                $passwd = $put["data"][0]["passwd"];

                $result = LogIn($UserEmail, $passwd);

                if ($result == false) {
                    echo "User not found";
                    header('HTTP/1.1 417 EXPECTATION FAILED');
                } else {
                    echo "user found!";
                    echo json_encode($result);
                    header('HTTP/1.1 200 OK');
                }
            } else { //si el mètode es qualsevol altre cosa que POST
                header('HTTP/1.1 405 Method Not Allowed');
            }
        } 
        else { //Ficar les funcions privades de l'API
            if (UserValidation($recurs1)  && $recurs2 == "UserInfo") {
                // echo "UserInfo";
                if ($method == "GET") {
                    if ($identificador != "") { //si hi ha un identificador d'usuari
                        echo json_encode(selectOneUser($recurs1, $identificador));
                    } else {
                        header('HTTP/1.1 417 EXPECTATION FAILED');
                        echo "User identifier needed";
                    }
                } else {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            } 
            else if (UserValidation($recurs1)  && $recurs2 == "ModifyUser") {
                if ($method == "POST") {
                    if ($identificador != "") { //si hi ha un identificador d'usuari
                        $put = json_decode(file_get_contents('php://input'), true);
                        //separo tot els valors JSON en diferents variables
                        $Firstname = $put["data"][0]["UserName"];
                        $LastName = $put["data"][0]["UserLastName"];
                        $UserEmail = $put["data"][0]["UserEmail"];
                        $passwd = $put["data"][0]["passwd"];
                        //registro la funcio i agafo el resultat
                        $missatge = modifyUser($Firstname, $LastName, $UserEmail, $passwd, $identificador);

                        if ($missatge == true) {
                            echo "user updated correctly";
                            header('HTTP/1.1 200 OK');
                        } else {
                            echo "user update failed";
                            header('HTTP/1.1 417 EXPECTATION FAILED');
                        }
                    } else {
                        header('HTTP/1.1 417 EXPECTATION FAILED');
                        echo "User identifier needed";
                    }
                } else {
                    header('HTTP/1.1 405 Method Not Allowed');
                }
            } 
            else {
                echo "api-key not valid";
                header('HTTP/1.1 405 Method Not Allowed');
            }
        }
    }
}

$server = new Server;
$server->serve();
