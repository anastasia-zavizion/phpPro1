INSERT INTO `leads` (`id`, `email`, `name`, `city`, `phone`, `address`) VALUES
(1,	'name1@gmail.com	',	'name1',	'city1',	'0661865727',	'address1'),
(2,	'name2@gmail.com',	'name2',	'city2',	'1111111111',	'address2');

INSERT INTO `tasks` (`id`, `title`, `content`, `status_id`) VALUES
(1,	'title1',	'vsdvdfvg',	NULL),
(2,	'title2',	'vrvsdvsdf',	NULL),
(3,	'title3',	'bgtrgrg',	NULL);

INSERT INTO `leads_tasks` (`id`, `task_id`, `lead_id`) VALUES
(1,	1,	1),
(2,	2,	2),
(4,	3,	1);

INSERT INTO `users` (`id`, `email`, `name`, `password`, `token`, `token_expired_at`, `created_at`) VALUES
(1,	'a.zavizion.a@gmail.om',	'user1',	'123456',	NULL,	NULL,	'2024-06-13 18:12:42');
