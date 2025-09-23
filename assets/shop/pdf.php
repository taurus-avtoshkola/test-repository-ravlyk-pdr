<?php
/// pdf2.php - ТАМ РАБОЧИЙ СКРИПТ!
die;
// Подключаем
define('MODX_API_MODE', true);
define ('ROOT', dirname(dirname(dirname(__FILE__))));
define ('MODX_BASE_PATH', ROOT.'/');
define ('MODX_BASE_URL', '/');
define ('MODX_SITE_URL', 'https://pdr-online.com.ua/');
require ROOT.'/index.php';
include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);

$file = MODX_BASE_PATH.'assets/shop/pdr/pdr_10_01_24.pdf';



function requireFilesOfFolder($dir)
{
    foreach (new DirectoryIterator($dir) as $fileInfo) {
        if (!$fileInfo->isDot()) {
            if ($fileInfo->isDir()) {
                requireFilesOfFolder($fileInfo->getPathname());
            } else {
                require_once $fileInfo->getPathname();
            }
        }
    }
}

$rootFolder = MODX_BASE_PATH.'/assets/shop/php/pdfparser-master/src/Smalot/PdfParser';

// Manually require files, which can't be loaded automatically that easily.
require_once $rootFolder.'/Element.php';
require_once $rootFolder.'/PDFObject.php';
require_once $rootFolder.'/Font.php';
require_once $rootFolder.'/Page.php';
require_once $rootFolder.'/Element/ElementString.php';
require_once $rootFolder.'/Encoding/AbstractEncoding.php';

/*
 * Load the rest of PDFParser files from /src/Smalot/PDFParser
 * Dont worry, it wont load files multiple times.
 */
requireFilesOfFolder($rootFolder);



use Smalot\PdfParser\Parser;

// Create a PDF parser object
$parser = new Parser();

// Parse the PDF file
$pdf = $parser->parseFile($file);


$text = $pdf->getText();
$paragraphs_a = explode("\n", $text);
$paragraphs = array_slice($paragraphs_a, 4);


