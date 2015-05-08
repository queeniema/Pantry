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

CREATE TABLE IF NOT EXISTS `items` (
    `item_id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `item_name` varchar(255) NOT NULL,
    `expiration_date` date NULL,
    `expired` boolean NOT NULL,
    `quantity` int(11) NOT NULL,
    `categories` varchar(255) NOT NULL,
    `env_id` int(11) NOT NULL,
    PRIMARY KEY (`item_id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`env_id`) REFERENCES `environments`(`env_id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `sl_items` (
    `user_id` int(11) NOT NULL,
    `item_name` varchar(255) NOT NULL,
    `quantity` int(11) NOT NULL,
    PRIMARY KEY (`user_id`, `item_name`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;
