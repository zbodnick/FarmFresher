
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS users CASCADE;
create table users(
id int UNIQUE,
p_level varchar(20) NOT NULL,
password varchar(20) NOT NULL,
primary key (id)
);

DROP TABLE IF EXISTS student CASCADE;
create table student(
  u_id int NOT NULL,
  fname varchar(20) NOT NULL,
  lname varchar(20) NOT NULL,
  addr varchar(50) NOT NULL,
  email varchar(30) NOT NULL,
  major varchar(20) NOT NULL,
  program varchar(3),
  gpa         double(2,1),
  formid      int,
  advisorid   int,
  applied_to_grad  int,
  has_hold BOOLEAN NOT NULL DEFAULT 0,
  admission_year int,
  primary key (u_id),
  foreign key (u_id) references users(id)
);

DROP TABLE IF EXISTS faculty CASCADE;
CREATE TABLE faculty(
f_id int NOT NULL,
fname varchar(20) NOT NULL,
lname varchar(20) NOT NULL,
addr varchar(50) NOT NULL,
email varchar(30) NOT NULL,
dept varchar(4) NOT NULL,
primary key (f_id),
foreign key (f_id) references users(id)
);

DROP TABLE IF EXISTS catalog CASCADE;
CREATE TABLE catalog(
c_id int AUTO_INCREMENT,
department varchar(20) NOT NULL,
c_no int NOT NULL,
title varchar(30) NOT NULL,
credits int NOT NULL,
primary key (c_id)
);

DROP TABLE IF EXISTS schedule CASCADE;
create table schedule(
crn int AUTO_INCREMENT,
course_id int NOT NULL,
section_no int NOT NULL,
semester varchar(20) NOT NULL,
year YEAR NOT NULL,
day char(1) NOT NULL,
start_time TIME NOT NULL,
end_time TIME NOT NULL,
primary key (crn),
foreign key (course_id) references catalog(c_id)
);

DROP TABLE IF EXISTS courses_taken CASCADE;
create table courses_taken(
u_id int NOT NULL,
crn int NOT NULL,
grade varchar(2) NOT NULL,
primary key (u_id, crn),
foreign key (u_id) references student(u_id),
foreign key (crn) references schedule(crn)
);

DROP TABLE IF EXISTS courses_taught CASCADE;
create table courses_taught(
f_id int NOT NULL,
crn int NOT NULL,
primary key (f_id, crn),
foreign key (f_id) references faculty(f_id),
foreign key (crn) references schedule(crn)
);

DROP TABLE IF EXISTS prereqs CASCADE;
create table prereqs(
course_Id int NOT NULL,
prereq1 varchar(20) NOT NULL,
prereq2 varchar(20) DEFAULT NULL,
primary key (course_Id, prereq1),
foreign key (course_Id) references catalog(c_id)
);


DROP TABLE IF EXISTS course CASCADE;
CREATE TABLE course (
 courseid      varchar(8),
 title         varchar(30),
 credits       int,
 prereqone     int,
 prereqtwo     int,
 primary key (courseid)
);


DROP TABLE IF EXISTS alumni CASCADE;
CREATE TABLE alumni (
  univid     int primary key,
  yeargrad   int,
  fname varchar(20) NOT NULL,
  lname varchar(20) NOT NULL,
  addr varchar(50) NOT NULL,
  email varchar(30) NOT NULL,
  major varchar(20) NOT NULL,
  program varchar(3)
);


DROP TABLE IF EXISTS transcript CASCADE;
CREATE TABLE transcript (
  univerid   int,
  crseid     varchar(8),
  semester   varchar(10),
  yeartaken  int,
  grade      varchar(2),
  chours     int,
  primary key (univerid, crseid)
);

DROP TABLE IF EXISTS personalinfo CASCADE;
CREATE TABLE personalinfo (
  universid int primary key,
  ftname  varchar(20),
  ltname  varchar(20),
  dob     date,
  address varchar(50),
  cell    bigint
);

DROP TABLE IF EXISTS formone CASCADE;
CREATE TABLE formone (
  universityid   int,
  cid            varchar(8),
  primary key(universityid, cid)
);

DROP TABLE IF EXISTS advisingform CASCADE;
CREATE TABLE advisingform (
  u_id int,
  cid  varchar(8),
  primary key (u_id, cid),
  foreign key (u_id) references users(id)
);

