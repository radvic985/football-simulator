
## Football Simulator for 20 teams of English Premier League

Should run migrations and seeders

php artisan migrate

php artisan db:seed

###Example 
is on the hosting [http://football-simulator-radkevych.herokuapp.com/](http://football-simulator-radkevych.herokuapp.com/) (https does not work correctly, must use http protocol in this url)

###Description

1. Can choose the quantity of teams on the main page.
2. Can set the strength of each team.
3. Receiving and updating data going on via AJAX in the all tables.
4. Clicking on the [Next Week] button shows matches results by the week and refreshes the tournament table.
5. Clicking on the [Play All] button calculates all matches results and shows them group by the week, the League Table shows the final standing of the championship.
6. Also was realized an ability of changing match's result during the championship and after his finishing with according refreshing and re-calculating teams points and standings. 
7. The predictions table with approximate percents is calculated too.
8. We can see the up-down icons after the second week near the team position in the league table.
9. Added the scroll for all tables when choose the big amount of teams.
10. The calculation of all possible match combinations was done programmatically only for team amount 4, but the other combinations for others team count were added manually.  
