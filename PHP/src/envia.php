<?php
  //Lê conteudo de um txt
  $tx2 = file_get_contents('NFe.tx2');
  
  //Dados do form
  $post_data['grupo']= $_POST['grupo'];
  $post_data['cnpj']= $_POST['CNPJ'];
  $post_data['arquivo']= $tx2;
  $post_data['encode']= "true";

  $host = $_POST['host'];

  //Gera query em formato URL
  $data=http_build_query($post_data);

  //Autenticação
  $usuario = $_POST['usuario'];
  $senha = $_POST['senha'];

  $auth = base64_encode("$usuario:$senha");

  $socket = fsockopen("ssl://".$host, 7071, $errno, $errstr, 15);

  $http  = "POST /ManagerAPIWeb/nfe/envia HTTP/1.1\r\n";
  $http .= "Authorization: Basic ".$auth."\r\n";
  $http .= "Host: ".$host.":7071\r\n";
  $http .= "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
  $http .= "Content-Type: application/x-www-form-urlencoded\r\n";
  $http .= "Content-length: " . strlen($data) . "\r\n";
  $http .= "Connection: close\r\n\r\n";
  $http .= $data."\r\n\r\n";
  fwrite($socket, $http);               

  $result="";

  //Lê todas as linhas do retorno
  while (!feof($socket))
  {
    $result .= fgets($socket, 4096);
  }
  fclose($socket);

  //Separa header do conteudo
  list($header, $body) = preg_split("/\R\R/", $result, 2);

  //Exibe conteudo
  echo($body);
?>