ALTER TABLE alumni
ADD foreign key (univid) references users(id);
ALTER TABLE personalinfo
ADD foreign key (universid) references users(id);
ALTER TABLE alumni
ADD foreign key (univid) references personalinfo(universid);
ALTER TABLE transcript
ADD foreign key (univerid) references student(u_id);
ALTER TABLE formone
ADD foreign key (universityid) references student(u_id);
ALTER TABLE transcript
ADD foreign key (crseid) references course(courseid);

drop table if exists applicant cascade;
drop table if exists application cascade;
drop table if exists reviewer_application cascade;
drop table if exists recommender cascade;
drop table if exists accepted cascade;
drop table if exists verification_codes cascade;

CREATE TABLE applicant (
  username int(8) PRIMARY KEY,
  fname varchar(255),
  lname varchar(255),
  email varchar(255),
  ssn int(9),
  addr varchar(255)
);

CREATE TABLE application (
  applicationID int UNIQUE PRIMARY KEY AUTO_INCREMENT,
  username int(8) UNIQUE,
  transID int,
  recommenderEmail varchar(255),
  GRE_ScoreVerbal varchar(10),
  GRE_ScoreQuantitative varchar(10),
  GRE_Date varchar(10),
  AdvGRE_Score varchar(10),
  AdvGRE_Subject varchar(255),
  AdvGRE_Date varchar(10),
  TOEFL_Score varchar(10),
  TOEFL_Date varchar(10),
  MS_Prior varchar(10),
  MS_GPA varchar(4),
  MS_Major varchar(255),
  MS_Year varchar(10),
  MS_University varchar(255),
  B_Prior varchar(10),
  B_GPA varchar(4),
  B_Major varchar(255),
  B_Year varchar(10),
  B_University varchar(255),
  experience varchar(1000),
  interests varchar(1000),
  completion int,
  recommendation int,
  reviewer_comment varchar(255),
  degree_type varchar(255),
  final_decision int,
  year int,
  semester int
);

CREATE TABLE reviewer_application (
  username int(8) PRIMARY KEY,
  applicantid int(8),
  status int
);

CREATE TABLE recommender (
  fname varchar(255),
  lname varchar(255),
  applicationID int(8),
  recommendation VARCHAR(10000)
);

CREATE TABLE accepted (
  username int(8),
  program varchar(255),
  year int,
  semester int
);

CREATE TABLE verification_codes (
  username int(8),
  verification int(5) PRIMARY KEY
);

ALTER TABLE application ADD FOREIGN KEY (username) REFERENCES applicant (username) ON DELETE CASCADE;
ALTER TABLE reviewer_application ADD FOREIGN KEY (username) REFERENCES users (id);
ALTER TABLE reviewer_application ADD FOREIGN KEY (applicantid) REFERENCES applicant (username);
ALTER TABLE applicant ADD FOREIGN KEY (username) REFERENCES users (id);
ALTER TABLE recommender ADD FOREIGN KEY (applicationID) REFERENCES applicant (username);
ALTER TABLE verification_codes ADD FOREIGN KEY (username) REFERENCES applicant (username);

INSERT INTO applicant VALUES(15555555, 'John', 'Lennon', 'jlennon@gwu.edu', 111111111, '123 Fairy Tale Lane');
INSERT INTO applicant VALUES(19999999, 'Ringo', 'Starr', 'bestdrummer@gwu.edu', 222111111, '600 Penny Lane');
INSERT INTO applicant VALUES(00001234, 'Louis', 'Armstrong', 'awonderfulworld@gwu.edu', 555111111, '987 Trumpet St');
INSERT INTO applicant VALUES(00001235, 'Aretha', 'Franklin', 'aFranklin12@gwu.edu', 666111111, '56 Soul Ave');
INSERT INTO applicant VALUES(00001236, 'Carlos', 'Santana', 'prsLuvr123@gwu.edu', 777111111, '200 Woodstock Dr');

INSERT INTO application VALUES (1,15555555, 1,'yoko_o@gwu.edu', '100', '600', '2018', '100', 'English', '2019',
                               '', '', '', '', '', '', '', 'BA', '3.4', 'Music', '1970', 'Cambridge', 'Worked at Elec Lady Studios', 'Yoko, guitar, singing, peace', 1, 0, '', 'MS', 0, 2020,1);
INSERT INTO application VALUES (2,19999999, 0,'p_mccartney@gwu.edu', '100', '600', '2018', '100', 'English', '2019',
                               '', '', '', '', '', '', '', 'BA', '3.4', 'Music', '1970', 'GW University', 'Walked down Abbey Road', 'Drums, thats about it', 0, 3, '12340004: awesome, 12340005: pretty good!', 'MS', 0, 2020,1);
