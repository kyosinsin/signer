-- create table `users`
create table if not exists `users` (
	`id` int primary key auto_increment,
    `name` varchar(32) default null
);

-- create table `logs`
create table if not exists `logs` (
	`id` int primary key auto_increment,
    `user_id` int not null,
    `user_name` text not null,
    `sign_time` datetime not null default CURRENT_TIMESTAMP,
    `type` enum('in', 'out') not null,
    `pic_url` varchar(200) not null,
    foreign key(user_id) references users(id)
);

-- create index for logs on (user_id,user_name,sign_time,type,pic_url)
alter table `logs` add index index_logs_on_user_id_user_name_sign_time_type_pic_url(`user_id`, `user_name`, `sign_time`,`type`,`pic_url`);