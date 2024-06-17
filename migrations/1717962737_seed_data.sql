INSERT INTO `users` (`id`, `email`, `username`, `password`, `token`,  `created_at`) VALUES
(1,	'a.zavizion.a@gmail.om','user1','12345678',NULL,	'2024-06-13 18:12:42');

INSERT INTO `users` (`id`, `email`, `username`, `password`, `token`,  `created_at`) VALUES
(2,	'test2@gmail.om','user2','12345678',NULL,	'2024-06-13 18:12:42');

INSERT INTO `leads` (`id`, `email`, `name`, `city`, `phone`, `address`,`user_id`) VALUES
(1,	'name1@gmail.com',	'name1',	'city1',	'0661865727',	'address1', 1),
(2,	'name2@gmail.com',	'name2',	'city2',	'1111111111',	'address2', 2);

INSERT INTO `tasks` (`id`, `title`, `content`, `status_id`, `user_id`) VALUES
(1,	'title1',	'vsdvdfvg',	NULL, 2),
(2,	'title2',	'vrvsdvsdf',	NULL, 2),
(3,	'title3',	'bgtrgrg',	NULL, 1);

INSERT INTO `leads_tasks` (`id`, `task_id`, `lead_id`) VALUES
(1,	1,	1),
(2,	2,	2),
(4,	3,	1);


