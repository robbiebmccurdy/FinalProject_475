--Query 1
SELECT Tournament.Tournament_Name, COUNT(DISTINCT Team.Team_ID) AS 'Team Count' FROM Tournament NATURAL JOIN Team GROUP BY Tournament.Tournament_Name ORDER BY Team.Team_ID ASC;
--Query 2
SELECT Player.Player_Tag FROM Player WHERE Player.Team_ID = (SELECT Team_ID FROM Team WHERE Team_Name = 'Cloud9');
--Query 3
SELECT Tournament_Name, GROUP_CONCAT(DISTINCT Team.Team_Name ORDER BY Team.Team_Name) AS Team_Names FROM Tournament NATURAL JOIN Team GROUP BY Tournament_Name ORDER BY Tournament_ID ASC;