CREATE TABLE IF NOT EXISTS `avis` (
	`id_avis` int AUTO_INCREMENT NOT NULL UNIQUE,
	`id_article` int NOT NULL,
	`login` varchar(255) NOT NULL,
	`titre` varchar(255) NOT NULL,
	`texte` text NOT NULL,
	`note` int NOT NULL,
	`date_creation` date NOT NULL,
	`date_modification` date,
	PRIMARY KEY (`id_avis`)
);

CREATE TABLE IF NOT EXISTS `utilisateur` (
	`login` varchar(255) NOT NULL UNIQUE,
	`mot_de_passe` varchar(255) NOT NULL,
	`nom` varchar(255) NOT NULL,
	`prenom` varchar(255) NOT NULL,
	`date_naissance` date NOT NULL,
	`adresse_mail` varchar(255) NOT NULL,
	`photo_profil` varchar(255) NOT NULL,
	`date_derniere_connexion` date NOT NULL,
	`date_creation` date NOT NULL,
	`role` varchar(255) NOT NULL,
	PRIMARY KEY (`login`)
);

CREATE TABLE IF NOT EXISTS `supportXarticle` (
	`id_support` int NOT NULL,
	`id_article` int NOT NULL,
	PRIMARY KEY (`id_support`, `id_article`)
);

CREATE TABLE IF NOT EXISTS `image` (
	`id_image` int AUTO_INCREMENT NOT NULL UNIQUE,
	`id_article` int NOT NULL,
	`chemin` varchar(255) NOT NULL,
	PRIMARY KEY (`id_image`)
);

CREATE TABLE IF NOT EXISTS `article` (
	`id_article` int AUTO_INCREMENT NOT NULL UNIQUE,
	`titre` varchar(255) NOT NULL,
	`sous_titre` varchar(255) NOT NULL,
	`contenu` text NOT NULL,
	`note` int NOT NULL,
	`nom_jeu` varchar(255) NOT NULL,
	`prix_jeu` int NOT NULL,
	`date_sortie_jeu` date NOT NULL,
	`synopsis_jeu` text NOT NULL,
	`jaquette_jeu` varchar(255) NOT NULL,
	`date_creation` date NOT NULL,
	`date_modification` date,
	PRIMARY KEY (`id_article`)
);

CREATE TABLE IF NOT EXISTS `categorieXarticle` (
	`id_categorie` int NOT NULL,
	`id_article` int NOT NULL,
	PRIMARY KEY (`id_categorie`, `id_article`)
);

CREATE TABLE IF NOT EXISTS `support` (
	`id_support` int AUTO_INCREMENT NOT NULL UNIQUE,
	`support` varchar(255) NOT NULL,
	PRIMARY KEY (`id_support`)
);

CREATE TABLE IF NOT EXISTS `categorie` (
	`id_categorie` int AUTO_INCREMENT NOT NULL UNIQUE,
	`categorie` varchar(255) NOT NULL,
	PRIMARY KEY (`id_categorie`)
);

ALTER TABLE `avis` ADD CONSTRAINT `avis_fk1` FOREIGN KEY (`id_article`) REFERENCES `article`(`id_article`);

ALTER TABLE `avis` ADD CONSTRAINT `avis_fk2` FOREIGN KEY (`login`) REFERENCES `utilisateur`(`login`);

ALTER TABLE `supportXarticle` ADD CONSTRAINT `supportXarticle_fk0` FOREIGN KEY (`id_support`) REFERENCES `support`(`id_support`);

ALTER TABLE `supportXarticle` ADD CONSTRAINT `supportXarticle_fk1` FOREIGN KEY (`id_article`) REFERENCES `article`(`id_article`);
ALTER TABLE `image` ADD CONSTRAINT `image_fk1` FOREIGN KEY (`id_article`) REFERENCES `article`(`id_article`);

ALTER TABLE `categorieXarticle` ADD CONSTRAINT `categorieXarticle_fk0` FOREIGN KEY (`id_categorie`) REFERENCES `categorie`(`id_categorie`);

ALTER TABLE `categorieXarticle` ADD CONSTRAINT `categorieXarticle_fk1` FOREIGN KEY (`id_article`) REFERENCES `article`(`id_article`);

-- Les entrées commencent à partir d'ici

INSERT INTO `support` (`id_support`, `support`) VALUES
	(1, 'PC'),
	(2, 'PS4'),
	(3, 'Xbox One'),
	(4, 'Switch'),
	(5, 'PS3'),
	(6, 'Xbox 360'),
	(7, 'Wii U'),
	(8, '3DS'),
	(9, 'PS Vita'),
	(10, 'Wii'),
	(11, 'DS'),
	(12, 'PSP'),
	(13, 'PS2'),
	(14, 'Xbox'),
	(15, 'GameCube'),
	(16, 'PS5');

INSERT INTO `categorie` (`id_categorie`, `categorie`) VALUES
	(1, 'Action'),
	(2, 'Aventure'),
	(3, 'Combat'),
	(4, 'Course'),
	(5, 'FPS'),
	(6, 'MMO'),
	(7, 'Plateforme'),
	(8, 'Réflexion'),
	(9, 'RPG'),
	(10, 'Simulation'),
	(11, 'Sport'),
	(12, 'Stratégie');

