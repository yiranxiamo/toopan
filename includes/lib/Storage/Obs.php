<?php
namespace lib\Storage;

class Obs {
	private $bucket;
	private $obsClient;
	private $errmsg;
	private $filepath = 'file/';
	function __construct($accessKey, $secretKey, $endpoint, $bucket) {
		$this->bucket = $bucket;
		$this->obsClient = new \Obs\ObsClient([
			'key' => $accessKey,
			'secret' => $secretKey,
			'endpoint' => $endpoint,
			'ssl_verify' => false,
		]);
	}
	function getClient(){
		return $this->obsClient;
	}
	function errmsg(){
		return $this->errmsg;
	}
	function exists($name) {
		try {
			$this->obsClient->getObjectMetadata([
				'Bucket' => $this->bucket,
				'Key' => $this->filepath.$name
			]);
			return true;
        } catch(\Obs\ObsException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->__toString();
			return false;
		}
	}
	function get($name) {
		try {
			$resp = $this->obsClient->getObject([
				'Bucket' => $this->bucket,
				'Key' => $this->filepath.$name
			]);
			return $resp['Body'];
        } catch(\Obs\ObsException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->__toString();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function downfile($name, $size=0) {
		try {
			$resp = $this->obsClient->getObject([
				'Bucket' => $this->bucket,
				'Key' => $this->filepath.$name
			]);
			echo $resp['Body'];
			return true;
        } catch(\Obs\ObsException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->__toString();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function upload($name,$tmpfile) {
        try {
			$this->obsClient->putObject([
				'Bucket' => $this->bucket,
				'Key' => $this->filepath.$name,
				'SourceFile' => $tmpfile
			]);
			return true;
        } catch(\Obs\ObsException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->__toString();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function getinfo($name) {
		try {
			$objectMeta = $this->obsClient->getObjectMetadata([
				'Bucket' => $this->bucket,
				'Key' => $this->filepath.$name
			]);
			$result = ['length'=>$objectMeta['ContentLength'], 'content_type'=>$objectMeta['ContentType']];
			return $result;
        } catch(\Obs\ObsException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->__toString();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function delete($name) {
		try {
			$this->obsClient->deleteObject([
				'Bucket' => $this->bucket,
				'Key' => $this->filepath.$name
			]);
			return true;
        } catch(\Obs\ObsException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->__toString();
			trigger_error($this->errmsg);
			return false;
		}
	}
}