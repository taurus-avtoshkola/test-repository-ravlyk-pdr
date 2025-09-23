<?php

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

$dumpling = false;//test по строкам!


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

$rootFolder = MODX_BASE_PATH.'assets/shop/php/pdfparser-master/src/Smalot/PdfParser';

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

if($_GET['pass'] == 'tauruspdr'){
// Create a PDF parser object
$parser = new Parser();

// Parse the PDF file
$pdf = $parser->parseFile($file);

$btext = $pdf->getText();
$paragraphs_a = explode("\n", $btext);
$paragraphs = array_slice($paragraphs_a, 4);


$chapter_cnt = 1;
$question_cnt = 1;
$page_cnt = 2;
$type = '1';
$cc = 0;
if($dumpling){
	echo "<table>";
}
$img_array_num_r = array();
$img_array_num = array();
$qq = array();
$chapter_info = array();
function isUpperCaseCyrillic($text) {
    return $text === mb_strtoupper($text, 'UTF-8');
}

//ТУТ СТРОКИ ИСКЛЮЧЕНИЙ!
$no_photo_a = array('1279','1359','1437','2641','6620','6949','7361','11676','12525','13053','13785','14346','15512','15769','15849');

$pp = false;
$img_cnt = 0;
$chapter_cnt = 0;
foreach($paragraphs as $k => $p){
if($cc < 9999999){
	$text = trim($p);
	//исключения скобка
	if($cc == '10267'){$text = '';}
	if($text === ''){
		if($pp){
			//исключения по строкам фото
			if(in_array($cc,$no_photo_a)){
				$type == 'Пробел';
			}else{
				$type = 'Фото';
				$img_array_num[$img_cnt] = $chapter_cnt.'-'.$question_num;
				$img_array_num_r[$chapter_cnt][$question_num][] = $img_cnt;
				$img_cnt++;
				$pp = false;
			}
		}else{
			$type = 'Пробел';
		}
	}else{
		if(is_numeric($text)){
			$type = 'Навигация';
			$pp = false;
		}else{

			if (preg_match('/^\d+[.)](\s|\d+\.\s)/u', $text)) {
				if (preg_match('/^\d+[.](\s|\d+\.\s)/u', $text)) {
					$exp = explode('. ',$text);

					if(isUpperCaseCyrillic(end($exp))){
						$type = 'Раздел';
						$nexttype = 'Раздел продолжение';
						$pp = false;
						//наполнение раздела
						$chapter_num = $exp[0];			
						$chapter_name = end($exp);
						$chapter_cnt++;
						$chapter_info[$chapter_cnt]['num'] = $chapter_num;
						$chapter_info[$chapter_cnt]['name'] = $chapter_name;					

					}else{
						$type = 'Вопрос';
						$nexttype = 'Вопрос продолжение';
						$pp = true;
						//наполнение вопроса
						$question_num = $exp[0];
						$qq[$chapter_cnt][$question_num]['name'] = $exp[1];
						$qq[$chapter_cnt][$question_num]['name'] = $exp[1];
					}
				}else{
					$type = 'Ответ';
					$nexttype = 'Ответ продолжение';
					$pp = false;
					$exp = explode(') ',$text);
					//наполнение ответа
					$answer_num = $exp[0];
					$qq[$chapter_cnt][$question_num]['answers'][$answer_num] = $exp[1];
				}
			}else{
				//xз
				$type = $nexttype;
				switch($type){
					case "Раздел продолжение":
						$chapter_info[$chapter_cnt]['name'] .= ' '.$text;	
						$pp = false;
					break;
					case "Вопрос продолжение":
						$qq[$chapter_cnt][$question_num]['name'] .= ' '.$text;
					break;
					case "Ответ продолжение":
						$qq[$chapter_cnt][$question_num]['answers'][$answer_num] .= ' '.$text;
						$pp = false;
					break;
				}
			}
		}
	}


	//$type = 'Номер старницы';

	if($dumpling){
		echo '<tr><td>'.$cc.'</td><td>'.$text.'</td><th>'.$type.'</th></tr>';
	}






}//cc
	$cc++;

}
if($dumpling){
	echo "</table>";die;
}

$images = $pdf->getObjectsByType('XObject', 'Image');
$i_c = 0;
$array_img = array();
foreach( $images as $image ) {
	$img = $image->getContent();
	$array_img[$i_c] = $img;
    $i_c++;
}

//ИСКЛЮЧЕНИЯ С ПОВТОРЯЮЩИМИСЯ ФОТО!!!
array_splice($array_img, 18, 0, $array_img[17]);
array_splice($array_img, 25, 0, $array_img[24]);
array_splice($array_img, 55, 0, $array_img[54]);
array_splice($array_img, 56, 0, $array_img[54]);
array_splice($array_img, 99, 0, $array_img[81]);
array_splice($array_img, 142, 1);
array_splice($array_img, 142, 1);
array_splice($array_img, 211, 0, $array_img[210]);
array_splice($array_img, 261, 0, $array_img[260]);
array_splice($array_img, 354, 0, '');
array_splice($array_img, 389, 0, $array_img[388]);
array_splice($array_img, 456, 0, $array_img[455]);
array_splice($array_img, 460, 0, $array_img[459]);
array_splice($array_img, 464, 0, $array_img[463]);
array_splice($array_img, 477, 0, $array_img[476]);
array_splice($array_img, 496, 1);
array_splice($array_img, 501, 0, $array_img[500]);
array_splice($array_img, 508, 1);
array_splice($array_img, 508, 1);
array_splice($array_img, 516, 0, $array_img[515]);
array_splice($array_img, 517, 0, $array_img[515]);
array_splice($array_img, 519, 0, $array_img[515]);
array_splice($array_img, 550, 0, $array_img[549]);
array_splice($array_img, 570, 1);
array_splice($array_img, 578, 1);
array_splice($array_img, 578, 1);
array_splice($array_img, 579, 0, '');
array_splice($array_img, 583, 0, $array_img[582]);
array_splice($array_img, 585, 0, '');
array_splice($array_img, 588, 0, '');
array_splice($array_img, 598, 1);
array_splice($array_img, 632, 1);
array_splice($array_img, 632, 1);
array_splice($array_img, 638, 1);
array_splice($array_img, 638, 1);
array_splice($array_img, 662, 1);
array_splice($array_img, 666, 0, '');
array_splice($array_img, 675, 1);
array_splice($array_img, 675, 1);
array_splice($array_img, 675, 1);
array_splice($array_img, 675, 1);
array_splice($array_img, 682, 1);
array_splice($array_img, 682, 1);
array_splice($array_img, 682, 1);
array_splice($array_img, 686, 0, '');
array_splice($array_img, 698, 1);
array_splice($array_img, 698, 1);
array_splice($array_img, 698, 1);
array_splice($array_img, 700, 1);
array_splice($array_img, 719, 0, $array_img[718]);
array_splice($array_img, 730, 0, $array_img[729]);
array_splice($array_img, 731, 0, $array_img[729]);
array_splice($array_img, 741, 1);
array_splice($array_img, 814, 1);
array_splice($array_img, 840, 0, $array_img[839]);
array_splice($array_img, 864, 0, $array_img[863]);
array_splice($array_img, 880, 1);
array_splice($array_img, 929, 0, $array_img[922]);
array_splice($array_img, 953, 0, $array_img[952]);
array_splice($array_img, 959, 0, $array_img[958]);
array_splice($array_img, 966, 0, $array_img[965]);
array_splice($array_img, 1006, 0, $array_img[1005]);
array_splice($array_img, 1016, 0, $array_img[1013]);
array_splice($array_img, 1026, 0, $array_img[1025]);
array_splice($array_img, 1045, 1);
array_splice($array_img, 1048, 0, '');
array_splice($array_img, 1049, 0, '');
array_splice($array_img, 1062, 0, '');
array_splice($array_img, 1072, 0, $array_img[1071]);
array_splice($array_img, 1073, 0, $array_img[1071]);
array_splice($array_img, 1160, 0, $array_img[1159]);


$cnt_questions = 0;
$cnt_questions_base = 0;
echo "<table>";
echo "<tr><td><h1>В ФАЙЛІ</h1></td><td><h1>В БАЗІ</h1></td></tr>";
foreach($qq as $chapter => $question){
	$cnt_q = count($question);
	$cnt_questions += $cnt_q;
	$check_total = $modx->db->getRow($modx->db->query('SELECT count(q.id) as cnt FROM `new_question` q LEFT JOIN `new_question_2_theme` q2t ON q2t.question_id = q.id LEFT JOIN `new_question_theme` qt ON qt.id = q2t.theme_id WHERE qt.number = "'.$modx->db->escape($chapter_info[$chapter]['num']).'"'));
	$cnt_questions_base += $check_total['cnt'];
	$cl_chapter = '';
	if($cnt_q != $check_total['cnt']){
		$cl_chapter = 'style="color:red;"';
	}
	echo "<tr><td style='width:50%;'><h2 ".$cl_chapter."><b>".$chapter_info[$chapter]['num'].". ".$chapter_info[$chapter]['name']." (".$cnt_q.")</b></h2></td><td style='width:50%;'><h2><b>(".$check_total['cnt'].")</b></h2></td></tr>";

	foreach($question as $num => $aa){
		if($_GET['question'] == 'true'){
			$aa['name'] = str_replace('  ', ' ', $aa['name']);
			$check_question = $modx->db->getRow($modx->db->query('SELECT *, q.id as qid FROM `new_question_theme` qt
LEFT JOIN `new_question_2_theme` q2t ON q2t.theme_id = qt.id 
LEFT JOIN `new_question` q ON q2t.question_id = q.id
WHERE qt.number = "'.$modx->db->escape($chapter_info[$chapter]['num']).'" AND q.number = "'.$modx->db->escape($num).'"
 LIMIT 1 '));
			$cl_question = '';
			if($aa['name'] != $check_question['question']){
				$cl_question = 'style="color:red;"';
			}

			echo "<tr><td style='width:50%;'><p ".$cl_question."><b>".$num.". ".$aa['name']."</b></p></td><td style='width:50%;'><p ".$cl_question."><b>".$num.". ".$check_question['question']."</b></p></td></tr>";

		}
		if($_GET['photo'] == 'true'){
			if(is_array($img_array_num_r[$chapter][$num])){
				foreach($img_array_num_r[$chapter][$num] as $n => $im){
					echo '<tr><td colspan="2"><img src="data:image/jpg;base64,'. base64_encode($array_img[$im]) .'" /></td></tr>';
				}
			}
		}
		if($_GET['answer'] == 'true'){
			$answers_i = json_decode($check_question['answers'],true);
			echo '<tr><td colspan="2"><table style="background:#eee;width:100%;">';
			foreach($aa['answers'] as $n => $a){
				$cl_answer = '';
				if($answers_i[($n-1)]['description'] != $a){
					$cl_answer = 'style="color:red;"';
				}

				echo "<tr><td style='width:50%;'><p ".$cl_answer.">".$n.". ".$a."</p></td><td style='width:50%;'><p ".$cl_answer.">".$n." ".$answers_i[($n-1)]['description']."</p></td></p>";
			}
			echo "</table></td></tr>";
		}

		//тут оновлення питань та відповідей та фото базових!
		/*
		unset($tt_a);
		$tt_a = array();
		$tc = 0;
		foreach($aa['answers'] as $n => $a){
			$tt_a[$tc]['id'] = uniqid();
			$tt_a[$tc]['description'] = $a;
			$tc++;
		}
		
		if(is_array($img_array_num_r[$chapter][$num])){
			foreach($img_array_num_r[$chapter][$num] as $n => $im){
				$n_p = 'assets/images/pdr/base/'.preg_replace('/\D+/', '', microtime()).'.jpg';
				file_put_contents(MODX_BASE_PATH.$n_p, $array_img[$im]);
			}
		}
		
		$modx->db->query('UPDATE `new_question` SET 
			`question` = "'.$modx->db->escape($aa['name']).'",
			`number` = "'.$modx->db->escape($num).'",
			`answers` = "'.$modx->db->escape(json_encode($tt_a)).'",
			`image_official` = "'.$modx->db->escape('/'.$n_p).'"
			WHERE id = "'.$modx->db->escape($check_question['qid']).'" LIMIT 1
		');
		*/

//		$n_q = $modx->db->query();


/*
// Тут створення нових питань!!!
		if($check_question['id'] == ''){
			echo '<tr><td colspan="2">Питання не знайдено '.$num.'</td></tr>';
			unset($tt_a);
			$tt_a = array();
			$tc = 0;
			foreach($aa['answers'] as $n => $a){
				$tt_a[$tc]['id'] = uniqid();
				$tt_a[$tc]['description'] = $a;
				$tc++;
			}
			if(is_array($img_array_num_r[$chapter][$num])){
				foreach($img_array_num_r[$chapter][$num] as $n => $im){
					$n_p = 'assets/images/pdr/base/'.preg_replace('/\D+/', '', microtime()).'.jpg';
					file_put_contents(MODX_BASE_PATH.$n_p, $array_img[$im]);
				}
			}
			$cc_theme = $modx->db->getRow($modx->db->query('SELECT * FROM `new_question_theme` WHERE number = "'.$modx->db->escape($chapter_info[$chapter]['num']).'" LIMIT 1'));
			$n_q = $modx->db->query('INSERT INTO `new_question` SET 
				`question` = "'.$modx->db->escape($aa['name']).'",
				`number` = "'.$modx->db->escape($num).'",
				`answers` = "'.$modx->db->escape(json_encode($tt_a)).'",
				`image_official` = "'.$modx->db->escape('/'.$n_p).'",
				`hash` = "'.$modx->db->escape(uniqid()).'"
			');
    		$question_id = $modx->db->getInsertId();
			$modx->db->query('INSERT INTO `new_question_2_theme` SET 
				question_id	= "'.$modx->db->escape($question_id).'",
				theme_id = "'.$modx->db->escape($cc_theme['id']).'",
				position = "'.$modx->db->escape($num).'"
				');
			echo 'ok'; 

		}
		*/

		echo "<p></p>";
	}
}
echo "</table>";
echo "<h1>ВСЬОГО ПИТАНЬ: ".$cnt_questions." | У НАС В БАЗІ: ".$cnt_questions_base."</h1>";





/*
$cnt = 0;
$images = $pdf->getObjectsByType('XObject', 'Image');
foreach( $images as $image ) {
	$type = $image->getHeader()->getDetails();

	echo '<p><img src="data:image/gif;base64,'. base64_encode($image->getContent()) .'" /></p>';
	//	file_put_contents(MODX_BASE_PATH.'assets/shop/pdr/img/img_'.$cnt.'.jpg', $image->getContent());

    $cnt++;
}
*/

}
die;