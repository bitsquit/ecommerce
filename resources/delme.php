<?php

class Shape {
	const PI = 3.1415;
	function __call($name, $args) {
		if($name === "area") 	{
			switch (count($args)) {
			case 0: return 0;
			case 1: return self::PI * $args[0] * $args[0];
			case 2: return $args[0] * $args[1];
			default: return "wrong input";
			}
		}
	}
}

$circle = new Shape();
echo $circle->area(3);

echo "\n";

$rect = new Shape();
echo $rect->area(8,6);

echo "\n";

?>
