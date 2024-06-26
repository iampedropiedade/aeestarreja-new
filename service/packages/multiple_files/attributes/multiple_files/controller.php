<?php
namespace Concrete\Package\MultipleFiles\Attribute\MultipleFiles;

use Concrete\Core\Attribute\FontAwesomeIconFormatter;
use Concrete\Package\MultipleFiles\Entity\Attribute\Value\Value\MultipleFilesValue;
use Concrete\Package\MultipleFiles\Entity\Attribute\Value\Value\MultipleFilesSelectedFiles;
use Concrete\Package\MultipleFiles\Entity\Attribute\Key\Settings\MultipleFilesSettings;
use Concrete\Core\Error\ErrorList\Error\Error;
use Concrete\Core\Error\ErrorList\Error\FieldNotPresentError;
use Concrete\Core\Error\ErrorList\Field\AttributeField;
use File;
use Concrete\Core\Attribute\Controller as AttributeTypeController;

class Controller extends AttributeTypeController
{

    public $akMaxFilesCount;

    public function getIconFormatter()
    {
        return new FontAwesomeIconFormatter('folder-open');
    }

    public function getSearchIndexValue()
    {
        return false;
    }

    public function getDisplayValue()
    {
        $html = '';
        $filesValue = $this->attributeValue->getValue();
        if(is_object($filesValue)) {
            
            $filesArray = $filesValue->getFileObjects();
            
            if(count($filesArray) > 0) {
                $this->addHeaderItem(\Core::make('helper/html')->css('/'.DIRNAME_PACKAGES.'/multiple_files/attributes/multiple_files/view.css'));
                $html .= '<div class="display_multiple_files multiple_files_akID_'.$this->getAttributeKey()->getAttributeKeyID().'">';
                foreach ($filesArray as $file) {
                    /** @var \Concrete\Core\File\File $file */
                    $fv = $file->getRecentVersion();
                    $html .= '<div class="file">';
                        $html .= '<div class="thumb">';
                            $html .= '<a href="'.$fv->getDownloadURL().'" title="'.$fv->getTitle().'">';
                                $html .= $fv->getListingThumbnailImage();
                            $html .= '</a>';
                        $html .= '</div>';
                        $html .= '<div class="filename">';

                            $html .= '<a href="'.$fv->getDownloadURL().'" title="'.$fv->getTitle().'">';
                                $html .= $fv->getTitle();
                            $html .= '</a>';

                            $description = $fv->getDescription();
                            if ($description) {
                                $html .= '<p class="description">';
                                    $html .= $description;
                                $html .= '</p>';
                            }

                        $html .= '</div>';
                    $html .= '<div class="clearfix"></div>';
                    $html .= '</div>';
                }
                $html .= '</div>';
            } else {
                $html .= t('Files not found');
            }
        } else {
            $html .= t('Attribute value not found');
        }
        return $html;
    }

    protected function load()
    {
        $ak = $this->getAttributeKey();
        if (!is_object($ak)) {
            return false;
        }
        $this->set('attributeKey', $ak);
        $this->akMaxFilesCount = $ak->getAttributeKeySettings()->getMaxFilesCount();
        $this->set('akMaxFilesCount', $this->akMaxFilesCount);
    }

    public function form()
    {
        $this->requireAsset('core/file-manager');
        $this->requireAsset('jquery/ui');
        $this->requireAsset('javascript', 'jquery/tmpl');

        $this->set('token', \Core::make('token'));

        $currentFiles = [];
        if (is_object($this->attributeValue)) {
            $currentFilesValue = $this->attributeValue->getValue();
            if ($currentFilesValue) {
                $currentFiles = $currentFilesValue->getFileObjects();
            }
        }
        $this->set('currentFiles', $currentFiles);

        $currentFilesJson = [];
        if (is_array($currentFiles)) {
            foreach ($currentFiles as $index => $file) {
                $fv = $file->getRecentVersion();
                $fileJson = ['fID' => $fv->getFileID(), 'filename' => $fv->getTitle(), 'thumbnailIMG' => $fv->getListingThumbnailImage()];
                $currentFilesJson[] = $fileJson;
            }
        }
        $this->set('currentFilesJson', $currentFilesJson);
        $this->load();
    }

    public function type_form()
    {
        $this->set('form', \Core::make('helper/form'));
        $this->load();
    }

    public function saveKey($data)
    {
        $type = $this->getAttributeKeySettings();
        $data['akMaxFilesCount'] = $data['akMaxFilesCount'] ?: null;
        $type->setMaxFilesCount($data['akMaxFilesCount']);
        return $type;

    }

    public function validateKey($data = array())
    {
        $e = $this->app->make('error');
        if ($data['akMaxFilesCount'] && !is_numeric($data['akMaxFilesCount'])) {
            $e->add(t('Maximum count of files must be number'), 'akMaxFilesCount', 'Maximum count of files');
        }

        if (!($data['akMaxFilesCount'] >= 0)) {
            $e->add(t('Maximum count of files must be greater than zero'), 'akMaxFilesCount', 'Maximum count of files');
        }
        return $e;
    }

    public function validateForm($data)
    {
        return true;
    }

    public function validateValue()
    {
        return true;
    }

    public function createAttributeValue($value = null)
    {
        $av = new MultipleFilesValue();
        if (is_array($value) && count($value)) {
            foreach ($value as $fID) {
                $file = File::getByID($fID);
                if ($file instanceof \Concrete\Core\Entity\File\File) {
                    $avFile = new MultipleFilesSelectedFiles();
                    $avFile->setFile($file);
                    $avFile->setAttributeValue($av);
                    $av->getSelectedFiles()->add($avFile);
                }
            }
        }
        return $av;

    }

    public function createAttributeValueFromRequest()
    {
        $data = $this->post();
        if (isset($data['value'])) {
            return $this->createAttributeValue($data['value']);
        }

        return $this->createAttributeValue(null);
    }

    public function getAttributeValueObject()
    {
        return $this->entityManager->find(MultipleFilesValue::class, $this->attributeValue->getGenericValue());
    }

    public function createAttributeKeySettings()
    {
        return new MultipleFilesSettings();
    }

    protected function retrieveAttributeKeySettings()
    {
        return $this->entityManager->find(MultipleFilesSettings::class, $this->attributeKey);
    }
}