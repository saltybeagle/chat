<?php
namespace Chat\User;

class User extends \Chat\Record
{
    public $id;           //INT(32)
    public $first_name;   //VARCHAR(256)
    public $last_name;    //VARCHAR(256)
    public $date_created; //DATETIME
    public $date_edited;  //DATETIME
    public $email;        //VARCHAR(256)
    protected $password;     //VARCHAR(256)
    public $username;     //VARCHAR(256)
    public $role;         //ENUM('ADMIN', 'USER')
    public $status;       //ENUM('ACTIVE', 'BANNED');
    public $chat_status;  //ENUM('AVAILABLE', 'BUSY', 'OFFLINE')

    public static function getByID($id)
    {
        return self::getByAnyField(__CLASS__, 'id', (int)$id);
    }

    public static function getByUsername($username)
    {
        return self::getByAnyField(
            __CLASS__,
           'username',
            \DB\RecordList::escapeString($username)
        );
    }

    public static function getByEmail($email)
    {
        return self::getByAnyField(
            __CLASS__,
            'email',
            \DB\RecordList::escapeString($email)
        );
    }

    public function keys()
    {
        return array('id');
    }

    public static function getTable()
    {
        return 'users';
    }

    public function insert()
    {
        $this->date_created = \Chat\Util::epochToDateTime();
        $this->date_edited  = \Chat\Util::epochToDateTime();

        return parent::insert();
    }

    public function update()
    {
        $this->date_edited = \Chat\Util::epochToDateTime();

        return parent::update();
    }

    public function render()
    {
        //Convert this object to an array
        $data = $this->toArray();

        //Don't send the password
        unset($data['password']);

        return $data;
    }

    public function getURL()
    {
        if (!$this->id) {
            return false;
        }

        return \Chat\Config::get("URL") . "users/" . $this->id;
    }

    public function getEditURL()
    {
        if (!$url = $this->getURL()) {
            return false;
        }

        return $url . '/edit';
    }
}