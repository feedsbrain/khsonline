SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `khsonline` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `khsonline` ;

-- -----------------------------------------------------
-- Table `khsonline`.`fakultas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`fakultas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nama` VARCHAR(50) NOT NULL ,
  `keterangan` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nama_UNIQUE` (`nama` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`jurusan`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`jurusan` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nama` VARCHAR(50) NOT NULL ,
  `keterangan` VARCHAR(100) NULL ,
  `fakultas` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nama_UNIQUE` (`nama` ASC) ,
  INDEX `fk_jurusan_fakultas_idx` (`fakultas` ASC) ,
  UNIQUE INDEX `uq_jurusan_fakultas` (`nama` ASC, `fakultas` ASC) ,
  CONSTRAINT `fk_jurusan_fakultas`
    FOREIGN KEY (`fakultas` )
    REFERENCES `khsonline`.`fakultas` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`kelas`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`kelas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nama` VARCHAR(10) NOT NULL ,
  `keterangan` VARCHAR(50) NULL ,
  `jurusan` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_kelas_jurusan_idx` (`jurusan` ASC) ,
  UNIQUE INDEX `uq_kelas_jurusan` (`nama` ASC, `jurusan` ASC) ,
  CONSTRAINT `fk_kelas_jurusan`
    FOREIGN KEY (`jurusan` )
    REFERENCES `khsonline`.`jurusan` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`mahasiswa`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`mahasiswa` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nim` VARCHAR(20) NOT NULL ,
  `nama` VARCHAR(100) NOT NULL ,
  `tahun` INT(4) NOT NULL ,
  `kelas` INT NOT NULL ,
  `tempat_lahir` VARCHAR(50) NULL ,
  `tanggal_lahir` DATE NULL ,
  `status` ENUM('AKTIF','DO','UNREG','CUTI','RESIGN','NOSTATUS') NOT NULL DEFAULT 'AKTIF' ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `nim_UNIQUE` (`nim` ASC) ,
  INDEX `fk_mahasiswa_kelas_idx` (`kelas` ASC) ,
  CONSTRAINT `fk_mahasiswa_kelas`
    FOREIGN KEY (`kelas` )
    REFERENCES `khsonline`.`kelas` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`matakuliah`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`matakuliah` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `kode` VARCHAR(10) NOT NULL ,
  `nama` VARCHAR(50) NOT NULL ,
  `kredit` INT(2) NOT NULL ,
  `jurusan` INT NOT NULL ,
  `semester` INT(2) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `kode_UNIQUE` (`kode` ASC) ,
  INDEX `fk_matakuliah_jurusan_idx` (`jurusan` ASC) ,
  CONSTRAINT `fk_matakuliah_jurusan`
    FOREIGN KEY (`jurusan` )
    REFERENCES `khsonline`.`jurusan` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(20) NOT NULL ,
  `password` VARCHAR(100) NOT NULL ,
  `level` ENUM('M','D','A','K','T','U') NOT NULL ,
  `name` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `active` TINYINT(1) NOT NULL DEFAULT 1 ,
  `system` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`krs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`krs` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `mahasiswa` INT NOT NULL ,
  `tahun` INT(4) NOT NULL ,
  `semester` INT(2) NOT NULL ,
  `dibuat_oleh` INT NOT NULL ,
  `tanggal_dibuat` DATETIME NOT NULL ,
  `diubah_oleh` INT NULL ,
  `tanggal_diubah` DATETIME NULL ,
  `posted` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_krs_mahasiswa_idx` (`mahasiswa` ASC) ,
  UNIQUE INDEX `uq_krs` (`mahasiswa` ASC, `semester` ASC, `tahun` ASC) ,
  INDEX `fk_krs_users_buat_idx` (`dibuat_oleh` ASC) ,
  INDEX `fk_krs_users_ubah_idx` (`diubah_oleh` ASC) ,
  CONSTRAINT `fk_krs_mahasiswa`
    FOREIGN KEY (`mahasiswa` )
    REFERENCES `khsonline`.`mahasiswa` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_krs_users_buat`
    FOREIGN KEY (`dibuat_oleh` )
    REFERENCES `khsonline`.`users` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_krs_users_ubah`
    FOREIGN KEY (`diubah_oleh` )
    REFERENCES `khsonline`.`users` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`spp`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`spp` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nama` VARCHAR(50) NOT NULL ,
  `tahun` INT(4) NOT NULL ,
  `semester` INT(2) NOT NULL ,
  `posted` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`sppdetail`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`sppdetail` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `spp` INT NOT NULL ,
  `keterangan` VARCHAR(50) NOT NULL ,
  `jumlah` DOUBLE NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_sppdetail_spp_idx` (`spp` ASC) ,
  CONSTRAINT `fk_sppdetail_spp`
    FOREIGN KEY (`spp` )
    REFERENCES `khsonline`.`spp` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`pembayaran`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`pembayaran` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `mahasiswa` INT NOT NULL ,
  `spp` INT NOT NULL ,
  `tanggal` DATETIME NOT NULL ,
  `jumlah` DOUBLE NOT NULL ,
  `dibuat_oleh` INT NOT NULL ,
  `tanggal_dibuat` DATETIME NOT NULL ,
  `diubah_oleh` INT NULL ,
  `tanggal_diubah` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pembayaran_mahasiswa_idx` (`mahasiswa` ASC) ,
  INDEX `fk_pembayaran_spp_idx` (`spp` ASC) ,
  INDEX `fk_pembayaran_users_idx_buat` (`dibuat_oleh` ASC) ,
  INDEX `fk_pembayaran_users_idx_ubah` (`diubah_oleh` ASC) ,
  CONSTRAINT `fk_pembayaran_mahasiswa`
    FOREIGN KEY (`mahasiswa` )
    REFERENCES `khsonline`.`mahasiswa` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pembayaran_spp`
    FOREIGN KEY (`spp` )
    REFERENCES `khsonline`.`spp` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pembayaran_users_buat`
    FOREIGN KEY (`dibuat_oleh` )
    REFERENCES `khsonline`.`users` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_pembayaran_users_ubah`
    FOREIGN KEY (`diubah_oleh` )
    REFERENCES `khsonline`.`users` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`sessions`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`sessions` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT '0' ,
  `ip_address` VARCHAR(45) NOT NULL DEFAULT '0' ,
  `user_agent` VARCHAR(120) NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT 0 ,
  `user_data` TEXT NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `last_activity_idx` (`last_activity` ASC) );


