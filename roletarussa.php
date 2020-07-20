<?php

$userid = $_GET['userid'];
$channel = $_GET['channel'];
$isMod = connectionDb($userid,$channel);
$frase = 'A Roleta Russa foi lançada ';
if(is_null($isMod))
{
	$toValue = rand(30,1209600);
	echo $toValue.' segundos <br>';
	if($toValue < 60)
	{
		$tempo = 'segundo';
		if($toValue>1)
		{
			$tempo = $tempo.'s';
		}
		$saida = "{$toValue} {$tempo} ";
	}
	elseif($toValue>=60 && $toValue<3600)
	{
		$tempo = 'minuto';
		if($toValue>60)
		{
			$tempo = $tempo.'s';
		}
		$saida = round(($toValue/60),2)." {$tempo} ";
	}
	elseif($toValue>=3600 && $toValue<86400)
	{
		$tempo = 'hora';
		if($toValue>3600)
		{
			$tempo = $tempo.'s';
		}
		$saida = round(($toValue/3600),2)." {$tempo} ";
	}
	elseif($toValue>=86400 && $toValue<604800)
	{
		$tempo = 'dia';
		if($toValue>86400)
		{
			$tempo = $tempo.'s';
		}
		$saida = round(($toValue/86400),2)." {$tempo} ";
	}
	else
	{
		$tempo = 'semana';
		if($toValue>604800)
		{
			$tempo = $tempo.'s';
		}
		$saida = round(($toValue/604800),2)." {$tempo} ";
	}
	
	echo "A roleta russa foi lançada e vc {$userid} receberá {$saida} de timeout";
}
else{
	echo "Como assim, você mero mortal quer dar T.O. em um MOD SUPREMO como {$userid}. BLASFÊMIA.";
}



function connectionDb ($user, $canal)
{
	 try
{
 $userid = $_GET['userid'];
 $channel = $_GET['channel'];
 $servidor = "mssql914.umbler.com";
    $porta = 5003;
    $database = "db_homolog";
    $usuario = "d41d8cd98f00b204";
    $senha = "W72sLvg81)OL5Hu";
    
    $conexao = new PDO( "sqlsrv:Server={$servidor},{$porta};Database={$database}", $usuario, $senha );
}
catch ( PDOException $e )
{
    // echo "Drivers disponiveis: " . implode( ",", PDO::getAvailableDrivers() );
    // echo "\nErro: " . $e->getMessage();
   
}
 
$query = $conexao->prepare("exec sp_VerificaModerador {$userid}, {$channel}");
$query->execute();
 
 //for($i=0; $row = $query->fetch(); $i++){
 //echo $i.+' – .'+$row[i]+'.<br/>';
 //echo $row[0]+'.<br/>';
 $resultado = $query->fetchAll();
 
$isMod = $resultado['0']['0'];

unset($pdo);
unset($query);

return $isMod;
}
?>