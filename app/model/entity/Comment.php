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
 * @property string $message
 * @property \DateTime $created_at
 */
class Comment extends BaseEntity
{

    /** @return \App\Model\Entity\User */
    public function getUser() {
        return new User($this->record->user);
    }

}