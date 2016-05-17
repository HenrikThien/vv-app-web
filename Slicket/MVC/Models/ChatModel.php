<?php

namespace Slicket\MVC\Models;
use Slicket\Library\BaseModel as BaseModel;
use Slicket\Library\Encryption as Encryption;

class ChatModel extends BaseModel {
    private $db = null;
    private $encryption;

    public function __construct($db) {
        $this->db = $db;
        $this->encryption = new Encryption($this->db);
    }
    
    public function getEncryption() {
        return $this->encryption;
    }
    
    public function get_my_chats() {
        $this->db->query("SELECT * FROM chats WHERE contact_a = :pid OR contact_b = :pid;");
        $this->db->bind(":pid", "Büro");
        $this->db->execute();
        
        return $this->db->resultSet();
    }
    
    public function saveEncryptedMessage($from,$message,$key,$iv) {
        $this->db->query("INSERT INTO chat_messages (sender,receiver,date,encrypted_message,encrypted_key,encrypted_iv) VALUES (:psender,:preceiver,:pdate,:pmessage,:pkey,:piv)");
        $this->db->bind(":psender", $from);
        $this->db->bind(":preceiver", -1);
        $this->db->bind(":pdate", date());
        $this->db->bind(":pmessage", $message);
        $this->db->bind(":pkey", $key);
        $this->db->bind(":piv");
    }
}