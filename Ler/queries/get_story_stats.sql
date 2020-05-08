SELECT (SELECT count(1) FROM Favorites where story_id = :story_id) as "Favorites",
(SELECT count(1) FROM History where story_id = :story_id and last_arc_id is not null and last_arc_id > -1) as "Progress"