$chapter_cnt = 1;
$question_cnt = 1;
$page_cnt = 2;
$type = '1';
$cc = 0;
$dumpling = false;
if($dumpling){
	echo "<table>";
}
foreach($paragraphs as $k => $p){
	if($cc < 6569){
	$text = trim($p);
	if($dumpling){
		echo '<tr><td>'.$cc.'</td><td>'.$text.'</td><th>'.$type.'</th></tr>';
	}
	//ignore pagination
	if($text === (string)$page_cnt){
		$page_cnt++;
		$type = 5;
	}else{

		switch ($type) {
			case '1': //chapter_search
				$c_h = explode('. ',$text);
				$chapter_num = $c_h[0];
				$chapter_name = $c_h[1];
				$chapter_cnt++;
				$chapter_info[$chapter_num] = $chapter_name; 
				$question_cnt = 1;
				$type = 10;
			break;
			case "10":
				if($text == ''){
					$type = 2;
				}else{
					$c_h = explode('. ',$text);
					if($c_h[0] == '1'){
						//first question

						$question_num = $c_h[0];

						$qq[$chapter_num][$question_num]['name'] = $c_h[1];
						$answer_zero = true;
						$question_cnt++;
						$type = 3;
					}else{
						//end chapter
						$chapter_info[$chapter_num] .= $text;
						$type = 10;
					}
				}
			break;
			case "2": //question or none or chapter


				if($text == ''){
					//none
					$type = 2;
				}else{

					$q_h = explode('. ',$text);

					if((int)$q_h[0] != ($question_num+1) AND isset($question_num)){
						if($answer_zero){
							//відповіді!
							//answer
							$a_h = explode(') ',$text);
							$qq[$chapter_num][$question_num]['answers'][$a_h[0]] = $a_h[1];
							$last_answer = $a_h[0];
							$type = 5;
							$answer_zero = false;
						}else{

							if(stripos($text,($last_answer+1).')') !== false ){
								//next answers
								$a_h = explode(') ',$text);
								$qq[$chapter_num][$question_num]['answers'][$a_h[0]] = $a_h[1];
								$last_answer = $a_h[0];
								$answer_zero = false;
								$type = 5;
							}else{

								//next chapter
								$chapter_num = $q_h[0];
								$chapter_name = $q_h[1];
								$chapter_cnt++;
								$chapter_info[$chapter_num] = $chapter_name;
								$question_cnt = 1;
								unset($question_num);
								unset($last_answer);
								$type = 10;
							}
						}
					}else{

						//question
						$question_num = $q_h[0];
						$qq[$chapter_num][$question_num]['name'] = $q_h[1];
						$answer_zero = true;
						$question_cnt++;
						$type = 3;
					}
				}
			break;
			case "3": //question end or answer or img
				if($text == '' OR $text == ' '){
					//img?
					$img_array_num[$chapter_num][] = $question_num;
					$type = 3;
				}else{
					//перевірка чи це перша відповідь
					if(stripos($text,'1)') !== false){
						//answer
						$a_h = explode(') ',$text);
						$qq[$chapter_num][$question_num]['answers'][$a_h[0]] = $a_h[1];
						$last_answer = $a_h[0];
						$answer_zero = false;
						$type = 5;
					}else{
						//перевірка чи це перше питання
						//if(stripos($text,'1.') !== false){
						//}

						//question end
						$qq[$chapter_num][$question_num]['name'] .= $text;
						$answer_zero = true;
						$type = 3;

					}
				}

			break;
			case "4": //answer first
				$a_h = explode(') ',$text);
				$qq[$chapter_num][$question_num]['answers'][$a_h[0]] = $a_h[1];
				$last_answer = $a_h[0];
				$answer_zero = false;
				$type = 5;
			break;
			case "5": //answer second or end or check question

			//ВИКЛЮЧЕННЯ!!!
			if($text == '14. ОБГІН'){
				//next chapter
				$q_h = explode('. ',$text);
				$chapter_num = $q_h[0];
				$chapter_name = $q_h[1];
				$chapter_cnt++;
				$chapter_info[$chapter_num] = $chapter_name;
				$question_cnt = 1;
				unset($question_num);
				unset($last_answer);
				$type = 10;
			}else{


				if(stripos($text,($question_num+1).'.') === 0){
					//check if question

					$q_h = explode('. ',$text);
					$question_num = $q_h[0];
					$qq[$chapter_num][$question_num]['name'] = $q_h[1];
					$answer_zero = true;
					$question_cnt++;
					$type = 3;

				}else{

				


					if(stripos($text,($last_answer+1).')') !== false AND isset($last_answer)){
						//next
						$a_h = explode(') ',$text);
						$qq[$chapter_num][$question_num]['answers'][$a_h[0]] = $a_h[1];
						$last_answer = $a_h[0];
						$answer_zero = false;
						$type = 5;
					}else{
						//end prev answer other or next question
						if($text == '' OR $text == ' '){
							//next question 
							$type = 2;
						}else{
							//end prev answer
							$qq[$chapter_num][$question_num]['answers'][$last_answer] .= $text;
							$type = 5;
						}
					}
				}
			}//end виключення
			break;
			default:
				
			break;
		}	
	}

}//cc
	$cc++;

}

if($dumpling){
	echo "</table>";die;
}



foreach($qq as $chapter => $question){
	echo "<h2 style='text-align:center;'><b>".$chapter.". ".$chapter_info[$chapter]."</b></h2></tr>";
	foreach($question as $num => $aa){
		echo "<p><b>".$num.". ".$aa['name']."</b></p>";
		foreach($aa['answers'] as $n => $a){
			echo "<p>".$n.". ".$a."</p>";
		}
		echo "<p></p>";
	}
}

die;
$images = $pdf->getObjectsByType('XObject', 'Image');

$cnt = 1;
foreach( $images as $image ) {
	$type = $image->getHeader()->getDetails();

	file_put_contents(MODX_BASE_PATH.'/assets/shop/pdr/img/img_'.$cnt.'.jpg', $image->getContent());
    echo '<img src="data:image/jpg;base64,'. base64_encode($image->getContent()) .'" />';
    $cnt++;
}