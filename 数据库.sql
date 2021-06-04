-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        8.0.22 - MySQL Community Server - GPL
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  11.1.0.6116
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- 导出 school 的数据库结构
CREATE DATABASE IF NOT EXISTS `school` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `school`;

-- 导出  表 school.admininfo 结构
CREATE TABLE IF NOT EXISTS `admininfo` (
  `aName` varchar(50) DEFAULT NULL,
  `aOpenid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `aIs` varchar(50) DEFAULT 'true',
  `aId` int NOT NULL AUTO_INCREMENT,
  `aPhone` varchar(50) DEFAULT NULL,
  KEY `aId` (`aId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在导出表  school.admininfo 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `admininfo` DISABLE KEYS */;
REPLACE INTO `admininfo` (`aName`, `aOpenid`, `aIs`, `aId`, `aPhone`) VALUES
	('沈宇锴', 'o25NJ40dOqIUttSOuwaAgkXQEyzU', 'true', 1, '13396979721'),
	('1', '11111', 'false', 3, '13385450639');
/*!40000 ALTER TABLE `admininfo` ENABLE KEYS */;

-- 导出  表 school.class 结构
CREATE TABLE IF NOT EXISTS `class` (
  `cName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cGrade` int DEFAULT NULL,
  `cNumber` int DEFAULT NULL,
  `cId` int NOT NULL AUTO_INCREMENT,
  `cIs` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'true',
  `cYear` year DEFAULT NULL,
  KEY `ClassId` (`cId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2080 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在导出表  school.class 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
REPLACE INTO `class` (`cName`, `cGrade`, `cNumber`, `cId`, `cIs`, `cYear`) VALUES
	('一年一班', 1, 1, 2079, 'true', '2021');
/*!40000 ALTER TABLE `class` ENABLE KEYS */;

-- 导出  表 school.einfo 结构
CREATE TABLE IF NOT EXISTS `einfo` (
  `eId` int NOT NULL AUTO_INCREMENT,
  `eSub` varchar(50) DEFAULT NULL,
  `ecId` int DEFAULT NULL,
  `etOpenid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `eType` varchar(50) DEFAULT NULL,
  `eIs` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'true',
  `eDate` varchar(50) DEFAULT NULL,
  `eYear` varchar(50) DEFAULT NULL,
  `eTerm` varchar(50) DEFAULT NULL,
  `eText` varchar(500) DEFAULT NULL,
  `eOk` varchar(50) DEFAULT 'false',
  `eAver` int DEFAULT '0',
  KEY `eId` (`eId`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='exame';

-- 正在导出表  school.einfo 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `einfo` DISABLE KEYS */;
REPLACE INTO `einfo` (`eId`, `eSub`, `ecId`, `etOpenid`, `eType`, `eIs`, `eDate`, `eYear`, `eTerm`, `eText`, `eOk`, `eAver`) VALUES
	(18, '数学', 2079, 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '月考', 'true', '2021-04-15', '2021', '上学期', '第一个考试', 'true', 80),
	(19, '数学', 2079, 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '月考', 'true', '2021-04-16', '2021', '上学期', '第二个考试', 'true', 60),
	(20, '数学', 2079, 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '月考', 'true', '2021-04-21', '2021', '上学期', '第三个考试', 'false', 0);
/*!40000 ALTER TABLE `einfo` ENABLE KEYS */;

-- 导出  表 school.ginfo 结构
CREATE TABLE IF NOT EXISTS `ginfo` (
  `gId` int NOT NULL AUTO_INCREMENT,
  `gsId` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `geId` int DEFAULT NULL,
  `gGrade` int DEFAULT NULL,
  `gIs` varchar(50) DEFAULT 'true',
  KEY `gId` (`gId`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='student''s grade';

-- 正在导出表  school.ginfo 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `ginfo` DISABLE KEYS */;
REPLACE INTO `ginfo` (`gId`, `gsId`, `geId`, `gGrade`, `gIs`) VALUES
	(37, '2111790001', 18, 90, 'true'),
	(38, '2111790002', 18, 70, 'true'),
	(39, '2111790001', 19, 70, 'true'),
	(40, '2111790002', 19, 50, 'true');
/*!40000 ALTER TABLE `ginfo` ENABLE KEYS */;

-- 导出  表 school.hinfo 结构
CREATE TABLE IF NOT EXISTS `hinfo` (
  `hName` varchar(50) DEFAULT NULL,
  `hSub` varchar(50) DEFAULT NULL,
  `hId` int NOT NULL AUTO_INCREMENT,
  `hNum` int DEFAULT '0',
  `hText` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `tOpenid` varchar(50) DEFAULT NULL,
  `hDeadline` varchar(50) DEFAULT NULL,
  `hIs` varchar(50) DEFAULT 'true',
  `cId` int DEFAULT NULL,
  `hOk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'false',
  `hTime` varchar(50) DEFAULT NULL,
  `hLook` int DEFAULT '0',
  KEY `hId` (`hId`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在导出表  school.hinfo 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `hinfo` DISABLE KEYS */;
REPLACE INTO `hinfo` (`hName`, `hSub`, `hId`, `hNum`, `hText`, `tOpenid`, `hDeadline`, `hIs`, `cId`, `hOk`, `hTime`, `hLook`) VALUES
	('第一份作业', '数学', 16, 1, '第一份作业', 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '2021-04-27', 'false', 2079, 'false', '2021-04-25', 1),
	('1', '数学', 17, 1, '111', 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '2021-05-26', 'true', 2079, 'false', '2021-05-04', 0);
/*!40000 ALTER TABLE `hinfo` ENABLE KEYS */;

-- 导出  表 school.hpinfo 结构
CREATE TABLE IF NOT EXISTS `hpinfo` (
  `hpId` int NOT NULL AUTO_INCREMENT,
  `hphId` int DEFAULT '0',
  `hppOpenid` varchar(50) DEFAULT NULL,
  `hpText` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `hpIs` varchar(50) DEFAULT 'false',
  KEY `hpId` (`hpId`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='homework parent';

-- 正在导出表  school.hpinfo 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `hpinfo` DISABLE KEYS */;
REPLACE INTO `hpinfo` (`hpId`, `hphId`, `hppOpenid`, `hpText`, `hpIs`) VALUES
	(4, 16, 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '完成了', 'true'),
	(5, 17, 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '可以说些什么', 'false');
/*!40000 ALTER TABLE `hpinfo` ENABLE KEYS */;

-- 导出  表 school.ninfo 结构
CREATE TABLE IF NOT EXISTS `ninfo` (
  `nName` varchar(50) DEFAULT NULL,
  `nId` int NOT NULL AUTO_INCREMENT,
  `cId` int DEFAULT NULL,
  `nText` varchar(500) DEFAULT NULL,
  `nNum` int DEFAULT '0',
  `nIs` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'true',
  `tOpenid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `nTime` varchar(50) DEFAULT NULL,
  `nSub` varchar(50) DEFAULT NULL,
  KEY `nId` (`nId`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='notic';

-- 正在导出表  school.ninfo 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `ninfo` DISABLE KEYS */;
REPLACE INTO `ninfo` (`nName`, `nId`, `cId`, `nText`, `nNum`, `nIs`, `tOpenid`, `nTime`, `nSub`) VALUES
	('这是个公告', 27, 2079, '一个公告', 1, 'false', 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '2021-04-25 19:33:03', '数学'),
	('111', 28, 2079, '1111', 0, 'false', 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '2021-05-04 14:05:35', '数学');
/*!40000 ALTER TABLE `ninfo` ENABLE KEYS */;

-- 导出  表 school.npinfo 结构
CREATE TABLE IF NOT EXISTS `npinfo` (
  `pOpenid` varchar(50) DEFAULT NULL,
  `npId` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='notice and parent';

-- 正在导出表  school.npinfo 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `npinfo` DISABLE KEYS */;
REPLACE INTO `npinfo` (`pOpenid`, `npId`) VALUES
	('o25NJ40dOqIUttSOuwaAgkXQEyzU', '27'),
	('o25NJ40dOqIUttSOuwaAgkXQEyzU', '');
/*!40000 ALTER TABLE `npinfo` ENABLE KEYS */;

-- 导出  表 school.parentinfo 结构
CREATE TABLE IF NOT EXISTS `parentinfo` (
  `pName` varchar(50) DEFAULT NULL,
  `pPic` varchar(500) DEFAULT NULL,
  `pRole` varchar(50) DEFAULT NULL,
  `pOpenid` varchar(50) DEFAULT NULL,
  `pRealname` varchar(50) DEFAULT NULL,
  `pPhone` varchar(50) DEFAULT NULL,
  `pIs` varchar(50) NOT NULL DEFAULT 'true',
  `pSex` varchar(50) DEFAULT NULL,
  KEY `pOpenid` (`pOpenid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在导出表  school.parentinfo 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `parentinfo` DISABLE KEYS */;
REPLACE INTO `parentinfo` (`pName`, `pPic`, `pRole`, `pOpenid`, `pRealname`, `pPhone`, `pIs`, `pSex`) VALUES
	('七ͭ月ͬ七ͯ日ͥ晴ͤ', 'https://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIt4qSHP6ltTrBWesEsyLa4xgTtNBuyplGK2ofvRhYMss2SGGqMZS63FkgOo3Zuc06nsTRhLFsgFg/132', '家长', 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '沈宇锴', '13396979721', 'true', '男');
/*!40000 ALTER TABLE `parentinfo` ENABLE KEYS */;

-- 导出  表 school.studentinfo 结构
CREATE TABLE IF NOT EXISTS `studentinfo` (
  `sId` varchar(50) DEFAULT NULL,
  `sName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cId` int DEFAULT NULL,
  `sPname` varchar(50) DEFAULT NULL,
  `pOpenid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `sSex` varchar(4) DEFAULT NULL,
  `sIs` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'true',
  KEY `StuId` (`sId`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在导出表  school.studentinfo 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `studentinfo` DISABLE KEYS */;
REPLACE INTO `studentinfo` (`sId`, `sName`, `cId`, `sPname`, `pOpenid`, `sSex`, `sIs`) VALUES
	('2111790001', '一号', 2079, '沈宇锴', 'o25NJ40dOqIUttSOuwaAgkXQEyzU', '男', 'true'),
	('2111790002', '二号', 2079, NULL, NULL, '女', 'true');
/*!40000 ALTER TABLE `studentinfo` ENABLE KEYS */;

-- 导出  表 school.tcinfo 结构
CREATE TABLE IF NOT EXISTS `tcinfo` (
  `tcOpenid` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `cId` varchar(50) DEFAULT NULL,
  `tcId` int NOT NULL AUTO_INCREMENT,
  `tcIs` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'true',
  `tRole` varchar(50) DEFAULT NULL,
  KEY `tcId` (`tcId`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='teacher and class';

-- 正在导出表  school.tcinfo 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `tcinfo` DISABLE KEYS */;
REPLACE INTO `tcinfo` (`tcOpenid`, `cId`, `tcId`, `tcIs`, `tRole`) VALUES
	('o25NJ40dOqIUttSOuwaAgkXQEyzU', '2079', 143, 'true', '班主任'),
	('11111', '2079', 144, 'true', '教师'),
	('22222', '2079', 145, 'true', '教师'),
	('33333', '2079', 146, 'true', '教师');
/*!40000 ALTER TABLE `tcinfo` ENABLE KEYS */;

-- 导出  表 school.teacherinfo 结构
CREATE TABLE IF NOT EXISTS `teacherinfo` (
  `tName` varchar(50) DEFAULT NULL,
  `tOpenid` varchar(100) DEFAULT NULL,
  `tPic` varchar(500) DEFAULT NULL,
  `tRole` varchar(50) DEFAULT NULL,
  `tRealname` varchar(50) DEFAULT NULL,
  `tPhone` varchar(50) DEFAULT NULL,
  `tIs` varchar(50) NOT NULL DEFAULT 'true',
  `tSex` varchar(50) DEFAULT NULL,
  `tSub` varchar(50) DEFAULT NULL,
  `tId` int NOT NULL AUTO_INCREMENT,
  KEY `tOpenid` (`tOpenid`),
  KEY `tid` (`tId`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在导出表  school.teacherinfo 的数据：~4 rows (大约)
/*!40000 ALTER TABLE `teacherinfo` DISABLE KEYS */;
REPLACE INTO `teacherinfo` (`tName`, `tOpenid`, `tPic`, `tRole`, `tRealname`, `tPhone`, `tIs`, `tSex`, `tSub`, `tId`) VALUES
	('1', '11111', '1111', '教师', '1', '13385450639', 'true', '男', '科学', 11),
	('2', '22222', '2222', '教师', '2', '15854696521', 'true', '男', '英语', 12),
	('3', '33333', '3333', '教师', '3', '16959585456', 'true', '男', '语文', 13),
	('4', '44444', '4444', '教师', '4', '13356594251', 'true', '男', '数学', 14),
	('七ͭ月ͬ七ͯ日ͥ晴ͤ', 'o25NJ40dOqIUttSOuwaAgkXQEyzU', 'https://thirdwx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIt4qSHP6ltTrBWesEsyLa4xgTtNBuyplGK2ofvRhYMss2SGGqMZS63FkgOo3Zuc06nsTRhLFsgFg/132', '班主任', '沈海生', '13396979721', 'true', '男', '数学', 19);
/*!40000 ALTER TABLE `teacherinfo` ENABLE KEYS */;

-- 导出  表 school.yearinfo 结构
CREATE TABLE IF NOT EXISTS `yearinfo` (
  `label` varchar(50) DEFAULT NULL,
  `yid` int NOT NULL AUTO_INCREMENT,
  `value` int NOT NULL,
  `text` varchar(50) DEFAULT NULL,
  KEY `yid` (`yid`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- 正在导出表  school.yearinfo 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `yearinfo` DISABLE KEYS */;
REPLACE INTO `yearinfo` (`label`, `yid`, `value`, `text`) VALUES
	('2019', 24, 1, '2019'),
	('2020', 27, 2, '2020'),
	('2021', 28, 3, '2021');
/*!40000 ALTER TABLE `yearinfo` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
