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

INSERT INTO student (u_id, fname, lname, addr, email, major) VALUES (88888888, 'Billie', 'Holiday', '11111 Street St. City, ST 22222', 'jacobpritchard9@gwu.edu', 'Computer Science');
INSERT INTO student (u_id, fname, lname, addr, email, major) VALUES (99999999, 'Diana', 'Krall', '33333 Drive Dr. City, ST 44444', 'jumina@gwu.edu', 'Computer Science');

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


/* -----------------------------------------------------------------------------

                            ╔══════════════╗
----------------------------    APPS SQL    ------------------------------------
                            ╚══════════════╝

--------------------------------------------------------------------------------
*/

drop table if exists applicant cascade;
drop table if exists application cascade;
drop table if exists reviewer_application cascade;
drop table if exists reccomender cascade;

CREATE TABLE `applicant` (
  `username` int(8) PRIMARY KEY,
  `fname` varchar(255),
  `lname` varchar(255),
  `ssn` int(9),
  `address` varchar(255)
);

CREATE TABLE `application` (
  `applicationID` int UNIQUE PRIMARY KEY AUTO_INCREMENT,
  `username` int(8),
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
  `final_decision` varchar(255) /*accept/reject/accept with aid*/
);

CREATE TABLE `reviewer_application` (
  `username` int(8) PRIMARY KEY,
  `applicantid` int,
  `status` int
);

CREATE TABLE `reccomender` (
  `applicationID` int PRIMARY KEY,
  `email` varchar(255),
  `reccomendation` VARCHAR(10000)
);

ALTER TABLE `application` ADD FOREIGN KEY (`username`) REFERENCES `applicant` (`username`) ON DELETE CASCADE;
ALTER TABLE `reviewer_application` ADD FOREIGN KEY (`username`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `reviewer_application` ADD FOREIGN KEY (`applicantid`) REFERENCES `application` (`username`);
ALTER TABLE `applicant` ADD FOREIGN KEY (`username`) REFERENCES `users` (`id`) ON DELETE CASCADE;
ALTER TABLE `reccomender` ADD FOREIGN KEY (`applicationID`) REFERENCES `application` (`applicationID`);

INSERT INTO applicant VALUES(55555555, 'John', 'Lennon', 111111111, '123 Fairy Tale Lane');
INSERT INTO applicant VALUES(66666666, 'Ringo', 'Starr', 222111111, '321 Penny Lane');
INSERT INTO applicant VALUES(33333333, 'Paul', 'McCartney', 333333333, '542 Abbey Road');

INSERT INTO `application` VALUES(1,66666666, 0,'lovesYoko@gwu.edu', '100', '600', '2018', '100', 'English', '2019', 
                               '100', '2014', '', '', '', '', '', 'BA', '3.4', 'Music', '1970', 'Cambridge', 'Worked at Elec Lady Studios', 'Yoko', 0, 0, '', 'MS', '');
INSERT INTO `application` VALUES(2,55555555, 0,'bestBeatle@gwu.edu', '100', '600', '2018', '100', 'English', '2019', 
                               '100', '2014', '', '', '', '', '', 'BA', '2.0', 'Drums', '1971', 'Oxford', 'Worked at Elec Lady Studios', 'Yoko', 0, 0, '', 'MS', '');
INSERT INTO `application` VALUES(3,33333333, 0,'paulM@gwu.edu', '100', '600', '2018', '100', 'English', '2019', 
                               '100', '2014', '', '', '', '', '', 'BA', '4.0', 'Sound Engin.', '1972', 'Abbey Rd Uni', 'Worked at Elec Lady Studios', 'Yoko', 0, 0, '', 'MS', '');

INSERT INTO reviewer_application VALUES(10000002,1,0);
INSERT INTO reviewer_application VALUES(10000003,2,0);
INSERT INTO reviewer_application VALUES(10000004,3,0);

INSERT INTO users (id, p_level, password) VALUES (55555555, 'Applicant', 'password');
INSERT INTO users (id, p_level, password) VALUES (66666666, 'Applicant', 'password');
INSERT INTO users (id, p_level, password) VALUES (33333333, 'Applicant', 'password');

INSERT INTO reccomender VALUES(1,'wdaughtridge@gwu.edu','looks like a great applicant');
INSERT INTO reccomender VALUES(2,'wdaughtridge@gwu.edu','not so sure - gpa is very low from bachelor degree');
INSERT INTO reccomender VALUES(3,'wdaughtridge@gwu.edu','absolutely');

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
