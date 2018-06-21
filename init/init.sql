BEGIN TRANSACTION;

CREATE TABLE `accounts` (
	`id`	INTEGER  NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
	`username`	TEXT NOT NULL UNIQUE,
	`password`	TEXT NOT NULL,
	`session`	TEXT UNIQUE
);
INSERT INTO `accounts` (username, password, session) VALUES ('master', 'main1', NULL);
INSERT INTO `accounts` (username, password, session) VALUES ('u_photog', 'cornellian', NULL);

CREATE TABLE `images` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `filename` TEXT NOT NULL UNIQUE,
  `img_alt` TEXT NOT NULL,
  `description` TEXT,
  `uploader` TEXT NOT NULL
);
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('MBKT01.JPG', 'Mens Basketball Dunk', 'Mens Basketball player #33 goes up for a slam-dunk at home over opponent Binghamton. (Courtesy of University Photography via the Cornellian Yearbook.)', 'u_photog');
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('MBKT02.JPG', 'Mens Basketball Intense', 'Mens Basketball player #13 intimidates and fakes-out his defender from Binghamton. (Courtesy of University Photography via the Cornellian Yearbook.)', 'u_photog');
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('MBKT03.JPG', 'Mens Basketball High-Five', 'Mens Basketball player #22 enthusiastically celebrates with his fellow teammates on their win over opponent Binghamton. (Courtesy of University Photography via the Cornellian Yearbook.)', 'u_photog');
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('MBSB01.JPG', 'Mens Baseball Catcher', 'Mens Baseball catcher acts true to his position as he catches the missed opportunity by the opposing batter. (Courtesy of University Photography via the Cornellian Yearbook.)', 'u_photog');
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('MBSB02.JPG', 'Mens Baseball High-Five', 'Mens Baseball player completes his teammates congratulatory high-five as he walks by the team dugout. (Courtesy of University Photography via the Cornellian Yearbook.)', 'u_photog');
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('MBSB03.JPG', 'Mens Baseball Running', 'Mens Baseball player #5 sprints from base-to-base to advance the teams position.', 'u_photog');
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('MLAX01.JPG', 'Mens Lacrosse Goalie', 'Mens Lacrosse Goaltender #40 walks down the line of excited teammates cheering him on before he faces their next opponent. (Courtesy of University Photography via the Cornellian Yearbook.)', 'u_photog');
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('MLAX02.JPG', 'Mens Lacrosse Action', 'Mens Lacrosse player #51 completes his teammates congratulatory high-five as he walks by the team dugout. (Courtesy of University Photography via the Cornellian Yearbook.)', 'u_photog');
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('WFH01.JPG', 'Womens Field Hockey Steal', 'Womens Field Hockey player reaches her stick to keep her Ohio opponent from gaining posession. (Courtesy of University Photography via the Cornellian Yearbook.)', 'u_photog');
INSERT INTO `images` (filename, img_alt, description, uploader) VALUES ('WFH02.JPG', 'Womens Field Hockey Coach Talk', 'Two Womens Field Hockey players speak with their coach on the sidelines on how they can improve their game. (Courtesy of University Photography via the Cornellian Yearbook.)', 'u_photog');


CREATE TABLE `tags` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `tag_name` TEXT NOT NULL UNIQUE
);
INSERT INTO `tags` (tag_name) VALUES ('basketball');
INSERT INTO `tags` (tag_name) VALUES ('mens');
INSERT INTO `tags` (tag_name) VALUES ('baseball');
INSERT INTO `tags` (tag_name) VALUES ('womens');
INSERT INTO `tags` (tag_name) VALUES ('lacrosse');
INSERT INTO `tags` (tag_name) VALUES ('action');

CREATE TABLE `image_tag` (
  `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
  `photo_id` INTEGER NOT NULL,
  `tag_id` INTEGER NOT NULL,
	FOREIGN KEY(photo_id) REFERENCES images(id),
	FOREIGN KEY(tag_id) REFERENCES tags(id)
);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (1, 1);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (1, 2);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (3, 1);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (3, 2);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (4, 3);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (2, 1);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (2, 2);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (4, 2);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (5, 3);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (5, 2);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (6, 3);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (7, 5);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (8, 5);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (9, 4);
INSERT INTO `image_tag` (photo_id, tag_id) VALUES (10, 4);

COMMIT;
