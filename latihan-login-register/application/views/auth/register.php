<h2>Register</h2>


<?= form_open('register') ?>
    <label for="">Email</label>
    <?=  form_error('email'); ?>
    <input type="email" name="email" value="<?=set_value('email') ?>"> <br>

    <label for="">Password</label>
    <?= form_error('password'); ?>
    <input type="password" name="password"> <br>


    <label for="">Ulangi Password</label>
    <?= form_error('password2'); ?>
    <input type="password" name="password2"> <br>

    <input type="submit" name="submit" valuew="register">

<?= form_close(); ?>