<?php
namespace lib\Storage;

class Qcloud {
	private $bucket;
	private $cosClient;
	private $errmsg;
	private $filepath = 'file/';
	function __construct($secretId, $secretKey, $region, $bucket) {
		$this->bucket = $bucket;
		$this->cosClient = new \Qcloud\Cos\Client(
			array(
				'region' => $region,
				'schema' => 'http',
				'verify' => false,
				'credentials'=> array(
					'secretId'  => $secretId ,
					'secretKey' => $secretKey)));
	}
	function getClient(){
		return $this->cosClient;
	}
	function errmsg(){
		return $this->errmsg;
	}
	function exists($name) {
		try {
			$result = $this->cosClient->headObject(['Bucket'=>$this->bucket, 'Key'=>$this->filepath.$name]);
			return true;
        } catch(\Qcloud\Cos\Exception\ServiceResponseException $e) {
			return false;
		}
	}
	function get($name) {
		try {
			$content = $this->cosClient->getObject(['Bucket'=>$this->bucket, 'Key'=>$this->filepath.$name]);
			return $content['Body'];
        } catch(\Qcloud\Cos\Exception\ServiceResponseException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function downfile($name, $size=0) {
		try {
			$content = $this->cosClient->getObject(['Bucket'=>$this->bucket, 'Key'=>$this->filepath.$name]);
			echo $content['Body'];
			return true;
        } catch(\Qcloud\Cos\Exception\ServiceResponseException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function upload($name,$tmpfile) {
        try {
			$this->cosClient->upload($this->bucket, $this->filepath.$name, fopen($tmpfile, 'rb'));
			return true;
        } catch(\Qcloud\Cos\Exception\ServiceResponseException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function getinfo($name) {
		try {
			$objectMeta = $this->cosClient->headObject(['Bucket'=>$this->bucket, 'Key'=>$this->filepath.$name]);
			$result = ['length'=>$objectMeta['ContentLength'], 'content_type'=>$objectMeta['ContentType']];
			return $result;
        } catch(\Qcloud\Cos\Exception\ServiceResponseException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function delete($name) {
		try {
			$this->cosClient->deleteObject(['Bucket'=>$this->bucket, 'Key'=>$this->filepath.$name]);
			return true;
        } catch(\Qcloud\Cos\Exception\ServiceResponseException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
}