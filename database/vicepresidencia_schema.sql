-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 18-07-2017 a las 18:43:20
-- Versión del servidor: 5.6.33-0ubuntu0.14.04.1
-- Versión de PHP: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `vicepresidencia`
--
CREATE DATABASE IF NOT EXISTS `vicepresidencia` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `vicepresidencia`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_egreso`
--

CREATE TABLE IF NOT EXISTS `alm_egreso` (
  `egr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prod_id` int(10) unsigned NOT NULL,
  `egr_cant` decimal(10,5) unsigned NOT NULL,
  `egr_fecha` date NOT NULL,
  `req_id` int(10) unsigned NOT NULL,
  `ing_id` int(10) unsigned NOT NULL,
  `egr_status` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `egr_rev` int(10) unsigned NOT NULL,
  `egr_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`egr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `alm_egreso`
--
DROP TRIGGER IF EXISTS `alm_egreso_ai`;
DELIMITER //
CREATE TRIGGER `alm_egreso_ai` AFTER INSERT ON `alm_egreso`
 FOR EACH ROW INSERT INTO alm_egreso_historial SET egr_id = NEW.egr_id, prod_id = NEW.prod_id, egr_cant = NEW.egr_cant, egr_fecha = NEW.egr_fecha, req_id = NEW.req_id, ing_id = NEW.ing_id, egr_status = NEW.egr_status, user_id = NEW.user_id, egr_rev = NEW.egr_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_egreso_au`;
DELIMITER //
CREATE TRIGGER `alm_egreso_au` AFTER UPDATE ON `alm_egreso`
 FOR EACH ROW INSERT INTO alm_egreso_historial SET egr_id = NEW.egr_id, prod_id = NEW.prod_id, egr_cant = NEW.egr_cant, egr_fecha = NEW.egr_fecha, req_id = NEW.req_id, ing_id = NEW.ing_id, egr_status = NEW.egr_status, user_id = NEW.user_id, egr_rev = NEW.egr_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_egreso_bd`;
DELIMITER //
CREATE TRIGGER `alm_egreso_bd` BEFORE DELETE ON `alm_egreso`
 FOR EACH ROW INSERT INTO alm_egreso_historial SET egr_id = OLD.egr_id, prod_id = OLD.prod_id, egr_cant = OLD.egr_cant, egr_fecha = OLD.egr_fecha, req_id = OLD.req_id, ing_id = OLD.ing_id, egr_status = OLD.egr_status, user_id = OLD.user_id, egr_rev = OLD.egr_rev
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_egreso_historial`
--

