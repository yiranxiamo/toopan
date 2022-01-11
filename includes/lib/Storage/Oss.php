<?php
namespace lib\Storage;

class Oss {
	private $bucket;
	private $ossClient;
	private $errmsg;
	private $filepath = 'file/';
	function __construct($accessKeyId, $accessKeySecret, $endpoint, $bucket) {
		$this->bucket = $bucket;
		$this->ossClient = new \OSS\OssClient($accessKeyId, $accessKeySecret, $endpoint);
	}
	function getClient(){
		return $this->ossClient;
	}
	function errmsg(){
		return $this->errmsg;
	}
	function exists($name) {
		try {
			return $this->ossClient->doesObjectExist($this->bucket, $this->filepath.$name);
        } catch(\OSS\Core\OssException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function get($name) {
		try {
			$content = $this->ossClient->getObject($this->bucket, $this->filepath.$name);
			return $content;
        } catch(\OSS\Core\OssException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function downfile($name, $size=0) {
		try {
			$content = $this->ossClient->getObject($this->bucket, $this->filepath.$name);
			echo $content;
			return true;
        } catch(\OSS\Core\OssException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function upload($name,$tmpfile) {
        try {
			$this->ossClient->uploadFile($this->bucket, $this->filepath.$name, $tmpfile);
			return true;
        } catch(\OSS\Core\OssException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function getinfo($name) {
		try {
			$objectMeta = $this->ossClient->getObjectMeta($this->bucket, $this->filepath.$name);
			$result = ['length'=>$objectMeta['content-length'], 'content_type'=>$objectMeta['content-type']];
			return $result;
        } catch(\OSS\Core\OssException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
	function delete($name) {
		try {
			$this->ossClient->deleteObject($this->bucket, $this->filepath.$name);
			return true;
        } catch(\OSS\Core\OssException $e) {
			$this->errmsg = __FUNCTION__ . ": " . $e->getMessage();
			trigger_error($this->errmsg);
			return false;
		}
	}
}