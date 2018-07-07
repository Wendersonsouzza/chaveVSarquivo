# Chave VS Arquivo

Esse script foi desenvolvido para analisa se o valor de cada registro,  corresponde ao nome de algum arquivo de um determinado diretório.
--------

Objetivo do projeto
----
O objetivo desse Script  em PHP que foi desenvolvido para atender a necessidade do cliente, em comparar seu relatório de chaves de acesso das Notas Fiscais Eletrônicas com os Arquivos Xmls correspondente as chaves de acesso de um determinado diretório.
Esse comparativo Server para analisar se no Diretório está faltando algum arquivo, ou se tem Arquivos que não estão no relatório.

Como foi Desenvolvido
---

Foi desenvolvido de forma bem Simples em PHP  criando uma class.  com alguns métodos, como de captura dos nomes do arquivos, captura dos registros e padronização de chaves para o padrão desejado.

Métodos e Descrições
---
- getChave(); 
Pega os dados do arquivo, ler os registro e Retorna um Array de Chaves.

- getXml(); 
Pega os arquivos Xml, Ler seus nomes e Retorna um Array de nomes dos XML.

- paramChave($ch);
Receber um array de chaves, Remove os espaço em branco do inicio e do fim do registro, Adiciona paramentos no fim de cada String, Retorno um Array de chaves padronizadas.
- comparacao($xml, $chave);  Receber os nomes de XML e as Chaves no padrão, Compara guarda as informações em $Vtem Se foi encontrado e $Vnao se não foi encontrado.

#
Atributos

- private $path = "xml/";
- private $paramN = "-nfe.xml";


#

	public function getChave(){
				
		$arquivo = file("chave.txt");
		$c =0;
		foreach($arquivo as $item){
		   $chave[$c] = trim($item); 
		   $c++;
		}
		return $chave;
	}
	
Método responsável em pegar o arquivo chave.txt contendo todas as chaves, cada chave em uma linha do Arquivo.
Foi usando o trim(); Para remover os espaços em branco do inicio e do fim de cada registro, pelo fato da quebra de linha que adicionar um espaço em cada registro.
#

	public function paramChave($ch){
		
		for($i=0; $i<Count($ch); $i++){
			$str = trim($ch[$i]);
			$valor[$i] = $str . "-nfe.xml";
		}
		return $valor;
	}
	
Método que recebe um  array de chaves de acesso no formato 0000000000  e é adicionado 0000000000-nfe.xml  ficando no padrão igual ao nome do arquivo xml para comparar se os nomes são iguais. Caso necessário adicione parâmetros no inicio do registro. é usado o trim(); para remover espaços  em brancos do registro.
#

	
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
	
Método Responsável em pegar o nome de todos os arquivos de um determinado diretório, e retorna um array contendo os nomes de casa arquivo.

#

	public function comparacao($xml, $chave){
		$par = 1;
		$Vtem;
		$Vnao;
		$contChave = 0;
		
		if($par == 1){
			
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

		
	}
	

Método que faz a comparação se um registro entre todos xmls tem algum com mesmo nome.
Feito de duas maneiras de acordo a variável $par = 1 ou $par =2 
- $par =1;  Compara se a chave e igual a algum nome dos arquivos xml, na variável $Vnao guarda a chave do registro que não existe o xml, na variável $Vtem guarda a chave dos registro que tem o Xml.
- $par =2; Compara se o nome do Xml é igual a alguma chave do registro, na variável $Vnao guarda o nome do xml que não existe o Registro, na variável  $Vtem guarda o nome do xml que tem o registro.

No formato
#
	Array(
	'chave' => $chave[$i], 
	'status' => "OK"
	);

- $contChave - Variável que iria conta quando registro foram processados.

Ficando preenchidas $Vtem e $Vnao e deve criar uma variável para passar os valores para uso futuro  ou processar as informações dentro do próprio método como foi feito nesse projeto  para atender a necessidade do cliente.
#
Nesse projeto foi adicionado o php7 e um arquivo .bat  como linhas de comando para iniciar o servidor com o php7 sem a necessidade de instalar e fazer esse processo manual facilitando o uso do projeto por pessoas com pouco conhecimento de programação.

