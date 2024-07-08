ALTER TABLE `sale_bills` ADD `store_id` INT(255) NULL AFTER `outer_client_id`;
ALTER TABLE `sale_bills` ADD FOREIGN KEY (`store_id`) REFERENCES `stores`(`id`) ON DELETE SET NULL ON UPDATE CASCADE;
