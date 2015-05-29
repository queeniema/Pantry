CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `users` VALUES (1,'test','test@email.com','test');



CREATE TABLE IF NOT EXISTS `environments` (
    `env_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `env_name` varchar(255) NOT NULL,
    `temperature` int(11) NOT NULL,
    PRIMARY KEY (`env_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `environments` VALUES (1,1,'test_env','100');



CREATE TABLE IF NOT EXISTS `categories` (
    `cat_id` int(11) NOT NULL AUTO_INCREMENT,
    `cat_name` varchar(255) NOT NULL,
    PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO `categories` VALUES (1, 'Dairy');
INSERT INTO `categories` VALUES (2, 'Fruits');
INSERT INTO `categories` VALUES (3, 'Vegetables');
INSERT INTO `categories` VALUES (4, 'Grains');
INSERT INTO `categories` VALUES (5, 'Meats');
INSERT INTO `categories` VALUES (6, 'Sweets');
INSERT INTO `categories` VALUES (7, 'Liquids');



CREATE TABLE IF NOT EXISTS `foods` (
    `food_id` int(11) NOT NULL AUTO_INCREMENT,
    `food_name` varchar(255) NOT NULL,
    `food_category` int(11) NOT NULL,
    `food_expire_room` int(11) NOT NULL,
    `food_expire_fridge` int(11) NOT NULL,
    `food_expire_freezer` int(11) NOT NULL,
    PRIMARY KEY (`food_id`),
    FOREIGN KEY (`food_category`) REFERENCES `categories`(`cat_id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

# 3 days = 72 hours
# 5 days = 120 hours
# 7 days = 168 hours
# 10 days = 240 hours
# 2 weeks = 336 hours
# 1 month  = 672 hours
# 3 months = 2160 hours
# 10 motnhs = 7200 hours
# 14 months = 10000 hours (basically)
# 3 years = 26000 hours
INSERT INTO `foods` VALUES (1, 'Other', 1, 0, 0, 0);
INSERT INTO `foods` VALUES (2, 'Other', 2, 0, 0, 0);
INSERT INTO `foods` VALUES (3, 'Other', 3, 0, 0, 0);
INSERT INTO `foods` VALUES (4, 'Other', 4, 0, 0, 0);
INSERT INTO `foods` VALUES (5, 'Other', 5, 0, 0, 0);
INSERT INTO `foods` VALUES (6, 'Other', 6, 0, 0, 0);
INSERT INTO `foods` VALUES (7, 'Other', 7, 0, 0, 0);

INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Egg Whites', 1, 1, 48, 8000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Egg Yolk', 1, 1, 48, 8000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Egg Shelled', 1, 2, 672, 8000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Milk', 1, 2, 168, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Soy Milk', 1, 2, 168, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Sour Cream', 1, 2, 168, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Whipped Cream', 1, 4, 336, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Yogurt', 1, 1, 168, 1000);

INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Apple Sliced', 2, 3, 48, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Apple Whole', 2, 48, 504, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Apricot Sliced', 2, 3, 48, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Apricot Whole', 2, 48, 96, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Avodcado Sliced', 2, 24, 48, 3240);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Avodcado Whole', 2, 120, 90, 3240);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Banana Sliced', 2, 6, 72, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Banana Whole', 2, 120, 168, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Cantaloupe Sliced', 2, 6, 72, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Cantaloupe Whole', 2, 72, 200, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Grapes', 2, 48, 168, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Kiwi Sliced', 2, 6, 72, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Kiwi Whole', 2, 48, 168, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Orange Sliced', 2, 6, 168, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Orange Whole', 2, 168, 336, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Peach Sliced', 2, 6, 72, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Peach Whole', 2, 48, 120, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pear Sliced', 2, 6, 72, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pear Whole', 2, 72, 120, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Strawberries', 2, 24, 72, 7200);

INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Artichoke', 3, 72, 168, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Asparagus', 3, 24, 72, 10000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Broccoli', 3, 24, 120, 10000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Celery', 3, 24, 336, 10000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Kale', 3, 24, 168, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Potato', 3, 336, 240, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Tomato', 3, 72, 96, 1300);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Spinach', 3, 24, 120, 7200);

INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Barley', 4, 8000, 8000, 8000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Cornmeal', 4, 8000, 12000, 16000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Rice Basmati', 4, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Rice Brown', 4, 4000, 8000, 12000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Rice Jasmine', 4, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pasta', 4, 26000, 26000, 26000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Ziti', 4, 26000, 26000, 26000);

INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Bacon', 5, 2, 150, 1300);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Beef Brisket', 5, 2, 120, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Beef Ground', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Bratwurst', 5, 2, 48, 1200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Catfish', 5, 2, 48, 6000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chicken Breast', 5, 2, 48, 6000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chicken Ground', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chicken Whole', 5, 2, 48, 8000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Crab Meat', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Duck Whole', 5, 2, 48, 4000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Ham', 5, 2, 120, 4000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Lobster Tail', 5, 2, 48, 4000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pork Chop', 5, 2, 120, 4000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pork Ground', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Turkey Piece', 5, 2, 48, 6500);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Turkey Ground', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Shrimp', 5, 2, 48, 4000);

INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Blackberry Jam', 6, 48, 336, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chocolate Baking', 6, 20000, 20000, 20000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chocolate Dark', 6, 20000, 20000, 20000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chocolate White', 6, 7200, 7200, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Honey', 6, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Maple Syrup', 6, 7200, 7200, 100000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Sugar White', 6, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Sugar Brown', 6, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Sugar Powdered', 6, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Ice Cream Vanilla', 6, 3, 24, 2160);

INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Beer', 7, 3500, 4000, 4000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Soda', 7, 2160, 2160, 2160);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Coffee Ground', 7, 7200, 7200, 7200);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Water', 7, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Vodka', 7, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Wine Red', 7, 26000, 26000, 26000);
INSERT INTO `foods` (food_name, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Wine White', 7, 26000, 26000, 26000);

# 3 days = 72 hours
# 5 days = 120 hours
# 7 days = 168 hours
# 10 days = 240 hours
# 2 weeks = 336 hours
# 1 month  = 672 hours
# 3 months = 2160 hours
# 10 motnhs = 7200 hours
# 14 months = 10000 hours (basically)
# 3 years = 26000 hours

CREATE TABLE IF NOT EXISTS `items` (
    `item_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `food_id` int(11) NOT NULL,
    `item_name` varchar(255) NOT NULL,
    `expiration_date` date NULL,
    `expired` boolean NOT NULL,
    `quantity` int(11) NOT NULL,
    `env_id` int(11) NOT NULL,
    PRIMARY KEY (`item_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`env_id`) REFERENCES `environments`(`env_id`) ON DELETE CASCADE,
    FOREIGN KEY (`food_id`) REFERENCES `foods`(`food_id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;



CREATE TABLE IF NOT EXISTS `sl_items` (
    `user_id` int(11) NOT NULL,
    `item_name` varchar(255) NOT NULL,
    `quantity` int(11) NOT NULL,
    `checked` boolean NOT NULL DEFAULT 0,
    PRIMARY KEY (`user_id`, `item_name`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
