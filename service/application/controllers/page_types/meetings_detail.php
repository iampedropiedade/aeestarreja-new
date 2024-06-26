<?php
namespace Application\Controller\PageType;

use Application\Models\Entity\Meetings as Model;
use Application\Page\Controller\PageController;
use Concrete\Core\Entity\User\User as UserEntity;
use Concrete\Core\Routing\Redirect as RoutingRedirect;
use Concrete\Core\User\User;
use Concrete\Core\Page\Page;
use Concrete\Core\Validation\CSRF\Token;
use Concrete\Package\Meetings\Entity\Group as GroupEntity;
use Concrete\Package\Meetings\Entity\Meeting as Entity;
use Doctrine\ORM\EntityManagerInterface;
use Application\Constants\Attributes;
use Application\Constants\Editor;


/**
 * Class MeetingsDetail
 * @package Application\Controller\PageType
 */
class MeetingsDetail extends PageController
{
    public const TOKEN_ACTION = 'meetings_form_submit';
    protected $entityManager;
    protected $user;
    protected $userInfo;
    protected $userEntity;
    protected $group;
    protected $postData;

    public function on_start()
    {
        parent::on_start();
        $this->entityManager = $this->app->make(EntityManagerInterface::class);
        $this->user = new User();
        if($this->user->uID) {
            $this->userInfo = $this->user->getUserInfoObject();
            $this->userEntity = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['uID' => $this->user->uID]);
        }
        $this->set('token', new Token());
        $this->set('tokenAction', self::TOKEN_ACTION);
        $this->set('userCompleteName', $this->userInfo->getAttributeValue(Attributes::USER_NAME));
        $this->getPostData();
    }

    public function view()
    {
        $this->entityManager = $this->app->make(EntityManagerInterface::class);
        $groupsList = $this->entityManager->getRepository(GroupEntity::class)->getAll();
        $this->set('groupsList', $groupsList);
        $editor = \Core::make('editor');
        $editor->setAllowFileManager(false);
        $editor->setAllowSitemap(false);
        $editor->getPluginManager()->deselect(Editor::DISABLED_PLUGINS_FOR_BASIC_EDITOR);
        $this->set('editor', $editor);
    }

    public function submit()
    {
        $model = new Model();
        $model->filterByDay($this->postData['datetimeObject']);
        if(!$this->validatePostData()) {
            return $this->view();
        }
        $this->set('meetings', $model->getResults());
        $this->set('submitted', true);
        $this->set('group', $this->entityManager->getRepository(GroupEntity::class)->findOneBy(['id'=>$this->postData['group']]));
    }

    public function confirmation()
    {
        if($this->postData['submit'] === 'update') {
            $this->view();
            return false;
        }
        if(!$this->validatePostData()) {
            return $this->view();
        }
        if($this->save()) {
            return RoutingRedirect::to(Page::getById($this->c->getCollectionParentID()));
        }
        $this->set('error', $this->error);
    }

    protected function save()
    {
        $entity = new Entity();
        $entity->setCreator($this->userEntity);
        $entity->setLocation($this->postData['location']);
        $entity->setPresidedBy($this->postData['presidedBy'] ?: $this->user->getUserInfoObject()->getAttributeValue(Attributes::USER_NAME));
        $entity->setContent($this->postData['content'], true);
        $entity->setGroup($this->group);
        $entity->setStartTimestamp($this->postData['datetimeObject']->getTimestamp());
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return true;
    }

    protected function getPostData()
    {
        $this->postData = $this->post('meeting');
        if($this->postData) {
            $this->postData['datetimeObject'] = date_create_from_format('d/m/Y H:i', $this->postData['datetime']);
            $this->group = $this->entityManager->getRepository(GroupEntity::class)->find(['id' => $this->postData['group']]);
            $this->set('postData', $this->postData);
        }
    }

    protected function validatePostData() : bool
    {
        if(!$this->user || !$this->userInfo) {
            $this->error->add(t('A sessão expirou, por favor autentique-se de novo.'));
        }

        if(!$this->postData['location']) {
            $this->error->add(t('O local é um campo obrigatório.'));
        }

        if(!$this->postData['content']) {
            $this->error->add(t('A ordem de trabalhos é um campo obrigatório.'));
        }

        if(!$this->group) {
            $this->error->add(t('O grupo é um campo obrigatório.'));
        }

        if(!$this->postData['datetimeObject'] || $this->postData['datetimeObject']->getTimestamp() < time()) {
            $this->error->add(t('Data inválida.'));
        }
        $this->set('errors', $this->error);
        if($this->error->has()) {
            return false;
        }

        return true;
    }

}