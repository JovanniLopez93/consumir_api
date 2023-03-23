<?php
    // para convertir nuestra respuesta en json y así poder consumirla como API
    header('Content-Type: application/json; charset=utf-8');
    /*
        configuramos nuestra liga a la API uso referencia por query para obtener mas datos en una petición
        y evitar muchas peticiones y tiempo de más
    */
    $liga_consumo = "https://api.chucknorris.io/jokes/search?query=movie";
    $user_agent = 'Mozilla HotFox 1.0';
    // abrimos conexión
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $liga_consumo);
    curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    // rescatamos datos
    $rescatamos_datos = curl_exec($ch);
    $rescatamos_datos = json_decode($rescatamos_datos);
    // imprimimos datos para saber que rescatamos pero comentamos ya no nos sirve
    // print_r($rescatamos_datos);
    // cerramos conexión
    curl_close($ch);
    //creamos variable donde rescataremos nuestros datos
    $regresar_json = [];
    // iniciamos nuestro contador en 0 para tomar en cuenta que debemos regresar 25 datos
    $cont = 0;
    // validamos el total de nuestros datos que nos regresa y así como el resultado
    if( $rescatamos_datos-> total ){
        $auxilar = $rescatamos_datos->result;
        foreach( $auxilar as $indice => $datos ){
            if( $cont <= 24){
                // vamos agregando las posiciones de la resputa a nuestro arreglo para regresar
                $regresar_json[] = $datos;
            }
            $cont++;
        }
    } else {
        // en caso de que no exitan muchas posiciones nos regresara un dato y rescatamos todo esto pasaria en caso 
        // de usar la liga: https://api.chucknorris.io/jokes/random
        $regresar_json = $rescatamos_datos;
    }
    // imprimimos nuestro json
    echo json_encode($regresar_json, JSON_FORCE_OBJECT);
?>