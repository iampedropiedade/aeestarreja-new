<?php
declare(strict_types=1);

namespace Application\Permissions;

use Application\Constants\Groups;

/**
 * Class ApiPermissions
 * @package Application\Permissions
 * @method bool canViewAllTickets()
 * @method bool canCloseTickets()
 */
class Permissions extends AbstractCustomPermissions
{
    public const CAN_VIEW_ALL_TICKETS = 'canViewAllTickets';
    public const CAN_CLOSE_TICKETS = 'canCloseTickets';

    protected $groupPermissions = [
        Groups::ADMINISTRATORS => [
            self::CAN_VIEW_ALL_TICKETS,
            self::CAN_CLOSE_TICKETS,
        ],
        Groups::SYS_ADMINS => [
            self::CAN_VIEW_ALL_TICKETS,
            self::CAN_CLOSE_TICKETS,
        ],
    ];

}
