set foreign_key_checks = 0;

drop table if exists applicant cascade;
drop table if exists `application` cascade;
drop table if exists user cascade;
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

CREATE TABLE `user` (
  `username` int(8) PRIMARY KEY,
  `password` varchar(255),
  `permission` int, /*1=applicant, 2=reviewer. 3=CAC/GS */
  `fname` varchar(255),
  `lname` varchar(255)
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

ALTER TABLE `reviewer_application` ADD FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE;

ALTER TABLE `reviewer_application` ADD FOREIGN KEY (`applicantid`) REFERENCES `application` (`username`);

ALTER TABLE `applicant` ADD FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE;

ALTER TABLE `reccomender` ADD FOREIGN KEY (`applicationID`) REFERENCES `application` (`applicationID`);

set foreign_key_checks = 1;

INSERT INTO user VALUES (10000000,'sysadmin',4,'Sys','Admin');
INSERT INTO user VALUES (55555555, 'password', 1, 'John', 'Lennon');
INSERT INTO user VALUES (66666666, 'password', 1, 'Ringo', 'Starr');
INSERT INTO user VALUES (77777777, 'password', 2, 'Bhagirath', 'Narahari');
INSERT INTO user VALUES (88888888, 'password', 3, 'John', 'Doe');
INSERT INTO applicant VALUES(55555555, 'John', 'Lennon', 111111111, '123 Fairy Tale Lane');
INSERT INTO applicant VALUES(66666666, 'Ringo', 'Starr', '222111111', '321 Fairy Tale Lane');
INSERT INTO application VALUES(1,66666666, 0,'someone@gwu.edu', 100, 100, "", 100, "", "", 100, "", 100, "", "", 1000, "", 100, "", "", 1000, "",'Worked at IBM', "", 0, 0, '', 'Masters', '');
INSERT INTO application VALUES(2,55555555, 0,'someone@gwu.edu', 100, 100, "", 100, "", "", 100, "", 100, "", "", 1000, "", 100, "", "", 1000, "", 'none', "", 1, 0, '', 'Doctorate', '');


/*INSERT INTO user VALUES ('nlyles', '123456', 1, 'Noah', 'Lyles');
INSERT INTO user VALUES ('yblake', '1234567', 1, 'Yohan', 'Blake');
INSERT INTO user VALUES ('ubolt', '12345678', 1, 'Usain', 'Bolt');
INSERT INTO user VALUES ('reviewer1', '12345678', 2, 'Will', 'D');

INSERT INTO applicant VALUES ('nlyles', 'Noah', 'Lyles', 111111111, '1 abc st');
INSERT INTO applicant VALUES ('yblake', 'Yohan', 'Blake', 222222222, '2 abc st');
INSERT INTO applicant VALUES ('ubolt', 'Usain', 'Bolt', 333333333, '3 abc st');

INSERT INTO application VALUES (1, 'nlyles', 1000, 10000, 150, 5, 100000, 0, 0, 'PhD');
INSERT INTO application VALUES (2, 'yblake', 1001, 10001, 140, 4, 100001, 0, 0, 'MS');
INSERT INTO application VALUES (3, 'ubolt', 1002, 10002, 160, 6, 100002, 0, 0, 'PhD');*/ /*added some data for testing*/

/*INSERT INTO reviewer_application VALUES ('reviewer1','nlyles',1);*/
