<?php
use Prado\Web\UI\TPage;
Prado::using('Application.database.AppUser');
Prado::using('Application.database.UserRecord');    
class Logout extends TPage
{
    public function onLoad($param)
    {
        parent::onLoad($param);

// Rediriger vers Login si session non valide

         $this->Session->open();
        // var_dump($this->Session['email']);
        // var_dump($this->Session['password']);
        // var_dump($this->Session['habilitations']);
        // var_dump($this->Session['userId']);
        // var_dump($this->Session['profileLabel']);
        // die();
       
        $this->Application->getUser()->setIsGuest(true);
        $this->Session->clear();    
        $this->Session->destroy(); 
        // var_dump($this->Session['email']);
        // var_dump($this->Session['password']);
        // var_dump($this->Session['habilitations']);
        // var_dump($this->Session['userId']);
        // var_dump($this->Session['profileLabel']);
        // die();
            $this->Response->redirect($this->Service->constructUrl('Login'));
            return;
    }
}
