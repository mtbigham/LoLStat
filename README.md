# LoLStat
Live League of Legends stats - Compare your current game to your average performance!

##Player History Algorithm
| number  | user action | algorithm action  |
|---------|:-----------:|:------------------:|
|1        | type in summoner name | search for current game and get championID  (if in game)  |
|2        | wait                  | search user's match history for that championID |
|3        | wait                  | for each match found, aggregate metrics (cs, xp, gold, kills) |
|4        | see graph             | graph averaged metrics on a line plot (with moving red line for the current game time |