-- -----------------------------------------------------
-- Table `khsonline`.`captcha`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`captcha` (
  `captcha_id` BIGINT(13) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `captcha_time` INT(10) UNSIGNED NOT NULL ,
  `ip_address` VARCHAR(16) NOT NULL DEFAULT '0' ,
  `word` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`captcha_id`) ,
  INDEX `word` (`word` ASC) );


-- -----------------------------------------------------
-- Table `khsonline`.`krsdetail`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`krsdetail` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `krs` INT NOT NULL ,
  `matakuliah` INT NOT NULL ,
  `nilai` INT(11) NOT NULL DEFAULT 0 ,
  `alpa` INT(11) NOT NULL DEFAULT 0 ,
  `izin` INT(11) NOT NULL DEFAULT 0 ,
  `sakit` INT(11) NOT NULL DEFAULT 0 ,
  `penilai` INT NULL ,
  `tanggal_dinilai` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_krsdetail_krs_idx` (`krs` ASC) ,
  INDEX `fk_krsdetail_matakuliah_idx` (`matakuliah` ASC) ,
  UNIQUE INDEX `uq_krsdetail` (`krs` ASC, `matakuliah` ASC) ,
  INDEX `fk_krsdetail_users_idx` (`penilai` ASC) ,
  CONSTRAINT `fk_krsdetail_krs`
    FOREIGN KEY (`krs` )
    REFERENCES `khsonline`.`krs` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_krsdetail_matakuliah`
    FOREIGN KEY (`matakuliah` )
    REFERENCES `khsonline`.`matakuliah` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_krsdetail_users`
    FOREIGN KEY (`penilai` )
    REFERENCES `khsonline`.`users` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`config`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`config` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `key` ENUM('SIG1TITLE','SIG1NAME','SIG2TITLE','SIG2NAME') NOT NULL ,
  `value` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `key_UNIQUE` (`key` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `khsonline`.`transkrip`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `khsonline`.`transkrip` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `no_seri` VARCHAR(20) NOT NULL ,
  `mahasiswa` INT NOT NULL ,
  `yudisium` DATE NOT NULL ,
  `reg_ijazah` VARCHAR(50) NOT NULL ,
  `karya_tulis` VARCHAR(200) NOT NULL ,
  `lambang` ENUM('A','B','C','D','E') NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_transkrip_mahasiswa_idx` (`mahasiswa` ASC) ,
  UNIQUE INDEX `mahasiswa_UNIQUE` (`mahasiswa` ASC) ,
  CONSTRAINT `fk_transkrip_mahasiswa`
    FOREIGN KEY (`mahasiswa` )
    REFERENCES `khsonline`.`mahasiswa` (`id` )
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB;

USE `khsonline` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
