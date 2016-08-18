<?php $this->assign('title', 'Add doctor');?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Patients'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Doctors'), ['action' => 'listDoctor']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add Doctor') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('username');
            echo $this->Form->input('password');
            echo $this->Form->input('email');
//            echo $this->Form->input('alert_value');
//            echo $this->Form->input('birthday');
//            echo $this->Form->input('address');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
