<?php
namespace Concrete\Package\Dropbox\Model;

use stdClass;
use DateTime;

class Folder
{
    protected const SORT_NAME = 'name';
    protected const SORT_DATE = 'date';
    protected const SORT_DATE_DESC = 'date desc';
    protected const SORT_OPTIONS = [
        self::SORT_NAME,
        self::SORT_DATE,
        self::SORT_DATE_DESC,
    ];

    protected string $path;

    /**
     * @var array<Item>
     */
    protected array $folders;
    /**
     * @var array<Item>
     */
    protected array $files;

    public function __construct(string $completePath)
    {
        $this->path = $completePath;
    }

    public function hasContent(): bool
    {
        return count($this->folders) > 0 || count($this->files) > 0;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): Folder
    {
        $this->path = $path;
        return $this;
    }

    public function addItem(Item $item): self
    {
        if($item->isDir() === true) {
            $this->addFolder($item);
        }
        else {
            $this->addFile($item);
        }
        return $this;
    }

    public function addFolder(Item $item): self
    {
        $this->folders[] = $item;
        return $this;
    }

    public function getFolders(): array
    {
        return $this->folders;
    }

    public function addFile(Item $item): self
    {
        $this->files[] = $item;
        return $this;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function sort($sort): self
    {
        if(!in_array($sort, self::SORT_OPTIONS)) {
            $sort = self::SORT_NAME;
        }

        if($sort === self::SORT_DATE_DESC) {
            usort($this->files, function(Item $a, Item $b) {
                return $b->getDate()->getTimestamp() > $a->getDate()->getTimestamp();
            });
            usort($this->folders, function(Item $a, Item $b) {
                return $b->getDate()->getTimestamp() > $a->getDate()->getTimestamp();
            });
            return $this;
        }

        if($sort === self::SORT_DATE) {
            usort($this->files, function(Item $a, Item $b) {
                return $a->getDate()->getTimestamp() > $b->getDate()->getTimestamp();
            });
            usort($this->folders, function(Item $a, Item $b) {
                return $a->getDate()->getTimestamp() > $b->getDate()->getTimestamp();
            });
            return $this;
        }

        usort($this->files, function(Item $a, Item $b) {
            return strcmp($a->getName(), $b->getName());
        });
        usort($this->folders, function(Item $a, Item $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return $this;
    }

}