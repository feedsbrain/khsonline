<div id="container">
    <?php echo validation_errors('<p class="msg error">', '</p>'); ?>
    <?php echo form_open('password/do_change_password'); ?>
    <?php if (!empty($success_message)) { echo '<p class="msg done">' . $success_message . '</p>'; }; ?>
    <fieldset>
        <legend>Ganti Password</legend>
        <table class="nostyle">
            <tr>
                <td style="width:100px;">Password Lama:</td>
                <td><input type="password" size="40" name="old_password" id="old_password" class="input-text" /></td>
            </tr>
            <tr>
                <td style="width:100px;">Password Baru:</td>
                <td><input type="password" size="40" name="new_password" id="new_password" class="input-text" /></td>
            </tr>
            <tr>
                <td style="width:100px;">Konfirmasi:</td>
                <td><input type="password" size="40" name="confirm_password" id="confirm_password" class="input-text" /></td>
            </tr>
            <tr>
                <td colspan="2"><input class="input-submit" type="submit" value="Ganti Password"/></td>
            </tr>
        </table>
    </fieldset>
    <?php echo form_close(); ?>
</div>