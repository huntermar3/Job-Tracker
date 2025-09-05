CREATE TABLE USER
( FName		VARCHAR(10)		NOT NULL, 
  Minit     CHAR,
  Lname     VARCHAR(20)     NOT NULL,
  Username  VARCHAR(20)		NOT NULL,
  Password  VARCHAR(20)		NOT NULL,
  UserID	VARCHAR(10)		NOT NULL,
  
PRIMARY KEY		(UserID));


CREATE TABLE JOB_LISTING 
( CName			VARCHAR(15)		NOT NULL,
  JTitle 		VARCHAR(20) 	NOT NULL,
  Location		VARCHAR(20)		NOT NULL,
  Salary		Int				NOT NULL,
  C_Email		VARCHAR(20),
  C_Phone		Int,
  Job_Desc		TEXT,
  Date_App		DATE			NOT NULL,
  App_Status	VARCHAR(15)		NOT NULL,
  
  PRIMARY KEY 	(C_Email));


CREATE TABLE SPREADSHEET
( Month			VARCHAR(9)		NOT NULL,
  Year			INT				NOT NULL,
  Date_Created	DATE			NOT NULL,
  Modified_T	TIME,
  Modified_D	DATE,
  
  PRIMARY KEY	(Month, Year));
  
  
  
