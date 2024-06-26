<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Package\Meetings\Entity\Meeting;
use Concrete\Core\Utility\Service\Text;
use Concrete\Core\Localization\Service\Date;

/** @var Meeting $meeting */
$created = $meeting->getCreatedAt();
$start = (new DateTime())->setTimestamp($meeting->getStartTimestamp());
$text = new Text();
/** @var Date $dateHelper */
$dateHelper = \Core::make('helper/date');
$meetingTitle = rawurlencode(sprintf('Reunião %s', $meeting->getGroup()->getName()));
$meetingDescription = rawurlencode(sprintf('Detalhes no documento em PDF: %s', $this->action('pdf', $meeting->getId())));
?>
<div class="list-group-item list-group-item-action flex-column align-items-start mb-3">
    <div class="d-flex w-100 justify-content-between">
        <h5 class="mb-1">
            Convocatória nº <?php echo $meeting->getNumber(); ?> - <?php echo $meeting->getGroup()->getName(); ?>
        </h5>
        <p>
            <small>Criada em <strong><?php echo $created->format('d-m-Y H:i'); ?></strong></small>
        </p>
    </div>
    <small>
        <?php echo sprintf('Reunião a realizar dia <strong>%s de %s de %s</strong> pelas <strong>%s</strong> no local <strong>%s</strong>',
            $start->format('d'),
            $dateHelper->date('F', $meeting->getStartTimestamp()),
            $start->format('Y'),
            $start->format('H:i'),
            $meeting->getLocation()
        ); ?>
    </small>
    <p>
        <a class="btn btn-sm btn-dark py-2 px-4 mt-2 mr-2" href="<?php echo $this->action('pdf', $meeting->getId()); ?>">
            <span class="icon-file-pdf-o mr-2"></span> Ver convocatória
        </a>
        <a class="btn btn-sm btn-outline-dark py-2 px-4 mt-2"
           target="_blank"
           href="https://www.google.com/calendar/render?action=TEMPLATE&text=<?php echo $meetingTitle; ?>&dates=<?php echo $meeting->getStartTime()->format('Ymd\THis\Z') . '/' . $meeting->getStartTime()->add(new DateInterval('PT1H30M'))->format('Ymd\THis\Z'); ?>&details=<?php echo $meetingDescription; ?>&location=<?php echo $meeting->getLocation(); ?>&sf=true&output=xml">
            <span class="icon-calendar-plus-o mr-2"></span> Adicionar ao calendário
        </a>
    </p>
</div>

