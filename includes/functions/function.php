<?php

/* front end function */
/* function to get category record*/
function getCat()
{
    global $connect;
    $getCat = $connect->prepare("select * from categories order by ID asc");
    $getCat->execute();
    $cats = $getCat->fetchAll();
    return $cats;
}
/* function to get items from database*/
function getItems($CatID)
{
    global $connect;
    $getItems = $connect->prepare("select * from items where Cat_ID = ? order by item_ID desc");
    $getItems->execute(array($CatID));
    $items = $getItems->fetchAll();
    return $items;
}


/* get user */
function getUser($select,$table,$email)
{
    global $connect;
    $getUser = $connect->prepare("SELECT $select from $table where Email=$email");
    $getUser->execute();
    $user = $getUser->fetch();
    return $user;

}
/* set title */
function setTitle()
{
    global $pageTitle;
    if(isset($pageTitle))
        echo $pageTitle;
    else
        echo 'Default';
}

/* redirect function */
function handleError($Msg,$url = null,$second = 3)
{
    if($url === null)
    {
        $url = 'index.php';
        $link = 'Homepage';
    }
    else
    {
        
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '')
        {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';
        }
        else
        {
            $url = 'index.php';
            $link = 'Homepage';
        }
    }
    echo $Msg;
    echo "<div  class = 'alert alert-info'>you will be redirected to $link after $second seconds.</div>";
    header("refresh:$second;url=$url");
    exit();
}
/* back function */
function Back($url = null,$second = 0)
{
    if($url === null)
    {
        $url = 'index.php';
        $link = 'Homepage';
    }
    else
    {
        
        if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '')
        {
            $url = $_SERVER['HTTP_REFERER'];
            $link = 'Previous Page';
        }
        else
        {
            $url = 'index.php';
            $link = 'Homepage';
        }
    }
    
    header("refresh:$second;url=$url");
    exit();
}



/* function to check items in database */
function checkItem($select,$from,$value)
{
    global $connect;
    $stmt = $connect->prepare("select $select from $from where $select = ?");
    $stmt->execute(array($value));
    $check = $stmt->rowCount();
    return $check;
}
/* function to count items in database */
function countItem($select,$from,$value)
{
    global $connect;
    $stmt = $connect->prepare("select $select from $from where $select = ?");
    $stmt->execute(array($value));
    return $stmt->fetchColumn();
}


/* function to get number of items */
function countItems($item,$table)
{
    global $connect;
    $stmt = $connect->prepare("select count($item) from $table");
    $stmt->execute();
    return $stmt->fetchColumn();
}

/* function to get latest record*/
function getLatest($select,$table,$order,$limit = 5)
{
    global $connect;
    $getstmt = $connect->prepare("select $select from $table order by $order DESC limit $limit");
    $getstmt->execute();
    $row = $getstmt->fetchAll();
    return $row;
}
    
?>