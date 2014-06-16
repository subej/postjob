
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



Create table UNIVERSITY (u_id integer,
Name char(40),
StreetNumber char(10),
StreetName char(40),
City char(40),
Province char(40),
PostalCode char(10),
PRIMARY KEY (u_id));


CREATE TABLE STUDENT_STUDIES (s_id Integer,
u_id Integer,
FirstName Char(20),
LastName Char(20),
Faculty Char(20),
Year Integer,
Major Char(20),
PRIMARY KEY (s_id),
Username Char(10) Unique,
Password Char(10),
FOREIGN KEY (u_id) REFERENCES UNIVERSITY(u_id));

CREATE TABLE GRAD (s_id Integer,
          Honours Char(20),
          PRIMARY KEY (s_id),
          foreign key (s_id) references STUDENT_STUDIES(s_id) ON DELETE CASCADE);

CREATE TABLE UGRAD (s_id Integer,

          Program Char(20),

          PRIMARY KEY (s_id),

          foreign key (s_id) references STUDENT_STUDIES(s_id)
ON DELETE CASCADE)
;

CREATE TABLE CONTRACT (c_id Integer,

Salary Float,

  Status Char(20),

TimePeriod Char(16),

PRIMARY KEY (c_id))
;


CREATE TABLE STUDENT_SIGNS (s_id Integer,

c_id Integer UNIQUE,

s_date date,

PRIMARY KEY (s_id),

foreign key (c_id) references CONTRACT(c_id))
;


CREATE TABLE PROFILE_CREATES (s_id Integer,
p_id Integer,
p_date date,

Experience Char(20),

Education Char(20),

PRIMARY KEY (s_id, p_id),
Foreign key (s_id) references STUDENT_STUDIES(s_id)
 ON DELETE CASCADE)
;

CREATE TABLE COMPANY
(co_id Integer,

Name Char(20),

   StreetNumber Integer,

StreetName Char(20),
City Char(20),

Province Char(20),

 PostalCode Char(10),
Username Char(10) Unique,

Password Char(10),

PRIMARY KEY (co_id)
)
;


CREATE TABLE JOB_POSTING (j_id Integer,

c_id Integer NOT NULL,

co_id Integer NOT NULL,

Position Char(20),

DatePosted date,

PRIMARY KEY(j_id),

FOREIGN KEY (c_id) REFERENCES CONTRACT(c_id),

FOREIGN KEY (co_id) REFERENCES COMPANY(co_id))
;


CREATE TABLE APPLIES (s_id Integer,

co_id Integer,

 j_id Integer,

ApplicationN Integer,

PRIMARY KEY (s_id, co_id, j_id),

FOREIGN KEY (s_id) REFERENCES STUDENT_STUDIES(s_id),

FOREIGN KEY (co_id) REFERENCES COMPANY(co_id),
FOREIGN KEY (j_id) REFERENCES JOB_POSTING(j_id))

;
set Foreign_key_checks=1;

insert into UNIVERSITY  values (00001, 'University of Toronto', '27', 'Kings College Circle', 'Toronto', 'Ontario', 'M5S1A1');
insert into UNIVERSITY  values (00002, 'The University of British Columbia', '2329' , 'West Mall', 'Vancouver', 'British Columbia', 'V6T1Z4');
insert into UNIVERSITY  values (00003, 'University of Alberta', '116', 'St. and 85 Ave.', 'Edmonton', 'Alberta', 'T6G2R3');
insert into UNIVERSITY  values (00004, 'Simon Fraser University', '8888', 'University Drive', 'Burnaby', 'British Columbia', 'V5A1S6');

insert into STUDENT_STUDIES  values(52151333, 00002, 'Apple', 'Juice', 'Science', 3, 'CPSC', 'Andy91', 'addm5678');
insert into STUDENT_STUDIES  values(54657524, 00002, 'Doge', 'Cate', 'Science', 3, 'CPSC', 'Doggy', 'Hipbone234');
insert into STUDENT_STUDIES  values(15125124, 00003, 'Sing', 'Ice', 'Science', 4, 'Chemistry','h2o2', '14235ICE');
insert into STUDENT_STUDIES  values(67845663, 00004, 'Bobby', 'Wane', 'Arts', 3, 'Econ', 'BWbw1123', 'bmesj43');
insert into STUDENT_STUDIES  values(77889922, 00001, 'Hasf', 'Esdge', 'Science', 1, 'Math', 'HappyEnd', 'asd23142');
insert into STUDENT_STUDIES  values(17889922, 00001, 'BROWN', 'JOHN', 'Science', 5, 'Math', 'bjohn', 'asd236989');




insert into CONTRACT values(42357, 2500, 'Valid', 'SUMMER OFFER');
insert into CONTRACT values(14273, 3500, 'Valid', 'COOP 1 YEAR');
insert into CONTRACT values(23647, 2500, 'Valid', 'FULL TIME');
insert into CONTRACT values(89032, 5000, 'Inval', 'COOP 4 MONTH');
insert into CONTRACT values(73456, 4000, 'Inval', 'FULL TIME');

insert into STUDENT_SIGNS values (52151333, 42357, '2008-7-04');
insert into STUDENT_SIGNS values(15125124, 14273, '2014-06-10');
insert into STUDENT_SIGNS values(67845663,89032,'2014-06-10');

 
insert into PROFILE_CREATES values (52151333, 0013, '2012-03-25', 'worked 3 years as TA', 'cpsc student');
insert into PROFILE_CREATES values (54657524, 0035, '2013-08-17', 'None','cpsc student');
insert into PROFILE_CREATES values (17889922, 0045, '2014-05-28', 'None', 'Math');

insert into COMPANY values(1, 'Wal-Mart Stores', 702, 'Sw 8th St', 'Bentonville', 'AR', '0361', 'WalMart001', 'mwad24232');
insert into COMPANY values(2, 'Phillips 66 Company', 301, 'Briarpark Dr','Houston', 'TX', '0241', 'PhilliO', '24hrs423');
insert into COMPANY values(3, 'AT&T Inc', 208, 'S Akard St', 'Dallas', 'TX', '1423', 'AT005', 'safgdf');
insert into COMPANY values(4, 'GDF SUEZ', 1, 'Place De Champlain',  'Courbevoie', 'WI', '1532', 'GGGD1', '1HRRR423');
insert into COMPANY values(5, 'Unipec Asia Ld', 1202,  'Convention Plz', 'Hong Kong', '999077', '1274', 'UACL001', 'Lxc42324');

insert into JOB_POSTING values (0137, 42357,1,'Developer', '2012-02-27');
insert into JOB_POSTING values (0248, 14273,2,'Developer', '2014-03-17');
insert into JOB_POSTING values (0569,23647,3,'Engineer', '2014-05-03');
insert into JOB_POSTING values (0178,89032,4,'Engineer', '2013-07-15'); 



insert into APPLIES values(52151333, 2, 0248, 65234);
insert into APPLIES values(54657524, 2, 0248, 34234);
insert into APPLIES values(15125124, 1, 0137, 53143);
insert into APPLIES values(67845663, 3, 0569, 50192);
insert into APPLIES values(17889922, 2, 0248, 14234);
