<div class="users form login-form">
<?= $this->Flash->render('auth') ?>
    <?= $this->Form->create() ?>
    <label for="">
    Username
    <?= $this->Form->input('username', [
        'label' => false
    ]) ?>
    </label>
    <label for="">
    Password
    <?= $this->Form->input('password', [
        'label' => false
    ]) ?>
    </label>
    <?= $this->Form->button(__('Login'), ['style' => 'width: 100%']); ?>
    <?= $this->Form->end() ?>
</div>

<style>
    .login-form {
        position:absolute;
        left:50%;
        top:50%;
        transform: translate3d(-50%, -50%, 0);
        width: 250px;
    }
</style>