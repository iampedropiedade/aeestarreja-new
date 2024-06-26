<?php
defined('C5_EXECUTE') or die('Access Denied.');
use Concrete\Core\Editor\CkeditorEditor;
/** @var CkeditorEditor $editor */

$this->inc('includes/doc_header.php');
$this->inc('includes/header.php');
$this->inc('elements/widgets/heading.php', ['headingImage' => true]);
?>
<main>
    <?php $this->inc('elements/widgets/errors.php', ['errors' => $errors]); ?>
    <section class="ftco-section py-5">
        <div class="container">
            <?php if($submitted) : ?>
                <h3 class="mb-5">Confirmação</h3>
                <div class="card">
                    <div class="card-body">
                        <p><strong>Grupo</strong></p>
                        <p><?php echo $group->getName(); ?></p>
                        <p><strong>Local</strong></p>
                        <p><?php echo $postData['location']; ?></p>
                        <p><strong>Data e hora</strong></p>
                        <p><?php echo $postData['datetime']; ?></p>
                        <p><strong>Ordem de trabalhos</strong></p>
                        <p><?php echo nl2br($postData['content']); ?></p>
                        <p><strong>Presidido por</strong></p>
                        <p><?php echo $postData['presidedBy'] ?: $userCompleteName; ?></p>
                    </div>
                </div>
                <?php if($meetings) : ?>
                    <div class="alert alert-warning my-5" role="alert">
                        Antes de submeter por favor confirme se podem existir sobreposições nas seguintes reuniões marcadas para o mesmo dia...
                    </div>
                    <?php $this->inc('elements/meetings/list.php', ['meetings'=>$meetings]); ?>
                <?php endif; ?>
                <form action="<?php echo $view->action('confirmation'); ?>" class="p-4 p-md-5 contact-form" method="post">
                    <input type="hidden" name="meeting[token]" value="<?php echo $token->generate($tokenAction); ?>">
                    <input type="hidden" name="meeting[group]" value="<?php echo $postData['group']; ?>">
                    <input type="hidden" name="meeting[location]" value="<?php echo htmlentities($postData['location'], ENT_QUOTES); ?>">
                    <input type="hidden" name="meeting[content]" value="<?php echo htmlentities($postData['content'], ENT_QUOTES); ?>">
                    <input type="hidden" name="meeting[presidedBy]" value="<?php echo htmlentities($postData['presidedBy'] ?: $userCompleteName, ENT_QUOTES); ?>">
                    <input type="hidden" name="meeting[datetime]" value="<?php echo $postData['datetime']; ?>">
                    <div class="form-group mt-5">
                        <button type="submit" name="meeting[submit]" value="update" class="btn btn-outline-secondary py-3 px-5">Alterar</button>
                        <button type="submit" name="meeting[submit]" value="confirm" class="btn btn-primary py-3 px-5">Submeter</button>
                    </div>
                </form>
            <?php else : ?>
                <div class="col-md-12">
                    <form action="<?php echo $view->action('submit'); ?>" class="p-4 p-md-5 contact-form" method="post" data-behaviour='parsley-validate'>
                        <input type="hidden" name="meeting[token]" value="<?php echo $token->generate($tokenAction); ?>">
                        <div class="form-group">
                            <label for="meeting[group]">Grupo</label>
                            <select data-behaviour="select2" class="form-control form-control-lg" name="meeting[group]" required>
                                <?php foreach($groupsList as $groupId=>$groupName) : ?>
                                    <option value="<?php echo $groupId; ?>" <?php echo $postData['group'] == $groupId ? 'selected' : ''; ?>><?php echo $groupName; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="meeting[location]">Local</label>
                            <input type="text" class="form-control form-control-lg" name="meeting[location]" value="<?php echo $postData['location'] ?: ''; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="meeting[content]">Ordem de trabalhos</label>
                            <textarea class="form-control form-control-lg" name="meeting[content]" rows="8"><?php echo $postData['content'] ?: "1 - ;\n2 - ;\n3 - ;\n"; ?></textarea>
                        </div>
                        <div style="overflow:hidden;">
                            <div class="form-group">
                                <label for="meeting[datetime]">Data e hora</label>
                                <div data-behaviour="datepicker" class="border p-5">
                                    <input type='hidden' name="meeting[datetime]" required />
                                </div>
                            </div>
                            <script type="text/javascript">
                                $(function () {
                                    <?php if($postData['datetimeObject']) : ?>
                                        var defaultDate = '<?php echo $postData['datetimeObject']->format('m/d/Y H:i'); ?>';
                                    <?php else : ?>
                                        var defaultDate = moment().add(3, 'days');
                                        if(defaultDate.day() === 0) {
                                            defaultDate.add(1, 'days');
                                        }
                                    <?php endif; ?>

                                    $('[data-behaviour="datepicker"]').datetimepicker({
                                        inline: true,
                                        sideBySide: true,
                                        minDate: moment().add(1, 'days'),
                                        locale: 'pt',
                                        defaultDate: defaultDate,
                                        daysOfWeekDisabled: [0],
                                        stepping: 5,
                                        enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21],
                                        icons: {
                                            up: 'icon-chevron-up',
                                            down: 'icon-chevron-down',
                                            time: 'icon-chevron-down',
                                            date: 'icon--calendar',
                                            previous: 'icon-chevron-left',
                                            next: 'icon-chevron-right',
                                            today: 'icon--screenshot',
                                            clear: 'icon--trash',
                                            close: 'icon--remove'
                                        }
                                    });
                                });
                            </script>
                        </div>
                        <div class="form-group">
                            <label for="meeting[presidedBy]">Presidido por</label>
                            <input type="text" class="form-control form-control-lg" name="meeting[presidedBy]" value="<?php echo $postData['presidedBy'] ?: $userCompleteName; ?>" required>
                        </div>
                        <div class="form-group mt-5">
                            <input type="submit" value="Submeter" class="btn btn-primary py-3 px-5">
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
<?php
$this->inc('includes/footer.php');
$this->inc('includes/doc_footer.php');
?>
