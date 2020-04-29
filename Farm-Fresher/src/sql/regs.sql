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
  yeargrad   int
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
  foreign key (u_id) references users(id),
  foreign key (cid) references schedule(crn)
);

ALTER TABLE alumni
ADD foreign key (univid) references users(id);
ALTER TABLE personalinfo
ADD foreign key (universid) references users(id);
ALTER TABLE alumni
ADD foreign key (univid) references personalinfo(universid);
ALTER TABLE student
ADD foreign key (u_id) references transcript(univerid);
ALTER TABLE student
ADD foreign key (u_id) references formone(universityid);
ALTER TABLE transcript
ADD foreign key (crseid) references course(courseid);

INSERT INTO users (id, p_level, password) VALUES (10000000, 'Admin', 'admin');
INSERT INTO users (id, p_level, password) VALUES (10000001, 'GS', 'gs123');
INSERT INTO users (id, p_level, password) VALUES (10000002, 'Faculty', 'bhagiweb');
INSERT INTO users (id, p_level, password) VALUES (10000003, 'Faculty', 'choi123');
INSERT INTO users (id, p_level, password) VALUES (10000004, 'Faculty', 'PASS');
INSERT INTO users (id, p_level, password) VALUES (10000005, 'Faculty', 'Pass999');
INSERT INTO users (id, p_level, password) VALUES (10000006, 'Faculty', 'PASSWORD');
INSERT INTO users (id, p_level, password) VALUES (10000007, 'Faculty', 'pass123');
INSERT INTO users (id, p_level, password) VALUES (10000008, 'Faculty', 'pass789');
INSERT INTO users (id, p_level, password) VALUES (10000009, 'Faculty', 'pass456');
INSERT INTO users (id, p_level, password) VALUES (88888888, 'Student', 'password');
INSERT INTO users (id, p_level, password) VALUES (99999999, 'Student', 'pword');
INSERT INTO users (id, p_level, password) VALUES (45678901, 'Student', 'pass');
INSERT INTO users (id, p_level, password) VALUES (10101010, 'Student', 'pword');


INSERT INTO student (u_id, fname, lname, addr, email, major) VALUES (88888888, 'Billie', 'Holiday', '11111 Street St. City, ST 22222', 'jacobpritchard9@gwu.edu', 'Computer Science');
INSERT INTO student (u_id, fname, lname, addr, email, major) VALUES (99999999, 'Diana', 'Krall', '33333 Drive Dr. City, ST 44444', 'jumina@gwu.edu', 'Computer Science');
INSERT INTO student (u_id, fname, lname, addr, email, major, program) VALUES (45678901, 'Jimi', 'Hendrix', '123 THISADDRESS, ISREAL', 'jimi@gmail.com', 'Computer Science', 'MS')

INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (10000002, 'Bhagi', 'Narahari', '55555 Road Rd. City, ST 66666', 'zbodnick@gwu.edu', 'CSCI');
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (10000003, 'Hyeong-Ah', 'Choi', '77777 Place Pl. City, ST 88888', 'jacobpritchard9@gwu.edu', 'CSCI');
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (10000004, 'Roxana', 'Leontie', '99999 F St. Washington, D.C. 11111', 'jumina@gwu.edu', 'CSCI');
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (10000005, 'Rahul', 'Simha', '12345 E St. Washington, D.C. 11111', 'zbodnick@gwu.edu', 'CSCI');
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (10000006, 'Pablo', 'Frank-Bolton', '56789 I St. Washington, D.C. 11111', 'jacobpritchard9@gwu.edu', 'CSCI');
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (10000007, 'Abdou Youssef', 'Youssef', '13579 K St. Washington, D.C. 11111', 'jumina@gwu.edu', 'CSCI');
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (10000008, 'James', 'Taylor', '24681 D St. Washington, D.C. 11111', 'zbodnick@gwu.edu', 'CSCI');
INSERT INTO faculty (f_id, fname, lname, addr, email, dept) VALUES (10000009, 'Gabe', 'Parmer', '38273 C St. Washington, D.C. 11111', 'jacobpritchard9@gwu.edu', 'CSCI');

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

INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (1, 1, 'Fall', 2020, 'M', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (2, 1, 'Fall', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (3, 1, 'Fall', 2020, 'W', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (5, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (6, 1, 'Fall', 2020, 'T', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (7, 1, 'Fall', 2020, 'W', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (8, 1, 'Fall', 2020, 'R', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (9, 1, 'Fall', 2020, 'T', '15:00', '17:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (11, 1, 'Fall', 2020, 'M', '18:00', '20:30');
INSERT INTO schedule (course_id, section_no, semester, year, day, start_time, end_time) VALUES (12, 1, 'Fall', 2020, 'M', '15:30', '18:00');
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

INSERT INTO courses_taken(u_id, crn, grade) VALUES (88888888, 2, 'IP');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (88888888, 3, 'IP');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 1, 'A');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 3, 'A');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 2, 'A');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 5, 'A');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 6, 'A');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 15, 'A');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 16, 'A');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 7, 'A');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 20, 'B');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 21, 'B');
INSERT INTO courses_taken(u_id, crn, grade) VALUES (45678901, 22, 'B');

INSERT INTO courses_taught(f_id, crn) VALUES (10000004, 1);
INSERT INTO courses_taught(f_id, crn) VALUES (10000002, 2);
INSERT INTO courses_taught(f_id, crn) VALUES (10000003, 3);
INSERT INTO courses_taught(f_id, crn) VALUES (10000005, 4);
INSERT INTO courses_taught(f_id, crn) VALUES (10000005, 5);
INSERT INTO courses_taught(f_id, crn) VALUES (10000005, 6);
INSERT INTO courses_taught(f_id, crn) VALUES (10000005, 7);
INSERT INTO courses_taught(f_id, crn) VALUES (10000004, 8);
INSERT INTO courses_taught(f_id, crn) VALUES (10000008, 9);
INSERT INTO courses_taught(f_id, crn) VALUES (10000006, 10);
INSERT INTO courses_taught(f_id, crn) VALUES (10000006, 11);
INSERT INTO courses_taught(f_id, crn) VALUES (10000006, 12);
INSERT INTO courses_taught(f_id, crn) VALUES (10000006, 13);
INSERT INTO courses_taught(f_id, crn) VALUES (10000009, 14);
INSERT INTO courses_taught(f_id, crn) VALUES (10000009, 15);
INSERT INTO courses_taught(f_id, crn) VALUES (10000004, 16);
INSERT INTO courses_taught(f_id, crn) VALUES (10000007, 17);
INSERT INTO courses_taught(f_id, crn) VALUES (10000007, 18);
INSERT INTO courses_taught(f_id, crn) VALUES (10000007, 19);
INSERT INTO courses_taught(f_id, crn) VALUES (10000007, 20);

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


