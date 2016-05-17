<?php

namespace Slicket\Library\Databases\Interfaces;

interface iDatabase {
    public function init();
    public function query($query);
    public function bind($param, $value, $type = null);
    public function resultSet($fetch = null);
    public function single($fetch = null);
    public function getRowCount();
    public function getLastInsertId();
    public function execute();
}
