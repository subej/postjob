insert into UNIVERSITY  values (00001, 'University of Toronto', 27, 'Kings College Circle', Toronto, Ontario, M5S1A1);
insert into UNIVERSITY  values (00002, 'The University of British Columbia', 2329 , 'West Mall', Vancouver, 'British Columbia', V6T1Z4);
insert into UNIVERSITY  values (00003, 'University of Alberta', 116, 'St. and 85 Ave.', Edmonton, Alberta, T6G2R3);
insert into UNIVERSITY  values (00004, 'Simon Fraser University', 8888, 'University Drive', 'Burnaby, British Columbia', V5A1S6);


INSERT INTO `university` (`u_id`, `Name`, `StreetNumber`, `StreetName`, `City`, `Province`, `PostalCode`) VALUES
(1, 'University of Toronto', '27', 'Kings College Circle', 'Toronto', 'Ontario', 'M5S1A1'),
(2, 'The University of British Columbia', '2329', 'West Mall', 'Vancouver', 'British Columbia', 'V6T1Z4'),
(3, 'University of Alberta', '116', 'St. and 85 Ave.', 'Edmonton', 'Alberta', 'T6G2R3'),
(4, 'Simon Fraser University', '8888', 'University Drive', 'Burnaby', 'British Columbia', 'V5A1S6'),
(5, 'McGill University', '845', 'Sherbrooke Street West', 'Montreal', 'Quebec', 'H3A2T5');


insert into STUDENT_STUDIES  values(52161314, 00002, 'Apple', 'Juice', 'Science', 3, 'CPSC', 'Andy91', 'addm5678');
insert into STUDENT_STUDIES  values(54657524, 00002, 'Doge', 'Cate', 'Science', 3, 'CPSC', 'Doggy', 'Hipbone234');
insert into STUDENT_STUDIES  values(15125124, 00003, 'Sing', 'Ice', 'Science', 4, 'Chemistry','h2o2', '14235ICE');
insert into STUDENT_STUDIES  values(67845663, 00005, 'Bobby', 'Wane', 'Arts', 3, 'Econ', 'BWbw1123', 'bmesj43');
insert into STUDENT_STUDIES  values(77889922, 00001, 'Hasf', 'Esdge', 'Science', 1, 'Math', 'HappyEnd', 'asd23142');
insert into STUDENT_STUDIES  values(17889922, 00001, 'BROWN', 'JOHN', 'Science', 5, 'Math', 'bjohn', 'asd236989');


insert into GRAD  values (17889922, 'bachelor of math');


insert into UGRAD  values(52161314, 'CPSC');
insert into UGRAD  values(54657524, 'CPSC');
insert into UGRAD  values(15125124, 'Chemistry');
insert into UGRAD  values(67845663, 'Econ');
insert into UGRAD  values(77889922, 'Math');

insert into STUDENT_SIGNS values (52151333, 42357, 2014-6-1);
insert into STUDENT_SIGNS values(15125124, 14273, 2014-6-1);
insert into STUDENT_SIGNS values(67845663,89032,2014-6-1);

insert into CONTRACT values(42357, 2500, 'Valid', 'SUMMER OFFER');
insert into CONTRACT values(14273, 3500, 'Valid', 'COOP 1 YEAR');
insert into CONTRACT values(23647, 2500, 'Valid', 'FULL TIME');
insert into CONTRACT values(89032, 5000, 'Inval', 'COOP 4 MONTH');
insert into CONTRACT values(73456, 4000, 'Inval', 'FULL TIME');
 
insert into PROFILE_CREATES values (52161314, 0013, 2012-3-25, 'worked 3 years as TA', 'cpsc student');
insert into PROFILE_CREATES values (54657524, 0035, 2013-8-17, 'None','cpsc student');
insert into PROFILE_CREATES values (17889922, 0045, 2014-5-28, 'None', 'Grad student, bachelor of math');

insert into JOB_POSTING values (0137, 42357,1,'Vancouver', 2012-2-27);
insert into JOB_POSTING values (0248, 14273,2,'New York', 2014-3-17);
insert into JOB_POSTING values (0569,23647,3,'Vancouver', 2014-5-03);
insert into JOB_POSTING values (0178,89032,4,'Toronto', 2013-7-15); 



insert into COMPANY values(1, 'Wal-Mart Stores', 702, 'Sw 8th St, Bentonville', 'AR', '72716', '0361', 'WalMart001', 'mwad24232');
insert into COMPANY values(2, 'Phillips 66 Company', 301, 'Briarpark Dr','Houston', 'TX', '0241', 'PhilliO', '24hrs423');
insert into COMPANY values(3, 'AT&T Inc', 208, 'S Akard St', 'Dallas', 'TX', '1423', 'AT005', 'safgdf');
insert into COMPANY values(4, 'GDF SUEZ', 1, 'Place Samuel De Champlain',  'Courbevoie', '00000000', '1532', 'GGGD1', '1HRRR423');
insert into COMPANY values(5, 'Unipec Asia Company Limited', 1202,  '12/F Convention Plz Office Twr', 'Hong Kong', '999077', '1274', 'UACL001', 'Lxc42324');

