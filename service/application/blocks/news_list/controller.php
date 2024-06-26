<?php

namespace Application\Block\NewsList;

use Application\Blocks\Controller as BlockController;
use Application\Constants\Attributes;
use Application\Models\Page\Articles;
use Application\Search\Pages\NewsArticles;

class Controller extends BlockController
{
    protected const TAGS_FIELD = 'tags';
    protected const TAGS_FILTER_OUT_FIELD = 'tagsFilterOut';

    protected $btCacheBlockRecord = false;
    protected $btTable = 'btNewsList';
    protected $btInterfaceWidth = '1200';
    protected $btInterfaceHeight = '900';
    protected $requiredFields = [
        ['fieldName'=>'title'],
    ];

    /**
     * @return string
     */
    public function getBlockTypeDescription()
    {
        return t('Renders a News list section');
    }

    /**
     * @return string
     */
    public function getBlockTypeName()
    {
        return t('News list');
    }

    public function view()
    {
        parent::view();
        $list = new NewsArticles();
        $tags = json_decode($this->get('tags'));
        $tagsFilterOut = json_decode($this->get('tagsFilterOut'));
        $list->filterBySelectMultipleOr(Attributes::TAGS, $tags);
        $list->filterBySelectMultipleOr(Attributes::TAGS, $tagsFilterOut, false);
        $list->setItemsPerPage($this->get('maxItems'));
        $list->sortByPublicDateDescending();
        $pagination = $list->getPaginationFactory();
        $pagination->setMaxPerPage($this->get('maxItems'));
        $pagination->setCurrentPage(1);
        $this->set('newsArticles', $pagination->getCurrentPageResults());
        $this->set('indexPageUrl', '/agrupamento/noticias');
    }

    public function edit()
    {
        $this->requireAsset('select2');
        parent::edit();
        $this->set('tagsList', (new Attributes())->getSelectOptions(Attributes::TAGS));
        $this->set('tags', json_decode($this->tags));
        $this->set('tagsFilterOut', json_decode($this->tagsFilterOut));
    }

    public function save($data)
    {
        $tags = is_array($data[self::TAGS_FIELD]) ? $data[self::TAGS_FIELD] : [];
        $data[self::TAGS_FIELD] = json_encode(array_values($tags));

        $tagsFilterOut = is_array($data[self::TAGS_FILTER_OUT_FIELD]) ? $data[self::TAGS_FILTER_OUT_FIELD] : [];
        $data[self::TAGS_FILTER_OUT_FIELD] = json_encode(array_values($tagsFilterOut));

        parent::save($data);
    }

}
