DROP TABLE IF EXISTS user CASCADE;

CREATE TABLE user (
                    id int(11) unsigned NOT NULL AUTO_INCREMENT,
                    name varchar(255) NOT NULL DEFAULT '',
                    username varchar(255) NOT NULL DEFAULT '',
                    email varchar(255) NOT NULL DEFAULT '',
                    birthdate datetime NOT NULL ,
                    phonenumber varchar(11) NOT NULL DEFAULT '',
                    password varchar(255) NOT NULL DEFAULT '',
                    profileimage varchar(255) NOT NULL DEFAULT '',
                    enabled boolean NOT NULL DEFAULT 0,
                    is_active boolean NOT NULL DEFAULT 1,
                    created_at datetime NOT NULL,
                    updated_at datetime NOT NULL,

                    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS product CASCADE;
CREATE TABLE product(

                      id  int(11) unsigned NOT NULL AUTO_INCREMENT,
                      userid int(11) unsigned NOT NULL ,
                      title varchar(255) NOT NULL DEFAULT '',
                      description varchar(255) NOT NULL DEFAULT '',
                      price DECIMAL(10,2) UNSIGNED  DEFAULT 0,
                      product_image varchar(255) NOT NULL DEFAULT '',
                      category varchar(255) NOT NULL DEFAULT '',
                      isActive boolean NOT NULL DEFAULT 1,
                      isFav boolean NOT NULL DEFAULT 0,
                      isSold boolean NOT NULL DEFAULT 0,
                      PRIMARY KEY (`id`),
                      FOREIGN KEY (`userid`) REFERENCES user(`id`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS product CASCADE;
CREATE TABLE favourite(
                        id  int(11) unsigned NOT NULL AUTO_INCREMENT,
                        userid int(11) unsigned NOT NULL ,
                        productid int(11) unsigned NOT NULL ,
                        PRIMARY KEY (`id`),
                        FOREIGN KEY (`userid`) REFERENCES user(`id`),
                        FOREIGN KEY (`productid`) REFERENCES product(`id`)

)ENGINE=InnoDB DEFAULT CHARSET=utf8;