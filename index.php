
<?php 
	if( isset($_POST['submit']) ) {
		if( $_FILES['file']['name']) {

			if(!file_exists('fileUpload')){
		  		mkdir('fileUpload');
			}
			$array = explode('.', $_FILES['file']['name']);
            $extension = end($array);
            $fileName = time().'.'.$extension;
			move_uploaded_file($_FILES['file']['tmp_name'], 'fileUpload/'.$fileName);
			$fileDir = 'fileUpload/'.$fileName;
			// $file = fopen($fileDir,"r");
			// $file = new SplFileObject($fileDir, 'r');

			// $file->setFlags(
			//     SplFileObject::READ_CSV |
			//     SplFileObject::READ_AHEAD |
			//     SplFileObject::SKIP_EMPTY |
			//     SplFileObject::DROP_NEW_LINE
			// );

			// $file->seek(PHP_INT_MAX);

			// $lineCount = $file->key() + 1;

			// $chunkSize = $lineCount/10;

			// echo $chunkSize;
			$file = fopen($fileDir,"r");
			$arrayCsv = array();


	while(!feof($file)) {      
  		$fpTotal = fgetcsv($file);
  		array_push($arrayCsv,$fpTotal);
	}

	$j = 1;
	$tempArray = [];
	$columns = [];
	$k = 1;

	for($i = 0; $i<count($arrayCsv); $i++){
				if(!$columns){
					$columns[] = $arrayCsv[$i];
					continue;
				}

			  	if($j<50){			  		
			  	// if($j<round($chunkSize)){			  		
			  		$tempArray[] = $arrayCsv[$i];
			  		$j++;
			  	} else{	  		
			  		
			  		$uploadCsvFileName = $k.'.csv';
			  		$nnFile = explode(".", $fileName);
			  		if(!file_exists('fileUpload/'.$nnFile[0])){
			  			mkdir('fileUpload/'.$nnFile[0]);
			  		}
			  		
			  		$newFile = fopen('fileUpload/'.$nnFile[0].'/'.$uploadCsvFileName, "w");

			  			for($ll = 0; $ll<count($columns);$ll++){

			  				fputcsv($newFile, $columns[$ll]);	
			  			}

			  			for($ll = 0; $ll<count($tempArray);$ll++){

			  				fputcsv($newFile, $tempArray[$ll]);	
			  			}
			  		
			  		
			  		$tempArray = [];
			  		$j = 1;
			  		$k++;
			  	}
			  }


			 echo "total file:" . $k;
			fclose($file);
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>

	<form action="" method="post" enctype="multipart/form-data">

		<input type="file" name="file">

		<input type="submit" name="submit">
		
	</form>

</body>
</html>