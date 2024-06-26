<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Package\Meetings\Entity\Meeting;
use Concrete\Core\Localization\Service\Date;

/** @var Meeting $meeting; */
if(!$meeting) {
    return;
}

/** @var Date $dateHelper */
$dateHelper = \Core::make('helper/date');

$created = $meeting->getCreatedAt();
$start = (new DateTime())->setTimestamp($meeting->getStartTimestamp());
setlocale(LC_TIME, 'pt_PT');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="<?php echo $siteName; ?>">
    <title><?php echo sprintf('Convocatoria número %s - %s', $meeting->getNumber(), $meeting->getGroup()->getName()); ?></title>
    <style>
        @font-face {
            font-family: 'OpenSans-Regular';
            font-style: normal;
            font-weight: normal;
            src: url(<?php echo $fontsUrl; ?>/OpenSans-Regular.ttf) format('truetype');
        }
        @font-face {
            font-family: 'OpenSans-Bold';
            font-style: normal;
            font-weight: 700;
            src: url(<?php echo $fontsUrl; ?>/OpenSans-Bold.ttf) format('truetype');
        }
        html {
            margin: 60px 80px;
        }
        body {
            font-family: 'OpenSans-Regular', sans-serif;
            font-size: 15px;
        }
        h1 {
            font-size: 26px;
            margin-bottom: 30px;
            font-weight: 700;
        }
        h2 {
            font-size: 20px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        strong {
            font-weight: 700;
        }
        header {
            margin-bottom: 10px;
            border-bottom: solid 1px #cccccc;
            text-align: center;
        }
        header img {
            max-width: 40%;
        }
        .justify {
            text-align: justify;
        }
        .center {
            text-align: center;
        }
        .smaller {
            font-size: 12px;
        }
        .mt {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <header>
        <img src="<?php echo $logo1; ?>" /><img src="<?php echo $logo2; ?>" />
    </header>
    <div class="center">
        <h1><?php echo $meeting->getGroup()->getName(); ?></h1>
        <h2>Convocatória Número <?php echo $meeting->getNumber(); ?></h2>
    </div>
    <div class="justify">
        <p>
            Convoca-se o/a <strong><?php echo $meeting->getGroup()->getName(); ?></strong>
            para uma reunião a realizar no dia
            <strong>
                <?php echo $start->format('d'); ?> de
                <?php echo $dateHelper->date('F', $meeting->getStartTimestamp()); ?> de
                <?php echo $start->format('Y'); ?>
            </strong>,
            pelas <strong><?php echo $start->format('H:i'); ?></strong>,
            no local <strong><?php echo $meeting->getLocation(); ?></strong>,
            com a seguinte ordem de trabalhos:
        </p>
        <p><?php echo $meeting->getContent(); ?></p>
    </div>
    <div class="center smaller mt">
        <p>
            Estarreja, <?php echo $created->format('d'); ?> de
            <?php echo $dateHelper->date('F', $created->getTimestamp()); ?> de
            <?php echo $created->format('Y'); ?><br/>
            O/A presidente da reunião
        </p>
        <p>
            _______________________________________<br/>
            (<?php echo $meeting->getPresidedBy(); ?>)
        </p>
        <p>Visto</p>
        <p>______ / ______ / 20______</p>
        <p>
            _______________________________________<br/>
            A Direção
        </p>
    </div>
</body>
</html>