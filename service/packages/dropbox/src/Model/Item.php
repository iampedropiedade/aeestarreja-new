<?php
namespace Concrete\Package\Dropbox\Model;

use stdClass;
use DateTime;

class Item
{
    protected const ICONS = [
        'video' => ['mp4', 'mpg', 'avi'],
        'audio' => ['mp3'],
        'word' => ['doc', 'docx'],
        'excel' => ['xls', 'xlsx'],
        'image' => ['jpg', 'jpeg', 'gif', 'png'],
        'pdf' => ['pdf']
    ];

    protected string $name;
    protected string $displayName;
    protected string $iconExtension;
    protected string $completePath;
    protected string $path;
    protected bool $isDir;
    protected ?string $root = null;
    protected ?string $size = null;
    protected ?string $link = null;
    protected ?DateTime $date;
    protected string $extension;

    public function __construct(stdClass $object, string $rootPath)
    {
        $itemPath = str_ireplace($rootPath, '', $object->path);
        $path = explode('/', $itemPath);
        $this->setPath($itemPath);
        $name = array_pop($path);
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $this->setName($name);
        $this->setDisplayName($name);
        $this->setExtension(strtolower($extension));
        $this->setIconExtension($extension);
        $this->setCompletePath($rootPath . $itemPath);
        $this->setPath($itemPath);
        $this->setIsDir($object->is_dir);
        $this->setRoot($object->root ?? null);
        $this->setSize($object->size ?? null);
        $this->setDate($object->modified ?? '');
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Item
    {
        $this->name = $name;
        return $this;
    }

    public function getDisplayName(): string
    {
        return $this->displayName;
    }

    public function setDisplayName(string $name): Item
    {
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $this->displayName = ucwords(strtolower(str_replace(['-', '_', '.' . $extension], [' ', ' ', ''], $name)));
        return $this;
    }

    public function getIconExtension(): string
    {
        return $this->iconExtension;
    }

    public function setIconExtension(): Item
    {
        $extension = $this->getExtension();
        $this->iconExtension = 'file';
        foreach(self::ICONS as $type => $extensions) {
            if(in_array($extension, $extensions)) {
                $this->iconExtension = $type;
            }
        }
        return $this;
    }

    public function getCompletePath(): string
    {
        return $this->completePath;
    }

    public function setCompletePath(string $completePath): Item
    {
        $this->completePath = $completePath;
        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): Item
    {
        $this->path = $path;
        return $this;
    }

    public function isDir(): bool
    {
        return $this->isDir;
    }

    public function setIsDir(bool $isDir): Item
    {
        $this->isDir = $isDir;
        return $this;
    }

    public function getRoot(): ?string
    {
        return $this->root;
    }

    public function setRoot(?string $root): Item
    {
        $this->root = $root;
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): Item
    {
        if($size === null) {
            $this->size = null;
            return $this;
        }
        if($size >= 1<<30) {
            $this->size = number_format($size / (1 << 30)) . ' GB';
            return $this;
        }
        if($size >= 1<<20) {
            $this->size = number_format($size / (1 << 20)) . ' MB';
            return $this;
        }
        if($size >= 1<<10) {
            $this->size = number_format($size / (1 << 10)) . ' KB';
            return $this;
        }
        $this->size = number_format($size) . ' bytes';
        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): Item
    {
        $this->link = $link;
        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(?string $date): Item
    {
        $this->date = new DateTime($date ?? '');
        return $this;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): Item
    {
        $this->extension = $extension;
        return $this;
    }

    public function getType(): string
    {
        return $this->isDir() ? 'folders' : 'files';
    }

}