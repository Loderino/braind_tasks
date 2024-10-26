use articles;

SELECT Article.id, IF(`value`=1, "Like", "Dislike") as reaction, NULL as `comment` FROM Grade
INNER JOIN Article ON Grade.article_id = Article.id
INNER JOIN Article_Author as AA ON AA.article_id = Article.id
INNER JOIN Author ON AA.author_id = Author.id
WHERE Author.name = "Виталий" AND Author.surname = "Манн"

UNION ALL

SELECT Article.id, NULL as reaction, content as `comment` FROM `Comment`
INNER JOIN Article ON `Comment`.article_id = Article.id
INNER JOIN Article_Author as AA ON AA.article_id = Article.id
INNER JOIN Author ON AA.author_id = Author.id
WHERE Author.name = "Виталий" AND Author.surname = "Манн";
