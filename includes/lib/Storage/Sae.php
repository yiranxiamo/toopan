<?php
namespace lib\Storage;

class Sae { //SaeStorage
	private $Storage = null;
	private $errmsg;
	private $domain;
	private $path = 'file/';
	function __construct($Storage) {
		$this->Storage = new \SaeStorage();
		$this->domain = $Storage;
		return true;
	}
	function getClient(){
		return $this->Storage;
	}
	function errmsg(){
		return $this->errmsg;
	}
	function exists($name) {
		return $this->Storage->fileExists($this->domain, $this->path.$name);
	}
	function get($name) {
		return $this->Storage->read($this->domain, $this->path.$name);
	}
	function downfile($name, $size=0) {
		$res = $this->Storage->read($this->domain, $this->path.$name);
		echo $res;
		return true;
	}
	function upload($name,$tmpfile) {
		return $this->Storage->upload($this->domain,$this->path.$name, $tmpfile);
	}
	function getinfo($name) {
		$res = $this->Storage->getAttr($this->domain, $this->path.$name);
		$result = ['length'=>$res['length'], 'content_type'=>$res['content_type']];
		return $result;
	}
	function delete($name) {
		return $this->Storage->delete($this->domain, $this->path.$name);
	}
}