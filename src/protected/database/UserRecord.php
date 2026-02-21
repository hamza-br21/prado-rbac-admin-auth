<?php
use Prado\Data\ActiveRecord\TActiveRecord;

class UserRecord extends TActiveRecord
{
    const TABLE = 'users';

    public $id;
    public $nom;
    public $email;
    //value by default 123
    public $password = '$2a$12$cSAS6LHu.gKqyy7zs7Ga/OYL9fhWmfyvUU7jtk0Y811i6ouK19Ajy';
    public $active; 
    
   //j'ai ajouté un champ id_profile pour stocker le profil user
    public $id_profile;

    public static $RELATIONS = array(
        'profile' => array(self :: BELONGS_TO, 'ProfileRecord', 'id_profile')
    );

    public static function finder($className = __CLASS__)
    {
        return parent::finder($className);
    }
}
