<?php

/*
 * This file is part of the TelegramBot package.
 *
 * (c) Avtandil Kikabidze aka LONGMAN <akalongman@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/
namespace Longman\TelegramBot\Entities;

use Longman\TelegramBot\Exception\TelegramException;

class Chat extends Entity
{

    protected $id;
    protected $type;
    protected $title;
    protected $username;
    protected $first_name;
    protected $last_name;

    public function __construct(array $data)
    {

        $this->id = isset($data['id']) ? $data['id'] : null;
        if (empty($this->id)) {
            throw new TelegramException('id is empty!');
        }

        $this->type = isset($data['type']) ? $data['type'] : null;

        $this->title = isset($data['title']) ? $data['title'] : null;
        $this->first_name = isset($data['first_name']) ? $data['first_name'] : null;
        $this->last_name = isset($data['last_name']) ? $data['last_name'] : null;
        $this->username = isset($data['username']) ? $data['username'] : null;
    }

    public function isGroupChat()
    {
        if ($this->type == 'group' ||  $this->id < 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isPrivateChat()
    {
        if ($this->type == 'private' || $this->id > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function isChannel()
    {
        if ($this->type == 'channel') {
            return true;
        } else {
            return false;
        }
    }

    public function getId()
    {

        return $this->id;
    }

    public function getType()
    {

        return $this->type;
    }

    public function getTitle()
    {

        return $this->title;
    }

    public function getFirstName()
    {

        return $this->first_name;
    }

    public function getLastName()
    {

        return $this->last_name;
    }

    public function getUsername()
    {

        return $this->username;
    }
}