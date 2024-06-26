<?php
namespace Concrete\Package\MultipleFiles\Entity\Attribute\Value\Value;

use \Concrete\Core\Entity\File\File;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="atMultipleFilesSelectedFiles")
 */
class MultipleFilesSelectedFiles
{
    /**
     * @ORM\Id @ORM\Column(type="integer", options={"unsigned":true})
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $avsID;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Package\MultipleFiles\Entity\Attribute\Value\Value\MultipleFilesValue")
     * @ORM\JoinColumn(name="avID", referencedColumnName="avID", onDelete="CASCADE")
     */
    public $value;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"unsigned": true})
     */
    public $fID;

    /**
     * @ORM\ManyToOne(targetEntity="\Concrete\Core\Entity\File\File")
     * @ORM\JoinColumn(name="fID", referencedColumnName="fID", onDelete="CASCADE")
     */
    protected $file;

    /**
     * @return File
     */
    public function getFile() : File
    {
        return $this->file;
    }

    /**
     * @param File $file
     * @return MultipleFilesSelectedFiles
     */
    public function setFile($file) : self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttributeValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return MultipleFilesSelectedFiles
     */
    public function setAttributeValue($value) : self
    {
        $this->value = $value;
        return $this;
    }
}
