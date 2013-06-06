<div id="container">
    <?php if (isset($fakultas)) { ?>
        <div id="fakultas_detail">    
            <?php
            foreach ($fakultas as $row) {
                if (!empty($row['keterangan'])) {
                    echo '<h3 class="tit">Fakultas: ' . $row['nama'] . ' - ' . $row['keterangan'] . '</h3>';                    
                } else {
                    echo '<h3 class="tit">Fakultas: ' . $row['nama']. '</h3>';    
                }
            }
            ?>            
        </div>
    <?php } ?>
    <?php echo $output; ?>     
</div>