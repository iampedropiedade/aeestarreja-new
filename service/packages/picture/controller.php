<?php
namespace Concrete\Package\Picture;
defined('C5_EXECUTE') or die(_("Access Denied."));

use Concrete\Core\Package\Package;

class Controller extends Package {

	protected $pkgHandle = 'picture';
	protected $appVersionRequired = '8.0.0';
	protected $pkgVersion = '1.0.0';

	protected $pkgAutoloaderRegistries = [
	    'src'=>'\Concrete\Package\Picture',
    ];


    public function getPackageName()
	{
		return t("Picture");
	}

	public function getPackageDescription()
	{
		return t("Creates various versions of images inside a picture element");
	}

    public function install()
    {
        if (!file_exists($this->getPackagePath() . '/vendor/autoload.php'))
            throw new \Exception('Please install the required composer dependencies');

        parent::install();
	}

    public function on_start()
    {
        require $this->getPackagePath() . '/vendor/autoload.php';
	}
}
