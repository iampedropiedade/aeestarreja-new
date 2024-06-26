<?php

namespace Application\Constants;

use Concrete\Package\RelatedPages\Controller;
use \ORM;
use Concrete\Core\Entity\Attribute\Key\Key;
use Concrete\Attribute\Select\Controller as SelectController;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption;
use Concrete\Core\Entity\Attribute\Value\Value\SelectValueUsedOption;

/**
 * Class Editor
 * @package Application\Constants
 */
class Editor
{

    // Plugins
    public const DISABLED_PLUGINS_FOR_BASIC_EDITOR = [
        'entities', 'floatingspace', 'justify','list','liststyle','magicline','resize',
        'showborders','concrete5inline','normalizeonchange', 'autogrow','a11yhelp',
        'contextmenu','concrete5styles','dialogadvtab','divarea','elementspath',
        'enterkey', 'strikethrough', 'subscript', 'superscript', 'concrete5link',
        'removeformat', 'tab', 'outdent', 'indentlist', 'format', 'stylescombo',
        'removeformat', 'image', 'image2', 'sourcearea', 'sourcedialog', 'table',
        'tableresize', 'tableselection', 'tabletools', 'underline',
        'specialcharacters', 'colordialog', 'indentblock', 'htmlwriter', 'showblocks'
    ];

}
