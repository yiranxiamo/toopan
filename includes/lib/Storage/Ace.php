<?php
namespace lib\Storage;

class Ace { //AceStorage
	private $Storage = null;
	private $errmsg;
	function __construct($Storage) {
		$this->Storage = \Alibaba::Storage($Storage);
		return true;
	}
	function getClient(){
		return $this->Storage;
	}
	function errmsg(){
		return $this->errmsg;
	}
	function exists($name) {
		return $this->Storage->fileExists($name);
	}
	function get($name) {
		return $this->Storage->get($name);
	}
	function downfile($name, $size=0) {
		$res = $this->Storage->get($name);
		echo $res;
		return true;
	}
	function upload($name,$tmpfile) {
		return $this->Storage->saveFile($name, $tmpfile);
	}
	function getinfo($name) {
		$res = $this->Storage->getMeta($name);
		$result = ['length'=>$res['content-length'], 'content_type'=>$res['content-type']];
		return $result;
	}
	function delete($name) {
		return $this->Storage->delete($name);
	}
}
