
set Foreign_key_checks=0;
drop table if exists UNIVERSITY cascade;
drop table if exists STUDENT_STUDIES cascade;
drop table if exists GRAD cascade;
drop table if exists UGRAD cascade;
drop table if exists CONTRACT cascade;
drop table if exists STUDENT_SIGNS cascade;
drop table if exists PROFILE_CREATES cascade;
drop table if exists COMPANY cascade;
drop table if exists JOB_POSTING cascade;
drop table if exists APPLIES cascade;



Create table UNIVERSITY (
	u_id integer,
	Name char(40),
	StreetNumber char(10),
	StreetName char(40),
	City char(40),
	Province char(40),
	PostalCode char(10),
		PRIMARY KEY (u_id));


CREATE TABLE STUDENT_STUDIES (
	s_id Integer,
	u_id Integer,
	FirstName Char(20),
	LastName Char(20),
	Faculty Char(20),
	Year Integer,
	Major Char(20),
		PRIMARY KEY (s_id),
	Username Char(10) Unique,
	Password Char(10),
		FOREIGN KEY (u_id) REFERENCES UNIVERSITY(u_id) ON DELETE CASCADE);

CREATE TABLE GRAD (
	s_id Integer,
        Honours Char(20),
        	PRIMARY KEY (s_id),
	        FOREIGN KEY (s_id) references STUDENT_STUDIES(s_id) ON DELETE CASCADE);

CREATE TABLE UGRAD (
	s_id Integer,
        Program Char(20),
	        PRIMARY KEY (s_id),
	        FOREIGN KEY (s_id) references STUDENT_STUDIES(s_id) ON DELETE CASCADE);

CREATE TABLE CONTRACT (
	c_id Integer,
	Salary Float,
	Status Char(20),
	TimePeriod Char(16),
		PRIMARY KEY (c_id));


CREATE TABLE STUDENT_SIGNS (
	s_id Integer,
	c_id Integer UNIQUE,
	s_date date,
		PRIMARY KEY (s_id),
		FOREIGN KEY (c_id) references CONTRACT(c_id));


