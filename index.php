  <!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Land Converter</title>
      <link rel="stylesheet" href="styles.css">
  </head>

  <body>

  <?php 
  $finalRopani= "";
  $finalAnna="";
  $finalBigha="";
  $finalDaam="";
  $finalPaisa="";
  $finalKattha="";
  $finalDhur="";
  $squareFeet="";
  $squareMeter="";
          
          function ropaniToSquareFeet($ropani){
              return $ropani * 5476.00;
          }
          
          function annaToSquareFeet($anna){
              return $anna * 342.25;
          }
          
          function paisaToSquareFeet($paisa){
              return $paisa * 85.56;
          }
          
          function squareFeetToMeter($squareFeet){
              return $squareFeet * 0.092903;
          }
          
          function daamToSquareFeet($daam){
              return $daam * 21.39;
          }
          
          function katthaToSquareFeet($kattha){
              return $kattha * 3645;
          }
          
          function dhurToSquareFeet($dhur){
              return $dhur * 182.25;
          }
          
          function squareFeetToDhur($sqFeet){
              return $sqFeet / 182.25;
          }

          function squareFeetToDaam($sqFeet){
              return $sqFeet * 0.047;
          }

          function splitDecimal($input) {
            // Check if the input is a valid decimal number
            if (preg_match('/^-?\d+(\.\d+)?$/', $input)) {
                // Split the decimal into integer and decimal parts
                $parts = explode('.', $input);
        
                // If the decimal part exists, return both parts, else return only the integer part
                if (count($parts) === 2) {
                    return [
                        'integer' => intval($parts[0]),
                        'decimal' => intval($parts[1])
                    ];
                } else {
                    return [
                        'integer' => intval($parts[0]),
                        'decimal' => 0
                    ];
                }
            } else {
                // Return an error or handle invalid input as needed
                return false;
            }
          }
          
          if (isset($_POST['convert-button'])) {
              $ropaniInput = floatval($_POST['ropani']);
              $annaInput = floatval($_POST['anna']);
              $paisaInput = floatval($_POST['paisa']);
              $daamInput = floatval($_POST['daam']);
              $bighaInput = floatval($_POST['bigha']);
              $katthaInput = floatval($_POST['kattha']);
              $dhurInput = floatval($_POST['dhur']);
              $sqfeetInput = floatval($_POST['sqfeet']);
              $sqmeterInput = floatval($_POST['sqmeter']);

  // For Ropani Aana Dhur
              if($ropaniInput > 0 || $annaInput > 0 || $paisaInput > 0 || $daamInput > 0){
                $squareFeet = $ropaniInput * 5476 + $annaInput * 342.25 + $paisaInput * 85.56 + $daamInput * 21.39;

                $bighaValue = $squareFeet / 72900;
                $katthaValue = $squareFeet / 3645;
                $dhurValue = $squareFeet / 182.25;  

                //Main Logic for bigha kattha dhur//
                if ($dhurValue > 20) {
                  $finalDhur = $dhurValue % 20;
                  $katthaOne = $dhurValue - $finalDhur;
                  if ($katthaOne > 20) {
                      $finalKattha = $katthaOne / 20;
                      
                      if($finalKattha > 20){
                        $finalBigha = $finalKattha / 20;
                        $finalKattha = $finalKattha % 20;
                        

                      }else{
                        $finalBigha = 0;
                      }

                  } else {
                      $finalKattha = $katthaOne;
                  }

              } else { 
                  $finalDhur = $dhurValue;
              }
              $splitKattha = is_array(splitDecimal($finalKattha)) ? splitDecimal($finalKattha) : ['integer' => 0, 'decimal' => 0];
              $splitBigha = is_array(splitDecimal($finalBigha)) ? splitDecimal($finalBigha) : ['integer' => 0, 'decimal' => 0];
              $katthaDecimal = $splitBigha['decimal'];
              $finalBigha = $splitBigha['integer'];
              
              $dhurDecimal = $splitKattha['decimal'] * 0.2;
              $dhurSecondPart = round(floatval($dhurDecimal), 0);
              
              $almostDhur = $finalDhur . '.' . $dhurSecondPart;
              $finalDhur = round(floatval($almostDhur), 2);
              $finalKattha = $splitKattha['integer'];

               
              }elseif($ropaniInput === 0 && $annaInput === 0 && $paisaInput === 0 && $daamInput === 0){
                $finalRopani = 0;
                $finalAnna = 0;
                $dhurInput = 0;
              }


          // For Bigha Kattha Dhur
          if($bighaInput > 0 || $katthaInput > 0 || $dhurInput > 0){
            $squareFeet = floatval($bighaInput * 72900 + $katthaInput * 3645 + $dhurInput * 182.25);

            $ropaniValue = $squareFeet / 5476.00 ;
            $annaValue = $squareFeet / 342.25; 
            $paisaValue = $squareFeet / 85.56;
            $daamVal = $squareFeet / 21.39;
            $daamValue = round($daamVal, 2);
            // $annaValue = $squareFeet *  


            $finalRopani = $ropaniValue;
            $finalAnna = $annaValue;
            $finalPaisa = $paisaValue;
            $finalDaam = $daamValue;

        // main logic for Ropani ...
            if($daamValue > 4){
                $finalDaam = $daamValue % 4;
                $paisaOne = $daamValue - $finalDaam;
                if($paisaOne > 4){
                    
            // $daamSecondPart = round($daamDecimal, 2);
            $splitPaisa = splitDecimal($finalPaisa);

            $paisaDecimal = $splitPaisa['decimal'];
            $finalPaisa = $paisaOne / 4;
            $daamDecimal = $paisaDecimal * 4;
            $almostDaam = $finalDaam.'.'.$daamDecimal;
            $finalDaam = round((float)$almostDaam, 2);
            $finalPaisa = $splitPaisa['integer'];

                    if($finalPaisa > 4){
                        $annaOne = $finalPaisa / 4;
                        $finalPaisa = $finalPaisa % 4;
                        $splitAnna = splitDecimal($finalAnna);
                        $finalAnna = $splitAnna['integer'];

                        if($finalAnna > 16){
                            $finalRopani = $finalAnna / 16;
                            $finalAnna = $finalAnna % 16;
                            $splitRopani = splitDecimal($finalRopani);
                            $finalRopani = $splitRopani['integer'];

                        }else{
                            $finalRopani = 0; 
                        }
                        
                    }else{
                        $finalAnna = 0;
                    }
                }else{
                    
                    $finalPaisa = $paisaOne;
                }
            }else{
                $finalDaam = round((float)$daamValue, 2);
            }

            


            


            // daam Decimal Conversion Concatenation.
            
            //conversion concatenation end

            




            
          }elseif($bighaInput === 0 && $katthaInput === 0 && $dhurInput === 0){
            $finalRopani = 0;
            $annaInput = 0;
            $paisaInput = 0;
            $daamInput = 0;
          }



          $sqMet = squareFeetToMeter($squareFeet);
          $squareMeter = round($sqMet, 2);
          
        }
      
              
          // }

          //For Ropani Anna Paisa Daam
        //   $squareDaam = squareFeetToDaam($squareFeet);
        //   if ($squareDaam > 4) {
        //     $finalDaam = $squareMeter % 4;
        //     $paisaOne = $squareMeter - $finalDaam;
        
        //     if ($paisaOne > 4) {
        //         $finalPaisa = $paisaOne / 4;
        
        //         if ($finalPaisa > 4) {
        //             $finalAnna = $finalPaisa / 4;
        //             $finalPaisa = $finalPaisa % 4;
        
        //             if ($finalAnna > 4) {
        //                 $finalRopani = $finalAnna / 4;
        //                 $finalAnna = $finalAnna % 4;
        //             } else {
        //                 $finalRopani = 0;
        //             }
        //         } else {
        //             $finalAnna = $finalPaisa;
        //             $finalRopani = 0;
        //         }
        //     } else {
        //         $finalPaisa = $paisaOne;
        //         $finalAnna = 0;
        //         $finalRopani = 0;
        //     }
        // } else {
        //     $finalDaam = $squareMeter;
        //     $finalPaisa = 0;
        //     $finalAnna = 0;
        //     $finalRopani = 0;
        // }
      ?>

      <form action="index.php" method="post">
      <div class="wrapper">
          <div class="first-row">
              <label for="ropani">Ropani</label>
              <input type="text" id="ropani" name="ropani" value="<?php echo $finalRopani; ?>" placeholder="0">

              <label for="ropani">anna</label>
              <input type="text" id="anna" name="anna" value="<?php echo $finalAnna; ?>" placeholder=  "0">

              <label for="paisa">Paisa</label>
              <input type="text"  id="paisa" name="paisa" value="<?php echo $finalPaisa; ?>" placeholder="0">

              <label for="daam">Daam</label>
              <input type="text"  id="daam" name="daam" value="<?php echo $finalDaam; ?>" placeholder="0">
          </div>
          <div class="second-row">
              <label for="bigha">Bigha</label>
              <input type="text"  id="bigha" name="bigha" value = "<?php echo $finalBigha; ?>" placeholder="0">
              <label for="kattha">Kattha</label>
              <input type="text" id="kattha" name="kattha" value = "<?php echo  $finalKattha; ?>" placeholder="0">

              <label for="dhur">Dhur</label>
              <input type="text" id="dhur" name="dhur" value = "<?php echo $finalDhur; ?>" placeholder="0">
              
          </div>
          <div class="third-row">
          <label for="sqfeet">Sq.Feet</label>
              <input type="text" id="sqfeet" name="sqfeet" value="<?php echo $squareFeet;?>" placeholder="0">

              <label for="sqmeter">Sq.Meter</label>
              <input type="text" id="sqmeter" name="sqmeter" value = "<?php echo $squareMeter; ?>" placeholder="0">
          </div>
          <button type="submit" name="convert-button">Convert</button>
      </div>    
      
      </form>
      <script>
    if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
  }
  </script>
  </body>
  </html>