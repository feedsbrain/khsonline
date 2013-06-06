<div id="container">
    <?php if($view_mode) { ?>
        <h2 class="t-center">TRANSKRIP NILAI</h2>
        <table class="transkrip-tabel nostyle">
            <tr>
                <td style="width:125px;"><strong>NIM</strong></td>
                <td style="width:10px;"><strong>&nbsp;:&nbsp;</strong></td>
                <td style="width:175px;"><strong><?php echo $mahasiswa->nim; ?></strong></td>
                <td></td>
                <td style="width:125px;"><strong>Tgl. Yudisium</strong></td>
                <td style="width:10px;"><strong>&nbsp;:&nbsp;</strong></td>
                <td style="width:175px;"><strong><?php echo $transkrip->yudisium; ?></strong></td>
            </tr>
            <tr>
                <td><strong>NAMA</strong></td>
                <td><strong>&nbsp;:&nbsp;</strong></td>
                <td><strong><?php echo $mahasiswa->nama; ?></strong></td>
                <td></td>
                <td><strong>No. Reg. Ijazah</strong></td>
                <td><strong>&nbsp;:&nbsp;</strong></td>
                <td><strong><?php echo $transkrip->reg_ijazah; ?></strong></td>
            </tr>
            <tr>
                <td><strong>TTL</strong></td>
                <td><strong>&nbsp;:&nbsp;</strong></td>
                <td><strong><?php echo $mahasiswa->tempat_lahir . ' ' . $mahasiswa->tanggal_lahir; ?></strong></td>
                <td></td>
                <td><strong>No. Seri Transkrip</strong></td>
                <td><strong>&nbsp;:&nbsp;</strong></td>
                <td><strong><?php echo $transkrip->no_seri; ?></strong></td>
            </tr>
        </table>
        <br/>
        <table class="transkrip-tabel">
            <tbody>
                <tr>
                    <th class="t-center">NO</th>
                    <th class="t-center">KODE MK</th>
                    <th class="t-center">NAMA MATA KULIAH</th>
                    <th class="t-center">SKS</th>
                    <th class="t-center">NILAI</th>
                    <th class="t-center">MUTU</th>
                </tr>
                <?php foreach ($data as $transcript) { ?>
                    <tr>
                        <td class="t-center"><?php echo $transcript->no; ?></td>
                        <td class="t-center"><?php echo $transcript->kode; ?></td>
                        <td><?php echo $transcript->nama; ?></td>
                        <td class="t-center"><?php echo $transcript->sks; ?></td>
                        <td class="t-center"><?php echo $transcript->nilai; ?></td>
                        <td class="t-center"><?php echo $transcript->mutu; ?></td>
                    </tr>
                <?php } ?>     
                <tr>
                    <td colspan="4" class="t-right"><strong>Jumlah SKS : <?php echo $jumlah_sks; ?>&nbsp;&nbsp;<strong></td>
                    <td colspan="2" class="t-center"><strong>Jumlah Mutu : <?php echo $jumlah_mutu; ?></strong></td>
                </tr>
                <tr>
                    <td colspan="4" class="t-right">&nbsp;</td>
                    <td  class="t-center"><strong>IPK</strong></td>
                    <td  class="t-center"><strong><?php echo $ipk; ?></strong></td>
                </tr>
            </tbody>
        </table>
        <br/>
        <table class="transkrip-tabel">
            <tbody>
                <tr>
                    <th class="t-center">JUDUL KARYA TULIS ILMIAH</th>
                    <th class="t-center">NILAI</th>
                    <th class="t-center">LAMBANG</th>
                </tr>
                <tr>
                    <td><?php echo $transkrip->karya_tulis; ?></td>
                    <td class="t-center"><?php echo $transkrip->nilai; ?></td>
                    <td class="t-center"><?php echo $transkrip->lambang; ?></td>
                </tr>
            </tbody>
        </table>
        </br>
        <div class="button-container">
            <div class="left-container">
                <a class="high" href="<?php echo base_url() . 'transkrip/'; ?>">
                    <span>
                        <img class="button-icon" src="<?php echo base_url() . 'assets/images/kembali.png'; ?>"><span class="button-label">Kembali</span>
                    </span>
                </a>
            </div>
            <div class="right-container">
                &nbsp;
            </div>
        </div>    
    <?php } else { ?>
        <?php echo $output; ?>
    <?php } ?>    
</div>