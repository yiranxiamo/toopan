<?php
namespace lib\Storage;

class Local {
	var $path = null;
	function __construct($filepath = null) {
		if($filepath && is_dir($filepath)){
			$this->path = $filepath;
		}else{
			$this->path = ROOT.'file/';
			if(!is_dir($this->path)) mkdir($this->path);
		}
		return true;
	}
	function exists($name) {
		return file_exists($this->path.$name);
	}
	function get($name) {
		return file_get_contents($this->path.$name);
	}
	function downfile($name, $size) {
		$read_buffer = 4096;
		$handle = fopen($this->path.$name, 'rb');
		$sum_buffer = 0;
		while(!feof($handle) && $sum_buffer<$size) {
			echo fread($handle,$read_buffer);
			$sum_buffer += $read_buffer;
		}
		fclose($handle);
		return true;
	}
	function upload($name,$tmpfile) {
		return move_uploaded_file($tmpfile,$this->path.$name);
	}
	function savefile($name,$tmpfile) {
		return rename($tmpfile,$this->path.$name);
	}
	function getsize($name) {
		return filesize($this->path.$name);
	}
	function gettype($name) {
		if(function_exists("finfo_open")){
			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			$type = finfo_file($finfo, $this->path.$name);
			finfo_close($finfo);
			return $type;
		} else {return null;}
	}
	function delete($name) {
		return unlink($this->path.$name);
	}
}