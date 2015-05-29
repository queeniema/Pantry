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
    `food_class` varchar(255) NOT NULL,
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
INSERT INTO `foods` VALUES (1, 'Other', 'other', 1, 0, 0, 0);
INSERT INTO `foods` VALUES (2, 'Other', 'other', 2, 0, 0, 0);
INSERT INTO `foods` VALUES (3, 'Other', 'other', 3, 0, 0, 0);
INSERT INTO `foods` VALUES (4, 'Other', 'other', 4, 0, 0, 0);
INSERT INTO `foods` VALUES (5, 'Other', 'other', 5, 0, 0, 0);
INSERT INTO `foods` VALUES (6, 'Other', 'other', 6, 0, 0, 0);
INSERT INTO `foods` VALUES (7, 'Other', 'other', 7, 0, 0, 0);

INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Egg Whites', 'egg-whites', 1, 1, 48, 8000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Egg Yolk', 'egg-yolk', 1, 1, 48, 8000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Egg Shelled', 'egg-shelled', 1, 2, 672, 8000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Milk', 'milk', 1, 2, 168, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Soy Milk', 'soy-milk', 1, 2, 168, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Sour Cream', 'sour-cream', 1, 2, 168, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Whipped Cream', 'whipped-cream', 1, 4, 336, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Yogurt', 'yogurt', 1, 1, 168, 1000);

INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Apple Sliced', 'apple-sliced', 2, 3, 48, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Apple Whole', 'apple-whole', 2, 48, 504, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Apricot Sliced', 'apricot-sliced', 2, 3, 48, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Apricot Whole', 'apricot-whole', 2, 48, 96, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Avodcado Sliced', 'avocado-sliced', 2, 24, 48, 3240);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Avodcado Whole', 'avocado-whole', 2, 120, 90, 3240);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Banana Sliced', 'banana-sliced', 2, 6, 72, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Banana Whole', 'banana-whole', 2, 120, 168, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Cantaloupe Sliced', 'cantaloupe-sliced', 2, 6, 72, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Cantaloupe Whole', 'cantaloupe-whole', 2, 72, 200, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Grapes', 'grapes', 2, 48, 168, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Kiwi Sliced', 'kiwi-sliced', 2, 6, 72, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Kiwi Whole', 'kiwi-whole', 2, 48, 168, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Orange Sliced', 'orange-sliced', 2, 6, 168, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Orange Whole', 'orange-whole', 2, 168, 336, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Peach Sliced', 'peach-sliced', 2, 6, 72, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Peach Whole', 'peach-whole', 2, 48, 120, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pear Sliced', 'pear-sliced', 2, 6, 72, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pear Whole', 'pear-whole', 2, 72, 120, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Strawberries', 'strawberries', 2, 24, 72, 7200);

INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Artichoke', 'artichoke', 3, 72, 168, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Asparagus', 'asparagus', 3, 24, 72, 10000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Broccoli', 'broccoli', 3, 24, 120, 10000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Celery', 'celery', 3, 24, 336, 10000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Kale', 'kale', 3, 24, 168, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Potato', 'potato', 3, 336, 240, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Tomato', 'tomato', 3, 72, 96, 1300);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Spinach', 'spinach', 3, 24, 120, 7200);

INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Barley', 'barley', 4, 8000, 8000, 8000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Cornmeal', 'cornmeal', 4, 8000, 12000, 16000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Rice Basmati', 'rice-basmati', 4, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Rice Brown', 'rice-brown', 4, 4000, 8000, 12000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Rice Jasmine', 'rice-jasmine', 4, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pasta', 'pasta', 4, 26000, 26000, 26000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Ziti', 'ziti', 4, 26000, 26000, 26000);

INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Bacon', 'bacon', 5, 2, 150, 1300);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Beef Brisket', 'beef-brisket', 5, 2, 120, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Beef Ground', 'beef-ground', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Bratwurst', 'bratwurst', 5, 2, 48, 1200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Catfish', 'catfish', 5, 2, 48, 6000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chicken Breast', 'chicken-breast', 5, 2, 48, 6000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chicken Ground', 'chicken-ground', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chicken Whole', 'chicken-whole', 5, 2, 48, 8000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Crab Meat', 'crab-meat', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Duck Whole', 'duck-whole', 5, 2, 48, 4000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Ham', 'ham', 5, 2, 120, 4000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Lobster Tail', 'lobster-tail', 5, 2, 48, 4000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pork Chop', 'pork-chop', 5, 2, 120, 4000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Pork Ground', 'pork-ground', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Turkey Piece', 'turkey-piece', 5, 2, 48, 6500);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Turkey Ground', 'turkey-ground', 5, 2, 48, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Shrimp', 'shrimp', 5, 2, 48, 4000);

INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Blackberry Jam', 'blackberry-jam', 6, 48, 336, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chocolate Baking', 'chocolate-baking', 6, 20000, 20000, 20000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chocolate Dark', 'chocolate-dark', 6, 20000, 20000, 20000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Chocolate White', 'chocolate-white', 6, 7200, 7200, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Honey', 'honey', 6, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Maple Syrup', 'maple-syrup', 6, 7200, 7200, 100000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Sugar White', 'sugar-white', 6, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Sugar Brown', 'sugar-brown', 6, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Sugar Powdered', 'sugar-powdered', 6, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Ice Cream Vanilla', 'ice-cream-vanilla', 6, 3, 24, 2160);

INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Beer', 'beer', 7, 3500, 4000, 4000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Soda', 'soda', 7, 2160, 2160, 2160);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Coffee Ground', 'coffee-ground', 7, 7200, 7200, 7200);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Water', 'water', 7, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Vodka', 'vodka', 7, 100000, 100000, 100000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Wine Red', 'wine-red', 7, 26000, 26000, 26000);
INSERT INTO `foods` (food_name, food_class, food_category, food_expire_room, food_expire_fridge, food_expire_freezer) VALUES ('Wine White', 'wine-white', 7, 26000, 26000, 26000);

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
    PRIMARY KEY (`user_id`, `item_name`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
