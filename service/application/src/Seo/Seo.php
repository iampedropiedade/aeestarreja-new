<?php

namespace Application\Seo;

use Concrete\Core\Support\Facade\Application;
use Concrete\Core\Support\Facade\Config;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\Controller\PageTypeController;
use Concrete\Core\Search\Pagination\PermissionablePagination;
use Application\Helpers\Imagify;

/**
 * Class Seo
 * @package Application\Seo
 */
class Seo
{

    /**
     * @return string
     */
    public static function getPageTitle(): string
    {
        $app = Application::getFacadeApplication();
        $site = $app->make('site')->getSite();
        $appConfig = $app->make('config');

        $c = Page::getCurrentPage();

        $pageTitle = $c->getAttribute('meta_title');
        if (!is_string($pageTitle) || $pageTitle === '') {
            $seo = $app->make('helper/seo');
            if (!$seo->hasCustomTitle()) {
                $pageTitle = $c->getCollectionName();
                if ($c->isSystemPage()) {
                    $pageTitle = t($pageTitle);
                }
                $seo->addTitleSegmentBefore($pageTitle);
            }
            $seo->setSiteName(tc('SiteName', $site->getSiteName()));
            $seo->setTitleFormat($appConfig->get('concrete.seo.title_format'));
            $seo->setTitleSegmentSeparator($appConfig->get('concrete.seo.title_segment_separator'));
            $pageTitle = $seo->getTitle();
        }
        return $pageTitle;
    }


    /**
     * Returns a canonical link tag URL of the current page, SEO requirement
     * @return string
     */
    public static function canonicalURL(): string
    {
        return "<link rel='canonical' href='" . Page::getCurrentPage()->getCollectionLink() . "' />\n";
    }

    /**
     * @param string $defaultImage
     * @return string
     */
    public static function metaOpenGraph(string $defaultImage = ""): string
    {
        $c = Page::getCurrentPage();

        $tags = [
            "type" => "website",
            "title" => $c->getCollectionName(),
            "description" => $c->getAttribute('meta_description') ? $c->getAttribute('meta_description') : $c->getCollectionDescription(),
            "url" => $c->getCollectionLink(),
            "site_name" => Config::get('concrete.site')
        ];

        if ($pageImage = Imagify::getImageSrc($c, 1200, 630, true)) {
            $tags["image"] = $pageImage;
        } elseif ($defaultImage) {
            $tags["image"] = BASE_URL . $defaultImage;
        }

        $metas = [];
        foreach ($tags as $key => $value) {
            $metas[] = '<meta property="og:' . $key . '" content="' . $value . '" />';
        }

        $returnString = "<!-- Open Graph data -->\n\t" . implode("\n\t", $metas) . "\n";

        return $returnString;
    }

    /**
     * Returns mobile UI tags
     * @string
     */
    public static function mobileUI(string $themePath): string
    {
        $tags = [
            "apple-mobile-web-app-capable" => "yes",
            "apple-mobile-web-app-title" => Config::get('concrete.site'),
            "apple-mobile-web-app-status-bar-style" => "black",
            "theme-color" => "#f70c36"
        ];

        $metas = [];
        foreach ($tags as $key => $value) {
            $metas[] = '<meta name="' . $key . '" content="' . $value . '" />';
        }

        $returnString = "<!-- Mobile UI  -->\n\t";
        $returnString .= implode("\n\t", $metas) . "\n\t";
        $returnString .= "<link rel='mask-icon' href='" . $themePath . "/app/images/touch/safari-pinned-tab.svg' color='#f70c36'>\n";

        return $returnString;
    }

    /**
     * Returns Twitter card data
     * @param string $site
     * @return string
     */
    public static function twitterCardData(string $site): string
    {
        $tags = [
            "twitter:card" => "summary_large_image",
            "twitter:site" => $site
        ];

        $metas = [];
        foreach ($tags as $key => $value) {
            $metas[] = '<meta name="' . $key . '" content="' . $value . '" />';
        }

        $returnString = "<!-- Twitter Card data -->\n\t" . implode("\n\t", $metas) . "\n";

        return $returnString;
    }

    /**
     * @return string
     */
    public static function metaRobotsTag(): string
    {
        return "<meta name='robots' content='" . ((Config::getEnvironment() === "staging") ? "noindex,nofollow" : "all") . "' />\n";
    }

    /**
     * Sets link rel next/prev header items if the controller requires it
     *
     * @param PageTypeController $controller
     * @param PermissionablePagination $pagination
     */
    public static function setMetaLinkNextPrev(PageTypeController $controller, PermissionablePagination $pagination)
    {
        if (is_object($pagination)) {
            $pages = $pagination->getNbPages();
            if ($pages) {
                $c = Page::getCurrentPage();
                $navigationHelper = Application::make('helper/navigation');
                $previous = $pagination->hasPreviousPage() ? $pagination->getPreviousPage() : false;
                $next = $pagination->hasNextPage() ? $pagination->getNextPage() : false;

                if ($previous) {
                    $controller->addHeaderItem('<link rel="prev" href="' . $navigationHelper->getCollectionUrl($c) . "?ccm_paging_p=" . $previous . '" />');
                }
                if ($next) {
                    $controller->addHeaderItem('<link rel="next" href="' . $navigationHelper->getCollectionUrl($c) . "?ccm_paging_p=" . $next . '" />');
                }
            }
        }
    }

}