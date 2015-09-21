<?php
/**
 * Created by PhpStorm.
 * User: samik
 * Date: 21.9.15
 * Time: 1:16
 */

namespace App\Model\Entity;


use App\Model\Entities\BaseEntity;
use YetORM\Entity;
use YetORM\EntityCollection;

/**
 * @property-read int $id
 * @property string $username
 * @property string $password
 * @property string $role
 */
class User extends BaseEntity
{

}