<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <title>COMPARAÇÃO ENTRE CHAVE E DOCUMENTOS</title>
    <meta charset="utf-8">
  </head>
  <body style="margin:0 25%; t-ext-align:center;">


<?php

$analise = new AnasliseNotas();

$chave = $analise->getChave();
echo "<br> TOTAL DE CHAVES DE ACESSO:  0".count($chave);

$xml = $analise->getXml();
echo "<br> TOTAL DE XMLs ECONTRADOS: 0".Count($xml);

$novaChave = $analise->paramChave($chave);
echo '<br> TOTAL DE CHAVES PARAMETRIZDAS 0'.Count($novaChave);


echo "<br><br> ====================== PROCESSANDO =========================<br><br>";
$comparacao = $analise->comparacao($xml, $novaChave);

class AnasliseNotas{
	
	private $path = "xml/";
	private $paramN = "-nfe.xml";
	public function getChave(){
				
		$arquivo = file("chave.txt");
		$c =0;
		foreach($arquivo as $item){
		   $chave[$c] = trim($item); 
		   $c++;
		}
		return $chave;
	}
	
	public function getXml(){
		
		$arquivo = dir($this->path);
		$c = 0;
		while($item = $arquivo->read()){
			$xml[$c] = $item;
			$c++;
		}
		$arquivo->close();
		return $xml;
	}
	
	public function paramChave($ch){
		
		for($i=0; $i<Count($ch); $i++){
			$str = trim($ch[$i]);
			$valor[$i] = $str . "-nfe.xml";
		}
		return $valor;
	}
	
	public function comparacao($xml, $chave){
		$par = 1; // 1 compara  chave com xml  2 compara xml com chave
		$Vtem;
		$Vnao;
		$contChave = 0;
		echo "|| PARAMETRO ||";
		if($par == 1){
			echo "== SE -> CHAVE É IGUAL XML ==<br>";
			for($i=0; $i<Count($chave); $i++){
				$tem = 0;
				$nao = 0;
				for($j=0; $j<Count($xml); $j++){
					if($chave[$i] == $xml[$j]){
						$tem++;
						break;
					}else{
						$nao++;
					}
				}
				
				if($tem > 0){
					$Vtem[$i] = Array('chave' => $chave[$i], 'status' => "OK");
				}
				if($nao == Count($xml)){
					$Vnao[$i] = Array('chave' => $chave[$i], 'status' => "NAO");
				}
				$contChave++;
			}
		}
		if($par == 2){
			echo "== SE -> XML É IGUAL CHAVE ==<br>";
				for($i=0; $i<Count($xml); $i++){
				$tem = 0;
				$nao = 0;
				for($j=0; $j< Count($chave); $j++){
					if($xml[$i] == $chave[$j]){
						$tem++;
						break;
					}else{
						$nao++;
					}
				}

				if($tem > 0){
					$Vtem[$i] = Array('chave' => $xml[$i], 'status' => "OK");
				}
				if($nao == Count($chave)){
					$Vnao[$i] = Array('chave' => $xml[$i], 'status' => "NAO");
				}
				$contChave++;
			}
		}
		
		echo "<br>FORAM PROCESSAD0S <STRONG>0".$contChave."</STRONG> REGISTROS <br>";
		
		echo "<br><br>======================= CHAVE =X= XML =======================<br><br>";
		if(!empty($Vtem)){
			echo "Quantidade de comparações com êxito  0".count($Vtem)."<br>";
			foreach($Vtem as $vl){
				echo '<br>'.$vl['chave'].'    |  '.$vl['status'];
			}
		}
		
		
		echo "<br><br>======================= CHAVE =OFF= XML =====================<br><br>";
		
		if(!empty($Vnao)){
			echo "Quantidade de comparações sem XML  0".count($Vnao)."<br>";
			foreach($Vnao as $vl){
				echo '<br>'.$vl['chave'].'    |  '.$vl['status'];
			}
		}
		
		echo "<br><br>=============================================================<br>";
		echo "=======================  Wenderson  Souzza.  =======================";
		echo "<br>=============================================================<br><br>";
	}
}



?>





    
  </body>
</html>