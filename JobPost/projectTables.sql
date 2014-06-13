Create table UNIVERSITY (u_id  integer,
	  Name  char(40),
	  StreetNumber  char(10),
	  StreetName  char(40),
          City  char(40),
	  Province  char(40),
	  PostalCode  char(10),
	  PRIMARY KEY (u_id));


CREATE TABLE STUDENT_STUDIES (s_id  Integer,
	  u_id  Integer,
	  FirstName  Char(20),
	  LastName  Char(20),
	  Faculty  Char(20),
	  Year  Integer,
	  Major  Char(20),
	  PRIMARY KEY (s_id),
	  Username  Char(10) Unique,
	  Password  Char(10),
	  FOREIGN KEY  (u_id)  REFERENCES UNIVERSITY);

CREATE TABLE GRAD (s_id  Integer,
          Honours Char(20),
          PRIMARY KEY (s_id),
          foreign key (s_id) references STUDENT_STUDIES ON DELETE CASCADE);

CREATE TABLE UGRAD (s_id  Integer,

          Program Char(20),

          PRIMARY KEY (s_id),

          foreign key (s_id) references STUDENT_STUDIES
	ON DELETE CASCADE)
;

CREATE TABLE CONTRACT (c_id  Integer,

	  Salary Float,
	
  Status Char(20), 

	  TimePeriod Char(16),
	  
PRIMARY KEY (c_id))
;


CREATE TABLE STUDENT_SIGNS (s_id Integer,

	  c_id  Integer  UNIQUE,

	  s_date  date,

	  PRIMARY KEY (s_id),

	  foreign key (c_id) references CONTRACT)
;


CREATE TABLE PROFILE_CREATES (s_id   Integer,
	  p_id Integer,
	  p_date  date,

	  Experience Char(20),

	  Education  Char(20),

	  PRIMARY KEY (s_id, p_id),
	  Foreign key (s_id) references STUDENT_STUDIES
 ON DELETE CASCADE)
;

CREATE TABLE COMPANY
(co_id  Integer,
	  
Name  Char(20),

  	  StreetNumber  Integer,

	  StreetName   Char(20),
	  City  Char(20),

	  Province  Char(20),
	 
 PostalCode  Char(10),
	  Username  Char(10) Unique,
	  
Password  Char(10),
	  
PRIMARY KEY (co_id)
)
;


CREATE TABLE JOB_POSTING (j_id Integer,

	  c_id  Integer NOT NULL,
	  
co_id Integer  NOT NULL,

	  Position  Char(20),

	  DatePosted  date,
	  
PRIMARY KEY(j_id),

	  FOREIGN KEY (c_id) REFERENCES CONTRACT,

	  FOREIGN KEY (co_id) REFERENCES COMPANY)
;


CREATE TABLE APPLIES (s_id  Integer,

	  co_id  Integer,
	 
 j_id  Integer,

	  ApplicationN  Integer,

	  PRIMARY KEY (s_id, co_id, j_id),

	  FOREIGN KEY (s_id) REFERENCES STUDENT_STUDIES,

	  FOREIGN KEY (co_id) REFERENCES COMPANY,
	  FOREIGN KEY (j_id) REFERENCES JOB_POSTING)
;