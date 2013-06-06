<div id="container">    
    <?php echo validation_errors('<p class="msg error">', '</p>'); ?>
    <?php echo form_open('penilaian'); ?>
    <fieldset>
        <legend>Kriteria Pencarian</legend>
        <table class="nostyle">
            <tr>
                <td style="width:100px;">Tahun Ajaran:</td>
                <td><input type="text" size="5" maxlength="4" name="tahun" id="tahun" class="input-text numeric t-center" value="<?php echo $tahun; ?>"/>
                    <?php if (!empty($tahun)) {echo ' - ';} ?><?php if (!empty($tahun)) {echo $tahun + 1;} ?></td>
            </tr>
            <tr>
                <td style="width:100px;">Semester:</td>
                <td><input type="text" size="5" maxlength="2" name="semester" id="semester" class="input-text numeric t-center" value="<?php echo $semester; ?>"/></td>
            </tr>
            <tr>
                <td style="width:100px;">Mata Kuliah:</td>
                <td><?php echo form_dropdown('matakuliah', $mk_list, $mk_selected); ?></td>
            </tr>
            <tr>
                <td colspan="2"><input class="input-submit" type="submit" value="Cari"/></td>
            </tr>
        </table>
    </fieldset>
    <?php echo form_close(); ?>
    <table class="penilaian-tabel" id="data">
        <tbody>
            <tr>
                <th style="width:50px;" class="t-center">No</th>
                <th style="width:50px;" class="t-center">Kelas</th>
                <th style="width:125px;" class="t-center">Jurusan</th>                
                <th>Mahasiswa</th>
                <th style="width:80px;" class="t-center">Nilai</th>
                <th style="width:50px;" class="t-center">Alpa</th>
                <th style="width:50px;" class="t-center">Izin</th>
                <th style="width:50px;" class="t-center">Sakit</th>
            </tr>
            <?php foreach ($penilaian as $row) { ?>
                <tr>
                    <td class="t-center"><?php echo $row->no; ?></td>
                    <td class="t-center"><?php echo $row->kelas; ?></td>
                    <td class="t-center"><?php echo $row->jurusan; ?></td>
                    <td><?php echo $row->mahasiswa; ?></td>
                    <td class="editableSingle nilai id<?php echo $row->id; ?> t-center">
                        <?php echo $row->nilai; ?></td>
                    <td class="editableSingle alpa id<?php echo $row->id; ?> t-center">
                        <?php echo $row->alpa; ?></td>
                    <td class="editableSingle izin id<?php echo $row->id; ?> t-center">
                        <?php echo $row->izin; ?></td>
                    <td class="editableSingle sakit id<?php echo $row->id; ?> t-center">
                        <?php echo $row->sakit; ?></td>
                </tr>
            <?php } ?>  
        </tbody>
    </table>    
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/jquery.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/grocery_crud/js/jquery_plugins/jquery.numeric.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/grocery_crud/js/jquery_plugins/config/jquery.numeric.config.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/inlineEdit.js'; ?>"></script>
    <script type="text/javascript">
        $(function() {
            $.inlineEdit({
                nilai: 'penilaian/set/nilai/',
                alpa: 'penilaian/set/alpa/',
                izin: 'penilaian/set/izin/',
                sakit: 'penilaian/set/sakit/'
            }, {
                animate: false,
                filterElementValue: function($o) {
                    if ($o.hasClass('nilai') || $o.hasClass('alpa') || $o.hasClass('izin') || $o.hasClass('sakit')) {
                        return $o.html().trim();
                    }
                }
            });
        });
    </script>
</div>