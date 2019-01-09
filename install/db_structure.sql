[query]

CREATE TABLE IF NOT EXISTS `behavior` (
  `id` int(11) NOT NULL,
  `type` enum('fixed','user_defined','','') COLLATE utf8_bin NOT NULL,
  `order_id` enum('enabled','disabled','','') COLLATE utf8_bin NOT NULL,
  `amount` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

[query]

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL,
  `timestamp` varchar(20) COLLATE utf8_bin NOT NULL,
  `order_id` varchar(250) COLLATE utf8_bin NOT NULL,
  `phone` varchar(20) COLLATE utf8_bin NOT NULL,
  `amount` int(11) NOT NULL,
  `overage` int(11) NOT NULL,
  `refunded` int(11) NOT NULL,
  `status` enum('unpaid','paid','cancelled','') COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

[query]

CREATE TABLE IF NOT EXISTS `staff` (
  `staff_id` int(11) NOT NULL,
  `first_name` varchar(50) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `password` varchar(300) COLLATE utf8_bin NOT NULL,
  `status` enum('super_admin','admin','auditor') COLLATE utf8_bin NOT NULL,
  `accesskey` varchar(200) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=316 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

[query]

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL,
  `ord_id` int(11) NOT NULL,
  `timestamp` varchar(20) COLLATE utf8_bin NOT NULL,
  `status` enum('initiated','completed','cancelled','failed','refunded','updated','charged_overage') COLLATE utf8_bin NOT NULL,
  `stripid` varchar(200) COLLATE utf8_bin NOT NULL,
  `strip_customer` varchar(250) COLLATE utf8_bin DEFAULT NULL,
  `notes` varchar(800) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

[query]

ALTER TABLE `behavior`
  ADD PRIMARY KEY (`id`);

[query]

ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

[query]
  
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

[query]

ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

[query]

ALTER TABLE `behavior`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

[query]

ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;

[query]
  
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=316;

[query]
  
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=95;

[query]
  
INSERT INTO `behavior` (`id`, `type`, `order_id`, `amount`) VALUES (NULL, 'user_defined', 'disabled', '');