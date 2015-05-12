ALTER TABLE  `user_carts` ADD  `user_cart_status_flags` TINYINT( 1 ) NULL DEFAULT  '0' AFTER  `promo_code` ;
LTER TABLE  `user_carts` DROP  `shop_brochure_id` ;