CREATE TABLE IF NOT EXISTS `alm_egreso_historial` (
  `egr_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `egr_id` int(10) unsigned NOT NULL,
  `prod_id` int(10) unsigned NOT NULL,
  `egr_cant` decimal(10,5) unsigned NOT NULL,
  `egr_fecha` date NOT NULL,
  `req_id` int(10) unsigned NOT NULL,
  `ing_id` int(10) unsigned NOT NULL,
  `egr_status` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `egr_rev` int(10) unsigned NOT NULL,
  `egr_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`egr_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_factura`
--

CREATE TABLE IF NOT EXISTS `alm_factura` (
  `fac_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fac_serie` varchar(20) NOT NULL,
  `fac_num` varchar(20) NOT NULL,
  `fac_fecha` date NOT NULL,
  `prov_id` int(10) unsigned NOT NULL,
  `orden_id` int(10) unsigned NOT NULL,
  `fac_1h` int(5) unsigned zerofill NOT NULL,
  `fac_control` int(5) unsigned zerofill NOT NULL,
  `fac_desc` mediumtext NOT NULL,
  `fac_obs` mediumtext NOT NULL,
  `fac_descuento` decimal(10,5) unsigned NOT NULL,
  `fac_status` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `fac_rev` int(10) unsigned NOT NULL,
  `fac_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fac_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `alm_factura`
--
DROP TRIGGER IF EXISTS `alm_factura_ai`;
DELIMITER //
CREATE TRIGGER `alm_factura_ai` AFTER INSERT ON `alm_factura`
 FOR EACH ROW INSERT INTO alm_factura_historial SET fac_id = NEW.fac_id, fac_serie =NEW.fac_serie, fac_num = New.fac_num, fac_fecha = NEW.fac_fecha, prov_id = NEW.prov_id, orden_id = NEW.orden_id, fac_1h = NEW.fac_1h, fac_control = NEW.fac_control, fac_desc = NEW.fac_desc, fac_obs = NEW.fac_obs, fac_descuento = NEW.fac_descuento, fac_status = NEW.fac_status, user_id = NEW.user_id, fac_rev = NEW.fac_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_factura_au`;
DELIMITER //
CREATE TRIGGER `alm_factura_au` AFTER UPDATE ON `alm_factura`
 FOR EACH ROW INSERT INTO alm_factura_historial SET fac_id = NEW.fac_id, fac_serie =NEW.fac_serie, fac_num = New.fac_num, fac_fecha = NEW.fac_fecha, prov_id = NEW.prov_id, orden_id = NEW.orden_id, fac_1h = NEW.fac_1h, fac_control = NEW.fac_control, fac_desc = NEW.fac_desc, fac_obs = NEW.fac_obs, fac_descuento = NEW.fac_descuento, fac_status = NEW.fac_status, user_id = NEW.user_id, fac_rev = NEW.fac_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_factura_bd`;
DELIMITER //
CREATE TRIGGER `alm_factura_bd` BEFORE DELETE ON `alm_factura`
 FOR EACH ROW INSERT INTO alm_factura_historial SET fac_id = OLD.fac_id, fac_serie =OLD.fac_serie, fac_num = OLD.fac_num, fac_fecha = OLD.fac_fecha, prov_id = OLD.prov_id, orden_id = OLD.orden_id, fac_1h = OLD.fac_1h, fac_control = OLD.fac_control, fac_desc= OLD.fac_desc, fac_obs = OLD.fac_obs, fac_desc = OLD.fac_desc, fac_status = OLD.fac_status, user_id = OLD.user_id, fac_rev = OLD.fac_rev
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_factura_historial`
--

CREATE TABLE IF NOT EXISTS `alm_factura_historial` (
  `fac_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fac_id` int(10) unsigned NOT NULL,
  `fac_serie` varchar(20) NOT NULL,
  `fac_num` varchar(20) NOT NULL,
  `fac_fecha` date NOT NULL,
  `prov_id` int(10) unsigned NOT NULL,
  `orden_id` int(10) unsigned NOT NULL,
  `fac_1h` int(5) unsigned zerofill NOT NULL,
  `fac_control` int(5) unsigned zerofill NOT NULL,
  `fac_desc` mediumtext NOT NULL,
  `fac_obs` mediumtext NOT NULL,
  `fac_descuento` decimal(10,5) unsigned NOT NULL,
  `fac_status` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `fac_rev` int(10) unsigned NOT NULL,
  `fac_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fac_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_ingreso`
--

CREATE TABLE IF NOT EXISTS `alm_ingreso` (
  `ing_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prod_id` int(10) unsigned NOT NULL,
  `ing_desc` varchar(50) NOT NULL,
  `ing_cant` decimal(10,5) unsigned NOT NULL,
  `ing_costo` decimal(10,5) unsigned NOT NULL,
  `ing_descuento` decimal(10,5) unsigned NOT NULL,
  `fac_id` int(10) unsigned NOT NULL,
  `folio_alm` varchar(25) NOT NULL,
  `folio_inv` varchar(25) NOT NULL,
  `nom_id` varchar(25) NOT NULL COMMENT 'Nomenclatura de Cuentas',
  `ing_status` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `ing_rev` int(10) unsigned NOT NULL,
  `ing_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ing_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `alm_ingreso`
--
DROP TRIGGER IF EXISTS `alm_ingreso_ai`;
DELIMITER //
CREATE TRIGGER `alm_ingreso_ai` AFTER INSERT ON `alm_ingreso`
 FOR EACH ROW INSERT INTO alm_ingreso_historial SET ing_id = New.ing_id, prod_id = NEW.prod_id, ing_desc = NEW.ing_desc, ing_cant = New.ing_cant, ing_costo = New.ing_costo, ing_descuento = NEW.ing_descuento, fac_id = New.fac_id, folio_alm = New.folio_alm, folio_inv = New.folio_inv, nom_id = New.nom_id, ing_status = New.ing_status, user_id = New.user_id, ing_rev = New.ing_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_ingreso_au`;
DELIMITER //
CREATE TRIGGER `alm_ingreso_au` AFTER UPDATE ON `alm_ingreso`
 FOR EACH ROW INSERT INTO alm_ingreso_historial SET ing_id = New.ing_id, prod_id = NEW.prod_id, ing_desc = NEW.ing_desc, ing_cant = New.ing_cant, ing_costo = New.ing_costo, ing_descuento = NEW.ing_descuento, fac_id = New.fac_id, folio_alm = New.folio_alm, folio_inv = New.folio_inv, nom_id = New.nom_id, ing_status = New.ing_status, user_id = New.user_id, ing_rev = New.ing_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_ingreso_bd`;
DELIMITER //
CREATE TRIGGER `alm_ingreso_bd` BEFORE DELETE ON `alm_ingreso`
 FOR EACH ROW INSERT INTO alm_ingreso_historial SET ing_id = OLD.ing_id, prod_id = OLD.prod_id, ing_desc = OLD.ing_desc,  ing_cant = OLD.ing_cant, ing_costo = OLD.ing_costo, ing_descuento = OLD.ing_descuento, fac_id = OLD.fac_id, folio_alm = OLD.folio_alm, folio_inv = OLD.folio_inv, nom_id = OLD.nom_id, ing_status = OLD.ing_status, user_id = OLD.user_id, ing_rev = OLD.ing_rev
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_ingreso_historial`
--

CREATE TABLE IF NOT EXISTS `alm_ingreso_historial` (
  `ing_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ing_id` int(10) unsigned NOT NULL,
  `prod_id` int(10) unsigned NOT NULL,
  `ing_desc` varchar(50) NOT NULL,
  `ing_cant` decimal(10,5) unsigned NOT NULL,
  `ing_costo` decimal(10,5) unsigned NOT NULL,
  `ing_descuento` decimal(10,5) unsigned NOT NULL,
  `fac_id` int(10) unsigned NOT NULL,
  `folio_alm` varchar(25) NOT NULL,
  `folio_inv` varchar(25) NOT NULL,
  `nom_id` varchar(25) NOT NULL COMMENT 'Nomenclatura de Cuentas',
  `ing_status` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `ing_rev` int(10) unsigned NOT NULL,
  `ing_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ing_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_kardex`
--

CREATE TABLE IF NOT EXISTS `alm_kardex` (
  `kx_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kx_num` int(5) unsigned zerofill NOT NULL,
  `prod_id` int(10) unsigned NOT NULL,
  `kx_status` int(10) unsigned NOT NULL,
  `kx_rev` int(10) unsigned NOT NULL,
  `kx_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kx_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `alm_kardex`
--
DROP TRIGGER IF EXISTS `alm_kardex_ai`;
DELIMITER //
CREATE TRIGGER `alm_kardex_ai` AFTER INSERT ON `alm_kardex`
 FOR EACH ROW INSERT INTO alm_kardex_historial SET kx_id = NEW.kx_id, kx_num = NEW.kx_num, prod_id = NEW.prod_id, kx_status = NEW.kx_status, kx_rev = NEW.kx_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_kardex_au`;
DELIMITER //
CREATE TRIGGER `alm_kardex_au` AFTER UPDATE ON `alm_kardex`
 FOR EACH ROW INSERT INTO alm_kardex_historial SET kx_id = NEW.kx_id, kx_num = NEW.kx_num, prod_id = NEW.prod_id, kx_status = NEW.kx_status, kx_rev = NEW.kx_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_kardex_bd`;
DELIMITER //
CREATE TRIGGER `alm_kardex_bd` BEFORE DELETE ON `alm_kardex`
 FOR EACH ROW INSERT INTO alm_kardex_historial SET kx_id = OLD.kx_id, kx_num = OLD.kx_num, prod_id = OLD.prod_id, kx_status = OLD.kx_status, kx_rev = OLD.kx_rev
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_kardex_historial`
--

CREATE TABLE IF NOT EXISTS `alm_kardex_historial` (
  `kx_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kx_id` int(10) unsigned NOT NULL,
  `kx_num` int(5) unsigned zerofill NOT NULL,
  `prod_id` int(10) unsigned NOT NULL,
  `kx_status` int(10) unsigned NOT NULL,
  `kx_rev` int(10) unsigned NOT NULL,
  `kx_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`kx_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_medida`
--

CREATE TABLE IF NOT EXISTS `alm_medida` (
  `med_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `med_nm` varchar(25) NOT NULL,
  `med_cat_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `med_status` int(11) NOT NULL,
  `med_rev` int(10) unsigned NOT NULL,
  `med_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`med_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `alm_medida`
--
DROP TRIGGER IF EXISTS `alm_medida_ai`;
DELIMITER //
CREATE TRIGGER `alm_medida_ai` AFTER INSERT ON `alm_medida`
 FOR EACH ROW INSERT INTO alm_medida_historial SET med_id = NEW.med_id, med_nm = NEW.med_nm, med_cat_id = NEW.med_cat_id, user_id = NEW.user_id, med_status = NEW.med_status, med_rev = NEW.med_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_medida_au`;
DELIMITER //
CREATE TRIGGER `alm_medida_au` AFTER UPDATE ON `alm_medida`
 FOR EACH ROW INSERT INTO alm_medida_historial SET med_id = NEW.med_id, med_nm = NEW.med_nm, med_cat_id = NEW.med_cat_id, user_id = NEW.user_id, med_status = NEW.med_status, med_rev = NEW.med_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_medida_bd`;
DELIMITER //
CREATE TRIGGER `alm_medida_bd` BEFORE DELETE ON `alm_medida`
 FOR EACH ROW INSERT INTO alm_medida_historial SET med_id = OLD.med_id, med_nm = OLD.med_nm, med_cat_id = OLD.med_cat_id, user_id = OLD.user_id, med_status = OLD.med_status, med_rev = OLD.med_rev
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_medida_categoria`
--

CREATE TABLE IF NOT EXISTS `alm_medida_categoria` (
  `med_cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `med_cat_nm` varchar(50) NOT NULL,
  `vp_user` int(11) NOT NULL,
  `med_cat_status` int(11) NOT NULL,
  `med_cat_rev` int(11) NOT NULL,
  `med_cat_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`med_cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_medida_historial`
--

CREATE TABLE IF NOT EXISTS `alm_medida_historial` (
  `med_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `med_id` int(10) unsigned NOT NULL,
  `med_nm` varchar(25) NOT NULL,
  `med_cat_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `med_status` int(11) NOT NULL,
  `med_rev` int(10) unsigned NOT NULL,
  `med_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`med_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_producto`
--

CREATE TABLE IF NOT EXISTS `alm_producto` (
  `prod_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `renglon_id` int(10) unsigned NOT NULL,
  `prod_cod` int(10) unsigned NOT NULL,
  `prod_nm` varchar(200) NOT NULL,
  `prod_desc` varchar(200) NOT NULL,
  `med_id` int(10) unsigned NOT NULL,
  `prod_min` int(10) unsigned NOT NULL,
  `prod_max` int(10) unsigned NOT NULL,
  `prod_status` int(2) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `prod_rev` int(10) unsigned NOT NULL,
  `prod_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `alm_producto`
--
DROP TRIGGER IF EXISTS `alm_producto_ai`;
DELIMITER //
CREATE TRIGGER `alm_producto_ai` AFTER INSERT ON `alm_producto`
 FOR EACH ROW INSERT INTO alm_producto_historial SET prod_id = NEW.prod_id, renglon_id =NEW.renglon_id, prod_cod = New.prod_cod, prod_nm = NEW.prod_nm, prod_desc = NEW.prod_desc, med_id = NEW.med_id, prod_min = NEW.prod_min, prod_max = NEW.prod_max, prod_status = NEW.prod_status, user_id = NEW.user_id, prod_rev = NEW.prod_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_producto_au`;
DELIMITER //
CREATE TRIGGER `alm_producto_au` AFTER UPDATE ON `alm_producto`
 FOR EACH ROW INSERT INTO alm_producto_historial SET prod_id = NEW.prod_id, renglon_id =NEW.renglon_id, prod_cod = New.prod_cod, prod_nm = NEW.prod_nm, prod_desc = NEW.prod_desc, med_id = NEW.med_id, prod_min = NEW.prod_min, prod_max = NEW.prod_max, prod_status = NEW.prod_status, user_id = NEW.user_id, prod_rev = NEW.prod_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_producto_bd`;
DELIMITER //
CREATE TRIGGER `alm_producto_bd` BEFORE DELETE ON `alm_producto`
 FOR EACH ROW INSERT INTO alm_producto_historial SET prod_id = OLD.prod_id, renglon_id =OLD.renglon_id, prod_cod = OLD.prod_cod, prod_nm = OLD.prod_nm, prod_desc = OLD.prod_desc, med_id = OLD.med_id, prod_min = OLD.prod_min, prod_max = OLD.prod_max, prod_status = OLD.prod_status, user_id = OLD.user_id, prod_rev = OLD.prod_rev
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_producto_historial`
--

CREATE TABLE IF NOT EXISTS `alm_producto_historial` (
  `prod_hist_id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(10) unsigned NOT NULL,
  `renglon_id` int(10) unsigned NOT NULL,
  `prod_cod` int(10) unsigned NOT NULL,
  `prod_nm` varchar(200) NOT NULL,
  `prod_desc` varchar(200) NOT NULL,
  `med_id` int(10) unsigned NOT NULL,
  `prod_min` int(10) unsigned NOT NULL,
  `prod_max` int(10) unsigned NOT NULL,
  `prod_status` int(2) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `prod_rev` int(10) unsigned NOT NULL,
  `prod_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prod_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_renglon`
--

CREATE TABLE IF NOT EXISTS `alm_renglon` (
  `renglon_id` int(10) unsigned NOT NULL,
  `renglon_nm` varchar(100) NOT NULL,
  `renglon_status` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `renglon_rev` int(10) unsigned NOT NULL,
  `renglon_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`renglon_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Disparadores `alm_renglon`
--
DROP TRIGGER IF EXISTS `alm_renglon_ai`;
DELIMITER //
CREATE TRIGGER `alm_renglon_ai` AFTER INSERT ON `alm_renglon`
 FOR EACH ROW INSERT INTO alm_renglon_historial SET renglon_id = NEW.renglon_id, renglon_nm = NEW.renglon_nm, renglon_status = NEW.renglon_status, user_id = NEW.user_id, renglon_rev = NEW.renglon_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_renglon_au`;
DELIMITER //
CREATE TRIGGER `alm_renglon_au` AFTER UPDATE ON `alm_renglon`
 FOR EACH ROW INSERT INTO alm_renglon_historial SET renglon_id = NEW.renglon_id,  renglon_nm = NEW.renglon_nm, renglon_status = NEW.renglon_status, user_id = NEW.user_id, renglon_rev = NEW.renglon_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_renglon_bd`;
DELIMITER //
CREATE TRIGGER `alm_renglon_bd` BEFORE DELETE ON `alm_renglon`
 FOR EACH ROW INSERT INTO alm_renglon_historial SET renglon_id = OLD.renglon_id, renglon_nm = OLD.renglon_nm, renglon_status = OLD.renglon_status, user_id = OLD.user_id, renglon_rev = OLD.renglon_rev
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_renglon_historial`
--

CREATE TABLE IF NOT EXISTS `alm_renglon_historial` (
  `renglon_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `renglon_id` int(10) unsigned NOT NULL,
  `renglon_nm` varchar(100) NOT NULL,
  `renglon_status` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `renglon_rev` int(10) unsigned NOT NULL,
  `renglon_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`renglon_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_requisicion`
--

CREATE TABLE IF NOT EXISTS `alm_requisicion` (
  `req_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `req_num` int(6) unsigned zerofill NOT NULL,
  `req_user` int(10) unsigned NOT NULL,
  `dep_id` int(10) unsigned NOT NULL,
  `req_status` int(10) unsigned NOT NULL,
  `req_fecha` date NOT NULL,
  `req_obs` varchar(200) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `req_rev` int(10) unsigned NOT NULL,
  `req_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`req_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `alm_requisicion`
--
DROP TRIGGER IF EXISTS `alm_requisicion_ai`;
DELIMITER //
CREATE TRIGGER `alm_requisicion_ai` AFTER INSERT ON `alm_requisicion`
 FOR EACH ROW INSERT INTO alm_requisicion_historial SET req_id = NEW.req_id, req_num = NEW.req_num, req_user = NEW.req_user, dep_id = NEW.dep_id, req_status = NEW.req_status, req_fecha = NEW.req_fecha, req_obs = NEW.req_obs, user_id = NEW.user_id, req_rev = NEW.req_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_requisicion_au`;
DELIMITER //
CREATE TRIGGER `alm_requisicion_au` AFTER UPDATE ON `alm_requisicion`
 FOR EACH ROW INSERT INTO alm_requisicion_historial SET req_id = NEW.req_id, req_num = NEW.req_num, req_user = NEW.req_user, dep_id = NEW.dep_id, req_status = NEW.req_status, req_fecha = NEW.req_fecha, req_obs = NEW.req_obs, user_id = NEW.user_id, req_rev = NEW.req_rev
//
DELIMITER ;
DROP TRIGGER IF EXISTS `alm_requisicion_bd`;
DELIMITER //
CREATE TRIGGER `alm_requisicion_bd` BEFORE DELETE ON `alm_requisicion`
 FOR EACH ROW INSERT INTO alm_requisicion_historial SET req_id = OLD.req_id, req_num = OLD.req_num, req_user = OLD.req_user, dep_id = OLD.dep_id, req_status = OLD.req_status, req_fecha = OLD.req_fecha, req_obs = OLD.req_obs, user_id = OLD.user_id, req_rev = OLD.req_rev
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alm_requisicion_historial`
--

CREATE TABLE IF NOT EXISTS `alm_requisicion_historial` (
  `req_hist_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `req_id` int(10) unsigned NOT NULL,
  `req_num` int(6) unsigned zerofill NOT NULL,
  `req_user` int(10) unsigned NOT NULL,
  `dep_id` int(10) unsigned NOT NULL,
  `req_status` int(10) unsigned NOT NULL,
  `req_fecha` date NOT NULL,
  `req_obs` varchar(200) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `req_rev` int(10) unsigned NOT NULL,
  `req_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`req_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arch_tipo`
--

CREATE TABLE IF NOT EXISTS `arch_tipo` (
  `tipo_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_nombre` varchar(50) NOT NULL,
  `tipo_status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `tipo_rev` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `user_id` tinyint(3) unsigned NOT NULL,
  `tipo_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tipo_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`tipo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `arch_tipo`
--
DROP TRIGGER IF EXISTS `arch_tipo_ai`;
DELIMITER //
CREATE TRIGGER `arch_tipo_ai` AFTER INSERT ON `arch_tipo`
 FOR EACH ROW INSERT INTO arch_tipo_historial SET tipo_id = NEW.tipo_id, tipo_nombre = NEW.tipo_nombre, tipo_status = NEW.tipo_status, tipo_rev = NEW.tipo_rev, user_id = NEW.user_id, tipo_creadoEn = NEW.tipo_creadoEn, tipo_actualizadoEn = NEW.tipo_actualizadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `arch_tipo_au`;
DELIMITER //
CREATE TRIGGER `arch_tipo_au` AFTER UPDATE ON `arch_tipo`
 FOR EACH ROW INSERT INTO arch_tipo_historial SET tipo_id = NEW.tipo_id, tipo_nombre = NEW.tipo_nombre, tipo_status = NEW.tipo_status, tipo_rev = NEW.tipo_rev, user_id = NEW.user_id, tipo_creadoEn = NEW.tipo_creadoEn, tipo_actualizadoEn = NEW.tipo_actualizadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `arch_tipo_bd`;
DELIMITER //
CREATE TRIGGER `arch_tipo_bd` BEFORE DELETE ON `arch_tipo`
 FOR EACH ROW INSERT INTO arch_tipo_historial SET tipo_id = OLD.tipo_id, tipo_nombre = OLD.tipo_nombre, tipo_status = OLD.tipo_status, tipo_rev = OLD.tipo_rev, user_id = OLD.user_id, tipo_creadoEn = OLD.tipo_creadoEn, tipo_actualizadoEn = OLD.tipo_actualizadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `arch_tipo_bu`;
DELIMITER //
CREATE TRIGGER `arch_tipo_bu` BEFORE UPDATE ON `arch_tipo`
 FOR EACH ROW SET NEW.tipo_rev = NEW.tipo_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `arch_tipo_historial`
--

CREATE TABLE IF NOT EXISTS `arch_tipo_historial` (
  `tipo_hist_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_id` tinyint(3) unsigned NOT NULL,
  `tipo_nombre` varchar(50) NOT NULL,
  `tipo_status` tinyint(3) unsigned NOT NULL,
  `tipo_rev` tinyint(3) unsigned NOT NULL,
  `user_id` tinyint(3) unsigned NOT NULL,
  `tipo_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tipo_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`tipo_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_banco`
--

CREATE TABLE IF NOT EXISTS `df_banco` (
  `bc_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID del banco',
  `bc_nombre` varchar(150) NOT NULL COMMENT 'Nombre del banco',
  `bc_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Estado del banco',
  `bc_rev` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Número de revisión del registro',
  `user_id` int(10) unsigned NOT NULL COMMENT 'Usuario que creo/modifico el banco',
  `bc_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `bc_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación del registro',
  PRIMARY KEY (`bc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `df_banco`
--
DROP TRIGGER IF EXISTS `df_banco_ai`;
DELIMITER //
CREATE TRIGGER `df_banco_ai` AFTER INSERT ON `df_banco`
 FOR EACH ROW INSERT INTO df_banco_historial SET bc_id = NEW.bc_id, bc_nombre = NEW.bc_nombre, bc_status = NEW.bc_status, bc_rev = NEW.bc_rev, user_id = NEW.user_id, bc_creadoEn = NEW.bc_creadoEN, bc_actualizadoEn = NEW.bc_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_banco_au`;
DELIMITER //
CREATE TRIGGER `df_banco_au` AFTER UPDATE ON `df_banco`
 FOR EACH ROW INSERT INTO df_banco_historial SET bc_id = NEW.bc_id, bc_nombre = NEW.bc_nombre, bc_status = NEW.bc_status, bc_rev = NEW.bc_rev, user_id = NEW.user_id, bc_creadoEn = NEW.bc_creadoEN, bc_actualizadoEn = NEW.bc_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_banco_bd`;
DELIMITER //
CREATE TRIGGER `df_banco_bd` BEFORE DELETE ON `df_banco`
 FOR EACH ROW INSERT INTO df_banco_historial SET bc_id = OLD.bc_id, bc_nombre = OLD.bc_nombre, bc_status = OLD.bc_status, bc_rev = OLD.bc_rev, user_id = OLD.user_id, bc_creadoEn = OLD.bc_creadoEN, bc_actualizadoEn = OLD.bc_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_banco_bu`;
DELIMITER //
CREATE TRIGGER `df_banco_bu` BEFORE UPDATE ON `df_banco`
 FOR EACH ROW SET new.bc_rev = new.bc_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_banco_historial`
--

CREATE TABLE IF NOT EXISTS `df_banco_historial` (
  `bc_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bc_id` int(10) unsigned NOT NULL,
  `bc_nombre` varchar(150) NOT NULL COMMENT 'Nombre del banco',
  `bc_status` tinyint(3) unsigned NOT NULL COMMENT 'Estado del banco',
  `bc_rev` int(10) unsigned NOT NULL COMMENT 'Número de revisión del registro',
  `user_id` int(10) unsigned NOT NULL COMMENT 'Usuario que creo/modifico el banco',
  `bc_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de creación del registro',
  `bc_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de modificación del registro',
  PRIMARY KEY (`bc_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_credito`
--

CREATE TABLE IF NOT EXISTS `df_credito` (
  `cdto_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID del crédito',
  `cta_id` int(10) unsigned NOT NULL COMMENT 'ID de la cuenta',
  `cdto_fecha` date NOT NULL COMMENT 'Fecha del crédito',
  `cdto_monto` decimal(13,5) unsigned NOT NULL COMMENT 'Monto acreditado',
  `cdto_desc` text NOT NULL COMMENT 'Descripción del crédito',
  `cdto_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Estado del credito',
  `cdto_rev` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Número de revisión del registro',
  `user_id` int(10) unsigned NOT NULL COMMENT 'Usuario que creo/modifico el registro',
  `cdto_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del crédito',
  `cdto_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación del crédito',
  PRIMARY KEY (`cdto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla para almacenar crédito en control de cheques';

--
-- Disparadores `df_credito`
--
DROP TRIGGER IF EXISTS `df_credito_ai`;
DELIMITER //
CREATE TRIGGER `df_credito_ai` AFTER INSERT ON `df_credito`
 FOR EACH ROW INSERT INTO df_credito_historial SET cdto_id = NEW.cdto_id,cta_id = NEW.cta_id,cdto_fecha = NEW.cdto_fecha,cdto_monto = NEW.cdto_monto,cdto_desc = NEW.cdto_desc,cdto_status = NEW.cdto_status,cdto_rev = NEW.cdto_rev,user_id = NEW.user_id,cdto_creadoEn = NEW.cdto_creadoEn, cdto_actualizadoEn = NEW.cdto_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_credito_au`;
DELIMITER //
CREATE TRIGGER `df_credito_au` AFTER UPDATE ON `df_credito`
 FOR EACH ROW INSERT INTO df_credito_historial SET cdto_id = NEW.cdto_id,cta_id = NEW.cta_id,cdto_fecha = NEW.cdto_fecha,cdto_monto = NEW.cdto_monto,cdto_desc = NEW.cdto_desc,cdto_status = NEW.cdto_status,cdto_rev = NEW.cdto_rev,user_id = NEW.user_id,cdto_creadoEn = NEW.cdto_creadoEn, cdto_actualizadoEn = NEW.cdto_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_credito_bd`;
DELIMITER //
CREATE TRIGGER `df_credito_bd` BEFORE DELETE ON `df_credito`
 FOR EACH ROW INSERT INTO df_credito_historial SET cdto_id = OLD.cdto_id,cta_id = OLD.cta_id,cdto_fecha = OLD.cdto_fecha,cdto_monto = OLD.cdto_monto,cdto_desc = OLD.cdto_desc,cdto_status = OLD.cdto_status,cdto_rev = OLD.cdto_rev,user_id = OLD.user_id,cdto_creadoEn = OLD.cdto_creadoEn, cdto_actualizadoEn = OLD.cdto_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_credito_bu`;
DELIMITER //
CREATE TRIGGER `df_credito_bu` BEFORE UPDATE ON `df_credito`
 FOR EACH ROW SET new.cdto_rev = new.cdto_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_credito_historial`
--

CREATE TABLE IF NOT EXISTS `df_credito_historial` (
  `cdto_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cdto_id` int(10) unsigned NOT NULL,
  `cta_id` int(10) unsigned NOT NULL COMMENT 'ID de la cuenta',
  `cdto_fecha` date NOT NULL COMMENT 'Fecha del crédito',
  `cdto_monto` decimal(13,5) unsigned NOT NULL COMMENT 'Monto acreditado',
  `cdto_desc` text NOT NULL COMMENT 'Descripción del crédito',
  `cdto_status` tinyint(3) unsigned NOT NULL COMMENT 'Estado del credito',
  `cdto_rev` int(10) unsigned NOT NULL COMMENT 'Número de revisión del registro',
  `user_id` int(10) unsigned NOT NULL COMMENT 'Usuario que creo/modifico el registro',
  `cdto_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de creación del crédito',
  `cdto_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de modificación del crédito',
  PRIMARY KEY (`cdto_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabla para almacenar crédito en control de cheques';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_cuenta`
--

CREATE TABLE IF NOT EXISTS `df_cuenta` (
  `cta_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID de la cuenta',
  `cta_titular` varchar(150) NOT NULL COMMENT 'Nombre de titular de cuenta',
  `cta_num` varchar(25) NOT NULL COMMENT 'Número de la cuenta',
  `bc_id` int(10) unsigned NOT NULL COMMENT 'ID del banco',
  `cta_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Estado de la cuenta',
  `cta_rev` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Número de revisión del registro',
  `user_id` int(10) unsigned NOT NULL COMMENT 'ID del usuario que crea/modifica',
  `cta_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `cta_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de actualización del registro',
  PRIMARY KEY (`cta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `df_cuenta`
--
DROP TRIGGER IF EXISTS `df_cuenta_ai`;
DELIMITER //
CREATE TRIGGER `df_cuenta_ai` AFTER INSERT ON `df_cuenta`
 FOR EACH ROW INSERT INTO df_cuenta_historial SET cta_id = NEW.cta_id, cta_titular = NEW.cta_titular,cta_num = NEW.cta_num,bc_id = NEW.bc_id,cta_status = NEW.cta_status,cta_rev = NEW.cta_rev,user_id = NEW.user_id,cta_creadoEn = NEW.cta_creadoEn,cta_actualizadoEn = NEW.cta_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_cuenta_au`;
DELIMITER //
CREATE TRIGGER `df_cuenta_au` AFTER UPDATE ON `df_cuenta`
 FOR EACH ROW INSERT INTO df_cuenta_historial SET cta_id = NEW.cta_id, cta_titular = NEW.cta_titular,cta_num = NEW.cta_num,bc_id = NEW.bc_id,cta_status = NEW.cta_status,cta_rev = NEW.cta_rev,user_id = NEW.user_id,cta_creadoEn = NEW.cta_creadoEn,cta_actualizadoEn = NEW.cta_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_cuenta_bd`;
DELIMITER //
CREATE TRIGGER `df_cuenta_bd` BEFORE DELETE ON `df_cuenta`
 FOR EACH ROW INSERT INTO df_cuenta_historial SET cta_id = OLD.cta_id, cta_titular = OLD.cta_titular,cta_num = OLD.cta_num,bc_id = OLD.bc_id,cta_status = OLD.cta_status,cta_rev = OLD.cta_rev,user_id = OLD.user_id,cta_creadoEn = OLD.cta_creadoEn,cta_actualizadoEn = OLD.cta_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_cuenta_bu`;
DELIMITER //
CREATE TRIGGER `df_cuenta_bu` BEFORE UPDATE ON `df_cuenta`
 FOR EACH ROW SET new.cta_rev = new.cta_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_cuenta_historial`
--

CREATE TABLE IF NOT EXISTS `df_cuenta_historial` (
  `cta_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cta_id` int(10) unsigned NOT NULL,
  `cta_titular` varchar(150) NOT NULL COMMENT 'Nombre de titular de cuenta',
  `cta_num` varchar(25) NOT NULL COMMENT 'Número de la cuenta',
  `bc_id` int(10) unsigned NOT NULL COMMENT 'ID del banco',
  `cta_status` tinyint(3) unsigned NOT NULL COMMENT 'Estado de la cuenta',
  `cta_rev` int(10) unsigned NOT NULL COMMENT 'Número de revisión del registro',
  `user_id` int(10) unsigned NOT NULL COMMENT 'ID del usuario que crea/modifica',
  `cta_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de creación del registro',
  `cta_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de actualización del registro',
  PRIMARY KEY (`cta_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_cupon_egr`
--

CREATE TABLE IF NOT EXISTS `df_cupon_egr` (
  `cupon_egr_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `cupon_ing_id` int(10) unsigned NOT NULL,
  `vehiculo_id` int(10) unsigned NOT NULL,
  `conductor_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `km_inicial` decimal(13,5) unsigned NOT NULL,
  `km_final` decimal(13,5) unsigned NOT NULL,
  `galones_consumidos` decimal(13,5) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `rev` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cupon_egr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `df_cupon_egr`
--
DROP TRIGGER IF EXISTS `df_cupon_egr_ai`;
DELIMITER //
CREATE TRIGGER `df_cupon_egr_ai` AFTER INSERT ON `df_cupon_egr`
 FOR EACH ROW INSERT INTO df_cupon_egr_historial SET cupon_egr_id = NEW.cupon_egr_id, fecha = NEW.fecha, cupon_ing_id = NEW.cupon_ing_id, vehiculo_id = NEW.vehiculo_id, conductor_id = NEW.conductor_id, usuario_id = NEW.usuario_id, km_inicial = NEW.km_inicial, km_final = NEW.km_final, galones_consumidos = NEW.galones_consumidos, status = NEW.status, rev = NEW.rev, user_id = NEW.user_id, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_cupon_egr_au`;
DELIMITER //
CREATE TRIGGER `df_cupon_egr_au` AFTER UPDATE ON `df_cupon_egr`
 FOR EACH ROW INSERT INTO df_cupon_egr_historial SET cupon_egr_id = NEW.cupon_egr_id, fecha = NEW.fecha, cupon_ing_id = NEW.cupon_ing_id, vehiculo_id = NEW.vehiculo_id, conductor_id = NEW.conductor_id, usuario_id = NEW.usuario_id, km_inicial = NEW.km_inicial, km_final = NEW.km_final, galones_consumidos = NEW.galones_consumidos, status = NEW.status, rev = NEW.rev, user_id = NEW.user_id, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_cupon_egr_bd`;
DELIMITER //
CREATE TRIGGER `df_cupon_egr_bd` BEFORE DELETE ON `df_cupon_egr`
 FOR EACH ROW INSERT INTO df_cupon_egr_historial SET cupon_egr_id = OLD.cupon_egr_id, fecha = OLD.fecha, cupon_ing_id = OLD.cupon_ing_id, vehiculo_id = OLD.vehiculo_id, conductor_id = OLD.conductor_id, usuario_id = OLD.usuario_id, km_inicial = OLD.km_inicial, km_final = OLD.km_final, galones_consumidos = OLD.galones_consumidos, status = OLD.status, rev = OLD.rev, user_id = OLD.user_id, creadoEn = OLD.creadoEn
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_cupon_egr_historial`
--

CREATE TABLE IF NOT EXISTS `df_cupon_egr_historial` (
  `cupon_egr_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cupon_egr_id` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `cupon_ing_id` int(10) unsigned NOT NULL,
  `vehiculo_id` int(10) unsigned NOT NULL,
  `conductor_id` int(10) unsigned NOT NULL,
  `usuario_id` int(10) unsigned NOT NULL,
  `km_inicial` decimal(13,5) unsigned NOT NULL,
  `km_final` decimal(13,5) unsigned NOT NULL,
  `galones_consumidos` decimal(13,5) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `rev` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cupon_egr_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_cupon_ing`
--

CREATE TABLE IF NOT EXISTS `df_cupon_ing` (
  `cupon_ing_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cupon_pedido_id` int(10) unsigned NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_cad` date NOT NULL,
  `num` int(10) unsigned NOT NULL,
  `monto` decimal(13,5) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `rev` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cupon_ing_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `df_cupon_ing`
--
DROP TRIGGER IF EXISTS `df_cupon_ing_ai`;
DELIMITER //
CREATE TRIGGER `df_cupon_ing_ai` AFTER INSERT ON `df_cupon_ing`
 FOR EACH ROW INSERT INTO df_cupon_ing_historial SET cupon_ing_id = NEW.cupon_ing_id, cupon_pedido_id = NEW.cupon_pedido_id, fecha_emision = NEW.fecha_emision, fecha_cad = NEW.fecha_cad, num = NEW.num, monto = NEW.monto, status = NEW.status, rev = NEW.rev, user_id  = NEW.user_id, creadoEn = NEW.creadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_cupon_ing_au`;
DELIMITER //
CREATE TRIGGER `df_cupon_ing_au` AFTER UPDATE ON `df_cupon_ing`
 FOR EACH ROW INSERT INTO df_cupon_ing_historial SET cupon_ing_id = NEW.cupon_ing_id, cupon_pedido_id = NEW.cupon_pedido_id, fecha_emision = NEW.fecha_emision, fecha_cad = NEW.fecha_cad, num = NEW.num, monto = NEW.monto, status = NEW.status, rev = NEW.rev, user_id  = NEW.user_id, creadoEn = NEW.creadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_cupon_ing_bd`;
DELIMITER //
CREATE TRIGGER `df_cupon_ing_bd` BEFORE DELETE ON `df_cupon_ing`
 FOR EACH ROW INSERT INTO df_cupon_ing_historial SET cupon_ing_id = OLD.cupon_ing_id, cupon_pedido_id = OLD.cupon_pedido_id, fecha_emision = OLD.fecha_emision, fecha_cad = OLD.fecha_cad, num = OLD.num, monto = OLD.monto, status = OLD.status, rev = OLD.rev, user_id  = OLD.user_id, creadoEn = OLD.creadoEN
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_cupon_ing_historial`
--

CREATE TABLE IF NOT EXISTS `df_cupon_ing_historial` (
  `cupon_ing_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cupon_ing_id` int(10) unsigned DEFAULT NULL,
  `cupon_pedido_id` int(10) unsigned NOT NULL,
  `fecha_emision` date NOT NULL,
  `fecha_cad` date NOT NULL,
  `num` int(10) unsigned NOT NULL,
  `monto` decimal(13,5) unsigned NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `rev` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cupon_ing_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_cupon_pedido`
--

CREATE TABLE IF NOT EXISTS `df_cupon_pedido` (
  `cupon_pedido_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cta_id` int(10) unsigned NOT NULL,
  `fac_fecha` date NOT NULL,
  `fac_serie` varchar(20) NOT NULL,
  `fac_num` varchar(20) NOT NULL,
  `pedido_num` int(10) unsigned NOT NULL,
  `codigo` int(11) NOT NULL,
  `prov_id` int(11) NOT NULL,
  `comentario` mediumtext NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '2',
  `rev` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cupon_pedido_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `df_cupon_pedido`
--
DROP TRIGGER IF EXISTS `df_cupon_pedido_ai`;
DELIMITER //
CREATE TRIGGER `df_cupon_pedido_ai` AFTER INSERT ON `df_cupon_pedido`
 FOR EACH ROW INSERT INTO df_cupon_pedido_historial SET cupon_pedido_id = NEW.cupon_pedido_id, cta_id = NEW.cta_id, fac_fecha = NEW.fac_fecha, fac_serie = NEW.fac_serie, fac_num = NEW.fac_num, pedido_num = NEW.pedido_num, codigo = NEW.codigo, prov_id = NEW.prov_id, comentario = NEW.comentario, status = NEW.status, rev = NEW.rev, user_id = NEW.user_id, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_cupon_pedido_au`;
DELIMITER //
CREATE TRIGGER `df_cupon_pedido_au` AFTER UPDATE ON `df_cupon_pedido`
 FOR EACH ROW INSERT INTO df_cupon_pedido_historial SET cupon_pedido_id = NEW.cupon_pedido_id, cta_id = NEW.cta_id, fac_fecha = NEW.fac_fecha, fac_serie = NEW.fac_serie, fac_num = NEW.fac_num, pedido_num = NEW.pedido_num, codigo = NEW.codigo, prov_id = NEW.prov_id, comentario = NEW.comentario, status = NEW.status, rev = NEW.rev, user_id = NEW.user_id, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_cupon_pedido_bd`;
DELIMITER //
CREATE TRIGGER `df_cupon_pedido_bd` BEFORE DELETE ON `df_cupon_pedido`
 FOR EACH ROW INSERT INTO df_cupon_pedido_historial SET cupon_pedido_id = OLD.cupon_pedido_id, cta_id = OLD.cta_id, fac_fecha = OLD.fac_fecha, fac_serie = OLD.fac_serie, fac_num = OLD.fac_num, pedido_num = OLD.pedido_num, codigo = OLD.codigo, prov_id = OLD.prov_id, comentario = OLD.comentario, status = OLD.status, rev = OLD.rev, user_id = OLD.user_id, creadoEn = OLD.creadoEn
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_cupon_pedido_historial`
--

CREATE TABLE IF NOT EXISTS `df_cupon_pedido_historial` (
  `cupon_pedido_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cupon_pedido_id` int(10) unsigned DEFAULT NULL,
  `cta_id` int(10) unsigned NOT NULL,
  `fac_fecha` date NOT NULL,
  `fac_serie` varchar(20) NOT NULL,
  `fac_num` varchar(20) NOT NULL,
  `pedido_num` int(10) unsigned NOT NULL,
  `codigo` int(11) NOT NULL,
  `prov_id` int(11) NOT NULL,
  `comentario` mediumtext NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `rev` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`cupon_pedido_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_debito`
--

CREATE TABLE IF NOT EXISTS `df_debito` (
  `dbto_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID del débito',
  `cta_id` int(10) unsigned NOT NULL COMMENT 'ID de la cuenta a la que se débita',
  `dbto_fecha` date NOT NULL COMMENT 'Fecha que se realiza el débito',
  `dbto_monto` decimal(13,5) unsigned NOT NULL COMMENT 'Monto a débitar',
  `dbto_desc` text NOT NULL COMMENT 'Descripción del débito',
  `dbto_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Estado del débito',
  `dbto_rev` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Número de revisión del registro',
  `user_id` int(10) unsigned NOT NULL COMMENT 'ID del usuario que crea/modifica el registro',
  `dbto_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación del registro',
  `dbto_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de modificación del registro',
  PRIMARY KEY (`dbto_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Disparadores `df_debito`
--
DROP TRIGGER IF EXISTS `df_debito_ai`;
DELIMITER //
CREATE TRIGGER `df_debito_ai` AFTER INSERT ON `df_debito`
 FOR EACH ROW INSERT INTO df_debito_historial SET dbto_id = NEW.dbto_id,cta_id = NEW.cta_id,dbto_fecha = NEW.dbto_fecha,dbto_monto = NEW.dbto_monto,dbto_desc = NEW.dbto_desc,dbto_status = NEW.dbto_status,dbto_rev = NEW.dbto_rev,user_id = NEW.user_id,dbto_creadoEn = NEW.dbto_creadoEn, dbto_actualizadoEn = NEW.dbto_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_debito_au`;
DELIMITER //
CREATE TRIGGER `df_debito_au` AFTER UPDATE ON `df_debito`
 FOR EACH ROW INSERT INTO df_debito_historial SET dbto_id = NEW.dbto_id,cta_id = NEW.cta_id,dbto_fecha = NEW.dbto_fecha,dbto_monto = NEW.dbto_monto,dbto_desc = NEW.dbto_desc,dbto_status = NEW.dbto_status,dbto_rev = NEW.dbto_rev,user_id = NEW.user_id,dbto_creadoEn = NEW.dbto_creadoEn, dbto_actualizadoEn = NEW.dbto_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_debito_bd`;
DELIMITER //
CREATE TRIGGER `df_debito_bd` BEFORE DELETE ON `df_debito`
 FOR EACH ROW INSERT INTO df_debito_historial SET dbto_id = OLD.dbto_id,cta_id = OLD.cta_id,dbto_fecha = OLD.dbto_fecha,dbto_monto = OLD.dbto_monto,dbto_desc = OLD.dbto_desc,dbto_status = OLD.dbto_status,dbto_rev = OLD.dbto_rev,user_id = OLD.user_id,dbto_creadoEn = OLD.dbto_creadoEn, dbto_actualizadoEn = OLD.dbto_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_debito_bu`;
DELIMITER //
CREATE TRIGGER `df_debito_bu` BEFORE UPDATE ON `df_debito`
 FOR EACH ROW SET new.dbto_rev = new.dbto_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_debito_historial`
--

CREATE TABLE IF NOT EXISTS `df_debito_historial` (
  `dbto_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dbto_id` int(10) unsigned NOT NULL,
  `cta_id` int(10) unsigned NOT NULL COMMENT 'ID de la cuenta a la que se débita',
  `dbto_fecha` date NOT NULL COMMENT 'Fecha que se realiza el débito',
  `dbto_monto` decimal(13,5) unsigned NOT NULL COMMENT 'Monto a débitar',
  `dbto_desc` text NOT NULL COMMENT 'Descripción del débito',
  `dbto_status` tinyint(3) unsigned NOT NULL COMMENT 'Estado del débito',
  `dbto_rev` int(10) unsigned NOT NULL COMMENT 'Número de revisión del registro',
  `user_id` int(10) unsigned NOT NULL COMMENT 'ID del usuario que crea/modifica el registro',
  `dbto_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de creación del registro',
  `dbto_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de modificación del registro',
  PRIMARY KEY (`dbto_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_proveedor`
--

CREATE TABLE IF NOT EXISTS `df_proveedor` (
  `prov_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prov_nm` varchar(100) NOT NULL,
  `prov_nit` varchar(15) NOT NULL,
  `prov_direccion` varchar(100) NOT NULL,
  `prov_tel` int(8) unsigned NOT NULL,
  `prov_email` varchar(50) NOT NULL,
  `prov_desc` mediumtext NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `prov_status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `prov_rev` int(10) unsigned NOT NULL DEFAULT '1',
  `prov_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `prov_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`prov_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `df_proveedor`
--
DROP TRIGGER IF EXISTS `df_proveedor_ai`;
DELIMITER //
CREATE TRIGGER `df_proveedor_ai` AFTER INSERT ON `df_proveedor`
 FOR EACH ROW INSERT INTO df_proveedor_historial SET prov_id = NEW.prov_id, prov_nm = NEW.prov_nm, prov_nit = NEW.prov_nit, prov_direccion = NEW.prov_direccion, prov_tel = NEW.prov_tel, prov_email = NEW.prov_email, prov_desc = NEW.prov_desc, user_id = NEW.user_id, prov_status = NEW.prov_status, prov_rev = NEW.prov_rev,prov_creadoEn = NEW.prov_creadoEn,prov_actualizadoEn = NEW.prov_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_proveedor_au`;
DELIMITER //
CREATE TRIGGER `df_proveedor_au` AFTER UPDATE ON `df_proveedor`
 FOR EACH ROW INSERT INTO df_proveedor_historial SET prov_id = NEW.prov_id, prov_nm = NEW.prov_nm, prov_nit = NEW.prov_nit, prov_direccion = NEW.prov_direccion, prov_tel = NEW.prov_tel, prov_email = NEW.prov_email, prov_desc = NEW.prov_desc, user_id = NEW.user_id, prov_status = NEW.prov_status, prov_rev = NEW.prov_rev,prov_creadoEn = NEW.prov_creadoEn,prov_actualizadoEn = NEW.prov_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_proveedor_bd`;
DELIMITER //
CREATE TRIGGER `df_proveedor_bd` BEFORE DELETE ON `df_proveedor`
 FOR EACH ROW INSERT INTO df_proveedor_historial SET prov_id = OLD.prov_id, prov_nm = OLD.prov_nm, prov_nit = OLD.prov_nit, prov_direccion = OLD.prov_direccion, prov_tel = OLD.prov_tel, prov_email = OLD.prov_email, prov_desc = OLD.prov_desc, user_id = OLD.user_id, prov_status = OLD.prov_status, prov_rev = OLD.prov_rev,prov_creadoEn = OLD.prov_creadoEn,prov_actualizadoEn = OLD.prov_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_proveedor_bu`;
DELIMITER //
CREATE TRIGGER `df_proveedor_bu` BEFORE UPDATE ON `df_proveedor`
 FOR EACH ROW SET NEW.prov_rev = NEW.prov_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_proveedor_historial`
--

CREATE TABLE IF NOT EXISTS `df_proveedor_historial` (
  `prov_hist_id` int(11) NOT NULL AUTO_INCREMENT,
  `prov_id` int(10) unsigned NOT NULL,
  `prov_nm` varchar(100) NOT NULL,
  `prov_nit` varchar(15) NOT NULL,
  `prov_direccion` varchar(100) NOT NULL,
  `prov_tel` int(8) unsigned NOT NULL,
  `prov_email` varchar(50) NOT NULL,
  `prov_desc` mediumtext NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `prov_status` tinyint(3) unsigned NOT NULL,
  `prov_rev` int(10) unsigned NOT NULL,
  `prov_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `prov_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`prov_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_voucher`
--

CREATE TABLE IF NOT EXISTS `df_voucher` (
  `vchr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID de Voucher',
  `cta_id` int(10) unsigned NOT NULL COMMENT 'ID de la cuenta a la que debita voucher',
  `vchr_fecha` date NOT NULL COMMENT 'Fecha del Voucher',
  `vchr_num` int(11) NOT NULL COMMENT 'Número de Voucher',
  `vchr_monto` decimal(13,5) NOT NULL COMMENT 'Monto del Voucher',
  `vchr_desc` mediumtext NOT NULL COMMENT 'Descripción del Voucher',
  `prov_id` int(10) unsigned NOT NULL COMMENT 'ID del Proveedor',
  `user_id` int(10) unsigned NOT NULL COMMENT 'ID de usuario que crea Voucher',
  `vchr_autoriza` varchar(75) NOT NULL COMMENT 'Persona que autoriza Voucher',
  `vchr_cheque_file` varchar(35) NOT NULL,
  `vchr_voucher_file` varchar(35) NOT NULL,
  `vchr_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Estado del Voucher',
  `vchr_rev` int(10) unsigned NOT NULL DEFAULT '1' COMMENT 'Número de revisión del Voucher',
  `vchr_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación en sistema del Voucher',
  `vchr_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Ultima modificación del Voucher',
  PRIMARY KEY (`vchr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Vouchers de sistema de control de Cheques';

--
-- Disparadores `df_voucher`
--
DROP TRIGGER IF EXISTS `df_voucher_ai`;
DELIMITER //
CREATE TRIGGER `df_voucher_ai` AFTER INSERT ON `df_voucher`
 FOR EACH ROW INSERT INTO df_voucher_historial SET vchr_id = NEW.vchr_id,cta_id = NEW.cta_id,vchr_fecha = NEW.vchr_fecha,vchr_num = NEW.vchr_num,vchr_monto = NEW.vchr_monto,vchr_desc = NEW.vchr_desc,prov_id = NEW.prov_id,user_id = NEW.user_id,vchr_autoriza = NEW.vchr_autoriza,vchr_cheque_file = NEW.vchr_cheque_file,vchr_voucher_file = NEW.vchr_voucher_file,vchr_status = NEW.vchr_status,vchr_rev = NEW.vchr_rev,vchr_creadoEn = NEW.vchr_creadoEn,vchr_actualizadoEn = NEW.vchr_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_voucher_au`;
DELIMITER //
CREATE TRIGGER `df_voucher_au` AFTER UPDATE ON `df_voucher`
 FOR EACH ROW INSERT INTO df_voucher_historial SET vchr_id = NEW.vchr_id,cta_id = NEW.cta_id,vchr_fecha = NEW.vchr_fecha,vchr_num = NEW.vchr_num,vchr_monto = NEW.vchr_monto,vchr_desc = NEW.vchr_desc,prov_id = NEW.prov_id,user_id = NEW.user_id,vchr_autoriza = NEW.vchr_autoriza,vchr_cheque_file = NEW.vchr_cheque_file,vchr_voucher_file = NEW.vchr_voucher_file,vchr_status = NEW.vchr_status,vchr_rev = NEW.vchr_rev,vchr_creadoEn = NEW.vchr_creadoEn,vchr_actualizadoEn = NEW.vchr_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_voucher_bd`;
DELIMITER //
CREATE TRIGGER `df_voucher_bd` BEFORE DELETE ON `df_voucher`
 FOR EACH ROW INSERT INTO df_voucher_historial SET vchr_id = OLD.vchr_id,cta_id = OLD.cta_id,vchr_fecha = OLD.vchr_fecha,vchr_num = OLD.vchr_num,vchr_monto = OLD.vchr_monto,vchr_desc = OLD.vchr_desc,prov_id = OLD.prov_id,user_id = OLD.user_id,vchr_autoriza = OLD.vchr_autoriza,vchr_cheque_file = OLD.vchr_cheque_file,vchr_voucher_file = OLD.vchr_voucher_file,vchr_status = OLD.vchr_status,vchr_rev = OLD.vchr_rev,vchr_creadoEn = OLD.vchr_creadoEn,vchr_actualizadoEn = OLD.vchr_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `df_voucher_bu`;
DELIMITER //
CREATE TRIGGER `df_voucher_bu` BEFORE UPDATE ON `df_voucher`
 FOR EACH ROW SET NEW.vchr_rev = NEW.vchr_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `df_voucher_historial`
--

CREATE TABLE IF NOT EXISTS `df_voucher_historial` (
  `vchr_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vchr_id` int(10) unsigned NOT NULL,
  `cta_id` int(10) unsigned NOT NULL COMMENT 'ID de la cuenta a la que debita voucher',
  `vchr_fecha` date NOT NULL COMMENT 'Fecha del Voucher',
  `vchr_num` int(11) NOT NULL COMMENT 'Número de Voucher',
  `vchr_monto` decimal(13,5) NOT NULL COMMENT 'Monto del Voucher',
  `vchr_desc` mediumtext NOT NULL COMMENT 'Descripción del Voucher',
  `prov_id` int(10) unsigned NOT NULL COMMENT 'ID del Proveedor',
  `user_id` int(10) unsigned NOT NULL COMMENT 'ID de usuario que crea Voucher',
  `vchr_autoriza` varchar(75) NOT NULL COMMENT 'Persona que autoriza Voucher',
  `vchr_cheque_file` varchar(35) NOT NULL,
  `vchr_voucher_file` varchar(35) NOT NULL,
  `vchr_status` tinyint(3) unsigned NOT NULL COMMENT 'Estado del Voucher',
  `vchr_rev` int(10) unsigned NOT NULL COMMENT 'Número de revisión del Voucher',
  `vchr_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de creación en sistema del Voucher',
  `vchr_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Ultima modificación del Voucher',
  PRIMARY KEY (`vchr_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Vouchers de sistema de control de Cheques';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_archivo`
--

CREATE TABLE IF NOT EXISTS `vp_archivo` (
  `arch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `arch_user` int(10) unsigned NOT NULL,
  `depto_id` int(10) unsigned NOT NULL,
  `inst_id` int(10) unsigned NOT NULL,
  `arch_cc` int(10) unsigned NOT NULL,
  `tipo_id` int(10) unsigned NOT NULL,
  `arch_fecha` date NOT NULL,
  `arch_correlativo` varchar(50) NOT NULL,
  `arch_titulo` varchar(150) NOT NULL,
  `arch_original` varchar(150) NOT NULL,
  `arch_firmado` varchar(150) NOT NULL,
  `arch_recibido` varchar(150) NOT NULL,
  `arch_status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `arch_rev` int(11) NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `arch_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arch_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`arch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `vp_archivo`
--
DROP TRIGGER IF EXISTS `vp_archivo_ai`;
DELIMITER //
CREATE TRIGGER `vp_archivo_ai` AFTER INSERT ON `vp_archivo`
 FOR EACH ROW INSERT INTO vp_archivo_historial SET arch_id = NEW.arch_id, arch_user = NeW.arch_user, depto_id = NEW.depto_id, inst_id = NEW.inst_id, arch_cc = NEW.arch_cc, tipo_id = NEW.tipo_id, arch_fecha = NeW.arch_fecha, arch_correlativo = NEW.arch_correlativo, arch_titulo = NEW.arch_titulo, arch_original = NEW.arch_original, arch_firmado = NEW.arch_firmado, arch_recibido = NEW.arch_recibido, arch_status = NEW.arch_status, arch_rev = NEW.arch_rev, user_id = NEW.user_id, arch_creadoEN = NEW.arch_creadoEn, arch_actualizadoEn = NEW.arch_actualizadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_archivo_au`;
DELIMITER //
CREATE TRIGGER `vp_archivo_au` AFTER UPDATE ON `vp_archivo`
 FOR EACH ROW INSERT INTO vp_archivo_historial SET arch_id = NEW.arch_id, arch_user = NeW.arch_user, depto_id = NEW.depto_id, inst_id = NEW.inst_id, arch_cc = NEW.arch_cc, tipo_id = NEW.tipo_id, arch_fecha = NeW.arch_fecha, arch_correlativo = NEW.arch_correlativo, arch_titulo = NEW.arch_titulo, arch_original = NEW.arch_original, arch_firmado = NEW.arch_firmado, arch_recibido = NEW.arch_recibido, arch_status = NEW.arch_status, arch_rev = NEW.arch_rev, user_id = NEW.user_id, arch_creadoEN = NEW.arch_creadoEn, arch_actualizadoEn = NEW.arch_actualizadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_archivo_bd`;
DELIMITER //
CREATE TRIGGER `vp_archivo_bd` BEFORE DELETE ON `vp_archivo`
 FOR EACH ROW INSERT INTO vp_archivo_historial SET arch_id = OLD.arch_id, arch_user = OLD.arch_user, depto_id = OLD.depto_id, inst_id = OLD.inst_id, arch_cc = OLD.arch_cc, tipo_id = OLD.tipo_id, arch_fecha = OLD.arch_fecha, arch_correlativo = OLD.arch_correlativo, arch_titulo = OLD.arch_titulo, arch_original = OLD.arch_original, arch_firmado = OLD.arch_firmado, arch_recibido = OLD.arch_recibido, arch_status = OLD.arch_status, arch_rev = OLD.arch_rev, user_id = OLD.user_id, arch_creadoEN = OLD.arch_creadoEn, arch_actualizadoEn = OLD.arch_actualizadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_archivo_bu`;
DELIMITER //
CREATE TRIGGER `vp_archivo_bu` BEFORE UPDATE ON `vp_archivo`
 FOR EACH ROW SET NEW.arch_rev = NEW.arch_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_archivo_destinatario`
--

CREATE TABLE IF NOT EXISTS `vp_archivo_destinatario` (
  `nombre` varchar(500) NOT NULL,
  `tipo` tinyint(4) NOT NULL,
  `arch_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_archivo_historial`
--

CREATE TABLE IF NOT EXISTS `vp_archivo_historial` (
  `arch_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `arch_id` int(10) unsigned NOT NULL,
  `arch_user` int(10) unsigned NOT NULL,
  `depto_id` int(10) unsigned NOT NULL,
  `inst_id` int(10) unsigned NOT NULL,
  `arch_cc` int(10) unsigned NOT NULL,
  `tipo_id` int(10) unsigned NOT NULL,
  `arch_fecha` date NOT NULL,
  `arch_correlativo` varchar(50) NOT NULL,
  `arch_titulo` varchar(150) NOT NULL,
  `arch_original` varchar(150) NOT NULL,
  `arch_firmado` varchar(150) NOT NULL,
  `arch_recibido` varchar(150) NOT NULL,
  `arch_status` tinyint(3) unsigned NOT NULL,
  `arch_rev` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `arch_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `arch_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`arch_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_archivo_recibido`
--

CREATE TABLE IF NOT EXISTS `vp_archivo_recibido` (
  `arch_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `arch_user` int(10) unsigned NOT NULL,
  `depto_id` int(10) unsigned NOT NULL,
  `inst_id` int(10) unsigned NOT NULL,
  `tipo_id` int(10) unsigned NOT NULL,
  `arch_fecha` date NOT NULL,
  `arch_correlativo` varchar(50) NOT NULL,
  `arch_titulo` varchar(150) NOT NULL,
  `arch_recibido` varchar(150) NOT NULL,
  `arch_status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `arch_rev` int(11) NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `arch_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arch_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`arch_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `vp_archivo_recibido`
--
DROP TRIGGER IF EXISTS `vp_archivo_recibido_ai`;
DELIMITER //
CREATE TRIGGER `vp_archivo_recibido_ai` AFTER INSERT ON `vp_archivo_recibido`
 FOR EACH ROW INSERT INTO vp_archivo_recibido_historial SET arch_id = NEW.arch_id, arch_user = NeW.arch_user, depto_id = NEW.depto_id, inst_id = NEW.inst_id, tipo_id = NEW.tipo_id, arch_fecha = NEW.arch_fecha, arch_correlativo = NEW.arch_correlativo, arch_titulo = NEW.arch_titulo, arch_recibido = NEW.arch_recibido, arch_status = NEW.arch_status, arch_rev = NEW.arch_rev, user_id = NEW.user_id, arch_creadoEN = NEW.arch_creadoEn, arch_actualizadoEn = NEW.arch_actualizadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_archivo_recibido_au`;
DELIMITER //
CREATE TRIGGER `vp_archivo_recibido_au` AFTER UPDATE ON `vp_archivo_recibido`
 FOR EACH ROW INSERT INTO vp_archivo_recibido_historial SET arch_id = NEW.arch_id, arch_user = NeW.arch_user, depto_id = NEW.depto_id, inst_id = NEW.inst_id, tipo_id = NEW.tipo_id, arch_fecha = NEW.arch_fecha, arch_correlativo = NEW.arch_correlativo, arch_titulo = NEW.arch_titulo, arch_recibido = NEW.arch_recibido, arch_status = NEW.arch_status, arch_rev = NEW.arch_rev, user_id = NEW.user_id, arch_creadoEN = NEW.arch_creadoEn, arch_actualizadoEn = NEW.arch_actualizadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_archivo_recibido_bd`;
DELIMITER //
CREATE TRIGGER `vp_archivo_recibido_bd` BEFORE DELETE ON `vp_archivo_recibido`
 FOR EACH ROW INSERT INTO vp_archivo_recibido_historial SET arch_id = OLD.arch_id, arch_user = OLD.arch_user, depto_id = OLD.depto_id, inst_id = OLD.inst_id, tipo_id = OLD.tipo_id, arch_fecha = OLD.arch_fecha, arch_correlativo = OLD.arch_correlativo, arch_titulo = OLD.arch_titulo, arch_recibido = OLD.arch_recibido, arch_status = OLD.arch_status, arch_rev = OLD.arch_rev, user_id = OLD.user_id, arch_creadoEN = OLD.arch_creadoEn, arch_actualizadoEn = OLD.arch_actualizadoEN
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_archivo_recibido_bu`;
DELIMITER //
CREATE TRIGGER `vp_archivo_recibido_bu` BEFORE UPDATE ON `vp_archivo_recibido`
 FOR EACH ROW SET NEW.arch_rev = NEW.arch_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_archivo_recibido_historial`
--

CREATE TABLE IF NOT EXISTS `vp_archivo_recibido_historial` (
  `arch_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `arch_id` int(10) unsigned NOT NULL,
  `arch_user` int(10) unsigned NOT NULL,
  `depto_id` int(10) unsigned NOT NULL,
  `inst_id` int(10) unsigned NOT NULL,
  `tipo_id` int(10) unsigned NOT NULL,
  `arch_fecha` date NOT NULL,
  `arch_correlativo` varchar(50) NOT NULL,
  `arch_titulo` varchar(150) NOT NULL,
  `arch_recibido` varchar(150) NOT NULL,
  `arch_status` tinyint(3) unsigned NOT NULL,
  `arch_rev` int(11) NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `arch_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `arch_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`arch_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_archivo_remitente`
--

CREATE TABLE IF NOT EXISTS `vp_archivo_remitente` (
  `nombre` varchar(500) NOT NULL,
  `arch_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_catalogo_insumos`
--

CREATE TABLE IF NOT EXISTS `vp_catalogo_insumos` (
  `prod_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID interno',
  `renglon_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'MINFIN - Renglón Número',
  `renglon_codigo` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Renglón incremental',
  `codigo` int(10) unsigned NOT NULL COMMENT 'MINFIN - Código de producto',
  `nombre` varchar(512) NOT NULL COMMENT 'MINFIN - Nombre de producto',
  `caracteristicas` varchar(4000) NOT NULL COMMENT 'MINFIN -Descripción de producto',
  `minimo` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Cantidad mínima de existencia',
  `maximo` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Cantidad máxima de existencia',
  `nombre_presentacion` varchar(255) NOT NULL COMMENT 'MINFIN - Nombre de la presentación ',
  `cantidad_unidad` varchar(255) NOT NULL COMMENT 'MINFIN - Cantidad y unidad de medida de la presentación',
  `codigo_presentacion` int(10) unsigned NOT NULL COMMENT 'MINFIN - Código de presentación',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Estado de insumo',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Usuario en sistema',
  `revision` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT 'Numero de modificación',
  `creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de creación en sistema',
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Fecha de actualización de registro',
  PRIMARY KEY (`prod_id`),
  UNIQUE KEY `producto_presentacion_uq` (`codigo`,`codigo_presentacion`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de insumos MINFIN';

--
-- Disparadores `vp_catalogo_insumos`
--
DROP TRIGGER IF EXISTS `vp_catalogo_insumos_ai`;
DELIMITER //
CREATE TRIGGER `vp_catalogo_insumos_ai` AFTER INSERT ON `vp_catalogo_insumos`
 FOR EACH ROW INSERT INTO vp_catalogo_insumos_historial SET prod_id = NEW.prod_id, renglon_id = NEW.renglon_id, renglon_codigo = NEW.renglon_codigo, codigo = NEW.codigo, nombre = NEW.nombre, caracteristicas = NEW.caracteristicas,
minimo = NEW.minimo, maximo = NEW.maximo, nombre_presentacion = NEW.nombre_presentacion, cantidad_unidad = NEW.cantidad_unidad, codigo_presentacion = NEW.codigo_presentacion, status = NEW.status,
user_id = NEW.user_id, revision = NEW.revision, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_catalogo_insumos_au`;
DELIMITER //
CREATE TRIGGER `vp_catalogo_insumos_au` AFTER UPDATE ON `vp_catalogo_insumos`
 FOR EACH ROW INSERT INTO vp_catalogo_insumos_historial SET prod_id = NEW.prod_id, renglon_id = NEW.renglon_id, renglon_codigo = NEW.renglon_codigo, codigo = NEW.codigo, nombre = NEW.nombre, caracteristicas = NEW.caracteristicas,
minimo = NEW.minimo, maximo = NEW.maximo, nombre_presentacion = NEW.nombre_presentacion, cantidad_unidad = NEW.cantidad_unidad, codigo_presentacion = NEW.codigo_presentacion, status = NEW.status,
user_id = NEW.user_id, revision = NEW.revision, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_catalogo_insumos_bd`;
DELIMITER //
CREATE TRIGGER `vp_catalogo_insumos_bd` BEFORE DELETE ON `vp_catalogo_insumos`
 FOR EACH ROW INSERT INTO vp_catalogo_insumos_historial SET prod_id = OLD.prod_id, renglon_id = OLD.renglon_id, renglon_codigo = OLD.renglon_codigo, codigo = OLD.codigo, nombre = OLD.nombre, caracteristicas = OLD.caracteristicas,
minimo = OLD.minimo, maximo = OLD.maximo, nombre_presentacion = OLD.nombre_presentacion, cantidad_unidad = OLD.cantidad_unidad, codigo_presentacion = OLD.codigo_presentacion, status = OLD.status,
user_id = OLD.user_id, revision = OLD.revision, creadoEn = OLD.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_catalogo_insumos_bu`;
DELIMITER //
CREATE TRIGGER `vp_catalogo_insumos_bu` BEFORE UPDATE ON `vp_catalogo_insumos`
 FOR EACH ROW SET NEW.revision = NEW.revision + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_catalogo_insumos_historial`
--

CREATE TABLE IF NOT EXISTS `vp_catalogo_insumos_historial` (
  `prod_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID interno de historial',
  `prod_id` int(10) unsigned DEFAULT NULL COMMENT 'ID interno de producto',
  `renglon_id` int(10) unsigned NOT NULL COMMENT 'MINFIN - Renglón Número',
  `renglon_codigo` int(10) unsigned NOT NULL COMMENT 'Renglón incremental',
  `codigo` int(10) unsigned NOT NULL COMMENT 'MINFIN - Código de producto',
  `nombre` varchar(512) NOT NULL COMMENT 'MINFIN - Nombre de producto',
  `caracteristicas` varchar(4000) NOT NULL COMMENT 'MINFIN -Descripción de producto',
  `minimo` int(10) unsigned NOT NULL COMMENT 'Cantidad mínima de existencia',
  `maximo` int(10) unsigned NOT NULL COMMENT 'Cantidad máxima de existencia',
  `nombre_presentacion` varchar(255) NOT NULL COMMENT 'MINFIN - Nombre de la presentación ',
  `cantidad_unidad` varchar(255) NOT NULL COMMENT 'MINFIN - Cantidad y unidad de medida de la presentación',
  `codigo_presentacion` int(10) unsigned NOT NULL COMMENT 'MINFIN - Código de presentación',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Estado de insumo',
  `user_id` int(10) unsigned NOT NULL COMMENT 'Usuario en sistema',
  `revision` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Numero de modificación',
  `creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Fecha de creación en sistema',
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Fecha de actualización de registro',
  PRIMARY KEY (`prod_hist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Catálogo de insumos vitacora MINFIN';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_combustible_tipo`
--

CREATE TABLE IF NOT EXISTS `vp_combustible_tipo` (
  `combustible_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL,
  `status` tinyint(3) NOT NULL DEFAULT '1',
  `rev` int(11) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`combustible_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `vp_combustible_tipo`
--
DROP TRIGGER IF EXISTS `vp_combustible_tipo_ai`;
DELIMITER //
CREATE TRIGGER `vp_combustible_tipo_ai` AFTER INSERT ON `vp_combustible_tipo`
 FOR EACH ROW INSERT INTO vp_combustible_tipo_historial SET combustible_id = NEW.combustible_id, nombre = NEW.nombre, status = NEW.status, rev = NEW.rev, user_id = NEW.user_id, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_combustible_tipo_au`;
DELIMITER //
CREATE TRIGGER `vp_combustible_tipo_au` AFTER UPDATE ON `vp_combustible_tipo`
 FOR EACH ROW INSERT INTO vp_combustible_tipo_historial SET combustible_id = NEW.combustible_id, nombre = NEW.nombre, status = NEW.status, rev = NEW.rev, user_id = NEW.user_id, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_combustible_tipo_bd`;
DELIMITER //
CREATE TRIGGER `vp_combustible_tipo_bd` BEFORE DELETE ON `vp_combustible_tipo`
 FOR EACH ROW INSERT INTO vp_combustible_tipo_historial SET combustible_id = OLD.combustible_id, nombre = OLD.nombre, status = OLD.status, rev = OLD.rev, user_id = OLD.user_id, creadoEn = OLD.creadoEn
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_combustible_tipo_historial`
--

CREATE TABLE IF NOT EXISTS `vp_combustible_tipo_historial` (
  `combustible_hist_id` int(11) NOT NULL AUTO_INCREMENT,
  `combustible_id` int(10) unsigned DEFAULT NULL,
  `nombre` varchar(25) NOT NULL,
  `status` tinyint(3) NOT NULL,
  `rev` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`combustible_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_conductor`
--

CREATE TABLE IF NOT EXISTS `vp_conductor` (
  `conductor_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `licencia_num` bigint(20) unsigned NOT NULL,
  `licencia_cad` date NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `rev` int(10) unsigned NOT NULL DEFAULT '1',
  `user_mod` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`conductor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `vp_conductor`
--
DROP TRIGGER IF EXISTS `vp_conductor_ai`;
DELIMITER //
CREATE TRIGGER `vp_conductor_ai` AFTER INSERT ON `vp_conductor`
 FOR EACH ROW INSERT INTO vp_conductor_historial SET conductor_id = NEW.conductor_id, user_id = NEW.user_id, licencia_num = NEW.licencia_num, licencia_cad = NEW.licencia_cad, status = NEW.status, rev = NEW.rev, user_mod = NEW.user_mod, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_conductor_au`;
DELIMITER //
CREATE TRIGGER `vp_conductor_au` AFTER UPDATE ON `vp_conductor`
 FOR EACH ROW INSERT INTO vp_conductor_historial SET conductor_id = NEW.conductor_id, user_id = NEW.user_id, licencia_num = NEW.licencia_num, licencia_cad = NEW.licencia_cad, status = NEW.status, rev = NEW.rev, user_mod = NEW.user_mod, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_conductor_bd`;
DELIMITER //
CREATE TRIGGER `vp_conductor_bd` BEFORE DELETE ON `vp_conductor`
 FOR EACH ROW INSERT INTO vp_conductor_historial SET conductor_id = OLD.conductor_id, user_id = OLD.user_id, licencia_num = OLD.licencia_num, licencia_cad = OLD.licencia_cad, status = OLD.status, rev = OLD.rev, user_mod = OLD.user_mod, creadoEn = OLD.creadoEn
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_conductor_historial`
--

CREATE TABLE IF NOT EXISTS `vp_conductor_historial` (
  `conductor_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `conductor_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `licencia_num` bigint(20) NOT NULL,
  `licencia_cad` date NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `rev` int(10) unsigned NOT NULL,
  `user_mod` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`conductor_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_deptos`
--

CREATE TABLE IF NOT EXISTS `vp_deptos` (
  `dep_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dep_nm` varchar(50) NOT NULL,
  `ofi_id` int(10) NOT NULL,
  `dep_encargado` tinyint(3) unsigned NOT NULL,
  `dep_status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `dep_rev` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` tinyint(3) unsigned NOT NULL,
  `dep_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dep_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dep_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_deptos_historial`
--

CREATE TABLE IF NOT EXISTS `vp_deptos_historial` (
  `dep_hist_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `dep_id` int(10) unsigned NOT NULL,
  `dep_nm` varchar(50) NOT NULL,
  `ofi_id` int(10) NOT NULL,
  `dep_encargado` tinyint(3) unsigned NOT NULL,
  `dep_status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `dep_rev` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` tinyint(3) unsigned NOT NULL,
  `dep_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dep_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dep_hist_id`),
  KEY `dep_id` (`dep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_institucion`
--

CREATE TABLE IF NOT EXISTS `vp_institucion` (
  `inst_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inst_codigo` int(10) unsigned NOT NULL,
  `inst_entidad` int(10) unsigned NOT NULL,
  `inst_nombre` varchar(200) NOT NULL,
  `inst_abrev` varchar(50) NOT NULL,
  `inst_padre` int(3) unsigned NOT NULL,
  `inst_direccion` varchar(150) NOT NULL,
  `inst_tel` int(8) unsigned NOT NULL,
  `inst_web` varchar(75) NOT NULL,
  `inst_tipo` tinyint(3) unsigned NOT NULL,
  `inst_status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `inst_rev` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `inst_creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `inst_actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`inst_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `vp_institucion`
--
DROP TRIGGER IF EXISTS `vp_institucion_ai`;
DELIMITER //
CREATE TRIGGER `vp_institucion_ai` AFTER INSERT ON `vp_institucion`
 FOR EACH ROW INSERT INTO vp_institucion_historial SET inst_id = NEW.inst_id, inst_codigo = NEW.inst_codigo, inst_entidad = NEW.inst_entidad, inst_nombre = NEW.inst_nombre, inst_abrev = NEW.inst_abrev, inst_padre = NEW.inst_padre, inst_direccion = NEW.inst_direccion, inst_tel = NEW.inst_tel, inst_web = NEW.inst_web, inst_tipo = NEW.inst_tipo, inst_status = NEW.inst_status, inst_rev = NEW.inst_rev, user_id = NEW.user_id, inst_creadoEn = NEW.inst_creadoEn, inst_actualizadoEn = NEW.inst_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_institucion_au`;
DELIMITER //
CREATE TRIGGER `vp_institucion_au` AFTER UPDATE ON `vp_institucion`
 FOR EACH ROW INSERT INTO vp_institucion_historial SET inst_id = NEW.inst_id, inst_codigo = NEW.inst_codigo, inst_entidad = NEW.inst_entidad, inst_nombre = NEW.inst_nombre, inst_abrev = NEW.inst_abrev, inst_padre = NEW.inst_padre, inst_direccion = NEW.inst_direccion, inst_tel = NEW.inst_tel, inst_web = NEW.inst_web, inst_tipo = NEW.inst_tipo, inst_status = NEW.inst_status, inst_rev = NEW.inst_rev, user_id = NEW.user_id, inst_creadoEn = NEW.inst_creadoEn, inst_actualizadoEn = NEW.inst_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_institucion_bd`;
DELIMITER //
CREATE TRIGGER `vp_institucion_bd` BEFORE DELETE ON `vp_institucion`
 FOR EACH ROW INSERT INTO vp_institucion_historial SET inst_id = OLD.inst_id, inst_codigo = OLD.inst_codigo, inst_entidad = OLD.inst_entidad, inst_nombre = OLD.inst_nombre, inst_abrev = OLD.inst_abrev, inst_padre = OLD.inst_padre, inst_direccion = OLD.inst_direccion, inst_tel = OLD.inst_tel, inst_web = OLD.inst_web, inst_tipo = OLD.inst_tipo, inst_status = OLD.inst_status, inst_rev = OLD.inst_rev, user_id = OLD.user_id, inst_creadoEn = OLD.inst_creadoEn, inst_actualizadoEn = OLD.inst_actualizadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_institucion_bu`;
DELIMITER //
CREATE TRIGGER `vp_institucion_bu` BEFORE UPDATE ON `vp_institucion`
 FOR EACH ROW SET NEW.inst_rev = NEW.inst_rev + 1
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_institucion_historial`
--

CREATE TABLE IF NOT EXISTS `vp_institucion_historial` (
  `inst_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `inst_id` int(10) unsigned NOT NULL,
  `inst_codigo` int(10) unsigned NOT NULL,
  `inst_entidad` int(10) unsigned NOT NULL,
  `inst_nombre` varchar(200) NOT NULL,
  `inst_abrev` varchar(50) NOT NULL,
  `inst_padre` int(10) unsigned NOT NULL,
  `inst_direccion` varchar(150) NOT NULL,
  `inst_tel` int(8) unsigned NOT NULL,
  `inst_web` varchar(75) NOT NULL,
  `inst_tipo` tinyint(3) unsigned NOT NULL,
  `inst_status` tinyint(3) unsigned NOT NULL,
  `inst_rev` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `inst_creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `inst_actualizadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`inst_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_login`
--

CREATE TABLE IF NOT EXISTS `vp_login` (
  `login_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `login_computer` varchar(50) NOT NULL,
  `login_ip` varchar(15) NOT NULL,
  `login_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_loginhistorial`
--

CREATE TABLE IF NOT EXISTS `vp_loginhistorial` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `login_fecha` int(11) NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_permisos`
--

CREATE TABLE IF NOT EXISTS `vp_permisos` (
  `perm_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `perm_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`perm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_roles`
--

CREATE TABLE IF NOT EXISTS `vp_roles` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_nm` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_role_perm`
--

CREATE TABLE IF NOT EXISTS `vp_role_perm` (
  `role_id` int(10) unsigned NOT NULL,
  `perm_id` int(10) unsigned NOT NULL,
  KEY `role_id` (`role_id`),
  KEY `perm_id` (`perm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_user`
--

CREATE TABLE IF NOT EXISTS `vp_user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_vid` int(4) unsigned NOT NULL,
  `user_pref` varchar(10) NOT NULL,
  `user_nm` varchar(50) NOT NULL,
  `user_pass` char(128) NOT NULL,
  `user_salt` char(128) NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `user_mail` varchar(60) NOT NULL,
  `ext_id` int(10) unsigned NOT NULL,
  `user_nm1` varchar(30) NOT NULL,
  `user_nm2` varchar(30) NOT NULL,
  `user_ap1` varchar(30) NOT NULL,
  `user_ap2` varchar(30) NOT NULL,
  `dep_id` int(10) unsigned NOT NULL,
  `user_puesto` varchar(50) NOT NULL,
  `user_nom` varchar(50) NOT NULL,
  `user_mod` int(10) unsigned NOT NULL,
  `user_rev` int(10) unsigned NOT NULL,
  `user_status` tinyint(1) unsigned NOT NULL,
  `user_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `vp_user`
--
DROP TRIGGER IF EXISTS `vp_user_ai`;
DELIMITER //
CREATE TRIGGER `vp_user_ai` AFTER INSERT ON `vp_user`
 FOR EACH ROW INSERT INTO vp_user_historial SET user_id = NEW.user_id, user_vid = NEW.user_vid, user_pref = NEW.user_pref, user_nm = NEW.user_nm, user_pass = NEW.user_pass, user_salt = NEW.user_salt, role_id = NEW.role_id, user_mail = NEW.user_mail, ext_id = NEW.ext_id, user_nm1 = NEW.user_nm1, user_nm2 = NEW.user_nm2, user_ap1 = NEW.user_ap1, user_ap2 = NEW.user_ap2, dep_id = NEW.dep_id, user_puesto = NEW.user_puesto, user_nom = NEW.user_nom, user_mod = NEW.user_mod, user_rev = NEW.user_rev, user_status = NEW.user_status
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_user_au`;
DELIMITER //
CREATE TRIGGER `vp_user_au` AFTER UPDATE ON `vp_user`
 FOR EACH ROW INSERT INTO vp_user_historial SET user_id = NEW.user_id, user_vid = NEW.user_vid, user_pref = NEW.user_pref, user_nm = NEW.user_nm, user_pass = NEW.user_pass, user_salt = NEW.user_salt, role_id = NEW.role_id, user_mail = NEW.user_mail, ext_id = NEW.ext_id, user_nm1 = NEW.user_nm1, user_nm2 = NEW.user_nm2, user_ap1 = NEW.user_ap1, user_ap2 = NEW.user_ap2, dep_id = NEW.dep_id, user_puesto = NEW.user_puesto, user_nom = NEW.user_nom, user_mod = NEW.user_mod, user_rev = NEW.user_rev, user_status = NEW.user_status
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_user_bd`;
DELIMITER //
CREATE TRIGGER `vp_user_bd` BEFORE DELETE ON `vp_user`
 FOR EACH ROW INSERT INTO vp_user_historial SET user_id = OLD.user_id, user_vid = OLD.user_vid, user_pref = OLD.user_pref, user_nm = OLD.user_nm, user_pass = OLD.user_pass, user_salt = OLD.user_salt, role_id = OLD.role_id, user_mail = OLD.user_mail, ext_id = OLD.ext_id, user_nm1 = OLD.user_nm1, user_nm2 = OLD.user_nm2, user_ap1 = OLD.user_ap1, user_ap2 = OLD.user_ap2, dep_id = OLD.dep_id, user_puesto = OLD.user_puesto, user_nom = OLD.user_nom, user_mod = OLD.user_mod, user_rev = OLD.user_rev, user_status = OLD.user_status
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_user_historial`
--

CREATE TABLE IF NOT EXISTS `vp_user_historial` (
  `user_hist_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user_vid` int(4) unsigned NOT NULL,
  `user_pref` varchar(10) NOT NULL,
  `user_nm` varchar(50) NOT NULL,
  `user_pass` char(128) NOT NULL,
  `user_salt` char(128) NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `user_mail` varchar(60) NOT NULL,
  `ext_id` int(10) unsigned NOT NULL,
  `user_nm1` varchar(30) NOT NULL,
  `user_nm2` varchar(30) NOT NULL,
  `user_ap1` varchar(30) NOT NULL,
  `user_ap2` varchar(30) NOT NULL,
  `dep_id` int(10) unsigned NOT NULL,
  `user_puesto` varchar(50) NOT NULL,
  `user_nom` varchar(50) NOT NULL,
  `user_mod` int(10) unsigned NOT NULL,
  `user_rev` int(10) unsigned NOT NULL,
  `user_status` tinyint(1) unsigned NOT NULL,
  `user_fechahora` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_vehiculo`
--

CREATE TABLE IF NOT EXISTS `vp_vehiculo` (
  `vehiculo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) NOT NULL,
  `linea` varchar(40) NOT NULL,
  `placa` varchar(15) NOT NULL,
  `modelo` year(4) NOT NULL,
  `cilindraje` tinyint(3) unsigned NOT NULL,
  `combustible_id` int(10) unsigned NOT NULL,
  `color` varchar(25) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `rev` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`vehiculo_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Disparadores `vp_vehiculo`
--
DROP TRIGGER IF EXISTS `vp_vehiculo_ai`;
DELIMITER //
CREATE TRIGGER `vp_vehiculo_ai` AFTER INSERT ON `vp_vehiculo`
 FOR EACH ROW INSERT INTO vp_vehiculo_historial SET vehiculo_id = NEW.vehiculo_id, nombre = NEW.nombre, linea = NEW.linea, placa = NEW.placa, modelo = NEW.modelo, cilindraje = NEW.cilindraje, combustible_id = NEW.combustible_id, color = NEW.color, status = NEW.status, rev = NEW.rev, user_id = NEW.user_id, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_vehiculo_au`;
DELIMITER //
CREATE TRIGGER `vp_vehiculo_au` AFTER UPDATE ON `vp_vehiculo`
 FOR EACH ROW INSERT INTO vp_vehiculo_historial SET vehiculo_id = NEW.vehiculo_id, nombre = NEW.nombre, linea = NEW.linea, placa = NEW.placa, modelo = NEW.modelo, cilindraje = NEW.cilindraje, combustible_id = NEW.combustible_id, color = NEW.color, status = NEW.status, rev = NEW.rev, user_id = NEW.user_id, creadoEn = NEW.creadoEn
//
DELIMITER ;
DROP TRIGGER IF EXISTS `vp_vehiculo_bd`;
DELIMITER //
CREATE TRIGGER `vp_vehiculo_bd` BEFORE DELETE ON `vp_vehiculo`
 FOR EACH ROW INSERT INTO vp_vehiculo_historial SET vehiculo_id = OLD.vehiculo_id, nombre = OLD.nombre, linea = OLD.linea, placa = OLD.placa, modelo = OLD.modelo, cilindraje = OLD.cilindraje, combustible_id = OLD.combustible_id, color = OLD.color, status = OLD.status, rev = OLD.rev, user_id = OLD.user_id, creadoEn = OLD.creadoEn
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `vp_vehiculo_historial`
--

CREATE TABLE IF NOT EXISTS `vp_vehiculo_historial` (
  `vehiculo_hist_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehiculo_id` int(10) unsigned DEFAULT NULL,
  `nombre` varchar(40) NOT NULL,
  `linea` varchar(40) NOT NULL,
  `placa` varchar(15) NOT NULL,
  `modelo` year(4) NOT NULL,
  `cilindraje` tinyint(3) unsigned NOT NULL,
  `combustible_id` int(10) unsigned NOT NULL,
  `color` varchar(25) NOT NULL,
  `status` tinyint(3) unsigned NOT NULL,
  `rev` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `creadoEn` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `actualizadoEn` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`vehiculo_hist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `vp_role_perm`
--
ALTER TABLE `vp_role_perm`
  ADD CONSTRAINT `vp_role_perm_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `vp_roles` (`role_id`),
  ADD CONSTRAINT `vp_role_perm_ibfk_2` FOREIGN KEY (`perm_id`) REFERENCES `vp_permisos` (`perm_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
