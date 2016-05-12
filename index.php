<?php

/*
Программа: поиск пути
Версия:1.0
На данном этапе программа ищет все возможные пути из точки A в B
*/


error_reporting(-1);

define('SUBWAY', 'sub');
define('FOOT', 'foot');
define('BUS', 'bus');

$transportName = array(
    SUBWAY  =>  'едешь на метро',
    FOOT    =>  'идешь пешком',
    BUS     =>  'едешь на автобусе'
);

/* Чтобы не писать много раз array('time' => ..., 'by' => ...), используем функцию. 
    «canGet» переводится как «можно попасть» */
function canGet($time, $byWhat) {
    return array('time'     =>  $time, 'by' =>  $byWhat);
}
function find_way($from,$where,$way){

$paths = array(
    'pet'   =>  array(
        'chk'   =>  canGet(10, BUS),
        'gor'   =>  canGet(3, SUBWAY)
    ),

    'chk'   =>  array(
        'pet'   =>  canGet(10, BUS),
        'spo'   =>  canGet(3, SUBWAY)
    ),

    'gor'   =>  array(
        'pet'   =>  canGet(3, BUS),
        'kre'   =>  canGet(5, FOOT),
        'gos'   =>  canGet(6, SUBWAY)
    ),

    'spo'   =>  array(
        'chk'   =>  canGet(3, SUBWAY),
        'vas'   =>  canGet(10, BUS),
        'sen'   =>  canGet(7, SUBWAY)
    ),

    'vas'   =>  array(
        'spo'   =>  canGet(10, BUS),
        'gos'   =>  canGet(7, SUBWAY),
        'nov'   =>  canGet(11, FOOT)
    ),

    'kre'   =>  array(
        'gor'   =>  canGet(5, FOOT)
    ),

    'let'   =>  array(
        'dvo'   =>  canGet(6, FOOT),
        'gos'   =>  canGet(7, FOOT)
    ),

    'dvo'   =>  array(
        'isa'   =>  canGet(6, FOOT),
        'gos'   =>  canGet(6, FOOT),
        'let'   =>  canGet(6, FOOT)
    ),

    'isa'   =>  array(
        'dvo'   =>  canGet(6, FOOT),
        'nov'   =>  canGet(5, FOOT)
    ),

    'nov'   =>  array(
        'vas'   =>  canGet(11, FOOT),
        'isa'   =>  canGet(5, FOOT),
        'ras'   =>  canGet(7, BUS)
    ),

    'ras'   =>  array(
        'nov'   =>  canGet(7, BUS),
        'sen'   =>  canGet(3, FOOT)
    ),

    'gos'   =>  array(
        'vas'   =>  canGet(7, SUBWAY),
        'sen'   =>  canGet(3, SUBWAY),
        'dvo'   =>  canGet(6, FOOT),
        'gor'   =>  canGet(6, SUBWAY),
        'let'   =>  canGet(7, FOOT),
        'vla'   =>  canGet(7, FOOT)        
    ),

    'sen'   =>  array(
        'ras'   =>  canGet(3, FOOT),
        'spo'   =>  canGet(7, SUBWAY),
        'gos'   =>  canGet(3, SUBWAY),
        'vla'   =>  canGet(4, SUBWAY),
        'vit'   =>  canGet(2, SUBWAY),
        'teh'   =>  canGet(3, SUBWAY)
    ),

    'vla'   =>  array(
        'sen'   =>  canGet(4, SUBWAY),
        'gos'   =>  canGet(7, FOOT),
        'vit'   =>  canGet(3, SUBWAY)
    ),

    'vit'   =>  array(
        'sen'   =>  canGet(2, SUBWAY),
        'teh'   =>  canGet(2, SUBWAY),
        'vla'   =>  canGet(3, SUBWAY)
    ),

    'teh'   =>  array(
        'sen'   =>  canGet(3, SUBWAY),
        'vit'   =>  canGet(2, SUBWAY)        
    )
);
	if (!is_array($way)){
		$way=array();
		$way[]=$from;
	}
	
	echo "\n\n\nФУНКЦИЯ(".$from.";".$where."; ".implode("=>",$way).")\n";


	$current=$way[count($way)-1]; //на какой мы сейчас станции
	echo "Текущая станция: ".$current."\n";
	
	if(array_key_exists($where,$paths[$current])){
		$way[]=$where;
		echo "		ОДИН ИЗ ПУТЕЙ: ".implode("=>",$way)."\n";
		$GLOBALS['ways'][]=$way; //Добавляем вариант прохода в возвращаемый функцией массив
	}
	else{
		foreach ($paths[$current] as $k=>$v){
			$next=$k;
			if(!in_array($next,$way)){
				echo "Станции ".$next." нет в пути ".implode("=>",$way)."\n";
				echo "	Вот какие у станции ".$next." выходы: ";		
				//---implode для ключей
				$stringImplode='';
				foreach($paths[$next] as $key=>$val)
					$stringImplode.=$key.", ";
				echo $stringImplode."\n";;
				//---

				$way[]=$next;
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
$ways=find_way('pet','spo',null);
echo "Способы достижения цели: \n";

foreach($ways as $k=>$v){
	echo implode("=>",$ways[$k]).";\n";
}