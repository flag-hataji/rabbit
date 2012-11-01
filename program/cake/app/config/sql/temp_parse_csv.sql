CREATE SEQUENCE temp_parse_csvs_id_seq START 1;
CREATE TABLE temp_parse_csvs(
 id int8 PRIMARY KEY DEFAULT nextval('temp_parse_csvs_id_seq'),
 user_id text,
 name text,
 mail text,
 parameter1 text,
 parameter2 text,
 parameter3 text,
 parameter4 text,
 parameter5 text,
 time_date text
);

CREATE SEQUENCE temp_disused_parse_csvs_id_seq START 1;
CREATE TABLE temp_disused_parse_csvs(
 id int8 PRIMARY KEY DEFAULT nextval('temp_disused_parse_csvs_id_seq'),
 user_id text,
 mail text
);