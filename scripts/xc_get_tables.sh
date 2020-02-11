#!/bin/bash
 
sed -n -e '/DROP TABLE.*`streams`/,/UNLOCK TABLES/p' andy_gray.sql > streams.sql

sed -i 's/DROP TABLE IF EXISTS `streams`;/ /' streams.sql

sed -i 's/CREATE TABLE `streams` (/CREATE TABLE `7_xc_streams` (/' streams.sql

sed -i 's/LOCK TABLES `streams` WRITE;/ /' streams.sql

sed -i 's/UNLOCK TABLES;/ /' streams.sql



CREATE TABLE `streams` (