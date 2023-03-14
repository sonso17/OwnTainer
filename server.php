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
                // echo "registre";
                // header('HTTP/1.1 200 OK');
                $put = json_decode(file_get_contents('php://input'), true);
                // echo $put->;

                $Firstname = $put["data"][0]["UserName"];
                $LastName = $put["data"][0]["UserLastName"];
                $UserEmail = $put["data"][0]["UserEmail"];
                $passwd = $put["data"][0]["passwd"];
               
                $missatge = registerUser($Firstname,$LastName,$UserEmail,$passwd);
                if($missatge == true){
                    json_encode("user inserted correctly");
                    header('HTTP/1.1 200 OK');
                }
                else{
                    json_encode("user registration failed");
                    header('HTTP/1.1 417 EXPECTATION FAILED');
                }
                // header('Location: http://localhost:8080/#/LlistaTasques');
            } else {
                header('HTTP/1.1 405 Method Not Allowed');
                echo json_encode("405");
            }
        } else {
            // echo $recurs1;
            echo json_encode("res");
        }

        //fer condicional de verificar l'apikey

    }
}

$server = new Server;
$server->serve();
