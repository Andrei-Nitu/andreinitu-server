<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $history->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $history->id)]
            )
        ?></li>
        <?php if ($auth_user['role'] == 'doctor'): ?>
        <li><?= $this->Html->link(__('List Patients'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <?php endif; ?>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="histories form large-9 medium-8 columns content">
    <?= $this->Form->create($history) ?>
    <fieldset>
        <legend><?= __('Edit History') ?></legend>
        <?php
            echo $this->Form->input('treatment');
            echo $this->Form->input('diagnostic');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
