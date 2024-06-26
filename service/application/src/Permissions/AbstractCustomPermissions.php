<?php
declare(strict_types=1);

namespace Application\Permissions;

use Concrete\Core\User\User;
use Concrete\Core\User\Group\Group;

/**
 * Class AbstractCustomPermissions
 * @package Application\Permissions
 */
abstract class AbstractCustomPermissions
{
    protected $groupPermissions = [];

    /**
     * @param string $permission
     * @param array $args
     * @return bool
     */
    public function __call(string $permission, array $args = []): bool
    {
        $user = new User();
        if ($user->isSuperUser()) {
            return true;
        }
        /** @var Group $userGroup */
        foreach ($user->getUserGroupObjects() as $userGroup) {
            $groupName = $userGroup->getGroupName();
            if (isset($this->groupPermissions[$groupName]) &&
                is_array($this->groupPermissions[$groupName]) &&
                in_array($permission, $this->groupPermissions[$groupName], true)) {
                return true;
            }
        }
        return false;
    }

}
