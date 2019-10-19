<h2>Halaman Login</h2>


<?= form_open('login') ?>
    <label for="">Email</label>
    <?=  form_error('email'); ?>
    <input type="email" name="email" value="<?=set_value('email') ?>"> <br>

    <label for="">Password</label>
    <?= form_error('password'); ?>
    <input type="password" name="password"> <br>



    <input type="submit" name="submit" value="login">

<?= form_close(); ?>