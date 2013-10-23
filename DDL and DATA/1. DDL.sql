CREATE TABLE IF NOT EXISTS users (
	email VARCHAR(128) PRIMARY KEY,
	password VARCHAR(128) NOT NULL,	
	first_name VARCHAR(128) NOT NULL,
	last_name VARCHAR(128) NOT NULL,
	birthday DATE,
	gender CHAR(1) NOT NULL CHECK(gender = 'M' OR gender = 'F' ),
	status_update VARCHAR(255),
	status_marital ENUM('single','married','in relationship'),
	isPrivate BIT NOT NULL,
	profile_picture VARCHAR(255) NOT NULL
) ENGINE = InnoDB ;

CREATE TABLE IF NOT EXISTS category(
	name VARCHAR(128) PRIMARY KEY,
	description TEXT NOT NULL,
	icon VARCHAR(255) NOT NULL
) ENGINE = InnoDB ;

CREATE TABLE IF NOT EXISTS interest_groups(
	admin VARCHAR(128),
	name VARCHAR(128) PRIMARY KEY,
	description TEXT NOT NULL,
	isPrivate BIT NOT NULL,
	icon VARCHAR(255) NOT NULL,
	FOREIGN KEY (admin) REFERENCES users(email)
	ON UPDATE CASCADE ON DELETE CASCADE
) Engine = InnoDB ;

CREATE TABLE IF NOT EXISTS member_of(
	grp_name VARCHAR(128),
	usr_email VARCHAR(128),
	join_date DATE,
	FOREIGN KEY (grp_name) REFERENCES interest_groups(name)
	ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (usr_email) REFERENCES users(email)
	ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY (grp_name, usr_email)
) ENGINE = InnoDB ;

CREATE TABLE IF NOT EXISTS group_category(
	grp_name VARCHAR(128),
	cat_name VARCHAR(128),
	FOREIGN KEY (grp_name) REFERENCES interest_groups(name)
	ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (cat_name) REFERENCES category(name)
	ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY (grp_name, cat_name)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS posts(
	post_id INT NOT NULL AUTO_INCREMENT,
	time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	contents VARCHAR(256) NOT NULL,
	poster VARCHAR(128),
	grp_name VARCHAR(128),
	FOREIGN KEY (poster) REFERENCES users(email)
	ON UPDATE CASCADE ON DELETE CASCADE,
	FOREIGN KEY (grp_name) REFERENCES interest_groups(name)
        ON UPDATE CASCADE ON DELETE CASCADE,
	PRIMARY KEY (post_id, poster,grp_name)
) Engine = InnoDB;
