<?php
namespace lib\Storage;

class Upyun {
	private $client;
	private $errmsg;
	private $filepath = 'file/';
	function __construct($operatorName, $operatorPwd, $serviceName) {
		$serviceConfig = new \Upyun\Config($serviceName, $operatorName, $operatorPwd);
		$this->client = new \Upyun\Upyun($serviceConfig);
	}
	function getClient(){
		return $this->client;
	}
	function errmsg(){
		return $this->errmsg;
	}
	function exists($name) {
		try {
			return $this->client->has($this->filepath.$name);
        } catch(\Exception $e) {
			return false;
		}
	}
	function get($name) {
		try {
			return $this->client->read($this->filepath.$name);
        } catch(\Exception $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function downfile($name, $size=0) {
		try {
			echo $this->client->read($this->filepath.$name);
        } catch(\Exception $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function upload($name,$tmpfile) {
        try {
			$this->client->write($this->filepath.$name, fopen($tmpfile, 'rb'));
			return true;
        } catch(\Exception $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function getinfo($name) {
		try {
			$info = $this->client->info($this->filepath.$name);
			$minetype = $this->client->getMimetype($this->filepath.$name);
			$result = ['length'=>$info['x-upyun-file-size'], 'content_type'=>$minetype];
			return $result;
        } catch(\Exception $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function delete($name) {
		try {
			return $this->client->delete($this->filepath.$name);
        } catch(\Exception $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
}