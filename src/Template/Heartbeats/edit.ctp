<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $heartbeat->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $heartbeat->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Heartbeats'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="heartbeats form large-9 medium-8 columns content">
    <?= $this->Form->create($heartbeat) ?>
    <fieldset>
        <legend><?= __('Edit Heartbeat') ?></legend>
        <?php
            echo $this->Form->input('user_id', ['options' => $users]);
            echo $this->Form->input('value');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
