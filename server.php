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
        } else if ($recurs1 == "LogIn") {
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
                    echo json_encode($result);
                    header('HTTP/1.1 200 OK');
                }
            } else { //si el mètode es qualsevol altre cosa que POST
                header('HTTP/1.1 405 Method Not Allowed');
            }
        } else if ($recurs1 == "getComponentProperties") {

            if ($method == "GET") {
                echo json_encode(getComponentProperties($recurs2));
                header('HTTP/1.1 200 OK');
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
            }
        } else if ($recurs1 == "selectOneComponent") {
            if ($method == "GET") { //fer condicio de verificar que hi ha component id i userID
                if ($recurs2 != "") { //si hi ha component id i userID
                    $resultatComponent = selectOneComponent($recurs2, $identificador);
                    if ($resultatComponent != "false") {
                        echo json_encode($resultatComponent);
                        header('HTTP/1.1 200 OK');
                    } else {
                        header('HTTP/1.1 417 private component');
                    }
                } else {
                    header('HTTP/1.1 417 Method Not Allowed');
                    echo "UserID or ComponentID required";
                }
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
            }
        } else if ($recurs1 == "selectPublicComponents") {
            if ($method == "GET") {

                $resultatCOMPonent = json_encode(selectPublicComponents());
                echo $resultatCOMPonent;
                header('HTTP/1.1 200 OK');
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
            }
        } 
        else if(1==1){
            // ficar aqui el get de seleccionar components relacionats
        }
        else { //Ficar les funcions privades de l'API

            $id = explode('.', $recurs1); //divideixo el valor passat del recurs1(apikey + userID)

            $apikey = $id[0];
            $userID = $id[1];

            if (UserValidation($apikey, $userID) == true) { // si la validació de l'apikey retorna true
                if ($recurs2 == "UserInfo") {
                    if ($method == "GET") {
                        if ($identificador != "") { //si hi ha un identificador d'usuari
                            echo json_encode(selectOneUser($apikey, $identificador)); //li passo l'api-key i el UserID
                            header('HTTP/1.1 200 OK');
                        } else {
                            header('HTTP/1.1 417 EXPECTATION FAILED');
                            echo "User identifier needed";
                        }
                    } else {
                        header('HTTP/1.1 405 Method Not Allowed');
                    }
                } else if ($recurs2 == "ModifyUser") {
                    if ($method == "POST") {
                        if ($identificador != "") { //si hi ha un identificador d'usuari
                            $put = json_decode(file_get_contents('php://input'), true);
                            //separo tot els valors JSON en diferents variables
                            $Firstname = $put["data"][0]["UserName"];
                            $LastName = $put["data"][0]["UserLastName"];
                            $UserEmail = $put["data"][0]["UserEmail"];
                            $passwd = $put["data"][0]["passwd"];
                            //registro la funcio i agafo el resultat
                            $missatge = modifyUser($Firstname, $LastName, $UserEmail, $passwd, $identificador, $apikey);

                            if ($missatge == true) {
                                echo "user updated correctly";
                                header('HTTP/1.1 200 OK');
                            } else {
                                echo "user update failed or you tried to update another user";
                                header('HTTP/1.1 417 EXPECTATION FAILED');
                            }
                        } else {
                            header('HTTP/1.1 417 EXPECTATION FAILED');
                            echo "User identifier needed";
                        }
                    } else {
                        header('HTTP/1.1 405 Method Not Allowed');
                    }
                } else if ($recurs2 == "RegisterComponent") {
                    if ($method == "POST") {
                        $put = json_decode(file_get_contents('php://input'), true);
                        $missatge = registerComponent($put, $userID);

                        if ($missatge == true) {
                            echo "Component inserted correctly";
                            header('HTTP/1.1 200 OK');
                        } else {
                            echo "Component registration failed";
                            header('HTTP/1.1 417 EXPECTATION FAILED');
                        }
                    } else {
                        header('HTTP/1.1 405 Method Not Allowed');
                    }
                } else if ($recurs2 == "ModifyComponent") {
                    if ($method == "POST") {
                        if ($identificador != "") { //si hi ha un identificador d'usuari
                            $put = json_decode(file_get_contents('php://input'), true);

                            $missatge = modifyComponent($put, $identificador, $userID);

                            if ($missatge == true) {
                                echo "component updated correctly";
                                header('HTTP/1.1 200 OK');
                            } else {
                                echo "component update failed or that component was not yours";
                                header('HTTP/1.1 417 EXPECTATION FAILED');
                            }
                        } else {
                            header('HTTP/1.1 417 EXPECTATION FAILED');
                            echo "Component identifier needed";
                        }
                    } else {
                        header('HTTP/1.1 405 Method Not Allowed');
                    }
                } else if ($recurs2 == "SelectUserComponents") { //Comprobar si hi ha identificador!!!
                    if ($method == "GET") {
                        if ($identificador != "") {
                            echo json_encode(selectUserComponents($identificador));
                            header('HTTP/1.1 200 OK');
                        } else {
                            header('HTTP/1.1 417 EXPECTATION FAILED');
                            echo "Component identifier needed";
                        }
                    } else {
                        header('HTTP/1.1 405 Method Not Allowed');
                    }
                } else if ($recurs2 == "DeleteComponent") {
                    if ($identificador != "") {
                        $missatge = deleteComponent($identificador, $userID);

                        if ($missatge == true) {
                            echo "component deleted correctly";
                            header('HTTP/1.1 200 OK');
                        } else {
                            echo "component deletion failed or that component was not yours";
                            header('HTTP/1.1 417 EXPECTATION FAILED');
                        }
                    } else {
                        header('HTTP/1.1 417 EXPECTATION FAILED');
                        echo "Component identifier needed";
                    }
                } else if ($recurs2 == "DeleteUser") {
                    if ($identificador != "") {
                        $missatge = deleteUser($identificador, $userID, $apikey);

                        if ($missatge == true) {
                            echo "User deleted correctly";
                            header('HTTP/1.1 200 OK');
                        } else {
                            echo "user deletion failed or that user was not yours";
                            header('HTTP/1.1 417 EXPECTATION FAILED');
                        }
                    } else {
                        header('HTTP/1.1 417 EXPECTATION FAILED');
                        echo "Component identifier needed";
                    }
                } else if ($recurs2 == "AddComponentType") {
                    if ($method == "POST") {

                        $put = json_decode(file_get_contents('php://input'), true);

                        $missatge = addComponentType($put);

                        if ($missatge == true) {
                            echo "component Type registered correctly";
                            header('HTTP/1.1 200 OK');
                        } else {
                            echo "component type registration failed";
                            header('HTTP/1.1 417 EXPECTATION FAILED');
                        }
                    } else {
                        header('HTTP/1.1 405 Method Not Allowed');
                    }
                }
            } else { //si l'API-KEY no és vàlida
                echo "api-key not valid";
                header('HTTP/1.1 417 EXPECTATION FAILED');
            }
        }
    }
}

$server = new Server;
$server->serve();
