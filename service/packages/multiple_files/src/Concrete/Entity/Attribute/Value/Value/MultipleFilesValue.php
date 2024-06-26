<?php
namespace Concrete\Package\MultipleFiles\Entity\Attribute\Value\Value;

use Concrete\Core\File\FileProviderInterface;
use Concrete\Core\Entity\Attribute\Value\Value\AbstractValue;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="atMultipleFilesValue")
 */
class MultipleFilesValue extends AbstractValue implements FileProviderInterface
{
    /**
     * @ORM\OneToMany(targetEntity="\Concrete\Package\MultipleFiles\Entity\Attribute\Value\Value\MultipleFilesSelectedFiles",
     *     cascade={"persist", "remove"}, mappedBy="value")
     * @ORM\JoinColumn(name="avID", referencedColumnName="avID")
     */
    protected $files;

    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    public function getSelectedFiles()
    {
        return $this->files;
    }

    /**
     * @param $files
     * @return MultipleFilesValue
     */
    public function setSelectedFiles($files) : self
    {
        $this->files = $files;
        return $this;
    }

    /**
     * @return array|\Concrete\Core\File\File[]
     */
    public function getFileObjects() : array
    {
        $files = [];
        $values = $this->getSelectedFiles();
        if ($values->count()) {
            foreach ($values as $f) {
                $files[] = $f->getFile();
            }
        }
        return $files;
    }

    public function __toString()
    {
        $items = [];
        foreach ($this->getFileObjects() as $file) {
            /** @var \Concrete\Core\Entity\File\File $file */
            $items[] = \URL::to('/download_file', $file->getFileID());
        }
        return implode(' ', $items);
    }
}
