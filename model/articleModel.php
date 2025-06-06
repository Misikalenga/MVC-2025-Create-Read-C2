<?php






function getAllArticle(PDO $con):array
{
  $sql = "
    SELECT a.`idarticle`, a.`article_title`, a.`article_text`, a.`article_date_created`, u.`iduser`
        FROM `article` a
        INNER JOIN `user` u
            ON u.`iduser` = a.`user_iduser`
    ORDER BY a.`article_date_created` DESC;
    ";

  try{
    $query = $con->query($sql);
    $result = $query->fetchAll();
    $query->closeCursor();
    return $result;
  }catch (Exception $e){
    die($e->getMessage());
  }
}

function insertArticle(PDO $con, string $titre, string $text, int $idUser, int $isPublish): bool
{


    $sql="
  INSERT INTO `article`
  (`article_title`,`article_text`,`user_iduser`, `article_is_published`) VALUES
  (?,?,?,?)";



  $titre = htmlspecialchars(strip_tags(trim($titre)),ENT_QUOTES);
  $text = htmlspecialchars(strip_tags(trim($text)),ENT_QUOTES);

  if(empty($titre)|| strlen($titre)> 160 || empty($text)) return false;

  $prepare = $con->prepare($sql);
  try{
    $prepare->execute([$titre,$text,$idUser,$isPublish]);
    return true;
  }catch(Exception $e){
    die($e->getMessage());
  }

}