CREATE TABLE PROFILE_CREATES (
	s_id Integer,
	p_id Integer,
	p_date date,
	Experience Char(20),
	Education Char(20),
		PRIMARY KEY (s_id, p_id),
		FOREIGN KEY (s_id) references STUDENT_STUDIES(s_id) 
			ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE COMPANY(
	co_id Integer,
	Name Char(20),
	StreetNumber Integer,
	StreetName Char(20),
	City Char(20),
	Province Char(20),
	PostalCode Char(10),
	Username Char(10) Unique,
	Password Char(10),
		PRIMARY KEY (co_id)
);


CREATE TABLE JOB_POSTING (
	j_id Integer,
	c_id Integer NOT NULL,
	co_id Integer NOT NULL,
	Position Char(20),
	DatePosted date,
		PRIMARY KEY(j_id),
		FOREIGN KEY (c_id) REFERENCES CONTRACT(c_id),
		FOREIGN KEY (co_id) REFERENCES COMPANY(co_id));


CREATE TABLE APPLIES (
	s_id Integer,
	co_id Integer,
	j_id Integer,
	ApplicationN Integer,
	Status Char(20),
		PRIMARY KEY (s_id, co_id, j_id),
		FOREIGN KEY (s_id) REFERENCES STUDENT_STUDIES(s_id),
		FOREIGN KEY (co_id) REFERENCES COMPANY(co_id),
		FOREIGN KEY (j_id) REFERENCES JOB_POSTING(j_id));

set Foreign_key_checks=1;

insert into UNIVERSITY  values (00001, 'University of Toronto', '27', 'Kings College Circle', 'Toronto', 'Ontario', 'M5S1A1');
insert into UNIVERSITY  values (00002, 'The University of British Columbia', '2329' , 'West Mall', 'Vancouver', 'British Columbia', 'V6T1Z4');
insert into UNIVERSITY  values (00003, 'University of Alberta', '116', 'St. and 85 Ave.', 'Edmonton', 'Alberta', 'T6G2R3');
insert into UNIVERSITY  values (00004, 'Simon Fraser University', '8888', 'University Drive', 'Burnaby', 'British Columbia', 'V5A1S6');
insert into UNIVERSITY  values (00005, 'McGill Universit', '4235', 'McGill Drive', 'Montreal', 'Quebec', 'AD9U9S');

insert into STUDENT_STUDIES  values(52151333, 00002, 'Apple', 'Juice', 'Science', 3, 'CPSC', 'Andy91', 'addm5678');
insert into STUDENT_STUDIES  values(54657524, 00002, 'Doge', 'Cate', 'Science', 3, 'CPSC', 'Doggy', 'Hipbone234');
insert into STUDENT_STUDIES  values(15125124, 00003, 'Sing', 'Ice', 'Science', 4, 'CHEM','h2o2', '14235ICE');
insert into STUDENT_STUDIES  values(67845663, 00004, 'Bobby', 'Wane', 'Arts', 3, 'PSYC', 'BWbw1123', 'bmesj43');
insert into STUDENT_STUDIES  values(77889922, 00003, 'Hasf', 'Esdge', 'Science', 1, 'MATH', 'HappyEnd', 'asd23142');
insert into STUDENT_STUDIES  values(17889922, 00002, 'BROWN', 'JOHN', 'Science', 5, 'PHYS', 'bjohn', 'asd236989');
insert into STUDENT_STUDIES  values(87493829, 00005, 'Fellow', 'Art', 'Arts', 2, 'ENGL', 'foo', 'bar');
insert into STUDENT_STUDIES  values(17880983, 00002, 'Henning', 'Jenny', 'Arts', 3, 'ECON', 'bar', 'foo');
insert into STUDENT_STUDIES  values(17880394, 00003, 'Wayne', 'Bruce', 'Science', 1, 'CHEM', 'notbatman', 'batman');
insert into STUDENT_STUDIES  values(17889834, 00004, 'Birdman', 'Harvey', 'Arts', 4, 'MATH', 'Attorney', 'atlaw');
insert into STUDENT_STUDIES  values(17889384, 00002, 'Banks', 'Julian', 'Arts', 1, 'PSYC', 'Sig', 'freud');
insert into STUDENT_STUDIES  values(17889325, 00001, 'Vader', 'Darth', 'Arts', 4, 'ENGL', 'Dark5ide', 'choketime');
insert into STUDENT_STUDIES  values(17880934, 00003, 'Commander', 'Cobra', 'Science', 2, 'BIOL', 'ComeForYou', 'gijoe');

insert into STUDENT_STUDIES  values(17889923, 00001, 'TYLER', 'DURDEN', 'Science', 5, 'CPSC', 'TYLER', 'DURDEN');
insert into STUDENT_STUDIES  values(17889933, 00001, 'KUMMER', 'ANNA', 'Science', 5, 'CPSC', 'KUMMER', 'ANNA');
insert into STUDENT_STUDIES  values(17889944, 00001, 'MEI', 'LI', 'Science', 5, 'MATH', 'APPLE', 'asd');
insert into STUDENT_STUDIES  values(17889955, 00001, 'MIKE', 'WHITE', 'Science', 5, 'CPSC', 'LEMON', '123456');
insert into STUDENT_STUDIES  values(17889966, 00001, 'BRANDON', 'SHAW', 'Science', 5, 'MATH', 'UBC', '109');

INSERT INTO GRAD VALUES(17889922, 'Bachelors in MATH');
INSERT INTO GRAD VALUES(17889933, 'Bachelors in CPSC');
INSERT INTO GRAD VALUES(17889944, 'Bachelors in MATH');
INSERT INTO GRAD VALUES(17889955, 'Bachelors in CPSC');
INSERT INTO GRAD VALUES(17889966, 'Bachelors in MATH');

INSERT INTO UGRAD VALUES(15125124, 'CHEM');
INSERT INTO UGRAD VALUES(52151333, 'CPSC');
INSERT INTO UGRAD VALUES(54657524, 'CPSC');
INSERT INTO UGRAD VALUES(67845663, 'ECON');
INSERT INTO UGRAD VALUES(77889922, 'PHYS');
INSERT INTO UGRAD VALUES(87493829, 'ENGL');
INSERT INTO UGRAD VALUES(17880983, 'ECON');
INSERT INTO UGRAD VALUES(17880394, 'CHEM');
INSERT INTO UGRAD VALUES(17889834, 'MATH');
INSERT INTO UGRAD VALUES(17889384, 'PSYC');
INSERT INTO UGRAD VALUES(17889325, 'ENGL');
INSERT INTO UGRAD VALUES(17880934, 'BIOL');

insert into CONTRACT values(42357, 2500, 'Valid', 'SUMMER OFFER');
insert into CONTRACT values(14273, 3500, 'Valid', 'COOP 1 YEAR');
insert into CONTRACT values(23647, 2500, 'Valid', 'FULL TIME');
insert into CONTRACT values(89032, 5000, 'Valid', 'COOP 4 MONTH');
insert into CONTRACT values(73456, 4000, 'Valid', 'FULL TIME');
insert into CONTRACT values(14325, 2500, 'Valid', 'SUMMER OFFER');
insert into CONTRACT values(90678, 3500, 'Valid', 'COOP 1 YEAR');
insert into CONTRACT values(03942, 2500, 'Valid', 'FULL TIME');
insert into CONTRACT values(57382, 5000, 'Inval', 'COOP 4 MONTH');
insert into CONTRACT values(09452, 4000, 'Inval', 'FULL TIME');
insert into CONTRACT values(38472, 2500, 'Valid', 'SUMMER OFFER');
insert into CONTRACT values(23453, 3500, 'Valid', 'COOP 1 YEAR');
insert into CONTRACT values(32459, 2500, 'Valid', 'FULL TIME');
insert into CONTRACT values(03948, 5000, 'Valid', 'COOP 4 MONTH');
insert into CONTRACT values(34590, 4000, 'Valid', 'FULL TIME');
insert into CONTRACT values(34540, 2500, 'Valid', 'SUMMER OFFER');
insert into CONTRACT values(34593, 3500, 'Valid', 'COOP 1 YEAR');
insert into CONTRACT values(98093, 2500, 'Valid', 'FULL TIME');
insert into CONTRACT values(55345, 5000, 'Inval', 'COOP 4 MONTH');
insert into CONTRACT values(02344, 4000, 'Inval', 'FULL TIME');

insert into STUDENT_SIGNS values (52151333, 42357, '2008-7-04');
insert into STUDENT_SIGNS values(15125124, 14273, '2014-06-10');
insert into STUDENT_SIGNS values(67845663,89032,'2014-06-10');
insert into STUDENT_SIGNS values (17889325, 73456, '2008-7-04');
insert into STUDENT_SIGNS values(17889944, 03942, '2014-06-10');
insert into STUDENT_SIGNS values(17880934, 23647, '2014-06-10');


insert into PROFILE_CREATES values (52151333, 0013, '2012-03-25', 'Worked 3 years as TA', 'AA');
insert into PROFILE_CREATES values (15125124, 0035, '2013-08-17', 'None','HS');
insert into PROFILE_CREATES values (67845663, 0045, '2014-05-28', 'None', 'HS');
insert into PROFILE_CREATES values (17889325, 0027, '2012-03-25', 'Worked 1 year as TA', 'BA');
insert into PROFILE_CREATES values (17889944, 0333, '2013-09-07', 'Worked as assistant','BS');
insert into PROFILE_CREATES values (17889922, 0025, '2014-06-18', 'Worked as assistant', 'HS');
insert into PROFILE_CREATES values (87493829, 0123, '2012-05-22', 'Worked 2 years as TA', 'BA');
insert into PROFILE_CREATES values (17889966, 0135, '2013-08-01', 'Worked as assistant','AA');
insert into PROFILE_CREATES values (17889955, 0445, '2014-05-25', 'None', 'AA');
insert into PROFILE_CREATES values (54657524, 0213, '2013-01-15', 'Worked 2 years as TA', 'AA');


insert into COMPANY values(1, 'Wal-Mart Stores', 702, 'Sw 8th St', 'Bentonville', 'AR', '0361', 'WalMart001', 'mwad24232');
insert into COMPANY values(2, 'Phillips 66 Company', 301, 'Briarpark Dr','Houston', 'TX', '0241', 'PhilliO', '24hrs423');
insert into COMPANY values(3, 'AT&T Inc', 208, 'S Akard St', 'Dallas', 'TX', '1423', 'AT005', 'safgdf');
insert into COMPANY values(4, 'GDF SUEZ', 1, 'Place De Champlain',  'Courbevoie', 'WI', '1532', 'GGGD1', '1HRRR423');
insert into COMPANY values(5, 'Unipec Asia Ld', 1202,  'Convention Plz', 'Hong Kong', '999077', '1274', 'UACL001', 'Lxc42324');
insert into COMPANY values(6, 'Facebook Inc', 324,  'Facebook St.', 'Palo Alto', 'CA', '1274', 'FB4ME', 'facebook');

insert into JOB_POSTING values (0137, 42357,1,'Developer', '2012-02-27');
insert into JOB_POSTING values (0248, 14273,1,'Developer', '2014-03-17');
insert into JOB_POSTING values (0569, 23647,1,'Engineer', '2014-05-03');
insert into JOB_POSTING values (0134, 89032,2,'Engineer', '2013-07-15'); 
insert into JOB_POSTING values (0139, 73456,2,'Analyst', '2013-04-27');
insert into JOB_POSTING values (5248, 14325,2,'Analyst', '2014-02-27');
insert into JOB_POSTING values (0534, 90678,3,'Engineer', '2014-07-12');
insert into JOB_POSTING values (0778, 03942,3,'Developer', '2013-12-13'); 
insert into JOB_POSTING values (0230, 57382,3,'Analyst', '2012-11-20');
insert into JOB_POSTING values (9248, 09452,4,'Actuary', '2014-05-07');
insert into JOB_POSTING values (0567, 38472,4,'Developer', '2014-08-09');
insert into JOB_POSTING values (0178, 23453,4,'Analyst', '2013-02-04'); 
insert into JOB_POSTING values (0117, 32459,5,'Developer', '2012-01-23');
insert into JOB_POSTING values (0341, 03948,5,'Developer', '2014-01-19');
insert into JOB_POSTING values (2343, 34590,5,'Assistant', '2014-09-12');
insert into JOB_POSTING values (0241, 34540,6,'Assistant', '2013-06-12'); 
insert into JOB_POSTING values (0345, 34593,6,'Developer', '2012-03-21');
insert into JOB_POSTING values (3923, 98093,6,'Developer', '2014-04-13');
insert into JOB_POSTING values (0989, 55345,1,'Engineer', '2014-06-03');
insert into JOB_POSTING values (0909, 02344,2,'Engineer', '2013-10-10'); 

insert into APPLIES values(52151333, 1, 0137, 65234, '-/-');
insert into APPLIES values(54657524, 1, 0248, 34234,'O/A');
insert into APPLIES values(15125124, 1, 0569, 53143, 'O/A');
insert into APPLIES values(67845663, 2, 0178, 50192,'O/-');
insert into APPLIES values(17889922, 2, 0139, 14234,'O/-');
insert into APPLIES values(17889325, 2, 5248, 23453, '-/-');
insert into APPLIES values(87493829, 3, 0534, 53464,'O/A');
insert into APPLIES values(15125124, 3, 0778, 56345, 'O/A');
insert into APPLIES values(17889922, 3, 0230, 50765,'O/-');
insert into APPLIES values(17889922, 4, 9248, 13454,'-/-');
insert into APPLIES values(52151333, 4, 0567, 61234, 'O/-');
insert into APPLIES values(54657524, 4, 0178, 36555,'O/A');
insert into APPLIES values(15125124, 5, 0117, 56666, 'O/A');
insert into APPLIES values(17889955, 5, 2343, 53453,'-/-');
insert into APPLIES values(17889955, 6, 0241, 14223,'O/-');