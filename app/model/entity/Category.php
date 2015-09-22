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


/**
 * @property-read int $id
 * @property string $title
 * @property string $url
 * @property \DateTime $created_at
 */
class Category extends BaseEntity
{

}
