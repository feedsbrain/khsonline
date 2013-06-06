<div id="container">
    <?php if (isset($jurusan)) { ?>
        <div id="jurusan_detail">    
            <?php
            foreach ($jurusan as $row) {
                if (!empty($row['keterangan'])) {
                    echo '<h3 class="tit">Jurusan: ' . $row['nama'] . ' - ' . $row['keterangan'] . '</h3>';                    
                } else {
                    echo '<h3 class="tit">Jurusan: ' . $row['nama']. '</h3>';    
                }
            }
            ?>            
        </div>
    <?php } ?>
    <?php echo $output; ?>     
</div>