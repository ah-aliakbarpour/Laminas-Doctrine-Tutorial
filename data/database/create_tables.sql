CREATE TABLE `post` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `title` text NOT NULL,
    `content` text NOT NULL,
    `status` int(11) NOT NULL,
    `date_created` datetime NOT NULL
);

CREATE TABLE `comment` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `post_id` int(11) NOT NULL,
    `content` text NOT NULL,
    `author` varchar(128) NOT NULL,
    `date_created` datetime NOT NULL
);

CREATE TABLE `tag` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `name` VARCHAR(128)
);

CREATE TABLE `post_tag` (
    `id` int(11) PRIMARY KEY AUTO_INCREMENT,
    `post_id` int(11) NOT NULL,
    `tag_id` int(11) NOT NULL
);