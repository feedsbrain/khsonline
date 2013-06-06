<div id="container">
    <?php echo validation_errors('<p class="msg error">', '</p>'); ?>
    <?php echo form_open('informasi/do_change_informasi'); ?>
    <?php if (!empty($success_message)) { echo '<p class="msg done">' . $success_message . '</p>'; }; ?>
    <fieldset>
        <legend>Update Informasi User</legend>
        <table class="nostyle">
            <tr>
                <td style="width:100px;">Nama:</td>
                <td><input type="text" size="40" name="name" id="name" value="<?php echo $name; ?>" class="input-text" /></td>
            </tr>
            <tr>
                <td style="width:100px;">E-Mail:</td>
                <td><input type="text" size="40" name="email" id="email" value="<?php echo $email; ?>" class="input-text" /></td>
            </tr>
            <tr>
                <td colspan="2"><input class="input-submit" type="submit" value="Update Informasi"/></td>
            </tr>
        </table>
    </fieldset>
    <?php echo form_close(); ?>
</div>