insert into APPLIES values (52161314, 2, 0248, 65234);
insert into APPLIES values(54657524, 2, 0248, 34234);
insert into APPLIES values(15125124, 1, 0137, 53143);
insert into APPLIES values(67845663, 3, 0569, 50192);
insert into APPLIES values(17889922, 2, 0248, 14234);



///// generated code

INSERT INTO `student_studies` (`s_id`, `u_id`, `FirstName`, `LastName`, `Faculty`, `Year`, `Major`, `Username`, `Password`) VALUES
(15125124, 3, 'Sing', 'Ice', 'Science', 4, 'Chemistry', 'h2o2', '14235ICE'),
(52161314, 2, 'Apple', 'Juice', 'Science', 3, 'CPSC', 'Andy91', 'addm5678'),
(54657524, 2, 'Doge', 'Cate', 'Science', 3, 'CPSC', 'Doggy', 'Hipbone234'),
(67845663, 5, 'Bobby', 'Wane', 'Arts', 3, 'Econ', 'BWbw1123', 'bmesj43'),
(77889922, 1, 'Hasf', 'Esdge', 'Science', 1, 'Math', 'HappyEnd', 'asd23142');

INSERT INTO `university` (`u_id`, `Name`, `StreetNumber`, `StreetName`, `City`, `Province`, `PostalCode`) VALUES
(1, 'University of Toronto', '27', 'Kings College Circle', 'Toronto', 'Ontario', 'M5S1A1'),
(2, 'The University of British Columbia', '2329', 'West Mall', 'Vancouver', 'British Columbia', 'V6T1Z4'),
(3, 'University of Alberta', '116', 'St. and 85 Ave.', 'Edmonton', 'Alberta', 'T6G2R3'),
(4, 'Simon Fraser University', '8888', 'University Drive', 'Burnaby', 'British Columbia', 'V5A1S6'),
(5, 'McGill University', '845', 'Sherbrooke Street West', 'Montreal', 'Quebec', 'H3A2T5');

INSERT INTO `grad` (`s_id`, `Honours`) VALUES
(17889922, 'bachelor of math');


INSERT INTO `ugrad` (`s_id`, `Program`) VALUES
(15125124, 'Chemistry'),
(52161314, 'cpsc'),
(54657524, 'cpsc'),
(67845663, 'Econ'),
(77889922, 'Math');

INSERT INTO `contract` (`c_id`, `Salary`, `Status`, `TimePeriod`) VALUES
(14273, 3500, 'Valid', 'COOP 1 YEAR'),
(23647, 2500, 'Valid', 'FULL TIME'),
(42357, 2500, 'Valid', 'SUMMER OFFER'),
(73456, 4000, 'Inval', 'FULL TIME'),
(89032, 5000, 'Inval', 'COOP 4 MONTH');

INSERT INTO `student_signs` (`s_id`, `c_id`, `s_date`) VALUES
(15125124, 14273, '0000-00-00'),
(52151333, 42357, '0000-00-00'),
(67845663, 89032, '0000-00-00');

INSERT INTO `profile_creates` (`s_id`, `p_id`, `p_date`, `Experience`, `Education`) VALUES
(17889922, 45, '0000-00-00', 'None', 'Grad student, bachel'),
(52161314, 13, '0000-00-00', 'worked 3 years as TA', 'cpsc student'),
(54657524, 35, '0000-00-00', 'None', 'cpsc student');

INSERT INTO `job_posting` (`j_id`, `c_id`, `co_id`, `Position`, `DatePosted`) VALUES
(137, 42357, 1, 'Vancouver', '0000-00-00'),
(178, 89032, 4, 'Toronto', '0000-00-00'),
(248, 14273, 2, 'New York', '0000-00-00'),
(569, 23647, 3, 'Vancouver', '0000-00-00');

INSERT INTO `company` (`co_id`, `Name`, `StreetNumber`, `StreetName`, `City`, `Province`, `PostalCode`, `Username`, `Password`) VALUES
(1, 'Wal-Mart Stores', 702, 'Sw 8th St, Bentonvil', 'AR', '72716', '0361', 'WalMart001', 'mwad24232'),
(2, 'Phillips 66 Company', 301, 'Briarpark Dr', 'Houston', 'TX', '0241', 'PhilliO', '24hrs423'),
(3, 'AT&T Inc', 208, 'S Akard St', 'Dallas', 'TX', '1423', 'AT005', 'safgdf'),
(4, 'GDF SUEZ', 1, 'Place Samuel De Cham', 'Courbevoie', '00000000', '1532', 'GGGD1', '1HRRR423'),
(5, 'Unipec Asia Company', 1202, '12/F Convention Plz', 'Hong Kong', '999077', '1274', 'UACL001', 'Lxc42324');


INSERT INTO `applies` (`s_id`, `co_id`, `j_id`, `ApplicationN`) VALUES
(15125124, 1, 137, 53143),
(17889922, 2, 248, 14234),
(52161314, 2, 248, 65234),
(54657524, 2, 248, 34234),
(67845663, 3, 569, 50192);







