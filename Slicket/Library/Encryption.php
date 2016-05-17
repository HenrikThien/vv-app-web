<?php
namespace Slicket\Library;
use Slicket\Library\Crypt\Crypt_AES as Crypt_AES;
use Slicket\Library\Crypt\Crypt_RSA as Crypt_RSA;

class Encryption 
{
	// plain text
	public $AESMessage = "";
	
	private $private_key;
	private $rsa_public;
	private $db;
	
	public function __construct($db) {
		$this->load_public_key();
		$this->db = $db;
		
		include 'Slicket\\Library\\Cert\\private.php';
		$this->private_key = $privateKey;
	}
	
	private function load_public_key() {
		$this->rsa_public = file_get_contents("Slicket\\Library\\Cert\\public.crt");
	}
	
	public function get_public_key() {
		return $this->rsa_public;
	}
	
	public function establish_connection($key,$iv) {
		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
		$rsa->loadKey($this->private_key);
		
		$key = $rsa->decrypt($this->Base64UrlDecode($key));
		$iv  = $rsa->decrypt($this->Base64UrlDecode($iv));

		return $this->getEncryptedResponse("AES OK", $key, $iv);
	}
	
	private function getEncryptedResponse($message, $key, $iv) {
		$aes = new Crypt_AES(CRYPT_AES_MODE_CBC);
		$aes->setKeyLength(256);
		$aes->setKey($key);
		$aes->setIV($iv);
		$aes->enablePadding();
		
		return $this->Base64UrlEncode($aes->encrypt($message));
	}
	
	public function decryptMessage($message,$key,$iv) {
		$rsa = new Crypt_RSA();
		$rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
		$rsa->loadKey($this->private_key);
		
		$decryptedKey = $rsa->decrypt($this->Base64UrlDecode($key));
		$decryptedIv  = $rsa->decrypt($this->Base64UrlDecode($iv));
		
		$aes = new Crypt_AES(CRYPT_AES_MODE_CBC);
		$aes->setKeyLength(256);
		$aes->setKey($decryptedKey);
		$aes->setIV($decryptedIv);
		$aes->enablePadding();
		
		$message = $aes->decrypt($this->Base64UrlDecode($message));
		return $message;
	}
	
	private function Base64UrlDecode($x)
	{
		return base64_decode(str_replace(array('_','-'), array('/','+'), $x));
	}
	private function Base64UrlEncode($x)
	{
		return str_replace(array('/','+'), array('_','-'), base64_encode($x));
	}
}