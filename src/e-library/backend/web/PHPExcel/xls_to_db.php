<?php

class Book {
    public $year;
		public $autors;
		public $name;
		public $edition;
		public $outputData;
		public $vak;
		public $rinc;
		public $wos;
		public $scopus;
		public $doi;
		public $link;
}

//require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
/** Include path **/
set_include_path(get_include_path() . PATH_SEPARATOR . '../PHPExcel/Classes/');
/** PHPExcel_IOFactory */
include 'Classes/PHPExcel/IOFactory.php';

function getBooks($file0) {

$file = $file0;//"../data/books/";
/*
if (isset($_GET["file"])) {
	$file = $file .$_GET["file"];
}
else {
	$file = $file ."books.xlsx";
}
echo $file;
*/

$xls = PHPExcel_IOFactory::load($file);
// Устанавливаем индекс активного листа
/*
if (isset($_GET["i"])) {
	$xls->setActiveSheetIndex($_GET["i"]);
}
else {
	$xls->setActiveSheetIndex(0);
}
*/
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();

$arr = array();
$rowIterator = $sheet->getRowIterator();
foreach ($rowIterator as $row) {
// Получили ячейки текущей строки и обойдем их в цикле
$cellIterator = $row->getCellIterator();

$mergedCellsRange;

$book0 = new Book();
$book = (array) $book0;

$key = 0;
foreach ($cellIterator as $cell) {


$rcell = null;
$mergedCellsRange = $sheet->getMergeCells();
foreach($mergedCellsRange as $currMergedRange) {
if($cell->isInRange($currMergedRange)) {
		$currMergedCellsArray = PHPExcel_Cell::splitRange($currMergedRange);
		$rcell = $sheet->getCell($currMergedCellsArray[0][0]);
		break;
	}
}
if ($key > 10)
	break;
$keys = array_keys($book);
/*
echo "<p>keys: {</p>";
echo var_dump($keys);
echo "}</p>";
*/
$key2 = $keys[$key];

	$book[$key2] = ($rcell != null)? $rcell->getCalculatedValue() : $cell->getCalculatedValue();
/*
echo "<p>value: {</p>";
echo var_dump($book[$key2] );
echo "}</p>";
*/
	$key++;
}
$arr[] = $book;
}
unset($arr[0]);
return $arr;
//echo var_dump($arr);
}
?>
