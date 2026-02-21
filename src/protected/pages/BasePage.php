<?php
use Prado\Web\UI\TPage;

class BasePage extends TPage
{

public function onLoad($param)
{
    parent::onLoad($param);
    
    // Rafraîchir les habilitations depuis la DB à chaque requête
    $userId = $this->Session['userId'] ?? null;
    if ($userId) {
        $user = UserRecord::finder()->findByPk($userId);
        if (!$user || !$user->active || !$user->profile || !$user->profile->active) {
            // User ou profil désactivé → déconnecter
            $this->Application->getUser()->setIsGuest(true);
            $this->Session->clear();
            $this->Response->redirect($this->Service->constructUrl('Login'));
            return;
        }
        // Mettre à jour les habs en session
        $habs = [];
        foreach ($user->profile->habilitations as $hab) {
            if ($hab->active) $habs[] = $hab->label;
        }
        $this->Session['habilitations'] = $habs;
        $this->Session['profileLabel'] = $user->profile->label;
    }
}
    /**
     * Vérifie si le user connecté a une habilitation
     */
    public function can(string $habilitation): bool
    {
        $habs = $this->Session['habilitations'] ?? [];
        return in_array($habilitation, $habs);
    }


    ////////////////////////////////////////////////////////////////////////////////////////////////////

      public function isInProfile($profileLabel): bool
    {
       return  $this->Session['profileLabel'] === $profileLabel;
    }

    ///////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Appelé au chargement : redirige si pas l'habilitation requise
     */
    protected function requireHabilitation(string $habilitation): void
    {
        if (!$this->can($habilitation)) {
            $this->Response->redirect($this->Service->constructUrl('Home'));
        }
    }

    public function getUserId(): ?int
    {
        return $this->Session['userId'] ?? null;
    }
}