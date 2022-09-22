<?php

function getdb(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "esg_web";
    try {
        $conn = mysqli_connect($servername, $username, $password, $db);
        echo "Connected successfully";
    }
    catch(exception $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }
    return $conn;
}

if(isset($_POST["Import"])){
    $con = getdb();


    $filename=$_FILES["file"]["tmp_name"];
    if($_FILES["file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        while (($getData = fgetcsv($file, 999999999, ",")) !== FALSE)
        {
            $comName = trim($getData[0]);
            $arBody = trim($getData[6]);
            if ($comName && $arBody) {
                $sql = "INSERT into scraped_data_tbl (company_name,search_term,source,link,date, article_title, article_body) 
                   values ('".$getData[0]."','".$getData[1]."','".$getData[2]."','".$getData[3]."','".$getData[4]."','".$getData[5]."','".$getData[6]."')";
                $result = mysqli_query($con, $sql);
            }


        }

        fclose($file);
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
</head>
<body>
<div id="wrap">
    <div class="container">
        <div class="row">
            <form class="form-horizontal" action="" method="post" name="upload_excel" enctype="multipart/form-data">
                <fieldset>
                    <!-- Form Name -->
                    <legend>Form Name</legend>
                    <!-- File Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="filebutton">Select File</label>
                        <div class="col-md-4">
                            <input type="file" name="file" id="file" class="input-large">
                        </div>
                    </div>
                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                        <div class="col-md-4">
                            <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>

    </div>
</div>
</body>
</html>
