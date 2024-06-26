<?php
declare(strict_types=1);

namespace Application\Service;

use Concrete\Core\User\User;
use Concrete\Core\User\UserList;
use Concrete\Core\User\Group\Group;
use Concrete\Core\User\UserInfo;

/**
 * Class GroupsService
 * @package Application\Services
 */
class GroupsService
{

    /**
     * @param string $groupName
     * @return array
     */
    public function getUsersEmailsByGroupName(string $groupName): array
    {
        /** @var ?Group $group */
        $group = Group::getByName($groupName);
        if ($group === null) {
            return [];
        }
        $userList = new UserList();
        $userList->ignorePermissions();
        $userList->filterByGroup($group);
        /** @var User[] $users */
        $users = $userList->getResults();
        if (empty($users)) {
            return [];
        }
        $notifyEmails = [];
        /** @var UserInfo $user */
        foreach ($users as $user) {
            $email = $user->getUserEmail();
            $notifyEmails[$email] = $email;
        }
        return $notifyEmails;
    }

}
