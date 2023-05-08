        --inserting into Circuit
        INSERT INTO Circuit(Circuit_Name, Circuit_Region) VALUES('LCS', 'NA');
        INSERT INTO Circuit(Circuit_Name, Circuit_Region) VALUES('LCK', 'KR');

        --inserting into Tournament
        INSERT INTO Tournament(Tournament_Name, Tournament_Location, Tournament_Year, Circuit_ID, Sport, Prize_Pool, Tournament_Winner, Tournament_Format) VALUES('LCS Spring Split', 'Los Angeles', 2023, 1, 'LoL', 123123.123, 'Cloud9', 'Round Robin');
        INSERT INTO Tournament(Tournament_Name, Tournament_Location, Tournament_Year, Circuit_ID, Sport, Prize_Pool, Tournament_Winner, Tournament_Format) VALUES('LCK Spring Split', 'Seoul', 2023, 2, 'LoL', 123123.123, 'T1', 'Round Robin');

         --inserting into Team for LCS
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('Cloud9', 14, 4, 1);
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('Flyquest', 14, 4, 1);
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('100 Thieves', 10, 8, 1);
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('Counter Logic Gaming', 10, 8, 1);
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('Evil Geniuses', 10, 8, 1);
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('Golden Guardians', 9, 9, 1);
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('TSM', 8, 10, 1);
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('Team Liquid', 8, 10, 1);
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('Immortals', 4, 14, 1);
        INSERT INTO Team (Team_Name, Team_Wins, Team_Losses, Tournament_ID) VALUES('Dignitas', 3, 15, 1);

        --inserting into Player
        INSERT INTO Player (Player_FName, Player_LName, Player_Tag, Player_Age, Player_Position, Player_Region, Player_Import_Status, Years_Pro, Years_With_Team, KDA, CSPM, GPM, Gold_Percentage, KP, CS15, G15, XP15, Kills, Deaths, Assists, DPM, DMG_Percent, Solo_Kills, Penta_Kills, VSPM, Team_ID) VALUES('Robbie', 'McCurdy', 'Roei', 21, 'Jungle', 'NA', FALSE, 3, 3, 20.0, 7.2, 105.0, 20.5, 70.5, 5.4, 60.5, 75.5, 50, 5, 50, 498, 28.8, 8, 1, 2.3, 1);
        INSERT INTO Player (Player_FName, Player_LName, Player_Tag, Player_Age, Player_Position, Player_Region, Player_Import_Status, Years_Pro, Years_With_Team, KDA, CSPM, GPM, Gold_Percentage, KP, CS15, G15, XP15, Kills, Deaths, Assists, DPM, DMG_Percent, Solo_Kills, Penta_Kills, VSPM, Team_ID) VALUES('Gabriel', 'Roban', 'Bee', 21, 'Mid', 'NA', FALSE, 3, 3, 20.0, 7.2, 105.0, 20.5, 70.5, 5.4, 60.5, 75.5, 50, 5, 50, 498, 28.8, 8, 1, 2.3, 2);

        --inserting into Match
        INSERT INTO `Match`(Tournament_ID, Team_ID_1, Team_ID_2, Match_Winner, Games_Played) VALUES(1, 1, 2, 'Cloud9', 1);