INSERT INTO course VALUES ( 'CSCI6221', 'SW Paradigms', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6461', 'Computer Architecture', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6212', 'Algorithms', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6220', 'Machine Learning', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6232', 'Networks 1', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6233', 'Networks 2', 3, 6232, null);
INSERT INTO course VALUES ( 'CSCI6241', 'Database 1', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6242', 'Database 2', 3, 6241, null);
INSERT INTO course VALUES ( 'CSCI6246', 'Compilers', 3, 6461, 6212);
INSERT INTO course VALUES ( 'CSCI6260', 'Multimedia', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6251', 'Cloud Computing', 3, 6461, null);
INSERT INTO course VALUES ( 'CSCI6254', 'SW Engineering', 3, 6221, null);
INSERT INTO course VALUES ( 'CSCI6262', 'Graphics 1', 3, null, null);
INSERT INTO course VALUES ( 'CSCI6283', 'Security 1', 3, 6212, null);
INSERT INTO course VALUES ( 'CSCI6284', 'Cryptography', 3, 6212, null);
INSERT INTO course VALUES ( 'CSCI6286', 'Network Security', 3, 6283, 6232);
INSERT INTO course VALUES ( 'CSCI6325', 'Algorithms 2', 3, 6212, null);
INSERT INTO course VALUES ( 'CSCI6339', 'Embedded Systems', 3, 6461, 6212);
INSERT INTO course VALUES ( 'CSCI6384', 'Cryptography 2', 3, 6284, null);
INSERT INTO course VALUES ( 'ECE6241',  'Communication Theory', 3, null, null);
INSERT INTO course VALUES ( 'ECE6242',  'Information Theory', 2, null, null);
INSERT INTO course VALUES ( 'MATH6210', 'Logic', 2, null, null);

INSERT INTO alumni VALUES ( 77777777, 2014);

INSERT INTO transcript VALUES (1, 'CSCI6221', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6461', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6212', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6220', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6232', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6233', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6241', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (1, 'CSCI6242', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6251', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6254', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'CSCI6262', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (1, 'ECE6241',  'Fall', 2019, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6221', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6212', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6461', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6232', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6223', 'Fall', 2014, 'A', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6241', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6246', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6262', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6283', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (55555555, 'CSCI6242', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'ECE6242',  'Fall', 2014, 'C', 2);
INSERT INTO transcript VALUES (66666666, 'CSCI6221', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6461', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6212', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6232', 'Fall', 2014, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6233', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6241', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6242', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6283', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (66666666, 'CSCI6284', 'Spring', 2015, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6221', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6212', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6461', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6232', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6233', 'Fall', 2013, 'B', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6241', 'Spring', 2014, 'A', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6242', 'Spring', 2014, 'A', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6283', 'Spring', 2014, 'A', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6284', 'Spring', 2014, 'A', 3);
INSERT INTO transcript VALUES (77777777, 'CSCI6286', 'Spring', 2014, 'A', 3);
INSERT INTO transcript VALUES (45678901, 'CSCI6221', 'Spring', 2017, 'A', 3);
INSERT INTO transcript VALUES (45678901, 'CSCI6212', 'Spring', 2017, 'A', 3);
INSERT INTO transcript VALUES (45678901, 'CSCI6461', 'Spring', 2017, 'A', 3);
INSERT INTO transcript VALUES (45678901, 'CSCI6232', 'Spring', 2017, 'A', 3);
INSERT INTO transcript VALUES (45678901, 'CSCI6233', 'Spring', 2017, 'A', 3);
INSERT INTO transcript VALUES (45678901, 'CSCI6284', 'Spring', 2017, 'A', 3);
INSERT INTO transcript VALUES (45678901, 'CSCI6286', 'Spring', 2017, 'A', 3);
INSERT INTO transcript VALUES (45678901, 'CSCI6241', 'Spring', 2017, 'A', 3);
INSERT INTO transcript VALUES (45678901, 'ECE6241', 'Spring', 2017, 'B', 3);
INSERT INTO transcript VALUES (45678901, 'ECE6242', 'Spring', 2017, 'B', 3);
INSERT INTO transcript VALUES (45678901, 'MATH6210', 'Spring', 2017, 'B', 3);

INSERT INTO personalinfo VALUES (1, 'Stanislav', 'Lukashevich', '1998-12-12', 'Arlington, VA, 22206', 7036094317);
INSERT INTO personalinfo VALUES (55555555, 'Paul', 'McCartney', '1999-04-04', 'Atlanta, GA, 22666', 2024892713);
INSERT INTO personalinfo VALUES (66666666, 'George', 'Harrison', '1999-02-02', 'Boston, MA, 22777', 2024892714);
INSERT INTO personalinfo VALUES (77777777, 'Eric', 'Clapton', '1996-02-02', 'Washington, DC, 22236', 2024892715);
INSERT INTO personalinfo VALUES (88888888, 'Bhagirath', 'Narahari', '1966-12-12', 'Washington, DC, 22236', 2024892716);
INSERT INTO personalinfo VALUES (99999999, 'Eric', 'Clapton', '1981-02-02', 'Washington, DC, 22236', 2024892717);
INSERT INTO personalinfo VALUES (2, 'Jake', 'Harris', '1999-01-01', 'Atlanta, GA, 44436', 2024892718);

/* -----------------------------------------------------------------------------

                            ╔══════════════╗
----------------------------    APPS SQL    ------------------------------------
                            ╚══════════════╝

--------------------------------------------------------------------------------
*/

drop table if exists applicant cascade;
drop table if exists application cascade;
drop table if exists reviewer_application cascade;
drop table if exists recommender cascade;
drop table if exists verification_codes cascade;

CREATE TABLE `applicant` (
  `username` int(8) PRIMARY KEY,
  `fname` varchar(255),
  `lname` varchar(255),
  `email` varchar(255),
  `ssn` int(9),
  `addr` varchar(255)
);

CREATE TABLE `application` (
  `applicationID` int UNIQUE PRIMARY KEY AUTO_INCREMENT,
  `username` int(8) UNIQUE,
  `transID` int,
  `recommenderEmail` varchar(255),
  `GRE_ScoreVerbal` varchar(10),
  `GRE_ScoreQuantitative` varchar(10),
  `GRE_Date` varchar(10),
  `AdvGRE_Score` varchar(10),
  `AdvGRE_Subject` varchar(255),
  `AdvGRE_Date` varchar(10),
  `TOEFL_Score` varchar(10),
  `TOEFL_Date` varchar(10),
  `MS_Prior` varchar(10),
  `MS_GPA` varchar(4),
  `MS_Major` varchar(255),
  `MS_Year` varchar(10),
  `MS_University` varchar(255),
  `B_Prior` varchar(10),
  `B_GPA` varchar(4),
  `B_Major` varchar(255),
  `B_Year` varchar(10),
  `B_University` varchar(255),
  `experience` varchar(1000),
  `interests` varchar(1000),
  `completion` int, /* 0=application not complete, 1=complete*/
  `recommendation` int, /*0=under review 1=reject, 2=borderline, 3=admit without aid, 4=admit with aid*/
  `reviewer_comment` varchar(255),
  `degree_type` varchar(255),
  `final_decision` int /*reject/accept/accept with aid*/
);

CREATE TABLE `reviewer_application` (
  `username` int(8) PRIMARY KEY,
  `applicantid` int(8),
  `status` int
);

CREATE TABLE `recommender` (
  `fname` varchar(255),
  `lname` varchar(255),
  `applicationID` int(8) PRIMARY KEY,
  `recommendation` VARCHAR(10000)
);

CREATE TABLE `verification_codes` (
  `username` int(8),
  `verification`  int(5) PRIMARY KEY
);

ALTER TABLE `application` ADD FOREIGN KEY (`username`) REFERENCES `applicant` (`username`);
ALTER TABLE `reviewer_application` ADD FOREIGN KEY (`username`) REFERENCES `users` (`id`);
ALTER TABLE `reviewer_application` ADD FOREIGN KEY (`applicantid`) REFERENCES `applicant` (`username`);
ALTER TABLE `applicant` ADD FOREIGN KEY (`username`) REFERENCES `users` (`id`);
ALTER TABLE `recommender` ADD FOREIGN KEY (`applicationID`) REFERENCES `applicant` (`username`);
ALTER TABLE `verification_codes` ADD FOREIGN KEY (`username`) REFERENCES `applicant` (`username`);

INSERT INTO applicant VALUES(55555555, 'John', 'Lennon', 'jlennon@gwu.edu', 111111111, '123 Fairy Tale Lane');
INSERT INTO applicant VALUES(66666666, 'Ringo', 'Starr', 'rstarr@gwu.edu', 222111111, '321 Penny Lane');
INSERT INTO applicant VALUES(33333333, 'Paul', 'McCartney', 'pmccartney@gwu.edu', 333333333, '542 Abbey Road');

INSERT INTO `application` VALUES(1,66666666, 0,'lovesYoko@gwu.edu', '100', '600', '2018', '100', 'English', '2019',
                               '100', '2014', '', '', '', '', '', 'BA', '3.4', 'Music', '1970', 'Cambridge', 'Worked at Elec Lady Studios', 'Yoko', 0, 0, '', 'MS', 0);
INSERT INTO `application` VALUES(2,55555555, 0,'bestBeatle@gwu.edu', '100', '600', '2018', '100', 'English', '2019',
                               '100', '2014', '', '', '', '', '', 'BA', '2.0', 'Drums', '1971', 'Oxford', 'Worked at Elec Lady Studios', 'Yoko', 0, 0, '', 'MS', 0);
INSERT INTO `application` VALUES(3,33333333, 0,'paulM@gwu.edu', '100', '600', '2018', '100', 'English', '2019',
                               '100', '2014', '', '', '', '', '', 'BA', '4.0', 'Sound Engin.', '1972', 'Abbey Rd Uni', 'Worked at Elec Lady Studios', 'Yoko', 0, 0, '', 'MS', 0);

INSERT INTO reviewer_application VALUES(10000002,66666666,0);
INSERT INTO reviewer_application VALUES(10000003,55555555,0);
INSERT INTO reviewer_application VALUES(10000004,33333333,0);

INSERT INTO users (id, p_level, password) VALUES (55555555, 'Applicant', 'password');
INSERT INTO users (id, p_level, password) VALUES (66666666, 'Applicant', 'password');
INSERT INTO users (id, p_level, password) VALUES (33333333, 'Applicant', 'password');
INSERT INTO users (id, p_level, password) VALUES (98765432, 'CAC', 'cac123');

INSERT INTO recommender VALUES('Eric','Clapton',66666666,'looks like a great applicant');
INSERT INTO recommender VALUES('Eric','Clapton',55555555,'not so sure - gpa is very low from bachelor degree');
INSERT INTO recommender VALUES('Eric','Clapton',33333333,'absolutely');

SET FOREIGN_KEY_CHECKS = 1;
/*
  ┌─┐  ─┐
　│▒│ /▒/
　│▒│/▒/
　│▒ /▒/─┬─┐
　│▒│▒|▒│▒│
┌┴─┴─┐-┘─┘
│▒┌──┘▒▒▒│
└┐▒▒▒▒▒▒┌┘
 └┐▒▒▒▒┌
*/
