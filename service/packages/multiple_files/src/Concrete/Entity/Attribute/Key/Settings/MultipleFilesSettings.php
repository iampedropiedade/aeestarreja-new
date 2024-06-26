<?php
namespace Concrete\Package\MultipleFiles\Entity\Attribute\Key\Settings;
use Concrete\Core\Entity\Attribute\Key\Settings\Settings;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="atMultipleFilesSettings")
 */
class MultipleFilesSettings extends Settings
{
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $akMaxFilesCount;

    public function getAttributeTypeHandle() : string
    {
        return 'multiple_files';
    }

    /**
     * @return integer
     */
    public function getMaxFilesCount() : int
    {
        return $this->akMaxFilesCount ?: 0;
    }

    /**
     * @param $maxFilesCount
     * @return MultipleFilesSettings
     */
    public function setMaxFilesCount($maxFilesCount) : self
    {
        $this->akMaxFilesCount = $maxFilesCount;
        return $this;
    }

}
