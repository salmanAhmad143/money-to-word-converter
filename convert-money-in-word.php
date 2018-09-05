<?php
function convertCurrencyInWord($number, $currency_type)
{
	$decimal = round($number - ($no = floor($number)), 2) * 100;
	$hundred = null;
	$digits_length = strlen($no);
	$i = 0;
	$str = array();
	$words = array(0 => 'zero', 1 => 'one', 2 => 'two',
		3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
		7 => 'seven', 8 => 'eight', 9 => 'nine',
		10 => 'ten', 11 => 'eleven', 12 => 'twelve',
		13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
		16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
		19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
		40 => 'forty', 50 => 'fifty', 60 => 'sixty',
		70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
		
	$currency = array(	"INR" => array('max_currency' => ' Rupee', 'min_currency' =>' Paise'), 
						"USD" => array('max_currency' => ' Dollar', 'min_currency' =>' Cent')
					);
	$digits = array('', 'hundred','thousand','lakh', 'crore');
	while( $i < $digits_length ) {
		$divider = ($i == 2) ? 10 : 100;
		$number = floor($no % $divider);
		$no = floor($no / $divider);
		$i += $divider == 10 ? 1 : 2;
		if ($number) {
			$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			$str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
		} else $str[] = $words[$number];
	}

	$before_decimal_part = implode('', array_reverse($str)) . $currency[$currency_type]['max_currency'];
	$nearestVal = ($decimal >20) ? floor($decimal / 10) * 10 : $decimal;
	$after_decimal_part = ($decimal) ? " and " . ($words[$nearestVal] . " " . $words[$decimal - $nearestVal]) . $currency[$currency_type]['min_currency'] : '';
	return ($before_decimal_part ? $before_decimal_part : '') . $after_decimal_part;
}
?>