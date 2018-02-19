--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `email`, `username`, `password`, `user_group_id`) VALUES
(1, 'admin@gmail.com', 'admin', 'admin', 1);

-- --------------------------------------------------------

--
-- Dumping data for table `user_group`
--

INSERT INTO `user_group` (`user_group_id`, `name`, `role`) VALUES
(1, 'Administration', 'a:5:{i:0;s:4:\"user\";i:1;s:17:\"inventory_approve\";i:2;s:13:\"inventory_add\";i:3;s:14:\"inventory_edit\";i:4;s:16:\"inventory_delete\";}');

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`product_id`, `name`, `vendor`, `mrp`, `batch_no`, `batch_date`, `quantity`, `status`) VALUES
(1, 'MacBook Pro', 'Apple', '120000.0000', 123456789, '2018-02-19', 99, 0),
(2, 'MacBook Air', 'Apple', '54000.0000', 456789, '2018-02-19', 99, 1);

