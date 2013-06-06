<div id="container">    
    <?php echo form_error('<p class="msg error">', '</p>'); ?>
    <?php echo validation_errors('<p class="msg error">', '</p>'); ?>    
    <?php if ($detail_mode) { ?>
        <fieldset>
            <legend><?php
                if ($krs_posted) {
                    echo 'Kartu Hasil Studi';
                } else {
                    echo 'Kartu Rencana Studi';
                };
                ?></legend>
            <table class="nostyle">
                <tbody>
                    <tr>
                        <td><strong>Mahasiswa</strong></td>
                        <td><strong>&nbsp;:&nbsp;</strong></td>
                        <td><?php if (!empty($nama_mahasiswa)) echo $nama_mahasiswa; ?></td>
                    </tr>
                    <tr>
                        <td><strong>NIM</strong></td>
                        <td><strong>&nbsp;:&nbsp;</strong></td>
                        <td><?php if (!empty($nim)) echo $nim; ?></td>
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
                    <?php if (!$krs_posted) { ?>
                        <tr>
                            <td><strong>Jumlah SKS</strong></td>
                            <td><strong>&nbsp;:&nbsp;</strong></td>
                            <td><?php if (!empty($jumlah_sks)) echo $jumlah_sks; ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($krs_posted) { ?>
                        <tr>
                            <td><strong>Jumlah Mutu / SKS</strong></td>
                            <td><strong>&nbsp;:&nbsp;</strong></td>
                            <td><?php if (!empty($jumlah_mutu)) { echo $jumlah_mutu; } else { echo '-'; } ?> / 
                                <?php if (!empty($jumlah_sks)) { echo $jumlah_sks; } else { echo '-'; }?></td>
                        </tr>
                        <tr>
                            <td><strong>Index Prestasi Semester</strong></td>
                            <td><strong>&nbsp;:&nbsp;</strong></td>
                            <td><?php if (!empty($ips)) echo $ips; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </fieldset>
        <?php echo $output; ?> 
        <div class="button-container">
            <div class="left-container">
                <a class="high" href="<?php echo base_url() . 'krs/'; ?>">
                    <span>
                        <img class="button-icon" src="<?php echo base_url() . 'assets/images/kembali.png'; ?>"><span class="button-label">Kembali</span>
                    </span>
                </a>
            </div>
            <div class="right-container">
                <?php if (!$krs_posted && ($level === 'A' || $level === 'D')) { ?>
                    <a class="high posting" href="<?php echo base_url() . 'krs/posting/' . $id_krs ?>">
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