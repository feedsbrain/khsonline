<div id="container">    
    <?php echo form_error('<p class="msg error">', '</p>'); ?>
    <?php echo validation_errors('<p class="msg error">', '</p>'); ?>    
    <?php if ($detail_mode) { ?>
        <fieldset>
            <legend>SPP</legend>
            <table class="nostyle">
                <tbody>
                    <tr>
                        <td><strong>Nama</strong></td>
                        <td><strong>&nbsp;:&nbsp;</strong></td>
                        <td><?php if (!empty($nama_spp)) echo $nama_spp; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Tahun Ajaran</strong></td>
                        <td><strong>&nbsp;:&nbsp;</strong></td>
                        <td><?php if (!empty($tahun_ajaran)) echo $tahun_ajaran; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Semester</strong></td>
                        <td><strong>&nbsp;:&nbsp;</strong></td>
                        <td><?php if (!empty($semester)) echo $semester; ?></td>
                    </tr>
                </tbody>
            </table>
        </fieldset>
        <?php echo $output; ?> 
        <div class="button-container">
            <div class="left-container">
                <a class="high" href="<?php echo base_url() . 'spp/'; ?>">
                    <span>
                        <img class="button-icon" src="<?php echo base_url() . 'assets/images/kembali.png'; ?>"><span class="button-label">Kembali</span>
                    </span>
                </a>
            </div>
            <div class="right-container">
                <?php if (!$spp_posted) { ?>
                    <a class="high posting" href="<?php echo base_url() . 'spp/posting/' . $id_spp ?>">
                        <span>
                            <img class="button-icon" src="<?php echo base_url() . 'assets/images/posted.png'; ?>"><span class="button-label">Tetapkan</span>
                        </span>
                    </a>
                <?php } ?>
            </div>
        </div>    
        <div id="confirm-dialog"></div>
    <?php } else { ?>
        <?php echo $output; ?> 
    <?php } ?>     
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/dialog.js'; ?>"></script>
</div>