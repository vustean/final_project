-- MySQL Script generated by MySQL Workbench
-- 05/29/17 18:39:57
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema onlineTests
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema onlineTests
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `onlineTests` DEFAULT CHARACTER SET utf8 ;
USE `onlineTests` ;

-- -----------------------------------------------------
-- Table `onlineTests`.`level`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `onlineTests`.`level` ;

CREATE TABLE IF NOT EXISTS `onlineTests`.`level` (
  `level_id` INT NOT NULL,
  `level_name` VARCHAR(10) NOT NULL,
  `description` LONGTEXT NOT NULL,
  PRIMARY KEY (`level_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `onlineTests`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `onlineTests`.`user` ;

CREATE TABLE IF NOT EXISTS `onlineTests`.`user` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `first_name` VARCHAR(45) NOT NULL,
  `last_name` VARCHAR(45) NOT NULL,
  `is_active` TINYINT(1) NOT NULL,
  `level_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `level_id`, `username`),
  INDEX `fk_user_level1_idx` (`level_id` ASC),
  CONSTRAINT `fk_user_level1`
    FOREIGN KEY (`level_id`)
    REFERENCES `onlineTests`.`level` (`level_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `onlineTests`.`subject`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `onlineTests`.`subject` ;

CREATE TABLE IF NOT EXISTS `onlineTests`.`subject` (
  `subject_id` INT NOT NULL AUTO_INCREMENT,
  `subject_name` VARCHAR(100) NOT NULL,
  `description` LONGTEXT NOT NULL,
  `logo` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`subject_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `onlineTests`.`questions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `onlineTests`.`questions` ;

CREATE TABLE IF NOT EXISTS `onlineTests`.`questions` (
  `question_id` INT NOT NULL AUTO_INCREMENT,
  `question` LONGTEXT NOT NULL,
  `answer1` LONGTEXT NOT NULL,
  `answer2` LONGTEXT NOT NULL,
  `answer3` LONGTEXT NOT NULL,
  `answer4` LONGTEXT NOT NULL,
  `correct_answer` LONGTEXT NOT NULL,
  `level_id` INT NOT NULL,
  `subject_id` INT NOT NULL,
  PRIMARY KEY (`question_id`, `level_id`, `subject_id`),
  INDEX `fk_question_level1_idx` (`level_id` ASC),
  INDEX `fk_question_subject1_idx` (`subject_id` ASC),
  CONSTRAINT `fk_question_level1`
    FOREIGN KEY (`level_id`)
    REFERENCES `onlineTests`.`level` (`level_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_question_subject1`
    FOREIGN KEY (`subject_id`)
    REFERENCES `onlineTests`.`subject` (`subject_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `onlineTests`.`quiz`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `onlineTests`.`quiz` ;

CREATE TABLE IF NOT EXISTS `onlineTests`.`quiz` (
  `quiz_id` INT NOT NULL AUTO_INCREMENT,
  `date` DATE NOT NULL,
  `score` DECIMAL(4,2) NOT NULL,
  `user_user_id` INT NOT NULL,
  `level_level_id` INT NOT NULL,
  `subject_subject_id` INT NOT NULL,
  PRIMARY KEY (`quiz_id`, `user_user_id`, `level_level_id`, `subject_subject_id`),
  INDEX `fk_quiz_user1_idx` (`user_user_id` ASC),
  INDEX `fk_quiz_level1_idx` (`level_level_id` ASC),
  INDEX `fk_quiz_subject1_idx` (`subject_subject_id` ASC),
  CONSTRAINT `fk_quiz_user1`
    FOREIGN KEY (`user_user_id`)
    REFERENCES `onlineTests`.`user` (`user_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quiz_level1`
    FOREIGN KEY (`level_level_id`)
    REFERENCES `onlineTests`.`level` (`level_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quiz_subject1`
    FOREIGN KEY (`subject_subject_id`)
    REFERENCES `onlineTests`.`subject` (`subject_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;