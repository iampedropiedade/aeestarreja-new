<?php
namespace Concrete\Package\Dropbox;

use Concrete\Core\Package\Package;
use Concrete\Core\Package\PackageService;
use Concrete\Core\Block\BlockType\BlockType;

defined('C5_EXECUTE') or die(_('Access Denied.'));

class Controller extends Package
{
	protected $pkgHandle = 'dropbox';
	protected $appVersionRequired = '8.5.0';
	protected $pkgVersion = '1.0.0';
    protected $pkgAutoloaderRegistries = ['src' => '\Concrete\Package\Dropbox'];
    protected $pkg;

    const BLOCK_TYPE_DROPBOX = 'dropbox';

	public function getPackageDescription()
	{
		return t('Dropbox files listing');
	}

	public function getPackageName()
	{
		return t('Dropbox');
	}


    public function install()
    {
        $this->pkg = parent::install();
        $this->packageSetup();
        return $this->pkg;
    }

    public function upgrade()
    {
        parent::upgrade();
        $this->pkg = $this->app->make(PackageService::class)->getByHandle($this->pkgHandle);
        $this->packageSetup();
    }

    protected function packageSetup()
    {
        // Blocks
        $blockType = BlockType::getByHandle(self::BLOCK_TYPE_DROPBOX);
        if (!is_object($blockType)) {
            BlockType::installBlockType(self::BLOCK_TYPE_DROPBOX, $this->pkg);
        }
    }
	
}