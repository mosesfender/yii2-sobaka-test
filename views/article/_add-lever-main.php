<?php
/*
 * Copyright © Sergey Siunov. 2024
 * email: <sergey@siunov.ru>
 */

?>
<script id="template_add_lever_main" type="text/x-tmpl">
<div class="add-lever" is="block-add-lever-main" id="add_lever">
    <div class="input-groups">
        <div class="insert-pos" role="group">
            <input type="radio" name="btnpos" id="btnposbegin" value="begin"/>
            <label class="btnposbegin si-insert-begin" for="btnposbegin"
                   title="<?= \yii::t('app', 'Begin') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="left"></label>

            <input type="radio" name="btnpos" id="btnposend" value="end"/>
            <label class="btnposend si-insert-end" for="btnposend"
                   title="<?= \yii::t('app', 'End') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="left"></label>
        </div>
        <div class="block-types" role="group">
            <input type="radio" name="btntype" id="btntypecitate" value="citate"/>
            <label class="btntypecitate si-block-citate" for="btntypecitate"
                   title="<?= \yii::t('app', 'Citate') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="right"></label>

            <input type="radio" name="btntype" id="btntypetext" value="text"/>
            <label class="btntypetext si-block-text" for="btntypetext"
                   title="<?= \yii::t('app', 'Text') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="right"></label>

            <input type="radio" name="btntype" id="btntypenote" value="note"/>
            <label class="btntypenote si-block-note" for="btntypenote"
                   title="<?= \yii::t('app', 'Note') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="right"></label>
        </div>
    </div>
    <div class="row">
        <div class="col-6 btn btn-outline-success btn-ok disabled"><?= \yii::t('app', 'Create block') ?></div>
        <div class="col-6 btn btn-outline-warning btn-cancel"><?= \yii::t('app', 'Cancel') ?></div>
    </div>
</div>
</script>