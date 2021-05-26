<?php if ($this->temErro($campo)): ?>
    <span class="d-block text-danger"><?= $this->getErro($campo) ?></span>
<?php endif ?>