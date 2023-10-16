CREATE DATABASE banner;

/*383 maximum for index */
CREATE TABLE banner.banner(
	ip_address INT UNSIGNED NOT NULL,
	user_agent VARCHAR(383) NOT NULL,
	view_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	page_url VARCHAR(383) NOT NULL,
 	views_count INT UNSIGNED NOT NULL DEFAULT 1,
    CONSTRAINT U_Banner UNIQUE (ip_address, page_url, user_agent)
);