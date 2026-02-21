<?php
use Prado\Security\IUser;

Prado::using('Application.database.UserRecord');
Prado::using('Application.database.ProfileRecord');

class AppUser implements IUser
{
    private string $_name = '';
    private bool $_isGuest = true;
    private array $_habilitations = [];  
    private ?int $_userId = null;
    private ?string $_profileLabel = null;

    public function getName(): string { return $this->_name; }      
    public function setName($name) { $this->_name = (string)$name;  }
    public function getIsGuest() { return (bool)$this->_isGuest; }
    public function setIsGuest($v) { $this->_isGuest = (bool)$v; }

    public function getHabilitations(): array { return $this->_habilitations; }
    public function getUserId(): ?int { return $this->_userId; }
    public function getProfileLabel(): ?string { return $this->_profileLabel; }

    // IUser role compatibility
    public function getRoles()
    {
        return $this->_habilitations;
    }

    public function setRoles($value)
    {
        if (is_string($value)) {
            $parts = array_map('trim', explode(',', $value));
            $this->_habilitations = array_values(array_filter($parts, 'strlen'));
        } elseif (is_array($value)) {
            $this->_habilitations = $value;
        } else {
            $this->_habilitations = [];
        }
    }

      /////pour moi le role est l'habilitation,

    public function isInRole($role)
    {
        return in_array($role, $this->_habilitations);
    }

    // Serialization expected by Prado\Security\IUser
    public function saveToString()
    {
        $data = [];
        $this->saveToSession($data);
        return serialize($data);
    }

    public function loadFromString($string)
    {
        $data = @unserialize($string);
        if (!is_array($data)) {
            return $this;
        }
        $this->loadFromSession($data);
        return $this;
    }

    /**
     * Vérifie si l'utilisateur a une habilitation spécifique
     */
    public function can(string $habilitation): bool
    {
        return in_array($habilitation, $this->_habilitations);
    }





    /**
     * Charge depuis la DB et remplit les habilitations
     */
    public static function loadFromDb(string $email): ?self
    {
        $record = UserRecord::finder()->find('email = ?', $email);
        if (!$record) return null;

        // Bloquer les users désactivés
        if (!$record->active) return null;

        // Bloquer si le profil est désactivé
        if (!$record->profile || !$record->profile->active) return null;

        $user = new self();
        $user->_name = $record->email;
        $user->_isGuest = false;
        $user->_userId = $record->id;
        $user->_profileLabel = $record->profile->label;

        // Charger les habilitations du profil
        foreach ($record->profile->habilitations as $hab) {
            if ($hab->active) {
                $user->_habilitations[] = $hab->label;
            }
        }

        return $user;
    }

    // Sérialisation en session (PRADO stocke l'user en session)
    public function saveToSession(array &$data): void
    {
        $data['name']         = $this->_name;
        $data['isGuest']      = $this->_isGuest;
        $data['habs']         = $this->_habilitations;
        $data['userId']       = $this->_userId;
        $data['profileLabel'] = $this->_profileLabel;
    }

    public function loadFromSession(array $data): void
    {
        $this->_name         = $data['name'] ?? '';
        $this->_isGuest      = $data['isGuest'] ?? true;
        $this->_habilitations = $data['habs'] ?? [];
        $this->_userId       = $data['userId'] ?? null;
        $this->_profileLabel = $data['profileLabel'] ?? null;
    }
}