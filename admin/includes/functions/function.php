<?php
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
    function handleError($Msg,$url = null,$second = 0)
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
    

    /* function to check items in database */
    function checkItem($select,$from,$value)
    {
        global $connect;
        $stmt = $connect->prepare("select $select from $from where $select = ?");
        $stmt->execute(array($value));
        $count = $stmt->rowCount();
        return $count;
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
    /* Get All */
    function getAll($table)
    {
        global $connect;
        $stmt = $connect->prepare("SELECT * from $table");
        $stmt->execute();
        $row = $stmt->fetchAll();
        return $row;
    }

    /* countTable */
    function countTable($table)
    {
        global $connect;
        $stmt = $connect->prepare("SELECT * from $table");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
    
?>