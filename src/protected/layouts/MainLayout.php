<?php
use Prado\Web\UI\TTemplateControl;

class MainLayout extends TTemplateControl
{
    public function onLoad($param)
    {
        parent::onLoad($param);

        $session  = $this->Application->getSession();
        $userId   = $session->itemAt('userId');
        $profile  = $session->itemAt('profileLabel');
        $email    = $session->itemAt('email');
     

        if ($userId && $email) {
            $this->UserInfoPanel->Visible = true;
            $name = htmlspecialchars($email);
            $prof = $profile ? htmlspecialchars($profile) : '';
            $this->UserInfoText->Text = $prof
                ? $name . ' &nbsp;&middot;&nbsp; <em>' . $prof . '</em>'
                : $name;
        } else {
            $this->UserInfoPanel->Visible = false;
            // $this->UserNav->Visible = false;
            $this->UserNav1->Visible = false;
            $this->UserNav2->Visible = false;
            $this->UserNav3->Visible = false;
        }
    }
}