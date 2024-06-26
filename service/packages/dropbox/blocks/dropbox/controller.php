<?php
namespace Concrete\Package\Dropbox\Block\Dropbox;

defined('C5_EXECUTE') or die('Access Denied.');

use Concrete\Core\Block\BlockController;
use Concrete\Package\Dropbox\Service\Dropbox;

class Controller extends BlockController {
	
	protected $btInterfaceWidth = 600;
	protected $btInterfaceHeight = '300';
	protected $btTable = 'btDropbox';
    protected Dropbox $dropbox;

	public function getBlockTypeDescription()
	{
		return t('Dropbox folders');
	}
	
	public function getBlockTypeName()
	{
		return t('Dropbox folders');
	}

	public function on_start()
    {
        parent::on_start();
        $sortList = [
            'name' => t('Alpha'),
            'date' => t('Oldest first'),
            'date desc'=>t('Newest first')
        ];
        $this->set('sortList', $sortList);
        $this->dropbox = new Dropbox();
    }

	public function save($args)
	{
		if($args['clear_cache'] === 'true') {
            $this->dropbox->clearFolderCache($args['rootPath']);
		}
		parent::save($args);
	}
	
	public function view()
	{
        $folders = $this->dropbox->getContents($this->get('rootPath'), $this->get('path'), $this->get('sort'));
		$this->set('folders', $folders);
	}

}
