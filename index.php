<?php
/*
Программа: поиск пути
Версия:0.0
Разбираемся в графах
*/
error_reporting(-1);

function find_way($from,$where,$way){
	$paths = array(
		1=>array(2,3,4),
		2=>array(1,3),
		3=>array(1,2,4,5,6),
		4=>array(1,3),
		5=>array(3),
		6=>array(3,7),
		7=>array(6)
	);
	
	if (!is_array($way)){
		$way=array();
		$way[]=$from;
	}
	
	echo "\n\n\nФУНКЦИЯ(".$from.";".$where."; ".implode("=>",$way).")\n";

	$current=$way[count($way)-1]; //на какой мы сейчас станции
	echo "Текущая станция: ".$current."\n";

		
	if(in_array($where,$paths[$current])){
		$way[]=$where;
		echo "		ОДИН ИЗ ПУТЕЙ: ".implode("=>",$way)."\n";
		$GLOBALS['ways'][]=$way; //Добавляем вариант прохода в возвращаемый функцией массив

	}
	else{
		foreach ($paths[$current] as $k=>$v){
			$next=$paths[$current][$k];
			if(!in_array($next,$way)){
				echo "Станции ".$next." нет в пути ".implode("=>",$way)."\n";
				echo "	Вот какие у станции ".$next." выходы: ";
				echo implode(",",$paths[$next])."; \n";

				$way[]=$next;
				echo "	Присвоенный путь для ф-ии: ".implode("=>",$way)."\n";
				find_way($from,$where,$way);
				array_pop($way);
			}
			else{
				echo "Станция ".$next." уже есть в пути ".implode("=>",$way).";\n";
			}

		}
	}
	if (isset($GLOBALS['ways']))
		return ($GLOBALS['ways']);
}

////////////////////////////////////
$ways=find_way(1,7,null);
echo "Способы достижения цели: \n";
foreach($ways as $k=>$v){
	echo implode("=>",$ways[$k]).";\n";
}