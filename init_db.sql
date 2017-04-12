-- create table `users`
create table if not exists `users` (
	`id` int primary key auto_increment,
    `name` varchar(32) default null
);

-- create table `logs`
create table if not exists `logs` (
	`id` int primary key auto_increment,
    `user_id` int not null,
    `datetime` datetime not null default now(),
    `type` enum('in', 'out') not null,
    foreign key(user_id) references users(id)
);

-- create index for logs on (user_id,datetime,type)
alter table `logs` add index index_logs_on_user_id_datetime_type(`user_id`, `datetime`, `type`);