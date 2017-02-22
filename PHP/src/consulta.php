<?php
  $curl = curl_init();
   $urlconsulta = "https://".$_GET['host'].":7071/ManagerAPIWeb/nfe/consulta?"."grupo=".$_GET['grupo']."&cnpj=".$_GET['cnpj']."&filtro=".$_GET['filtroconsulta']."&campos=".$_GET['camposconsulta']."&encode=true";
  //Autenticação
  $usuario = $_GET['usuario'];
  $senha = $_GET['senha'];

  $auth = base64_encode("$usuario:$senha");

  curl_setopt_array($curl, array(
  	  CURLOPT_RETURNTRANSFER => 1,
  	  CURLOPT_SSL_VERIFYPEER => false,
  	  CURLOPT_URL => $urlconsulta,
  	  CURLOPT_USERAGENT => 'Codular Sample cURL Request'
  	));

  curl_setopt($curl, CURLOPT_HTTPHEADER, array(
  	  'Authorization: Basic '.$auth
  	));

  $retorno = curl_exec($curl);

  curl_close($curl);
  echo $retorno;
?>