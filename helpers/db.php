<?php

require_once dirname(__DIR__) . '/helpers/config.php';

function get_db() {
    static $link;
    if ($link) return $link;

    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

    if (!$link) {
        extendPageData('error', 'Could not connected to database: ' . mysqli_error($link));
        redirect('404.php');
        die;
    }
    return $link;
}

function try_init_tables()
{
    $db = get_db();
    $db->begin_transaction();

    $query = <<<SQL
create table if not exists users
(
	id int auto_increment,
	name varchar(100) null,
	surname varchar(100) null,
	email_address varchar(100) null,
	username varchar(100) null,
	password varchar(500) null,
	constraint users_pk	primary key (id)
);
SQL;

    $query .= _str_create_index_for_table('users', 'users_email_address_uindex', 'email_address');
    $query .= _str_create_index_for_table('users', 'users_username_uindex', 'username');

    $db->query($query);
    if (!$db->commit()) {
        extendPageData('error', 'User Table could not be created');
        return false;
    }

    $db->begin_transaction();
    $query = <<<SQL
create table if not exists entries
(
	id int auto_increment,
	title varchar(1000) null,
	categories varchar(1000) null,
	tags varchar(1000) null,
	like_count int default 0 not null,
	content varchar(6000) null,
	created_at int null,
	constraint entries_pk primary key (id),
	constraint created_by foreign key (id) references users (id)
);
SQL;

    $db->query($query);
    if (!$db->commit()) {
        extendPageData('error', 'Entries Table could not be created');
        return false;
    }

    $query = <<<SQL
create table if not exists entry_comments
(
	id int auto_increment,
	content varchar(6000) null,
	created_at int null,
	like_count int default 0 null,
	constraint entry_comments_pk primary key (id),
	constraint sent_by foreign key (id) references users (id)
);
SQL;

    $db->query($query);
    if (!$db->commit()) {
        extendPageData('error', 'Entry Comments Table could not be created');
        return false;
    }

    return true;
}

/**
 * Creates an index for a table
 * @param $table_name string Target table name.
 * @param $index_name string Index name.
 * @param $index_col string Index column to relate.
 * @return string The generated SQL.
 */
function _str_create_index_for_table($table_name, $index_name, $index_col)
{
    $sql = <<<SQL
SET @x := (
  SELECT count(*) 
  FROM information_schema.statistics 
  WHERE table_name = '$table_name' 
    AND index_name = '$index_name' 
    AND table_schema = database()
);
SET @sql := if( @x > 0, 'SELECT ''Index exists.''', 'ALTER TABLE $table_name ADD Index $index_name ($index_col);');
PREPARE stmt FROM @sql;
EXECUTE stmt;
SQL;

    return $sql;
}


require_once dirname(__DIR__) . '/db/users.php';