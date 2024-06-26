<?php 
namespace Concrete\Package\MultipleFiles;
use \Concrete\Core\Package\Package as PackageInstaller;
use Route;
use \Concrete\Core\Attribute\Type as AttributeType;
use File;

defined('C5_EXECUTE') or die('Access Denied.');

class Controller extends PackageInstaller {

	protected $pkgHandle = 'multiple_files';
	protected $appVersionRequired = '8.0.0';
	protected $pkgVersion = '1.0.0';

    public function getPackageName()
    {
		return t('Multiple files attribute');
	}

	public function getPackageDescription()
	{
		return t('Allows adding multiple files on an attribute');
	}

    public function on_start()
    {
        $al = \Concrete\Core\Asset\AssetList::getInstance();
        //JS
        $al->register(
            'javascript', //asset type
            'jquery/tmpl', //asset name
            'assets/js/jquery.tmpl.min.js', //path
            array(),
            'multiple_files' //from package
        );

        //Routes
        Route::register('/ccm/multiple_files_attribute/get_file_info/', function() {
            /** @var \Concrete\Core\Validation\CSRF\Token $token */
            $token = \Core::make('token');
            /** @var \Concrete\Core\Error\ErrorList\ErrorList $e */
            $e = \Core::make('error');
            /** @var \Concrete\Core\Http\Service\AJAX $ajax */
            $ajax =  \Core::make('helper/ajax');

            if($token->validate('get_files_info')) {
                //$fIDs = explode(',', $_GET['fIDs']);
                $fIDs = $_GET['fIDs'];

                if(is_array($fIDs) && count($fIDs) > 0) {
                    foreach($fIDs as $fID) {
                        /** @var \Concrete\Core\File\File $file */
                        $file = File::getByID($fID);
                        if($file instanceof \Concrete\Core\Entity\File\File) {
                            /** @var \Concrete\Core\Entity\File\Version $fv */
                            $fv = $file->getRecentVersion();
                            $fileInfo = new \StdClass();
                            $fileInfo->fID = $fv->getFileID();
                            $fileInfo->filename = $fv->getTitle();
                            $fileInfo->thumbnailIMG = $fv->getListingThumbnailImage();
                            $files[] = $fileInfo;
                        } 
                        else {
                            $e->add(t('File not found'));
                            break;
                        }
                    }
                } 
                else {
                    $e->add(t('File IDs is not valid'));
                }
            } 
            else {
                $e->add($token->getErrorMessage());
            }

            if(!$e->has()) {
                $ajax->sendResult($files);
            } 
            else {
                $ajax->sendError($e);
            }
        });
    }

    public function install() 
    {
        $pkg = parent::install();
        $factory = $this->app->make(\Concrete\Core\Attribute\TypeFactory::class);
        $type = $factory->getByID('multiple_files');
        if (!is_object($type)) {
            $type = $factory->add('multiple_files', 'Multiple Files', $pkg);
        }
        
        $service = $this->app->make(\Concrete\Core\Attribute\Category\CategoryService::class);
        $category = $service->getByHandle('collection')->getController();
        $category->associateAttributeKeyType($type);
	}

}