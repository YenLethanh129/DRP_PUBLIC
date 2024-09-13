<?php 
namespace App\Utils;

class RecipeUnitConverterController { 
  const CONVERSION_RATIOS = [
    'TSP' => ['DSP' => 4 / 3, 'TBSP' => 1 / 3, 'CUP' => 1 / 48, 'ML' => 5, 'LIT' => 1 / 200],
    'DSP' => ['TSP' => 3 / 4, 'TBSP' => 3 / 4, 'CUP' => 1 / 20, 'ML' => 20, 'LIT' => 1 / 60],
    'TBSP' => ['TSP' => 3, 'CUP' => 1 / 16, 'ML' => 15, 'LIT' => 1 / 67],
    'CUP' => ['TSP' => 48, 'TBSP' => 16, 'ML' => 240, 'LIT' => 0.24],
    'ML' => ['TSP' => 1 / 5, 'TBSP' => 1 / 16, 'CUP' => 1 / 240, 'LIT' => 1 / 1000],
    'LIT' => ['TSP' => 200, 'TBSP' => 67, 'CUP' => 240, 'ML' => 1000],
    'G' => ['KG' => 1 / 1000, 'MG' => 1000],
    'KG' => ['G' => 1000, 'MG' => 1000000],
    'MG' => ['G' => 1 / 1000, 'KG' => 1 / 1000000]
  ];

  static public function convertUnits($input, $toUnit) {
    try {
      // Seperate number and letter parts 
      preg_match('/([\d\s\/]+)\s*(\D+)/', $input, $matches);
      $trimInput = array(trim($matches[1]), trim($matches[2]));
      if (!isset(self::CONVERSION_RATIOS[$trimInput[1]]) || !isset(self::CONVERSION_RATIOS[$trimInput[1]][$toUnit]))
        throw new \Exception("Incapitable unit or no suitable conversion ratio! ");

      // Trim the number and fraction 
      preg_match('/(\d+)\s*(\d*\/\d*)?/', $trimInput[0], $matches);
      $fraction = 0;
      if (isset($matches[2]) && !empty($matches[2])) {
        list($numerator, $denominator) = explode('/', $matches[2]);
        $fraction = (float)($numerator) / (float)($denominator);
      }
      
      // Calculate the total amount
      $total = number_format((intval($matches[1]) + $fraction), 5);
      $conversionRatio = self::CONVERSION_RATIOS[$trimInput[1]][$toUnit];
      $convertedAmount = (float)$total * $conversionRatio;
      return $convertedAmount;
    } catch (\Exception $e) {
      echo $e->getMessage();
      return false;
    }
  }
}
