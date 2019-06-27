<?php
class Helper{
		public static function sanitize(string $str):string{
		    return strip_tags(stripslashes(trim($str)));
		}
		public static function getId(string $s, string $prefix){
			return substr($s,strpos($s,$prefix)+3,strlen($s));
		}
}
?>
