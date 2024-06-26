<?php
namespace Application\Controller\PageType;

use Application\Page\Controller\PageController;
use Application\Models\Entity\Meetings as Model;
use Concrete\Core\Routing\Redirect as RoutingRedirect;
use Dompdf\Dompdf;
use Dompdf\Options;
use \URL;
use Concrete\Core\Utility\Service\Text;
use Application\Models\Page\Generic;
/**
 * Class MeetingsIndex
 * @package Application\Controller\PageType
 */
class MeetingsIndex extends PageController
{
    public function view()
    {
        $filters = $this->clearEmptyParams($this->request('filters'));
        $this->set('filters', $filters);
        $model = new Model();
        $model->sortByCreatedTimeDesc();
        $pagination = $model->getPaginationFactory();
        $this->set('meetings', $model->getPagedResults());
        $this->set('pagination', $pagination);

        $pagelist = new Generic();
        $pagelist->filterByPageTypeHandle('meetings_detail');
        $addMeeting = reset($pagelist->getResults());
        $this->set('addMeeting', $addMeeting);
    }

    public function pdf($id=false)
    {
        if(!$id) {
            return RoutingRedirect::to($this->c->getCollectionLink());
        }
        $model = new Model();
        $meeting = $model->getResultById($id);
        if(!$meeting) {
            return RoutingRedirect::to($this->c);
        }
        $text = new Text();
        $filename = $text->sanitizeFileSystem(sprintf('Convocatoria número %s - %s', $meeting->getNumber(), $meeting->getGroup()->getName()));

        $view = $this->getViewObject();
        $appFolder = sprintf('application/themes/%s/app/', $view->getThemeHandle());
        ob_start();
        $view->inc('elements/meetings/pdf.php', [
            'meeting' => $meeting,
            'logo1' => sprintf('%s/images/pdf/aee.png', $appFolder),
            'logo2' => sprintf('%s/images/pdf/min_edu.png', $appFolder),
            'fontsUrl' => Url::to(sprintf('%s/fonts/open-sans/', $appFolder)),
            'siteName' => $this->app->make('site')->getSite()->getSiteName(),
        ]);
        $html = ob_get_clean();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $pdf = new Dompdf($options);
        $pdf->setPaper('A4');
        $pdf->loadHtml($html);
        $pdf->render();
        $pdf->stream($filename);
        exit;
    }

}