-- Feel free to change this to suit your needs.

CREATE TABLE `nonce` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `message` text NOT NULL,
    `created` datetime DEFAULT NOW(),
    `user` int(11),
    PRIMARY KEY(`id`),
    INDEX(`user`)
) AUTO_INCREMENT=1 ;

CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(64) NOT NULL,
    `pubkey` char(50),
    PRIMARY KEY(`id`),
) AUTO_INCREMENT=1 ;
