<?php
include "models/base.php";
include "models/keywords.php";
include "models/movies.php";
$oKeywords= new Keywords();
$oMovies= new Movies();
if(!empty($_GET))
{
  print_r($_GET);
  if(isset($_GET['title']))
  {
    $oMovies->add($_GET);
    $oMovies->write();
  }else if (isset($_GET['keywords']))
  {
    foreach($_GET['keywords'] as $id => $keyword)
    {
      $oKeywords->edit($id,$keyword);
    }
    $oKeywords->write();
  }
}

$keywords=$oKeywords->getAll();
$movies=$oMovies->getAll();
?>




<!DOCTYPE html>
<html>
<head>
  <title>CRUD json</title>
  <style>
  form, .list{
    display: flex;
    flex-direction: column;
    margin:50px 25%;
  }

  </style>
</head>
<body>

<form method='GET'>
<h4>Add a movie</h4>
  <label for="title">Title</label><input id="title" type="text" name="title" >
  <label for="description">Description</label><input id="description" type="text" name="description" >
  <label for="date">Date</label><input id="date" type="text" name="date" >
  <select name='keywords[]' multiple>
  <?php foreach($keywords as $id =>$keyword): ?>
    <option value='<?= $id ?>'><?=$keyword['name'] ?></option>
    <?php endforeach; ?>
  </select>
    <button type='submit'>Add Movie</button>
</form>
<hr />
<form method='GET'>
<h4>Modifie keyword</h4>
  <?php foreach($keywords as $id=>$keyword): ?>
    <input type='text' name='keywords[<?= $id ?>][name]' value="<?= $keyword['name'] ?>">
  <?php endforeach; ?>
  <button type='submit'> Modifie keyword</button>
</form>
<hr />
<div class='list'>
  <h2>List of movies</h2>
  <ul>
    <?php foreach($keywords as $id=>$keyword):?>
      <li><?= $keyword['name'] ?> :</li>
      <ul>
      <?php foreach($movies as $movie): 
         if(in_array($id, $movie['keywords'])) { ?>
          <li><?= $movie['title'] ?> - <?= $movie['date'] ?></li>
        <?php } ?>
      <?php endforeach ?>
      </ul>
    <?php endforeach ?>
  </ul>
</div>
</body>
</html>