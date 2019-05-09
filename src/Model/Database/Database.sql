CREATE TABLE user (
                    id int(11) unsigned NOT NULL AUTO_INCREMENT,
                    name varchar(255) NOT NULL DEFAULT '',
                    username varchar(255) NOT NULL DEFAULT '',
                    email varchar(255) NOT NULL DEFAULT '',
                    birthdate datetime NOT NULL ,
                    phonenumber varchar(11) NOT NULL DEFAULT '',
                    password varchar(255) NOT NULL DEFAULT '',
                    profileimage varchar(255) NOT NULL DEFAULT '',
                    is_active boolean NOT NULL DEFAULT 1,
                    enabled boolean NOT NULL DEFAULT 0,
                    created_at datetime NOT NULL,
                    updated_at datetime NOT NULL,

                    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE product(

                      id  int(11) unsigned NOT NULL AUTO_INCREMENT,
                      id_user int unsigned NOT NULL,
                      title varchar(255) NOT NULL DEFAULT '',
                      description varchar(255) NOT NULL DEFAULT '',
                      price DECIMAL(10,2) UNSIGNED  DEFAULT 0,
                      product_image varchar(255) NOT NULL DEFAULT '',
                      category varchar(255) NOT NULL DEFAULT '',
                      isActive boolean NOT NULL DEFAULT 1,
                      PRIMARY KEY (`id`),
                      FOREIGN KEY (`id_user`) REFERENCES  user(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;