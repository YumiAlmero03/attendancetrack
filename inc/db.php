<?php

require_once 'env.php';

$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

if(!$conn)
{
    die("Connection Failed: ". mysqli_connect_error());
}

function backupDB(){
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "db_attendance";
    $mysqli = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName); 
        // $mysqli->select_db($dbName); 
        $mysqli->query("SET NAMES 'utf8'");

        $queryTables    = $mysqli->query('SHOW TABLES'); 
        while($row = $queryTables->fetch_row()) 
        { 
            $target_tables[] = $row[0]; 
        }   
        foreach($target_tables as $table)
        {
            $result         =   $mysqli->query('SELECT * FROM '.$table);  
            $fields_amount  =   $result->field_count;  
            $rows_num=$mysqli->affected_rows;     
            $res            =   $mysqli->query('SHOW CREATE TABLE '.$table); 
            $TableMLine     =   $res->fetch_row();
            $content        = (!isset($content) ?  '' : $content) . "\n\n".$TableMLine[1].";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fields_amount;   $i++, $st_counter=0) 
            {
                while($row = $result->fetch_row())  
                { //when started (and every after 100 command cycle):
                    if ($st_counter%100 == 0 || $st_counter == 0 )  
                    {
                            $content .= "\nINSERT INTO ".$table." VALUES";
                    }
                    $content .= "\n(";
                    for($j=0; $j<$fields_amount; $j++)  
                    { 
                        $row[$j] = str_replace("\n","\\n", addslashes($row[$j]) ); 
                        if (isset($row[$j]))
                        {
                            $content .= '"'.$row[$j].'"' ; 
                        }
                        else 
                        {   
                            $content .= '""';
                        }     
                        if ($j<($fields_amount-1))
                        {
                                $content.= ',';
                        }      
                    }
                    $content .=")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ( (($st_counter+1)%100==0 && $st_counter!=0) || $st_counter+1==$rows_num) 
                    {   
                        $content .= ";";
                    } 
                    else 
                    {
                        $content .= ",";
                    } 
                    $st_counter=$st_counter+1;
                }
            } $content .="\n\n\n";
        }
        $backup_name = $dbName."_(".date('H-i-s')."_".date('d-m-Y').").sql";
        // $backup_name = $backup_name ? $backup_name : $dbName.".sql";
        header('Content-Type: application/octet-stream');   
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$backup_name."\"");  
        echo $content; exit;
}

function uploadS3($name,$tmpname)
{
    // var_dump($file);
    $file_name = 'files/'.$name;   
    $temp_file_location = $tmpname; 

    require 'vendor/autoload.php';

    $s3 = new Aws\S3\S3Client([
        'region'  => 'ap-southeast-1',
        'version' => 'latest',
        'credentials' => [
            'key'    => "AKIAVZ4H6LJO4JMRJISB",
            'secret' => "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",
        ]
    ]);     

    $result = $s3->putObject([
        'Bucket' => 'onsitelogbook-files',
        'Key'    => $file_name,
        'SourceFile' => $temp_file_location         
    ]);
    return $result['ObjectURL'];
}
?>