INSERT INTO application VALUES (3,00001234, 1,'marty@gwu.edu', '100', '600', '2018', '100', 'English', '2019',
                               '', '', '', '', '', '', '', 'BA', '3.4', 'Music', '1970', 'Cambridge', 'Everyone knows me', 'Trumpet, beautiful music', 1, 1, '', 'MS', 1, 2017,1);
INSERT INTO application VALUES (4,00001235, 1,'musiclover@gwu.edu', '100', '600', '2018', '100', 'English', '2019',
                               '', '', '', '', '', '', '', 'BA', '3.4', 'Music', '1970', 'Cambridge', 'Sung the best soul music you will here', 'Singing and writing songs', 1, 3, '', 'MS', 4, 2017,1);
INSERT INTO application VALUES (5,00001236, 1,'soulsacrifice@gwu.edu', '100', '600', '2018', '100', 'English', '2019',
                               '', '', '', '', '', '', '', 'BA', '3.4', 'Music', '1970', 'Cambridge', 'Played at Woodstock', 'Fusion of amazing musics', 1, 4, '', 'phd', 4, 2017,1);

INSERT INTO reviewer_application VALUES (12340002,15555555,0);
INSERT INTO reviewer_application VALUES (12340003,15555555,0);
INSERT INTO reviewer_application VALUES (12340004,19999999,1);
INSERT INTO reviewer_application VALUES (12340005,19999999,1);

INSERT INTO accepted VALUES (00001235,"MS",2017,1);
INSERT INTO accepted VALUES (00001236,"phd",2017,1);

INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6221, 'SW Paradigms', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6461, 'Computer Architecture', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6212, 'Algorithms', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6220, 'Machine Learning', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6232, 'Networks 1', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6233, 'Networks 2', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6241, 'Database 1', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6242, 'Database 2', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6246, 'Compilers', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6260, 'Multimedia', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6251, 'Cloud Computing', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6254, 'SW Engineering', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6262, 'Graphics 1', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6283, 'Security 1', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6284, 'Cryptography', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6286, 'Network Security', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6325, 'Algorithms 2', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6339, 'Embedded Systems', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('CSCI', 6384, 'Cryptography 2', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('ECE', 6241, 'Communication Theory', 3);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('ECE', 6242, 'Information Theory', 2);
INSERT INTO catalog (department, c_no, title, credits) VALUES ('MATH', 6210, 'Logic', 2);

/* Populate schedule with courses */

INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (1, 1, 'Fall', 2019, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (2, 1, 'Fall', 2019, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (3, 1, 'Fall', 2019, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (5, 1, 'Fall', 2019, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (6, 1, 'Fall', 2019, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (7, 1, 'Fall', 2019, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (8, 1, 'Fall', 2019, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (9, 1, 'Fall', 2019, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (11, 1, 'Fall', 2019, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (12, 1, 'Fall', 2019, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (10, 1, 'Fall', 2019, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (13, 1, 'Fall', 2019, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (14, 1, 'Fall', 2019, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (15, 1, 'Fall', 2019, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (16, 1, 'Fall', 2019, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (19, 1, 'Fall', 2019, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (20, 1, 'Fall', 2019, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (21, 1, 'Fall', 2019, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (22, 1, 'Fall', 2019, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (18, 1, 'Fall', 2019, 'R', '16:00', '18:30');

INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (1, 1, 'Spring', 2020, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (2, 1, 'Spring', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (3, 1, 'Spring', 2020, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (5, 1, 'Spring', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (6, 1, 'Spring', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (7, 1, 'Spring', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (8, 1, 'Spring', 2020, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (9, 1, 'Spring', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (11, 1, 'Spring', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (12, 1, 'Spring', 2020, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (10, 1, 'Spring', 2020, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (13, 1, 'Spring', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (14, 1, 'Spring', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (15, 1, 'Spring', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (16, 1, 'Spring', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (19, 1, 'Spring', 2020, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (20, 1, 'Spring', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (21, 1, 'Spring', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (22, 1, 'Spring', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (18, 1, 'Spring', 2020, 'R', '16:00', '18:30');

INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (1, 1, 'Fall', 2020, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (2, 1, 'Fall', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (3, 1, 'Fall', 2020, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (5, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (6, 1, 'Fall', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (7, 1, 'Fall', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (8, 1, 'Fall', 2020, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (9, 1, 'Fall', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (11, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (12, 1, 'Fall', 2020, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (10, 1, 'Fall', 2020, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (13, 1, 'Fall', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (14, 1, 'Fall', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (15, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (16, 1, 'Fall', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (19, 1, 'Fall', 2020, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (20, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (21, 1, 'Fall', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (22, 1, 'Fall', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (18, 1, 'Fall', 2020, 'R', '16:00', '18:30');

/*Populate pre-requisites*/


INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (6, 'CSCI 6232', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (8, 'CSCI 6241', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (9, 'CSCI 6461', 'CSCI 6212');
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (11, 'CSCI 6241', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (12, 'CSCI 6221', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (14, 'CSCI 6212', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (15, 'CSCI 6212', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (16, 'CSCI 6283', 'CSCI 6232');
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (17, 'CSCI 6212', NULL);
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (18, 'CSCI 6461','CSCI 6212');
INSERT INTO prereqs(course_Id, prereq1, prereq2) VALUES (19, 'CSCI 6284', NULL);

/* Populating Faculty */

/*ADMIN*/
INSERT INTO users (id, p_level, password) VALUES (10000000, "Admin", "pass");
/*GS*/
INSERT INTO users (id, p_level, password) VALUES (10000001, "GS", "pass");
/*CAC*/
INSERT INTO users (id, p_level, password) VALUES (10000002, "CAC", "pass");


/*Populating Applicants*/


/*TODO: Need reviewer_application, reccomender, application and applicant?*/

/*John Lennon*/
INSERT INTO users (id, p_level, password) VALUES (15555555, "Applicant", "pass");

/*Ringo Starr*/
INSERT INTO users (id, p_level, password) VALUES (19999999, "Applicant", "pass");

/*Louis Armstrong*/
INSERT INTO users (id, p_level, password) VALUES (00001234, "Applicant", "pass");

/*Aretha Franklin*/
INSERT INTO users (id, p_level, password) VALUES (00001235, "Applicant", "pass");

/*Carlos Santana*/
INSERT INTO users (id, p_level, password) VALUES (00001236, "Applicant", "pass");


/*Populating Students*/


/*Billie Holiday*/
INSERT INTO users (id, p_level, password) VALUES (88888888, "Student", "pass");
INSERT INTO student (u_id, fname, lname, addr, email, major, program, advisorid, applied_to_grad, has_hold, admission_year) VALUES (88888888, "Billie", "Holiday", "88888 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "MS", 12340007, 0, 0, 2018);
INSERT INTO courses_taken (u_id, crn, grade) VALUES
(88888888, 22, "IP"),
(88888888, 23, "IP");

/*Diana Krall */
INSERT INTO users (id, p_level, password) VALUES (99999999, "Student", "pass");
INSERT INTO student (u_id, fname, lname, addr, email, major, program, advisorid, applied_to_grad, has_hold, admission_year) VALUES (99999999, "Diana", "Krall", "99999 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "MS", 12340004, 0, 1, 2019);

/*Ella Fitzgerald*/
INSERT INTO users (id, p_level, password) VALUES (23456789, "Student", "pass");
INSERT INTO student (u_id, fname, lname, addr, email, major, program, advisorid, applied_to_grad, has_hold, admission_year) VALUES (23456789, "Ella", "Fitzgerald", "23456 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "phd", 12340002, 0, 1, 2019);

/*Eva Cassidy*/
INSERT INTO users (id, p_level, password) VALUES (87654321, "Student", "pass");
INSERT INTO student (u_id, fname, lname, addr, email, major, program, advisorid, applied_to_grad, has_hold, admission_year) VALUES (87654321, "Eva", "Cassidy", "87654 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "MS", 12340006, 0, 0, 2017);
INSERT INTO courses_taken (u_id, crn, grade) VALUES 
(87654321, 1, "A"),
(87654321, 2, "A"),
(87654321, 3, "A"),
(87654321, 4, "A"),
(87654321, 5, "A"),
(87654321, 14, "A"),
(87654321, 15, "A"),
(87654321, 6, "C"),
(87654321, 8, "C"),
(87654321, 12, "C");

INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6221");
INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6212");
INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6461");
INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6232");
INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6233");
INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6284");
INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6286");
INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6241");
INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6246");
INSERT INTO formone (universityid, cid) VALUES (87654321, "CSCI6262");

/*Jimi Hendrix*/
INSERT INTO users (id, p_level, password) VALUES (45678901, "Student", "pass");
INSERT INTO student (u_id, fname, lname, addr, email, major, program, advisorid, applied_to_grad, has_hold, admission_year) VALUES (45678901, "Jimi", "Hendrix", "87654 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "MS", 12340005, 0, 0, 2017);
INSERT INTO courses_taken (u_id, crn, grade) VALUES 
(45678901, 1, "A"),
(45678901, 2, "A"),
(45678901, 3, "A"),
(45678901, 4, "A"),
(45678901, 5, "A"),
(45678901, 6, "A"),
(45678901, 14, "A"),
(45678901, 15, "A"),
(45678901, 17, "B"),
(45678901, 18, "B"),
(45678901, 19, "B");

/*Paul McCartney*/
INSERT INTO users (id, p_level, password) VALUES (14444444, "Student", "pass");
INSERT INTO student (u_id, fname, lname, addr, email, major, program, advisorid, applied_to_grad, has_hold, admission_year) VALUES (14444444, "Paul", "McCartney", "14444 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "MS", 12340002, 0, 0, 2017);
INSERT INTO courses_taken (u_id, crn, grade) VALUES 
(14444444, 1, "A"),
(14444444, 2, "A"),
(14444444, 3, "A"),
(14444444, 4, "A"),
(14444444, 5, "A"),
(14444444, 6, "B"),
(14444444, 7, "B"),
(14444444, 8, "B"),
(14444444, 12, "B"),
(14444444, 13, "B");

INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6221");
INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6212");
INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6461");
INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6232");
INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6233");
INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6283");
INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6242");
INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6241");
INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6246");
INSERT INTO formone (universityid, cid) VALUES (14444444, "CSCI6262");

/*George Harrison*/
INSERT INTO users (id, p_level, password) VALUES (16666666, "Student", "pass");
INSERT INTO student (u_id, fname, lname, addr, email, major, program, advisorid, applied_to_grad, has_hold, admission_year) VALUES (16666666, "George", "Harrison", "16666 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "MS", 12340005, 0, 0, 2016);
INSERT INTO courses_taken (u_id, crn, grade) VALUES 
(16666666, 18, "C"),
(16666666, 1, "B"),
(16666666, 2, "B"),
(16666666, 3, "B"),
(16666666, 4, "B"),
(16666666, 5, "B"),
(16666666, 6, "B"),
(16666666, 7, "B"),
(16666666, 13, "B"),
(16666666, 14, "B");

/*Stevie Nicks*/
INSERT INTO users (id, p_level, password) VALUES (12345678, "Student", "pass");
INSERT INTO student (u_id, fname, lname, addr, email, major, program, advisorid, applied_to_grad, has_hold, admission_year) VALUES (12345678, "Stevie", "Nicks", "12345 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "phd", 12340007, 0, 0, 2017);

INSERT INTO courses_taken (u_id, crn, grade) VALUES 
(12345678, 1, "A"),
(12345678, 2, "A"),
(12345678, 3, "A"),
(12345678, 4, "A"),
(12345678, 5, "A"),
(12345678, 6, "B"),
(12345678, 7, "B"),
(12345678, 8, "B"),
(12345678, 12, "B"),
(12345678, 13, "B"),
(12345678, 14, "A"),
(12345678, 15, "A");

INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6221");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6212");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6461");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6232");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6233");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6284");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6242");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6241");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6246");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6262");
INSERT INTO formone (universityid, cid) VALUES (12345678, "CSCI6283");



/*Populating alumni*/

/*Eric Clapton*/
INSERT INTO users (id, p_level, password) VALUES (77777777, "Alumni", "pass");
INSERT INTO alumni (univid, yeargrad, fname, lname, addr, email, major, program) VALUES (77777777, 2014, "Eric", "Clapton", "77777 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "MS");
INSERT INTO courses_taken (u_id, crn, grade) VALUES 
(77777777, 1, "B"),
(77777777, 2, "B"),
(77777777, 3, "B"),
(77777777, 5, "B"),
(77777777, 6, "B"),
(77777777, 7, "B"),
(77777777, 8, "B"),
(77777777, 14, "A"),
(77777777, 15, "A"),
(77777777, 16, "A");

/*Kurt Cobain*/
INSERT INTO users (id, p_level, password) VALUES (34567890, "Alumni", "pass");
INSERT INTO alumni (univid, yeargrad, fname, lname, addr, email, major, program) VALUES (34567890, 2015, "Kurt", "Cobain", "34567 Street St. City, ST 22222", "zbodnick@gwu.edu", "Computer Science", "phd");
INSERT INTO courses_taken (u_id, crn, grade) VALUES 
(34567890, 1, "A"),
(34567890, 2, "A"),
(34567890, 3, "A"),
(34567890, 5, "A"),
(34567890, 6, "A"),
(34567890, 7, "A"),
(34567890, 14, "A"),
(34567890, 15, "A"),
(34567890, 16, "A"),
(34567890, 8, "B"),
(34567890, 11, "B"),
(34567890, 12, "B");


/*Populating faculty*/


/*Bhagi Narahari*/
INSERT INTO users (id, p_level, password) VALUES (12340002, "Faculty", "pass");
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (12340002, 'Bhagi', 'Narahari', '55555 Road Rd. City, ST 66666', 'zbodnick@gwu.edu', 'CSCI');
INSERT INTO courses_taught (f_id, crn) VALUES 
/*Fall 2019*/
(12340002, 1),
(12340002, 2),
(12340002, 9),
(12340002, 10),
(12340002, 11),
/*Sprint 2020*/
(12340002, 21),
(12340002, 22),
(12340002, 29),
(12340002, 30),
(12340002, 31),
/*Fall 2020*/
(12340002, 41),
(12340002, 42),
(12340002, 49),
(12340002, 50),
(12340002, 51);

/*Hyeong-Ah Choi*/
INSERT INTO users (id, p_level, password) VALUES (12340003, "Faculty", "pass");
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (12340003, 'Hyeong-Ah', 'Choi', '77777 Place Pl. City, ST 88888', 'jacobpritchard9@gwu.edu', 'CSCI');
INSERT INTO courses_taught (f_id, crn) VALUES
/*Fall 2019*/
(12340003, 3),
(12340003, 4),
(12340003, 5),
(12340003, 12),
(12340003, 13),
/*Sprint 2020*/
(12340003, 23),
(12340003, 24),
(12340003, 25),
(12340003, 32),
(12340003, 33),
/*Fall 2020*/
(12340003, 43),
(12340003, 44),
(12340003, 45),
(12340003, 52),
(12340003, 53);

/*Gabe Parmer*/
INSERT INTO users (id, p_level, password) VALUES (12340004, "Faculty", "pass");
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (12340004, 'Gabe', 'Parmer', '38273 C St. Washington, D.C. 11111', 'jacobpritchard9@gwu.edu', 'CSCI');

/*Tim Wood*/
INSERT INTO users (id, p_level, password) VALUES (12340005, "Faculty", "pass");
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (12340005, 'Tim', 'Wood', '24681 D St. Washington, D.C. 11111', 'zbodnick@gwu.edu', 'CSCI');
INSERT INTO courses_taught (f_id, crn) VALUES 
/*Fall 2019*/
(12340005, 6),
(12340005, 8),
(12340005, 14),
(12340005, 15),
(12340005, 16),
/*Spring 2020*/
(12340005, 26),
(12340005, 28),
(12340005, 34),
(12340005, 35),
(12340005, 36),
/*Fall 2020*/
(12340005, 46),
(12340005, 48),
(12340005, 54),
(12340005, 55),
(12340005, 56);

/*Shelly Heller*/
INSERT INTO users (id, p_level, password) VALUES (12340006, "Faculty", "pass");
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (12340006, 'Shelly', 'Heller', '56789 I St. Washington, D.C. 11111', 'jacobpritchard9@gwu.edu', 'CSCI');

/*Sarah Morin*/
INSERT INTO users (id, p_level, password) VALUES (12340007, "Faculty", "pass");
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (12340007, 'Sarah', 'Morin', '56789 I St. Washington, D.C. 11111', 'jacobpritchard9@gwu.edu', 'CSCI');

/*Kevin Deems*/
INSERT INTO users (id, p_level, password) VALUES (12340008, "Faculty", "pass");
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (12340008, 'Kevin', 'Deems', '12345 E St. Washington, D.C. 11111', 'zbodnick@gwu.edu', 'CSCI');
INSERT INTO courses_taught (f_id, crn) VALUES 
/*Fall 2019*/
(12340008, 7),
(12340008, 17),
(12340008, 18),
(12340008, 19),
(12340008, 20),

/*Spring 2020*/
(12340008, 27),
(12340008, 37),
(12340008, 38),
(12340008, 39),
(12340008, 40),

/*Fall 2020*/
(12340008, 47),
(12340008, 57),
(12340008, 58),
(12340008, 59),
(12340008, 60);

SET FOREIGN_KEY_CHECKS = 1;
