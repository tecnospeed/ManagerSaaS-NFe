<?php
  $post_data['grupo']= $_POST['grupo'];
  $post_data['cnpj']= $_POST['CNPJ'];
  $post_data['chavenota']= $_POST['chavenota'];
  $post_data['justificativa']= $_POST['justificativa'];
  $post_data['encode']= "true";

  $host = $_POST['host'];

  $data=http_build_query($post_data);

  $usuario = $_POST['usuario'];
  $senha = $_POST['senha'];

  $auth = base64_encode("$usuario:$senha");

  $socket = fsockopen("ssl://".$host, 7071, $errno, $errstr, 15);

  $http  = "POST /ManagerAPIWeb/nfe/cancela HTTP/1.1\r\n";
  $http .= "Authorization: Basic ".$auth."\r\n";
  $http .= "Host: ".$host.":7071\r\n";
  $http .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
  $http .= "Content-Type: application/x-www-form-urlencoded\r\n";
  $http .= "Content-length: " . strlen($data) . "\r\n";
  $http .= "Connection: close\r\n\r\n";
  $http .= $data."\r\n\r\n";
  fwrite($socket, $http);               

  $result="";

  while (!feof($socket))
  {
    $result .= fgets($socket, 4096);
  }
  fclose($socket);

  list($header, $body) = preg_split("/\R\R/", $result, 2);

  echo($body);
?>