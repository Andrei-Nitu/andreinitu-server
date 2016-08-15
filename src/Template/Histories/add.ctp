<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <?php if ($auth_user['role'] == 'doctor'): ?>
        <li><?= $this->Html->link(__('List Patients'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <?php endif; ?>
    </ul>
</nav>
<div class="histories form large-9 medium-8 columns content">
    <?= $this->Form->create($history) ?>
    <fieldset>
        <legend><?= __('Add Diagnostic') ?></legend>
        <?php
            echo $this->Form->input('diagnostic');
            echo $this->Form->input('treatment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
