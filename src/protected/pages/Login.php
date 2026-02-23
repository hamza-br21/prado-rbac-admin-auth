<?php
use Prado\Web\UI\TPage;

Prado::using('Application.database.AppUser');
Prado::using('Application.database.UserRecord');

class Login extends TPage
{
    public function onLogin($sender, $param)
    {
        $email    = trim($this->Email->Text);
        $password = $this->Password->Text;

        // Chercher l'utilisateur en DB
        $record = UserRecord::finder()->find('email = ?', $email);

        if (!$record) {
            $this->ErrorMsg->Text = "Email ou mot de passe incorrect.";
            return;
        }

        // Vérifier le mot de passe (ici simple, voir note sécurité ci-dessous)
        if (!password_verify($password, $record->password)) {
            $this->ErrorMsg->Text = "Email ou mot de passe incorrect.";
            return;
        }

        // Vérifier active user
        if (!$record->active) {
            $this->ErrorMsg->Text = "Votre compte est désactivé.";
            return;
        }

        // Vérifier active profil
        if (!$record->profile || !$record->profile->active) {
            $this->ErrorMsg->Text = "Votre profil est désactivé. Contactez un administrateur.";
            return;
        }

        // Créer l'AppUser et le mettre en session
        $appUser = AppUser::loadFromDb($email);
        // meme je fait ici setIsGuest true il reste la valeur de BasePage
        $this->Application->getUser()->setIsGuest(false);
        $this->Application->getUser()->setName($appUser->getName());
        
        

        //  var_dump($this->Application->getUser()->getIsGuest());
        // die();
        // Stocker les habilitations en session
        $this->Session['habilitations'] = $appUser->getHabilitations();
        $this->Session['userId']        = $appUser->getUserId();
        $this->Session['profileLabel']  = $appUser->getProfileLabel();
        
        //       ////////////////
       
        $this->Session['email'] = $email; 
        $this->Session['password'] = $password; 


        // Rediriger vers Home
        $this->Response->redirect($this->Service->constructUrl('Home'));
    }
}