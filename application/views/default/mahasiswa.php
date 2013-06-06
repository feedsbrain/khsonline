<div id="container">
    <?php if (isset($kelas)) { ?>
        <div id="kelas_detail">    
            <?php
            foreach ($kelas as $row) {
                if (!empty($row['keterangan'])) {
                    echo '<h3 class="tit">Kelas: ' . $row['nama'] . ' - ' . $row['keterangan'] . '</h3>';                    
                } else {
                    echo '<h3 class="tit">Kelas: ' . $row['nama']. '</h3>';    
                }
            }
            ?>            
        </div>
    <?php } ?>
    <?php echo $output; ?>     
</div>