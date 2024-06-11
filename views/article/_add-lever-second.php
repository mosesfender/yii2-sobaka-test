<?php
/*
 * Copyright © Sergey Siunov. 2024
 * email: <sergey@siunov.ru>
 */

?>
<script id="template_add_lever_second" type="text/x-tmpl">
<div class="add-lever" is="block-add-lever-second" id="add_lever">
    <div class="input-groups">
        <div class="insert-pos" role="group">
            <input type="radio" name="btnpos" id="btnposbegin"/>
            <label class="btnposbegin si-insert-before" for="btnposbegin"
                   title="<?= \yii::t('app', 'Before') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="left"></label>

            <input type="radio" name="btnpos" id="btnposend"/>
            <label class="btnposend si-insert-after" for="btnposend"
                   title="<?= \yii::t('app', 'After') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="left"></label>
        </div>
        <div class="block-types" role="group">
            <input type="radio" name="btntype" id="btntypecitate"/>
            <label class="btntypecitate si-block-citate" for="btntypecitate"
                   title="<?= \yii::t('app', 'Citate') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="right"></label>

            <input type="radio" name="btntype" id="btntypetext"/>
            <label class="btntypetext si-block-text" for="btntypetext"
                   title="<?= \yii::t('app', 'Text') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="right"></label>

            <input type="radio" name="btntype" id="btntypenote"/>
            <label class="btntypenote si-block-note" for="btntypenote"
                   title="<?= \yii::t('app', 'Note') ?>"
                   data-bs-toggle="tooltip" data-bs-placement="right"></label>
        </div>
    </div>
    <div class="row">
        <button class="col-6 btn btn-outline-success"><?= \yii::t('app', 'Create block') ?></button>
        <button class="col-6 btn btn-outline-warning"><?= \yii::t('app', 'Cancel') ?></button>
    </div>
</div>


</script>