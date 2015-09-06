<?php

/*
 * BaseModel - provides database connection
 */

namespace App\Model;

use Nette;
use Nette\Object;

abstract class BaseModel extends Object {

    protected $db;

    public function __construct(Nette\Database\Context $db) {
        $this->db = $db;
    }

}
