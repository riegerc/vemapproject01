<?php
class Helper{
		public static function sanitize(string $str):string{
		    return strip_tags(stripslashes(trim($str)));
		}
		public static function getId(string $s){
			return substr($s,strpos($s,"inp")+3,strlen($s));
		}
}
?>