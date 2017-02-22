<?php
  //Criamos a variável $curl e com o comando curl_init(); damos o poder a ela de acessar uma determinada URL.
  $curl = curl_init();
  
  /*Aqui montamos a URL de consulta, no final ela terá o seguinte formato:   
  https://managersaashom.tecnospeed.com.br:7071/ManagerAPIWeb/nfe/consulta?grupo=edoc&cnpj=08187168000160&filtro=chave=41170208187168000160553210000006521000000019&campos=situacao,nprotenvio*/
  $urlconsulta = "https://".$_GET['host'].":7071/ManagerAPIWeb/nfe/consulta?"."grupo=".$_GET['grupo']."&cnpj=".$_GET['cnpj']."&filtro=".$_GET['filtroconsulta']."&campos=".$_GET['camposconsulta']."&encode=true";
  
  //Da mesma forma que fizemos a autenticação para o Envio, vamos precisar para a Consulta.
  $usuario = $_GET['usuario'];
  $senha = $_GET['senha'];

  $auth = base64_encode("$usuario:$senha");
  
  //Montamos então as opções do cURL para enviarmos a requisição.
  curl_setopt_array($curl, array(
  	  CURLOPT_RETURNTRANSFER => 1,
  	  CURLOPT_SSL_VERIFYPEER => false,
  	  CURLOPT_URL => $urlconsulta,
  	  CURLOPT_USERAGENT => 'Codular Sample cURL Request'
  	));

  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
  	  'Authorization: Basic '.$auth
  	));

  //Com o comando curl_exec($curl); nós enviamos o GET para o SaaS.
  $retorno = curl_exec($curl);
  
  //É importante que sempre que uma comunicação for aberta, após o uso ela seja fechada.
  curl_close($curl);
  echo $retorno;
?>
