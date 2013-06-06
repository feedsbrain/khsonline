<div id="container">
    <?php echo validation_errors('<p class="msg error">', '</p>'); ?>
    <?php echo form_open('login/perform'); ?>
    <fieldset>
        <legend>User Login</legend>
        <table class="nostyle">
            <tr>
                <td style="width:100px;">Username:</td>
                <td><input type="text" size="40" name="username" id="username" class="input-text" /></td>
            </tr>
            <tr>
                <td style="width:100px;">Password:</td>
                <td><input type="password" size="40" name="password" id="password" class="input-text" /></td>
            </tr>
            <tr>
                <td style="width:100px;" >Captcha:</td>
                <td class="captcha-container"><input type="captcha" size="10" maxlength="6" name="captcha" id="captcha" class="input-text"/><?php echo $cap['image']; ?></td>
            </tr>
            <tr>
                <td colspan="2"><input class="input-submit" type="submit" value="Login"/></td>
            </tr>
        </table>
    </fieldset>
    <?php echo form_close(); ?>
</div>