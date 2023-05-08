DROP TABLE IF EXISTS `Match`, `Player`, `Tournament`, `Circuit`, `Team`;

-- Drop tables in reverse order
DROP TABLE IF EXISTS `Match`;
DROP TABLE IF EXISTS `Player`;
DROP TABLE IF EXISTS `Tournament`;
DROP TABLE IF EXISTS `Circuit`;
DROP TABLE IF EXISTS `Team`;

-- Create Circuit table
CREATE TABLE `Circuit` (
    Circuit_ID INT PRIMARY KEY AUTO_INCREMENT,
    Circuit_Name varchar(50),
    Circuit_Region varchar(50)
) ENGINE = InnoDB;

-- Create Tournament table
CREATE TABLE Tournament (
    Tournament_ID INT PRIMARY KEY AUTO_INCREMENT, 
    Tournament_Name varchar(50),
    Tournament_Location varchar(100),
    Tournament_Year YEAR,
    Circuit_ID INT NOT NULL,
    Sport varchar(50),
    Prize_Pool decimal(65,2) NOT NULL,
    Tournament_Winner varchar(75),
    Tournament_Format varchar(50),
    FOREIGN KEY (Circuit_ID) REFERENCES Circuit(Circuit_ID)
) ENGINE = InnoDB;

-- Create Team table
CREATE TABLE `Team` (
    Team_ID INT PRIMARY KEY AUTO_INCREMENT,
    Team_Name varchar(75),
    Team_Wins INT,
    Team_Losses INT,
    Tournament_ID INT,
    FOREIGN KEY (Tournament_ID) REFERENCES Tournament(Tournament_ID)
) ENGINE = InnoDB;

-- Create Player table
CREATE TABLE Player (
    Player_ID INT PRIMARY KEY AUTO_INCREMENT,
    Player_FName varchar(100),
    Player_LName varchar(100),
    Player_Tag varchar(100),
    Player_Age INT,
    Player_Position varchar(100),
    Player_Region varchar(50),
    Player_Import_Status boolean,
    Years_Pro INT,
    Years_With_Team INT,
    KDA decimal(50,2),
    CSPM decimal(50,2),
    GPM decimal(65,2),
    Gold_Percentage decimal(65,2),
    KP decimal(65,2),
    CS15 decimal(50, 2),
    G15 decimal(65,2),
    XP15 decimal(65,2),
    Kills INT,
    Deaths INT,
    Assists INT,
    DPM decimal(65, 2),
    DMG_Percent decimal(65,2),
    Solo_Kills INT,
    Penta_Kills INT,
    VSPM decimal(65,2),
    Team_ID INT,
    FOREIGN KEY (Team_ID) REFERENCES Team(Team_ID)
) ENGINE = InnoDB;

-- Create Match table
CREATE TABLE `Match` (
    Match_ID INT PRIMARY KEY AUTO_INCREMENT,
    Tournament_ID INT NOT NULL,
    Team_ID_1 INT NOT NULL,
    Team_ID_2 INT NOT NULL,
    Match_Winner varchar(50),
    Games_Played INT,
    FOREIGN KEY (Tournament_ID) REFERENCES Tournament(Tournament_ID),
    FOREIGN KEY (Team_ID_1) REFERENCES Team(Team_ID),
    FOREIGN KEY (Team_ID_2) REFERENCES Team(Team_ID)
) ENGINE = InnoDB;
