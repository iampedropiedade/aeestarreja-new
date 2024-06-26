<?php
namespace Concrete\Package\Dropbox\Service;

use Concrete\Core\Cache\Level\ExpensiveCache;
use Concrete\Package\Dropbox\Dropbox\Client;
use Concrete\Package\Dropbox\Model\Folder;
use Concrete\Package\Dropbox\Model\Item;

class Dropbox
{
    private const CACHE_KEY = 'package/dropbox';
    protected const TTL = 3600;

    protected ExpensiveCache $cache;
    protected array $accessToken = [
        't' => 'Ls2UDggU_nsAAAAAAAEp84kTybsifFDWl1WD2aWacMoXvwP2wNxvDGlLj827lH11',
        'account_id'=>'dbid:AAAzf9MAqFQhUPg47h_ciNMmNH4baeO9bkM'
    ];
    protected string $appKey = '22tbr2vytqsfnwo';
    protected string $appSecret = '1dlsbt9lykl2p7l';
    protected string $rootPath = '';
    protected Client $dropbox;

    public function __construct()
    {
        $this->cache = new ExpensiveCache();
        $this->dropbox = new Client(['app_key' => $this->appKey, 'app_secret' => $this->appSecret, 'app_full_access' => true], 'pt');
        $this->dropbox->setBearerToken($this->accessToken);
    }

    public function getContents(?string $rootPath, ?string $path, string $sort = 'alpha')
    {
        $this->rootPath = $rootPath;
        if($path) {
            $path = rawurldecode($path);
        }
        $completePath = $this->rootPath . $path;

        $dropboxObjects = $this->getFolder($completePath);
        $folder = new Folder($completePath);

        if(is_array($dropboxObjects)) {
            foreach($dropboxObjects as $object) {
                $item = new Item($object, $this->rootPath);
                if($item->isDir() === false) {
                    $item->setLink($this->getLinkToFile($item->getCompletePath()));
                }
                $folder->addItem($item);
            }
        }
        $folder->sort($sort);
        return $folder;
    }


    public function getLinkToFile($completePath)
    {
        $cacheKey = $this->generateCacheKey([self::CACHE_KEY, 'link', rawurlencode($completePath)]);
        $item = $this->cache->getItem($cacheKey);

        if ($item->isMiss() === true) {
            $item->lock();
            $data = $this->dropbox->getLink($completePath, false);
            $item->set($data)->setTTL(self::TTL);
            $this->cache->save($item);
        } else {
            $data = $item->get();
        }
        return $data;
    }

    public function getFolder($completePath)
    {
        $cacheKey = $this->generateCacheKey([self::CACHE_KEY, 'folder', rawurlencode($completePath)]);
        $item = $this->cache->getItem($cacheKey);

        if ($item->isMiss() === true) {
            $item->lock();
            $data = $this->dropbox->getFiles($completePath);
            $item->set($data)->setTTL(self::TTL);
            $this->cache->save($item);
        }
        else {
            $data = $item->get();
        }
        return $data;
    }

    public function clearFolderCache(string $completePath)
    {
        $cacheKey = $this->generateCacheKey([self::CACHE_KEY, 'folder', rawurlencode($completePath)]);
        $item = $this->cache->getItem($cacheKey);
        $item->clear();
    }

    protected function generateCacheKey(array $path): string
    {
        return implode('/', $path);
    }

}