INSERT INTO `utilisateur` (`login`, `mot_de_passe`, `nom`, `prenom`, `date_naissance`, `adresse_mail`, `photo_profil`, `date_derniere_connexion`, `date_creation`, `role`) VALUES
	('admin', 'admin', 'Admin', 'Admin', '1990-01-01', 'admin@adm.in', 'th-3540367948.jpg', '2022-01-01', '2022-01-01', 'administrateur'),	
	('johndoe', 'password1', 'John', 'Doe', '1990-01-01', 'john.doe@example.com', 'th-3358567010.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('janesmith', 'password2', 'Jane', 'Smith', '1995-02-15', 'jane.smith@example.com', 'th-133994816.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('michaeljohnson', 'password3', 'Michael', 'Johnson', '1988-07-10', 'michael.johnson@example.com', 'th-412824294.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('emilybrown', 'password4', 'Emily', 'Brown', '1992-04-20', 'emily.brown@example.com', 'th-3644322206.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('danieltaylor', 'password5', 'Daniel', 'Taylor', '1991-09-05', 'daniel.taylor@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('oliviamiller', 'password6', 'Olivia', 'Miller', '1994-12-18', 'olivia.miller@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('davidanderson', 'password7', 'David', 'Anderson', '1987-03-25', 'david.anderson@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('sophiawilson', 'password8', 'Sophia', 'Wilson', '1993-06-30', 'sophia.wilson@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('jamesthomas', 'password9', 'James', 'Thomas', '1996-11-12', 'james.thomas@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('isabellarobinson', 'password10', 'Isabella', 'Robinson', '1990-08-08', 'isabella.robinson@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('williamclark', 'password11', 'William', 'Clark', '1989-02-28', 'william.clark@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('miawalker', 'password12', 'Mia', 'Walker', '1997-05-14', 'mia.walker@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('benjaminlewis', 'password13', 'Benjamin', 'Lewis', '1993-10-22', 'benjamin.lewis@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('charlottehall', 'password14', 'Charlotte', 'Hall', '1986-09-09', 'charlotte.hall@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('henryyoung', 'password15', 'Henry', 'Young', '1991-12-03', 'henry.young@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('amelialee', 'password16', 'Amelia', 'Lee', '1995-07-17', 'amelia.lee@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('alexandergreen', 'password17', 'Alexander', 'Green', '1988-04-11', 'alexander.green@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('ellabaker', 'password18', 'Ella', 'Baker', '1992-11-27', 'ella.baker@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('josephhill', 'password19', 'Joseph', 'Hill', '1994-06-08', 'joseph.hill@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('victoriacarter', 'password20', 'Victoria', 'Carter', '1990-03-16', 'victoria.carter@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('samuelmurphy', 'password21', 'Samuel', 'Murphy', '1989-08-02', 'samuel.murphy@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('gracecook', 'password22', 'Grace', 'Cook', '1996-01-20', 'grace.cook@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('andrewrivera', 'password23', 'Andrew', 'Rivera', '1993-04-07', 'andrew.rivera@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('chloeward', 'password24', 'Chloe', 'Ward', '1987-11-23', 'chloe.ward@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('danielturner', 'password25', 'Daniel', 'Turner', '1991-06-05', 'daniel.turner@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('sophiacollins', 'password26', 'Sophia', 'Collins', '1994-09-18', 'sophia.collins@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('josephstewart', 'password27', 'Joseph', 'Stewart', '1988-02-14', 'joseph.stewart@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('oliviamorris', 'password28', 'Olivia', 'Morris', '1992-05-30', 'olivia.morris@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('davidperry', 'password29', 'David', 'Perry', '1996-10-13', 'david.perry@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur'),
	('emmanelson', 'password30', 'Emma', 'Nelson', '1990-07-21', 'emma.nelson@example.com', 'default.jpg', '2022-01-01', '2022-01-01', 'utilisateur');

INSERT INTO `article` (`id_article`, `titre`, `sous_titre`, `contenu`, `note`, `nom_jeu`, `prix_jeu`, `date_sortie_jeu`, `synopsis_jeu`, `jaquette_jeu`, `date_creation`) VALUES
	(1, 'The Witcher 3: Wild Hunt', 'Un jeu d''exception', 'The Witcher 3: Wild Hunt est un jeu de rôle en monde ouvert de nouvelle génération situé dans un univers fantastique plein de choix et de conséquences. Vous incarnez un chasseur de monstres professionnel, Geralt de Riv, chargé de retrouver la jeune Ciri, héritière d''une ancienne lignée de guerriers dotée de pouvoirs surnaturels, poursuivie par la Sauvageonne, une force terrifiante aux intentions obscures.', 7, 'The Witcher 3: Wild Hunt', 29.99, '2015-05-19', 'The Witcher 3: Wild Hunt est un jeu de rôle en monde ouvert de nouvelle génération situé dans un univers fantastique plein de choix et de conséquences. Vous incarnez un chasseur de monstres professionnel, Geralt de Riv, chargé de retrouver la jeune Ciri, héritière d''une ancienne lignée de guerriers dotée de pouvoirs surnaturels, poursuivie par la Sauvageonne, une force terrifiante aux intentions obscures.', 'witcher3.jpg', '2022-01-01'),
	(2, 'The Legend of Zelda: Breath of the Wild', 'Un jeu d''aventure épique', 'The Legend of Zelda: Breath of the Wild est un jeu d''action-aventure en monde ouvert qui vous emmène dans un voyage à travers le royaume d''Hyrule. Vous incarnez Link, un jeune héros qui doit sauver la princesse Zelda et le royaume d''Hyrule des griffes du maléfique Ganon. Explorez des donjons, résolvez des énigmes et combattez des monstres dans ce jeu épique.', 8, 'The Legend of Zelda: Breath of the Wild', 59.99, '2017-03-03', 'The Legend of Zelda: Breath of the Wild est un jeu d''action-aventure en monde ouvert qui vous emmène dans un voyage à travers le royaume d''Hyrule. Vous incarnez Link, un jeune héros qui doit sauver la princesse Zelda et le royaume d''Hyrule des griffes du maléfique Ganon. Explorez des donjons, résolvez des énigmes et combattez des monstres dans ce jeu épique.', 'zelda.jpg', '2024-01-02'),
	(3, 'Red Dead Redemption 2', 'Un western épique', 'Red Dead Redemption 2 est un jeu d''action-aventure en monde ouvert qui vous plonge dans l''Amérique sauvage de la fin du XIXe siècle. Vous incarnez Arthur Morgan, un hors-la-loi en fuite qui doit survivre dans un monde impitoyable où la loi du plus fort règne. Explorez des paysages grandioses, affrontez des bandits et vivez des aventures inoubliables dans ce western épique.', 9, 'Red Dead Redemption 2', 39.99, '2018-10-26', 'Red Dead Redemption 2 est un jeu d''action-aventure en monde ouvert qui vous plonge dans l''Amérique sauvage de la fin du XIXe siècle. Vous incarnez Arthur Morgan, un hors-la-loi en fuite qui doit survivre dans un monde impitoyable où la loi du plus fort règne. Explorez des paysages grandioses, affrontez des bandits et vivez des aventures inoubliables dans ce western épique.', 'rdr2.jpg', '2023-01-04'),
	(4, 'Super Mario Odyssey', 'Un jeu de plateforme incontournable', 'Super Mario Odyssey est un jeu de plateforme en monde ouvert qui vous emmène dans une aventure épique à travers le royaume champignon. Vous incarnez Mario, le célèbre plombier moustachu, qui doit sauver la princesse Peach des griffes de Bowser. Explorez des mondes colorés, résolvez des énigmes et affrontez des boss redoutables dans ce jeu incontournable.', 9, 'Super Mario Odyssey', 49.99, '2017-10-27', 'Super Mario Odyssey est un jeu de plateforme en monde ouvert qui vous emmène dans une aventure épique à travers le royaume champignon. Vous incarnez Mario, le célèbre plombier moustachu, qui doit sauver la princesse Peach des griffes de Bowser. Explorez des mondes colorés, résolvez des énigmes et affrontez des boss redoutables dans ce jeu incontournable.', 'mario.jpg', '2022-01-01'),
	(5, 'Uncharted 4: A Thief''s End', 'Un jeu d''aventure palpitant', 'Uncharted 4: A Thief''s End est un jeu d''action-aventure en monde ouvert qui vous plonge dans une aventure épique à travers le monde. Vous incarnez Nathan Drake, un chasseur de trésors intrépide, qui doit retrouver un trésor légendaire avant ses rivaux. Explorez des ruines anciennes, affrontez des mercenaires et vivez des moments inoubliables dans ce jeu palpitant.', 8, 'Uncharted 4: A Thief''s End', 19.99, '2016-05-10', 'Uncharted 4: A Thief''s End est un jeu d''action-aventure en monde ouvert qui vous plonge dans une aventure épique à travers le monde. Vous incarnez Nathan Drake, un chasseur de trésors intrépide, qui doit retrouver un trésor légendaire avant ses rivaux. Explorez des ruines anciennes, affrontez des mercenaires et vivez des moments inoubliables dans ce jeu palpitant.', 'uncharted4.jpg', '2021-11-03'),
	(6, 'Horizon Zero Dawn', 'Un jeu de rôle futuriste', 'Horizon Zero Dawn est un jeu de rôle en monde ouvert qui vous plonge dans un univers post-apocalyptique où la nature a repris ses droits. Vous incarnez Aloy, une chasseuse intrépide, qui doit découvrir les mystères de son monde et affronter des machines redoutables. Explorez des terres sauvages, résolvez des énigmes et combattez des ennemis dans ce jeu futuriste.', 10, 'Horizon Zero Dawn', 29.99, '2017-02-28', 'Horizon Zero Dawn est un jeu de rôle en monde ouvert qui vous plonge dans un univers post-apocalyptique où la nature a repris ses droits. Vous incarnez Aloy, une chasseuse intrépide, qui doit découvrir les mystères de son monde et affronter des machines redoutables. Explorez des terres sauvages, résolvez des énigmes et combattez des ennemis dans ce jeu futuriste.', 'horizon.jpg', '2022-01-01'),
	(7, 'God of War', 'Un jeu d''action épique', 'God of War est un jeu d''action-aventure en monde ouvert qui vous plonge dans un univers mythologique où les dieux et les monstres règnent en maîtres. Vous incarnez Kratos, un guerrier spartiate redoutable, qui doit affronter les forces du mal pour sauver son fils et le monde. Explorez des royaumes divins, résolvez des énigmes et combattez des créatures légendaires dans ce jeu épique.', 3, 'God of War', 39.99, '2018-04-20', 'God of War est un jeu d''action-aventure en monde ouvert qui vous plonge dans un univers mythologique où les dieux et les monstres règnent en maîtres. Vous incarnez Kratos, un guerrier spartiate redoutable, qui doit affronter les forces du mal pour sauver son fils et le monde. Explorez des royaumes divins, résolvez des énigmes et combattez des créatures légendaires dans ce jeu épique.', 'godofwar.jpg', '2022-01-01'),
	(8, 'Bloodborne', 'Un jeu de rôle sombre et intense', 'Bloodborne est un jeu de rôle en monde ouvert qui vous plonge dans un univers gothique et cauchemardesque où les ténèbres règnent en maîtres. Vous incarnez le Chasseur, un héros solitaire, qui doit affronter des créatures terrifiantes et des boss redoutables pour sauver la ville maudite de Yharnam. Explorez des ruelles sombres, résolvez des énigmes et combattez des ennemis impitoyables dans ce jeu sombre et intense.', 9, 'Bloodborne', 19.99, '2015-03-24', 'Bloodborne est un jeu de rôle en monde ouvert qui vous plonge dans un univers gothique et cauchemardesque où les ténèbres règnent en maîtres. Vous incarnez le Chasseur, un héros solitaire, qui doit affronter des créatures terrifiantes et des boss redoutables pour sauver la ville maudite de Yharnam. Explorez des ruelles sombres, résolvez des énigmes et combattez des ennemis impitoyables dans ce jeu sombre et intense.', 'bloodborne.jpg', '2022-01-21'),
	(9, 'Persona 5', 'Un jeu de rôle japonais culte', 'Persona 5 est un jeu de rôle en monde ouvert qui vous plonge dans un univers urbain et fantastique où les masques cachent de sombres secrets. Vous incarnez un lycéen ordinaire, qui doit devenir un voleur fantôme pour combattre les forces du mal et sauver le monde. Explorez des donjons, résolvez des énigmes et combattez des démons dans ce jeu japonais culte.', 9, 'Persona 5', 29.99, '2017-04-04', 'Persona 5 est un jeu de rôle en monde ouvert qui vous plonge dans un univers urbain et fantastique où les masques cachent de sombres secrets. Vous incarnez un lycéen ordinaire, qui doit devenir un voleur fantôme pour combattre les forces du mal et sauver le monde. Explorez des donjons, résolvez des énigmes et combattez des démons dans ce jeu japonais culte.', 'persona5.jpg', '2022-01-01'),
	(10, 'Dark Souls III', 'Un jeu de rôle exigeant', 'Dark Souls III est un jeu de rôle en monde ouvert qui vous plonge dans un univers sombre et impitoyable où la mort rôde à chaque coin de rue. Vous incarnez l''Élu des Cendres, un héros maudit, qui doit affronter des créatures infernales et des boss redoutables pour sauver le royaume de Lothric. Explorez des terres désolées, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu exigeant.', 6, 'Dark Souls III', 19.99, '2016-04-12', 'Dark Souls III est un jeu de rôle en monde ouvert qui vous plonge dans un univers sombre et impitoyable où la mort rôde à chaque coin de rue. Vous incarnez l''Élu des Cendres, un héros maudit, qui doit affronter des créatures infernales et des boss redoutables pour sauver le royaume de Lothric. Explorez des terres désolées, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu exigeant.', 'darksouls3.jpg', '2022-01-01'),
	(11, 'The Last of Us Part II', 'Un jeu d''action intense', 'The Last of Us Part II est un jeu d''action-aventure en monde ouvert qui vous plonge dans un univers post-apocalyptique où la survie est un combat de tous les instants. Vous incarnez Ellie, une jeune femme courageuse, qui doit affronter des infectés et des survivants hostiles pour retrouver un sens à sa vie. Explorez des ruines dévastées, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu intense.', 9, 'The Last of Us Part II', 39.99, '2020-06-19', 'The Last of Us Part II est un jeu d''action-aventure en monde ouvert qui vous plonge dans un univers post-apocalyptique où la survie est un combat de tous les instants. Vous incarnez Ellie, une jeune femme courageuse, qui doit affronter des infectés et des survivants hostiles pour retrouver un sens à sa vie. Explorez des ruines dévastées, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu intense.', 'tlou2.jpg', '2022-03-01'),
	(12, 'Sekiro: Shadows Die Twice', 'Un jeu d''action exigeant', 'Sekiro: Shadows Die Twice est un jeu d''action-aventure en monde ouvert qui vous plonge dans un Japon féodal où les samouraïs et les ninjas se livrent une guerre sans merci. Vous incarnez le Loup, un shinobi solitaire, qui doit affronter des guerriers redoutables et des créatures surnaturelles pour venger son maître. Explorez des temples anciens, résolvez des énigmes et combattez des ennemis impitoyables dans ce jeu exigeant.', 9, 'Sekiro: Shadows Die Twice', 29.99, '2019-03-22', 'Sekiro: Shadows Die Twice est un jeu d''action-aventure en monde ouvert qui vous plonge dans un Japon féodal où les samouraïs et les ninjas se livrent une guerre sans merci. Vous incarnez le Loup, un shinobi solitaire, qui doit affronter des guerriers redoutables et des créatures surnaturelles pour venger son maître. Explorez des temples anciens, résolvez des énigmes et combattez des ennemis impitoyables dans ce jeu exigeant.', 'sekiro.jpg', '2022-01-01'),
	(13, 'Final Fantasy VII Remake', 'Un jeu de rôle épique', 'Final Fantasy VII Remake est un jeu de rôle en monde ouvert qui vous plonge dans un univers fantastique où la magie et la technologie se côtoient. Vous incarnez Cloud Strife, un mercenaire solitaire, qui doit affronter une organisation maléfique pour sauver le monde de la destruction. Explorez des cités futuristes, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu épique.', 10, 'Final Fantasy VII Remake', 59.99, '2020-04-10', 'Final Fantasy VII Remake est un jeu de rôle en monde ouvert qui vous plonge dans un univers fantastique où la magie et la technologie se côtoient. Vous incarnez Cloud Strife, un mercenaire solitaire, qui doit affronter une organisation maléfique pour sauver le monde de la destruction. Explorez des cités futuristes, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu épique.', 'ff7remake.jpg', '2022-03-09'),
	(14, 'Death Stranding', 'Un jeu de science-fiction mystérieux', 'Death Stranding est un jeu d''action-aventure en monde ouvert qui vous plonge dans un univers post-apocalyptique où la mort est omniprésente. Vous incarnez Sam Porter Bridges, un coursier solitaire, qui doit traverser des terres désolées pour reconnecter l''humanité. Explorez des paysages dévastés, résolvez des énigmes et combattez des créatures surnaturelles dans ce jeu mystérieux.', 9, 'Death Stranding', 29.99, '2019-11-08', 'Death Stranding est un jeu d''action-aventure en monde ouvert qui vous plonge dans un univers post-apocalyptique où la mort est omniprésente. Vous incarnez Sam Porter Bridges, un coursier solitaire, qui doit traverser des terres désolées pour reconnecter l''humanité. Explorez des paysages dévastés, résolvez des énigmes et combattez des créatures surnaturelles dans ce jeu mystérieux.', 'deathstranding.jpg', '2022-09-11'),
	(15, 'Nioh 2', 'Un jeu de rôle japonais exigeant', 'Nioh 2 est un jeu de rôle en monde ouvert qui vous plonge dans un Japon féodal où les yokai et les samouraïs se livrent une guerre sans merci. Vous incarnez un mercenaire solitaire, qui doit affronter des démons redoutables et des guerriers impitoyables pour sauver le royaume de la corruption. Explorez des temples anciens, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu exigeant.', 5, 'Nioh 2', 19.99, '2020-03-13', 'Nioh 2 est un jeu de rôle en monde ouvert qui vous plonge dans un Japon féodal où les yokai et les samouraïs se livrent une guerre sans merci. Vous incarnez un mercenaire solitaire, qui doit affronter des démons redoutables et des guerriers impitoyables pour sauver le royaume de la corruption. Explorez des temples anciens, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu exigeant.', 'nioh2.jpg', '2022-04-24'),
	(16, 'Ghost of Tsushima', 'Un jeu d''action épique', 'Ghost of Tsushima est un jeu d''action-aventure en monde ouvert qui vous plonge dans un Japon médiéval où les samouraïs et les mongols se livrent une guerre sans merci. Vous incarnez Jin Sakai, un guerrier solitaire, qui doit affronter des envahisseurs redoutables pour sauver son peuple et son honneur. Explorez des paysages grandioses, résolvez des énigmes et combattez des ennemis impitoyables dans ce jeu épique.', 9, 'Ghost of Tsushima', 39.99, '2020-07-17', 'Ghost of Tsushima est un jeu d''action-aventure en monde ouvert qui vous plonge dans un Japon médiéval où les samouraïs et les mongols se livrent une guerre sans merci. Vous incarnez Jin Sakai, un guerrier solitaire, qui doit affronter des envahisseurs redoutables pour sauver son peuple et son honneur. Explorez des paysages grandioses, résolvez des énigmes et combattez des ennemis impitoyables dans ce jeu épique.', 'ghostoftsushima.jpg', '2022-01-01'),
	(17, 'Demon''s Souls', 'Un jeu de rôle exigeant', 'Demon''s Souls est un jeu de rôle en monde ouvert qui vous plonge dans un univers sombre et impitoyable où les ténèbres règnent en maîtres. Vous incarnez un héros solitaire, qui doit affronter des démons redoutables et des boss impitoyables pour sauver le royaume de Boletaria. Explorez des terres désolées, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu exigeant.', 6, 'Demon''s Souls', 19.99, '2020-11-12', 'Demon''s Souls est un jeu de rôle en monde ouvert qui vous plonge dans un univers sombre et impitoyable où les ténèbres règnent en maîtres. Vous incarnez un héros solitaire, qui doit affronter des démons redoutables et des boss impitoyables pour sauver le royaume de Boletaria. Explorez des terres désolées, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu exigeant.', 'demonssouls.jpg', '2022-01-01'),
	(18, 'Resident Evil Village', 'Un jeu d''horreur terrifiant', 'Resident Evil Village est un jeu d''horreur en monde ouvert qui vous plonge dans un village hanté par des créatures cauchemardesques. Vous incarnez Ethan Winters, un père désespéré, qui doit affronter des monstres terrifiants pour sauver sa fille et sa propre vie. Explorez des maisons abandonnées, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu terrifiant.', 9, 'Resident Evil Village', 49.99, '2021-05-07', 'Resident Evil Village est un jeu d''horreur en monde ouvert qui vous plonge dans un village hanté par des créatures cauchemardesques. Vous incarnez Ethan Winters, un père désespéré, qui doit affronter des monstres terrifiants pour sauver sa fille et sa propre vie. Explorez des maisons abandonnées, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu terrifiant.', 're8.jpg', '2022-01-01'),
	(19, 'Call of Duty: Modern Warfare', 'Un jeu de tir intense', 'Call of Duty: Modern Warfare est un jeu de tir en monde ouvert qui vous plonge dans un conflit mondial où les forces du bien et du mal s''affrontent sans merci. Vous incarnez un soldat d''élite, qui doit combattre des terroristes et des mercenaires pour sauver le monde de la destruction. Explorez des champs de bataille, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu intense.', 9, 'Call of Duty: Modern Warfare', 59.99, '2019-10-25', 'Call of Duty: Modern Warfare est un jeu de tir en monde ouvert qui vous plonge dans un conflit mondial où les forces du bien et du mal s''affrontent sans merci. Vous incarnez un soldat d''élite, qui doit combattre des terroristes et des mercenaires pour sauver le monde de la destruction. Explorez des champs de bataille, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu intense.', 'codmw.jpg', '2024-01-02'),
	(20, 'Assassin''s Creed Valhalla', 'Un jeu d''aventure épique', 'Assassin''s Creed Valhalla est un jeu d''action-aventure en monde ouvert qui vous plonge dans l''âge des vikings où la guerre et la trahison règnent en maîtres. Vous incarnez Eivor, un guerrier légendaire, qui doit affronter des royaumes hostiles pour conquérir l''Angleterre. Explorez des terres sauvages, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu épique.', 7, 'Assassin''s Creed Valhalla', 49.99, '2020-11-10', 'Assassin''s Creed Valhalla est un jeu d''action-aventure en monde ouvert qui vous plonge dans l''âge des vikings où la guerre et la trahison règnent en maîtres. Vous incarnez Eivor, un guerrier légendaire, qui doit affronter des royaumes hostiles pour conquérir l''Angleterre. Explorez des terres sauvages, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu épique.', 'acvalhalla.jpg', '2022-08-09'),
	(21, 'Cyberpunk 2077', 'Un jeu de rôle futuriste', 'Cyberpunk 2077 est un jeu de rôle en monde ouvert qui vous plonge dans un univers cyberpunk où la technologie et la criminalité se côtoient. Vous incarnez V, un mercenaire solitaire, qui doit affronter des corporations maléfiques pour sauver sa propre vie. Explorez des mégapoles futuristes, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu futuriste.', 8, 'Cyberpunk 2077', 59.99, '2020-12-10', 'Cyberpunk 2077 est un jeu de rôle en monde ouvert qui vous plonge dans un univers cyberpunk où la technologie et la criminalité se côtoient. Vous incarnez V, un mercenaire solitaire, qui doit affronter des corporations maléfiques pour sauver sa propre vie. Explorez des mégapoles futuristes, résolvez des énigmes et combattez des ennemis redoutables dans ce jeu futuriste.', 'cyberpunk2077.jpg', '2022-01-01');

INSERT INTO `avis` (`id_article`, `login`, `titre`, `texte`, `note`, `date_creation`, `date_modification`)
VALUES
(1, 'michaeljohnson', 'Une aventure immersive', 'The Witcher 3: Wild Hunt offre une expérience de jeu immersive avec ses quêtes passionnantes et son monde vivant. Un jeu à ne pas manquer.', 9, '2024-05-09', NULL),
(2, 'isabellarobinson', 'Un chef-d''œuvre du jeu vidéo', 'The Legend of Zelda: Breath of the Wild est un chef-d''œuvre qui repousse les limites du jeu d''aventure. Chaque détail est soigné et chaque découverte est excitante.', 10, '2024-05-08', NULL),
(3, 'charlottehall', 'Une expérience cinématographique', 'Red Dead Redemption 2 est plus qu''un simple jeu. C''est une expérience cinématographique immersive où chaque décision compte.', 9, '2024-05-07', NULL),
(4, 'chloeward', 'Un jeu pour tous les âges', 'Super Mario Odyssey est un jeu qui plaît aux joueurs de tous âges. Ses mécaniques simples mais efficaces en font un jeu accessible et amusant.', 8, '2024-05-06', NULL),
(5, 'amelialee', 'Une aventure épique', 'Uncharted 4: A Thief''s End propose une aventure épique avec des personnages charismatiques et des moments d''action spectaculaires.', 9, '2024-05-05', NULL),
(6, 'isabellarobinson', 'Un jeu captivant', 'Horizon Zero Dawn m''a captivé dès les premières minutes. Son univers original et son gameplay innovant en font un jeu incontournable pour les fans de science-fiction.', 10, '2024-05-04', NULL),
(7, 'samuelmurphy', 'Une expérience mémorable', 'God of War m''a offert une expérience de jeu mémorable avec ses combats épiques et son histoire émouvante. Un jeu à vivre absolument.', 9, '2024-05-03', NULL),
(8, 'sophiawilson', 'Une aventure terrifiante', 'Bloodborne est un jeu qui m''a terrifié à chaque coin de rue. Son atmosphère sombre et son gameplay exigeant en font une expérience unique.', 9, '2024-05-02', NULL),
(9, 'alexandergreen', 'Une pépite du jeu vidéo', 'Persona 5 est une pépite du jeu vidéo qui marie habilement gameplay, narration et esthétique. Un must-have pour tous les amateurs de RPG.', 10, '2024-05-01', NULL),
(10, 'alexandergreen', 'Un jeu de rôle exigeant', 'Dark Souls III est un jeu qui défie ses joueurs à chaque instant. Sa difficulté exigeante en fait une expérience gratifiante pour ceux qui osent s''y aventurer.', 8, '2024-04-30', NULL),
(1, 'gracecook', 'Une aventure épique', 'The Witcher 3: Wild Hunt m''a offert des centaines d''heures d''aventure palpitante. Son univers riche et ses quêtes captivantes en font un jeu exceptionnel.', 9, '2024-04-29', NULL),
(2, 'oliviamorris', 'Un monde à explorer', 'The Legend of Zelda: Breath of the Wild m''a transporté dans un monde ouvert immense et plein de surprises. Chaque coin de la carte regorge de secrets à découvrir et d''énigmes à résoudre, ce qui rend l''exploration vraiment gratifiante.', 10, '2024-04-28', NULL),
(3, 'williamclark', 'Une expérience immersive', 'Red Dead Redemption 2 m''a totalement immergé dans son monde ouvert riche en détails. Les interactions avec les PNJ et les choix moraux ajoutent une profondeur supplémentaire à l''histoire.', 9, '2024-04-27', NULL),
(4, 'sophiacollins', 'Un jeu pour tous les âges', 'Super Mario Odyssey est un jeu qui plaira à toute la famille. Ses niveaux colorés et son gameplay accessible en font un jeu amusant pour les joueurs de tous âges.', 8, '2024-04-26', NULL),
(5, 'emilybrown', 'Des moments d''action palpitants', 'Uncharted 4: A Thief''s End est un jeu qui m''a fait vivre des moments d''action palpitants. Les séquences de tir et d''escalade sont parfaitement équilibrées.', 8, '2024-04-25', NULL),
(6, 'janesmith', 'Un univers captivant', 'Horizon Zero Dawn m''a fasciné avec son univers post-apocalyptique unique et son héroïne charismatique. Les combats contre les machines sont intenses et gratifiants.', 10, '2024-04-24', NULL),
(7, 'gracecook', 'Une immersion terrifiante', 'God of War m''a plongé dans un monde mythologique terrifiant où chaque combat est une lutte pour survivre. Les combats contre les boss sont particulièrement intenses.', 9, '2024-04-23', NULL),
(8, 'williamclark', 'Une expérience sombre et intense', 'Bloodborne m''a offert une expérience de jeu sombre et intense que je n''oublierai pas de sitôt. Chaque découverte est accompagnée d''une montée d''adrénaline.', 9, '2024-04-22', NULL),
(9, 'oliviamiller', 'Une aventure épique', 'Persona 5 m''a emmené dans une aventure épique où chaque décision compte. Les liens sociaux et le système de combat sont parfaitement intégrés à l''histoire.', 10, '2024-04-21', NULL),
(10, 'oliviamiller', 'Un défi exigeant', 'Dark Souls III m''a poussé dans mes retranchements avec sa difficulté exigeante. Chaque victoire est une victoire bien méritée.', 8, '2024-04-20', NULL),
(11, 'danielturner', 'Un chef-d''œuvre de narration', 'The Last of Us Part II est un chef-d''œuvre de narration qui m''a profondément touché. Les personnages sont bien développés et l''histoire est captivante du début à la fin.', 10, '2024-05-19', NULL),
(11, 'benjaminlewis', 'Des émotions intenses', 'The Last of Us Part II m''a fait ressentir une gamme d''émotions intenses, allant de la tristesse à l''espoir. La façon dont l''histoire se déroule est vraiment remarquable.', 9, '2024-05-18', NULL),
(12, 'andrewrivera', 'Un défi stimulant', 'Sekiro: Shadows Die Twice est un jeu qui m''a poussé à repousser mes limites. Les combats sont exigeants mais gratifiants, et l''exploration du monde est toujours pleine de surprises.', 9, '2024-05-17', NULL),
(13, 'johndoe', 'Une renaissance réussie', 'Final Fantasy VII Remake est une renaissance réussie d''un classique bien-aimé. Les graphismes sont superbes et le système de combat est à la fois stratégique et dynamique.', 10, '2024-05-16', NULL),
(13, 'alexandergreen', 'Une aventure inoubliable', 'Final Fantasy VII Remake m''a transporté dans un monde fantastique où chaque décision compte. L''histoire est riche en rebondissements et les personnages sont vraiment mémorables.', 10, '2024-05-15', NULL),
(14, 'chloeward', 'Une expérience captivante', 'Death Stranding est une expérience captivante qui m''a fait réfléchir sur la condition humaine. L''atmosphère du jeu est vraiment unique et la bande-son est magnifique.', 9, '2024-05-14', NULL),
(14, 'janesmith', 'Un jeu intrigant', 'Death Stranding est un jeu intrigant qui m''a gardé accroché du début à la fin. L''histoire est complexe et les mécaniques de jeu sont innovantes.', 9, '2024-05-13', NULL),
(15, 'josephstewart', 'Un défi stimulant', 'Nioh 2 est un défi stimulant pour les amateurs de jeux de rôle. Les combats sont rapides et intenses, et la personnalisation du personnage permet une grande variété de styles de jeu.', 8, '2024-05-12', NULL),
(16, 'miawalker', 'Une immersion totale', 'Ghost of Tsushima offre une immersion totale dans le Japon médiéval. L''attention portée aux détails est impressionnante et les combats sont d''une fluidité remarquable.', 10, '2024-05-11', NULL),
(16, 'josephhill', 'Des paysages époustouflants', 'Ghost of Tsushima offre des paysages époustouflants qui donnent envie d''explorer chaque recoin de la carte. Les quêtes annexes ajoutent une profondeur supplémentaire à l''expérience de jeu.', 9, '2024-05-10', NULL),
(17, 'henryyoung', 'Un défi pour les joueurs expérimentés', 'Demon''s Souls est un défi pour les joueurs expérimentés qui recherchent une expérience de jeu exigeante. Chaque victoire est gratifiante et chaque défaite est une leçon.', 8, '2024-05-09', NULL),
(17, 'emilybrown', 'Une atmosphère envoûtante', 'Demon''s Souls possède une atmosphère envoûtante qui vous plonge immédiatement dans son univers sombre et mystérieux. Chaque nouvel environnement est une découverte fascinante.', 9, '2024-05-08', NULL),
(18, 'victoriacarter', 'Une expérience horrifique immersive', 'Resident Evil Village est une expérience horrifique immersive qui vous garde sur le bord de votre siège du début à la fin. Les graphismes sont superbes et l''ambiance est terrifiante.', 10, '2024-05-07', NULL),
(18, 'sophiawilson', 'Des frissons garantis', 'Resident Evil Village garantit des frissons à chaque tournant avec ses ennemis terrifiants et ses jump scares bien placés. C''est un must pour les fans d''horreur.', 9, '2024-05-06', NULL),
(19, 'danieltaylor', 'Une action palpitante', 'Call of Duty: Modern Warfare offre une action palpitante avec ses fusillades intenses et ses séquences spectaculaires. Le multijoueur est particulièrement addictif.', 9, '2024-05-05', NULL),
(20, 'danielturner', 'Une épopée viking captivante', 'Assassin''s Creed Valhalla offre une épopée viking captivante avec ses batailles épiques et ses intrigues politiques. L''exploration des fjords norvégiens est une expérience à ne pas manquer.', 8, '2024-05-04', NULL),
(21, 'danieltaylor', 'Un jeu captivant', 'Cyberpunk 2077 offre une expérience de jeu immersive avec son univers cyberpunk et ses quêtes captivantes.', 9, '2022-05-15', NULL),
(21, 'josephstewart', 'Très décevant', 'Malgré les attentes élevées, Cyberpunk 2077 souffre de nombreux bugs et de problèmes de performance.', 5, '2022-05-16', NULL);

INSERT INTO categorieXarticle (id_article, id_categorie) VALUES
(1, 9), -- The Witcher 3: Wild Hunt est un jeu de rôle (RPG)
(2, 2), (2, 9), -- The Legend of Zelda: Breath of the Wild est un jeu d''aventure et de rôle
(3, 1), (3, 2), -- Red Dead Redemption 2 est un jeu d'action et d'aventure
(4, 7), -- Super Mario Odyssey est un jeu de plateforme
(5, 1), (5, 2), -- Uncharted 4: A Thief's End est un jeu d'action et d'aventure
(6, 1), (6, 9), -- Horizon Zero Dawn est un jeu d'action et de rôle
(7, 1), (7, 9), -- God of War est un jeu d'action et de rôle
(8, 1), (8, 9), -- Bloodborne est un jeu d'action et de rôle
(9, 9), -- Persona 5 est un jeu de rôle
(10, 1), (10, 9), -- Dark Souls III est un jeu d'action et de rôle
(11, 1), (11, 2), -- The Last of Us Part II est un jeu d'action et d'aventure
(12, 1), (12, 9), -- Sekiro: Shadows Die Twice est un jeu d'action et de rôle
(13, 9), -- Final Fantasy VII Remake est un jeu de rôle
(14, 1), (14, 2), (14, 9), -- Death Stranding est un jeu d'action, d'aventure et de rôle
(15, 1), (15, 9), -- Nioh 2 est un jeu d'action et de rôle
(16, 1), (16, 2), -- Ghost of Tsushima est un jeu d'action et d'aventure
(17, 1), (17, 9), -- Demon's Souls est un jeu d'action et de rôle
(18, 2), -- Resident Evil Village est un jeu d'aventure
(19, 5), -- Call of Duty: Modern Warfare est un jeu de tir à la première personne (FPS)
(20, 1), (20, 2), -- Assassin's Creed Valhalla est un jeu d'action et d'aventure
(21, 1), (21, 9); -- Cyberpunk 2077 est un jeu d'action et de rôle

-- Remplissage de la table supportXarticle
INSERT INTO supportXarticle (id_article, id_support) VALUES
(1, 1), (1, 2), (1, 3), -- The Witcher 3: Wild Hunt est disponible sur PC, PS4 et Xbox One
(2, 1), (2, 2), (2, 4), -- The Legend of Zelda: Breath of the Wild est disponible sur PC, PS4 et Switch
(3, 1), (3, 2), (3, 3), -- Red Dead Redemption 2 est disponible sur PC, PS4 et Xbox One
(4, 4), -- Super Mario Odyssey est disponible sur Switch
(5, 2), (5, 3), -- Uncharted 4: A Thief's End est disponible sur PS4 et Xbox One
(6, 1), (6, 2), -- Horizon Zero Dawn est disponible sur PC et PS4
(7, 1), (7, 2), -- God of War est disponible sur PC et PS4
(8, 1), (8, 2), -- Bloodborne est disponible sur PC et PS4
(9, 1), (9, 2), (9, 3), -- Persona 5 est disponible sur PC, PS4 et Xbox One
(10, 1), (10, 2), (10, 3), -- Dark Souls III est disponible sur PC, PS4 et Xbox One
(11, 2), (11, 3), -- The Last of Us Part II est disponible sur PS4 et Xbox One
(12, 1), (12, 2), (12, 3), -- Sekiro: Shadows Die Twice est disponible sur PC, PS4 et Xbox One
(13, 1), (13, 2), -- Final Fantasy VII Remake est disponible sur PC et PS4
(14, 1), (14, 2), (14, 3), -- Death Stranding est disponible sur PC, PS4 et Xbox One
(15, 1), (15, 2), (15, 3), -- Nioh 2 est disponible sur PC, PS4 et Xbox One
(16, 1), (16, 2), -- Ghost of Tsushima est disponible sur PC et PS4
(17, 2), (17, 3), -- Demon's Souls est disponible sur PS4 et Xbox One
(18, 1), (18, 2), (18, 3), (18, 4), -- Resident Evil Village est disponible sur PC, PS4, Xbox One et Switch
(19, 1), (19, 2), (19, 3), -- Call of Duty: Modern Warfare est disponible sur PC, PS4 et Xbox One
(20, 1), (20, 2), (20, 3), (20, 4), -- Assassin's Creed Valhalla est disponible sur PC, PS4, Xbox One et Switch
(21, 1), (21, 2), (21, 3); -- Cyberpunk 2077 est disponible sur PC, PS4 et Xbox One

INSERT INTO image (id_image, id_article, chemin) VALUES
(1, 1, 'th-4147402598.jpg'),
(2, 1, 'th-2571139522.jpg'),
(3, 1, 'th-3345774322.jpg'),
(4, 2, 'th-3718651120.jpg'),
(5, 2, 'th-2879033298.jpg'),
(6, 2, 'th-4055996124.jpg'),
(7, 3, 'th-2115306354.jpg'),
(8, 3, 'th-1651708330.jpg'),
(9, 3, 'th-2332234884.jpg'),
(10, 4, 'th-2125401562.jpg'),
(11, 4, 'th-1665324190.jpg'),
(12, 4, 'th-3990068776.jpg'),
(13, 5, 'th-2639036492.jpg'),
(14, 5, 'th-1304812882.jpg'),
(15, 5, 'th-67486160.jpg'),
(16, 6, 'th-4189553050.jpg'),
(17, 6, 'th-194464250.jpg'),
(18, 6, 'th-1122630130.jpg'),
(19, 7, 'th-146613272.jpg'),
(20, 7, 'th-2826289512.jpg'),
(21, 7, 'th-1427730562.jpg'),
(22, 8, 'th-3320360912.jpg'),
(23, 8, 'th-546291556.jpg'),
(24, 8, 'th-228586814.jpg'),
(25, 9, 'th-4147402598.jpg'),
(26, 9, 'th-4147402598.jpg'),
(27, 9, 'th-4147402598.jpg'),
(28, 10, 'th-4147402598.jpg'),
(29, 10, 'th-4147402598.jpg'),
(30, 10, 'th-4147402598.jpg'),
(31, 11, 'th-4147402598.jpg'),
(32, 11, 'th-4147402598.jpg'),
(33, 11, 'th-4147402598.jpg'),
(34, 12, 'th-4147402598.jpg'),
(35, 12, 'th-4147402598.jpg'),
(36, 12, 'th-4147402598.jpg'),
(37, 13, 'th-4147402598.jpg'),
(38, 13, 'th-4147402598.jpg'),
(39, 13, 'th-4147402598.jpg'),
(40, 14, 'th-4147402598.jpg'),
(41, 14, 'th-4147402598.jpg'),
(42, 14, 'th-4147402598.jpg'),
(43, 15, 'th-4147402598.jpg'),
(44, 15, 'th-4147402598.jpg'),
(45, 15, 'th-4147402598.jpg'),
(46, 16, 'th-4147402598.jpg'),
(47, 16, 'th-4147402598.jpg'),
(48, 16, 'th-4147402598.jpg'),
(49, 17, 'th-4147402598.jpg'),
(50, 17, 'th-4147402598.jpg'),
(51, 17, 'th-4147402598.jpg'),
(52, 18, 'th-4147402598.jpg'),
(53, 18, 'th-4147402598.jpg'),
(54, 18, 'th-4147402598.jpg'),
(55, 19, 'th-4147402598.jpg'),
(56, 19, 'th-4147402598.jpg'),
(57, 19, 'th-4147402598.jpg'),
(58, 20, 'th-4147402598.jpg'),
(59, 20, 'th-4147402598.jpg'),
(60, 20, 'th-4147402598.jpg'),
(61, 21, 'th-4083264610.jpg'),
(62, 21, 'th-2157398880.jpg'),
(63, 21, 'th-1337603274.jpg');