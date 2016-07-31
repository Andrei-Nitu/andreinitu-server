<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Heartbeat'), ['action' => 'edit', $heartbeat->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Heartbeat'), ['action' => 'delete', $heartbeat->id], ['confirm' => __('Are you sure you want to delete # {0}?', $heartbeat->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Heartbeats'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Heartbeat'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="heartbeats view large-9 medium-8 columns content">
    <h3><?= h($heartbeat->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('User') ?></th>
            <td><?= $heartbeat->has('user') ? $this->Html->link($heartbeat->user->id, ['controller' => 'Users', 'action' => 'view', $heartbeat->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($heartbeat->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Value') ?></th>
            <td><?= $this->Number->format($heartbeat->value) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($heartbeat->created) ?></td>
        </tr>
        <tr>
            <th><?= __('Modified') ?></th>
            <td><?= h($heartbeat->modified) ?></td>
        </tr>
    </table>
</div>
