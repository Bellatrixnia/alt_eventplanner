CREATE TABLE tx_alteventplanner_domain_model_event (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,
    starttime int(11) DEFAULT '0' NOT NULL,
    endtime int(11) DEFAULT '0' NOT NULL,
    sorting int(11) DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,

    title varchar(255) DEFAULT '' NOT NULL,
  begin int(11) DEFAULT '0' NOT NULL,
  end int(11) DEFAULT '0' NOT NULL,
  minimum_volunteers int(11) DEFAULT '0' NOT NULL,
  sign_ups int(11) DEFAULT '0' NOT NULL,


    PRIMARY KEY (uid),
    KEY parent (pid)
);

CREATE TABLE tx_alteventplanner_domain_model_signup (
    uid int(11) NOT NULL auto_increment,
    pid int(11) DEFAULT '0' NOT NULL,

    tstamp int(11) DEFAULT '0' NOT NULL,
    crdate int(11) DEFAULT '0' NOT NULL,
    cruser_id int(11) DEFAULT '0' NOT NULL,
    deleted tinyint(4) DEFAULT '0' NOT NULL,
    hidden tinyint(4) DEFAULT '0' NOT NULL,

    t3_origuid int(11) DEFAULT '0' NOT NULL,

    frontenduser_uid int(11) DEFAULT '0' NOT NULL,
    event_uid int(11) DEFAULT '0' NOT NULL,
    signup_type int(11) DEFAULT '0' NOT NULL,

    PRIMARY KEY (uid),
    KEY parent (pid)
);