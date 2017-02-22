<?php
  //Carregamos o conteúdo do arquivo NFe.tx2, pois dentro dele nós temos todos os dados necessários para autorizar uma nota
  $tx2 = file_get_contents('NFe.tx2');
  
  //Aqui vamos preencher os parâmetros obrigatórios da rota Envia
  $post_data['grupo']= $_POST['grupo'];
  $post_data['cnpj']= $_POST['CNPJ'];
  $post_data['arquivo']= $tx2;
  $post_data['encode']= "true";

  //Passamos para a variável host o endereço do SaaS
  $host = $_POST['host'];

  //Monta uma query no formato que a requisição POST necessita para enviar informações para um determinado destinatário
  $data=http_build_query($post_data);

  //Para o SaaS autorizar uma comunicação entre seu sistema e nosso servidor, é necessário autenticar essa requisição com o usuario e senha
  $usuario = $_POST['usuario'];
  $senha = $_POST['senha'];

  $auth = base64_encode("$usuario:$senha");

  //Aqui iniciamos o processo de montagem da requisição e envio dela
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

  //Lemos todas as linhas do retorno da requisição e atribuímos elas para a variável $result
  while (!feof($socket))
  {
    $result .= fgets($socket, 4096);
  }
  fclose($socket);

  //Aqui separamos o que é header e o que é o conteúdo que vamos retornar para o front
  list($header, $body) = preg_split("/\R\R/", $result, 2);

  //Devolvemos para o front o conteúdo de resposta do SaaS
  echo($body);
?>
