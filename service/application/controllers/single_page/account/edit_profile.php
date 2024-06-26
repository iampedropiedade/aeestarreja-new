<?php

namespace Application\Controller\SinglePage\Account;

use Concrete\Core\Entity\Attribute\Key\UserKey;
use Concrete\Core\Error\UserMessageException;
use Concrete\Core\User\User;
use UserAttributeKey;
use \Concrete\Core\User\UserInfo;
use Concrete\Core\Support\Facade\Application;

class EditProfile extends \Concrete\Controller\SinglePage\Account\EditProfile
{

    public function view()
    {
        $profile = $this->get('profile');
        if (!is_object($profile)) {
            throw new UserMessageException(t('You must be logged in to access this page.'));
        }

        $em = \ORM::entityManager();
        /** @var User $user */
        $user = \Core::make(User::class);
        $userInfo = $user->getUserInfoObject();
        $attributes = [
            'name' => 'name',
        ];
        $userData = [];
        foreach($attributes as $key=>$attribute) {
            $userData[$key]['attr'] = $em->getRepository(UserKey::class)->findOneBy(['akHandle'=>$attribute]);
            $userData[$key]['field'] = 'akID[' . $userData[$key]['attr']->getAttributeKeyID() . '][value]';
            $userData[$key]['value'] = $userInfo->getAttributeValue($attribute);
        }
        $this->set('userData', $userData);
        $this->set('email', $userInfo->getUserEmail());
    }

    public function save_complete()
    {
        $this->set('message', t('Your details were updated successfully.'));
        $this->view();
    }

    public function save()
    {
        $this->view();
        /* @var UserInfo $ui */
        $ui = $this->get('profile');

        $app = $this->app;
        $valt = $app->make('token');
        $data = $this->post();

        if(!$valt->validate('profile_edit')) {
            $this->error->add($valt->getErrorMessage());
        }

        if($data['action'] === 'delete') {
            \Core::make(User::class)->logout();
            $ui->delete();
            $this->redirect('/');
            Application::shutdown();
        }

        if($data['action'] === 'save') {
            $aks = UserAttributeKey::getEditableInProfileList();
            foreach ($aks as $uak) {
                $controller = $uak->getController();
                $validator = $controller->getValidator();
                $response = $validator->validateSaveValueRequest($controller, $this->request, $uak->isAttributeKeyRequiredOnProfile());
                if (!$response->isValid()) {
                    $error = $response->getErrorObject();
                    $this->error->add($error);
                }
            }

            if (!$this->error->has()) {
                $data['uEmail'] = $ui->getUserEmail();
                $ui->saveUserAttributesForm($aks);
                $ui->update($data);
                $this->redirect('/account/edit_profile', 'save_complete');
            }
        }
    }
}