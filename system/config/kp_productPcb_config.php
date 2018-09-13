<?php

//棣栨杩愯鐨勬椂鍊欒鍚敤涓嬫柟涓よ鏃ュ織浠ｇ爜锛岀敤浜庡彇寰梡roduct options
//鎴愬姛鑾峰彇鍚庯紝鍗冲彲鍒犻櫎鎴栭噸鏂版敞閲婁笅鏂逛袱琛屾棩蹇椾唬鐮併??
//姝ラ锛? 鍘婚櫎娉ㄩ噴绗?->娴忚鍣ㄦ墦寮?鏂板晢鍝丳CB Prototype鐨勯〉闈?->鏈嶅姟鍣╯ystem/logs/kp_debug.txt鏌ョ湅鏃ュ織
//$log = new Log("kp_debug.log");
//$log->write(print_r($options,1));


/**
  PCB options setup, format as following:
  this is only an example
  548 => array('name'=>'Material',           'tips'=>'123'),
  product_option_id => array('name'=>'option name', 'tips'=>'the contents here will display for question mark popups')
 */
$config_PCB = array(
    637 => array('name' => 'Material', "tips" => "FR-4 is the most commonly used PCB material. Aluminum Base performs well with heat radiation and is commonly used for LED projects. Flexible Printed Circuit Board (FPCB) can be bent to some extent. <a href='https://www.smart-prototyping.com/PCB-Materials-Description-and-Comparison' target='_blank'>Learn More</a>"),
    638 => array('name' => 'Layers', "tips" => "This option is set for how many circuit layers in your design. Please try to design your board with fewer circuit layers because multi-layer board is not cheap."),
    639 => array('name' => 'Dimension Length (mm)', "tips" => "The maximum length and width of your board. Dimension limitation is minimum 10mm and maximum 500mm for an online quotation. Contact us for additional sizes."),
    640 => array('name' => 'Dimension Width (mm)', "tips" => ""),
    647 => array('name' => 'PCB Quantity', "tips" => ""),
    645 => array('name' => 'Separated Different Design', "tips" => "Number of separated different designs included in your Gerber file. Please learn more if you are unsure about the amount. <a href='https://www.smart-prototyping.com/Separated-Different-Designs' target='_blank'>Learn More</a>"),
    646 => array('name' => 'Panelized PCBs', "tips" => "If you require panelized PCBs, you can either define it by yourself in your Gerber file or we can help you define it (for our help please select, “Required”). <a href='https://www.smart-prototyping.com/Panelized-PCBs' target='_blank'>Learn More</a>"),
    648 => array('name' => 'Solder Mask Color', "tips" => "Note: The silkscreen color is white for all solder mask colors except the white solder mask. For white solder masks, the silkscreen is black."),
    649 => array('name' => 'PCB Thickness', "tips" => "Board thickness tolerance is +/-10%. Solder mask and copper plating will make the boards thicker. <a href='https://www.smart-prototyping.com/PCB-Thickness' target='_blank'>Learn More</a>"),
    650 => array('name' => 'Copper Thickness', "tips" => "This parameter is for the Top/Bottom layer circuits’ copper weight. <a href='https://www.smart-prototyping.com/Copper-Thickness' target='_blank'>Learn More</a>"),
    651 => array('name' => 'Inner Copper Thickness', "tips" => "Inner copper weight by default is 0.5oz and has no extra fees."),
    652 => array('name' => 'Surface Finish', "tips" => "OSP (Organic Solderability Preservative) is a water-based, organic surface finish that is typically used for copper pads. <a href='https://www.smart-prototyping.com/PCB-Surface-Finish-Breakdown-Pros-and-Cons' target='_blank'>Learn More</a>")
);
$config_Panelized_PCBs = array(
    'rows' => 642,
    'colums' => 641
);

$config_special = array(
    654 => array('name' => 'Min. Hole Size', "tips" => "The minimum drilling size of the hole in your PCB."),
    653 => array('name' => 'Min. Trace / Space', "tips" => "The minimum width of the trace /space in your PCB."),
    655 => array('name' => 'BGA', "tips" => ""),
    656 => array('name' => 'Edge Connector', "tips" => "Gold Fingers are gold plated connectors on one edge of a printed circuit board."),
    657 => array('name' => 'Blind Vias', "tips" => "The online quotation is for 1-order blind/ buried vias. If your board is more complex our customer service will contact you for extra charge. "),
    658 => array('name' => 'Half Cut Holes', "tips" => "Should half-cut holes on the edge of the PCB be made with copper? This will allow it to be soldered to another PCB."),
    659 => array('name' => 'Impedance Control', "tips" => ""),
);

$config_stencil = array(
    660 => array('name' => 'Stencil Dimensions', 'type' => 'drop-select', "tips" => "Please make sure the effective area should be larger than PCB size. <a href='https://www.smart-prototyping.com/SMT-Solder-Paste-Stencil' target='_blank'>Learn More</a>"),
    661 => array('name' => 'Stencil Quantity', "tips" => ""),
    662 => array('name' => 'Fiducial Mark', 'type' => 'select', "tips" => "Fiducial Mark is designed to help the SMT placement machine to check the location. "),
    664 => array('name' => 'Polishing Technique', 'type' => 'select', "tips" => "BGA plating is also called Electropolishing. If your board has BGA, we highly recommend you to choose BGA Plating."),
);

$config_gerber = array(
    643 => array('name' => 'Gerber File'),
    644 => array('name' => 'Remarks')
);

/**
 * Expedited Production Cost ID and front page settings
 * product_option_id => array(
 *      'name' => 'option name',
 *      'option_prices' => array(
 *          product_option_value_id => (price/piece)
 *      )
 * )
 */
$config_expedited = array(
    663 => array(
        'name' => 'Expedited Production Cost',
    ),
);

$config_expeditedRules = array(
    'layer' => 638,
    'qty' => 647,
    'material' => 637,
    
    'material_options' => array(
        #Material=FR-4
        1593 => array(
            'pre_condition' => array(
                #PCB Thickness=0.8,,1.0,1.2,1.6
                649 => [1656, 1657, 1658, 1659],
                
                #Dimension Length<=20
                'dimension_l' => [639, 200],
                
                #Dimension Length<=20
                'dimension_w' => [640, 200],
                
                #Copper thickness=1oz
                650 => [1663],
                
                #Inner Copper=0.5oz
                
                
                #Min Hole size=0.3mm
                654 => [1681],
                
                #Min Trace / Space=6/6mil
                653 => [1676],
                
                #Blind Vias=no
                657 => [1688],
                
                #BGA=no
                655 => [1682],
                
                #Castellated Holes=no
                658 => [1690],
                
                #Gold fingers=no
                656 => [1686],
                
                #Impedance Control=no
                659 => [1692]
            ),
            
            #layer=1, PCB qty<=30, production time show 3-4 working days, 2 Working Day, 1 Working Day
            'result_layer1_qty30' => array(
                'pre_success' => [1720,1723,1724],
                'pre_fail' => [1720],
                'pre_success_default' => 1720,
                'pre_fail_default' => 1720,
            ),
            
            #layer=1, and 30>qty<=50, production time 4-5 working days, 3 Working Day, 2 Working Day
            'result_layer1_qty3050' => array(
                'pre_success' => [1719,1721,1728],
                'pre_fail' => [1719],
                'pre_success_default' => 1719,
                'pre_fail_default' => 1719,
            ),
            
            // #layer=1, pcb qty>50, only show 5-6 working days
            // 'result_layer1_qty50' => array(
            //     'normal' => [1718],
            //     'normal_default' => 1718
            // ),

                 #layer=1,pcb 50<qty<=100,only show 4-5 working days
            'result_layer1_qty50100' => array(
                'normal' => [1719],
                'normal_default' => 1719
            ),

           #layer=1, pcb 100<qty<300, only show 5-6 working days
            'result_layer1_qty100300' => array(
                'normal' => [1718],
                'normal_default'=>1718
            ),
            
            #layer=1,pcb 300<qty<1000,only show 7-9 working days
            'result_layer1_qty3001000' => array(
                'normal' => [1717],
                'normal_default' =>[1717]
            ),
            
            #layer=1,pcb 100<qty<10000,only show 9-11 working days
            'result_layer1_qty100010000' => array(
                'normal' => [1716],
                'normal_default' => 1716
            ),
            
            #layer=2, pcb qty<=30, show 3-4 working days, 2 Working Day, 1 Working Day, 3-4 working days
            'result_layer2_qty30' => array(
                'pre_success' => [1720,1723,1724],
                'pre_fail' => [1720],
                'pre_success_default' => 1720,
                'pre_fail_default' => 1720,
            ),
            
            #layer=2, and 30>qty<=50, production time 4-5 working days, 3 Working Day, 2 Working Day
            'result_layer2_qty3050' => array(
                'pre_success' => [1728,1721,1719],
                'pre_fail' => [1719],
                'pre_success_default' => 1719,
                'pre_fail_default' => 1719,
            ),
            
            #layer=2, pcb qty>50, only show 4-5 working days
            // 'result_layer2_qty50' => array(
            //     'normal' => [1719],
            //     'normal_default' => 1719
            // ),
            #layer=2,pcb 50<qty<=100,only show 
            'result_layer2_qty50100' => array(
                'normal' => [1719],
                'normal_default' => 1719
            ),

           #layer=2, pcb 100<qty<300, only show 5-6 working days
            'result_layer2_qty100300' => array(
                'normal' => [1718],
                'normal_default'=>1718
            ),
            
            #layer=2,pcb 300<qty<1000,only show 7-9 working days
            'result_layer2_qty3001000' => array(
                'normal' => [1717],
                'normal_default' =>[1717]
            ),
            
            #layer=2,pcb 100<qty<10000,only show 9-11 working days
            'result_layer2_qty100010000' => array(
                'normal' => [1716],
                'normal_default' => 1716
            ),
            
            #layer=4, pcb qty<=30, show 4-5 working days, 3 Working Day, 2 Working Day,
            'result_layer4_qty30' => array(
                'pre_success' => [1719,1722,1729],
                'pre_fail' => [1719],
                'pre_success_default' => 1719,
                'pre_fail_default' => 1719,
            ),
            
            #layer=4, pcb 30<qty<=100, show 5 - 6 Working Days
            'result_layer4_qty30100' => array(
                'normal' => [1718],
                'normal_default' => 1718
            ),

            #layer=4,pcb 100<qty<=100,show 6-7 Working Days
            'result_layer4_qty100500' => array(
                'normal' => [2037],
                'normal_default' => 2037
            ),

            #layer=4,pcb 500<qty<=1000,show 7-9 Working Days
            'result_layer4_qty5001000' => array(
                'normal' => [1717],
                'normal_default' => 1717
            ),

            #layer=4,pcb qt 1000,show 9-12 Working Days
            'result_layer4_qtygt1000' => array(
                'normal' => [1716],
                'normal_default' => 1716
            ),
            
            #when layer=6, Expedited production Cost show 7-9 working days
             'result_layer6' => array(
                'normal' => [1717],
                'normal_default' => 1717
            ),
            
            #layer=8, 10,12,14,16 show Expedited production Cost 9-11 working days
            'result_layer8' => array(
                'normal' => [1716],
                'normal_default' => 1716
            ),
        ),
        
        #Material=Aluminum Base
        1594 => array(
            #4-5 working days
            'normal' => [1719],
            'default' => 1719
        ),
        
        #Material=Flexible PCB
        1595 => array(
            #7-9 working days
            'normal' => [1717],
            'default' => 1717
        ),
    )
);

/**
 * related options and values settings, disable and hide option values 
*/
$config_banRule = array(
    'trigger_product_option_id' => 637,
    'condition' => array(
        #Material=FR-4
        1593 => array(
            'disabled' => array(
                638 => array(
                    #layers = 1 layer
                    1596 => array(
                        'last' => 1,
                        
                        #Blind via (Disable "Yes")
                        657 => array(1689),
                        #Half-cut / Castellated Holes (Disable "Yes")
                        658 => array(1691),
                        #inner Copper Thickness (hide All Options)
                        651 => array(1667, 1668, 1669),
                        #Thickness disable 2.4
                        649 => array(1661)
                    ),
                    
                    #layers = 2 layer
                    1597 => array(
                        'last' => 1,
                        #Blind via (Disable "Yes")
                        657 => array(1689),
                        #inner Copper Thickness (Hidden All Options)
                        651 => array(1667, 1668, 1669),
                        #Thickness disable 2.4
                        649 => array(1661)

                    ),
                    
                    #layers = 4 layer
                    1598 => array(
                        'last' => 1,
                        #PCB Thickness (Disable "0.4, 2.4")
                        649 => array(1654, 1661),
                        #inner Copper Thickness (Hidden No)
                        651 => array(1666),
                        #Copper Thickness (Hidden 3oz)
                        650 => array(1665),
                    ),
                    
                    #layers = 6 layer
                    1599 => array(
                        'last' => 1,
                        #PCB Thickness (Disable "0.4,0.6,0.8")
                        649 => array(1654, 1655, 1656),
                        #inner Copper Thickness (Hidden No)
                        651 => array(1666),
                        #Copper Thickness (Hidden 3oz)
                        650 => array(1665),
                    ),
                    
                    #layers = 8 layer
                    1600 => array(
                        'last' => 1,
                        #PCB Thickness (Disable "0.4,0.6,0.8")
                        649 => array(1654, 1655, 1656),
                        #inner Copper Thickness (Hidden No)
                        651 => array(1666),
                        #Copper Thickness (Hidden 3oz)
                        650 => array(1665),
                    ),
                    
                    #layers = 10 layer
                    1601 => array(
                        'last' => 1,
                        #PCB Thickness (Disable "0.4,0.6,0.8,1.0")
                        649 => array(1654, 1655, 1656, 1657),
                        #inner Copper Thickness (Hidden No)
                        651 => array(1666),
                        #Copper Thickness (Hidden 3oz)
                        650 => array(1665),
                    ),
                    
                    #layers = 12 layer
                    1602 => array(
                        'last' => 1,
                        #PCB Thickness (Disable "0.4,0.6,0.8,1.0,1.2")
                        649 => array(1654, 1655, 1656, 1657,1658),
                        #inner Copper Thickness (Hidden No)
                        651 => array(1666),
                        #Copper Thickness (Hidden 3oz)
                        650 => array(1665),
                    ),
                    
                    #layers = 14 layer
                    1603 => array(
                        'last' => 1,
                        #PCB Thickness (Disable "0.4,0.6,0.8,1.0,1.2,1.6")
                        649 => array(1654, 1655, 1656, 1657, 1658, 1659),
                        #inner Copper Thickness (Disable No)
                        651 => array(1666),
                        #Copper Thickness (Disable 3oz)
                        650 => array(1665),
                    ),
                    
                    #layers = 16 layer
                    1604 => array(
                        'last' => 1,
                        #PCB Thickness (Disable "0.4,0.6,0.8,1.0,1.2,1.6,2.0")
                        649 => array(1654, 1655, 1656, 1657,1658, 1659, 1660),
                        #inner Copper Thickness (Hide No)
                        651 => array(1666),
                        #Copper Thickness (Hide 3oz)
                        650 => array(1665),
                    ),
                ),
                
                #PCB thickness = 0.4 or 0.6 or 0.8
                649 => array(
                    # 0.4
                    1654 => array(
                        'last' => 1,
                        
                        #Copper thickness (Disable "2oz, 3oz")
                        650 => array(1664, 1665)
                    ),
                    
                    # 0.6
                    1655 => array(
                        'last' => 1,
                        
                        #Copper thickness (Disable "2oz, 3oz")
                        650 => array(1664, 1665)
                    ),
                    
                    # 0.8
                    1656 => array(
                        'last' => 1,
                        
                        #Copper thickness (Disable "2oz, 3oz")
                        650 => array(1664, 1665)
                    ),
                    
                    # 1.0
                    1657 => array(
                        'last' => 1,
                        
                        #Copper thickness (Disable "2oz, 3oz")
                        650 => array(1664, 1665)
                    ),
                    
                    # 1.2
                    1658 => array(
                        'last' => 1,
                        
                        #Copper thickness (Disable "2oz, 3oz")
                        650 => array(1664, 1665)
                    ),
                ),
                
                #Copper thickness
                650 => array(
//                     #Copper thickness = 1oz
//                    1663 => array(
//                        'last' => 1,
//
//                        #Min Tracking / Spacing (Disable "10/10 mil, 15/15 mil")
//                        653 => array(1674, 1675)
//                    ),
                
                    #Copper thickness = 2oz
                    1664 => array(
                        'last' => 1,
                        
                        #min hole size  (Disable "0.20, 0.25")
                        654 => array(1679, 1680),
                        
                        #Min Tracking / Spacing (Disable "4/4 mil, 5/5 mil, 6/6 mil")
                        653 => array(1676, 1677, 1678)
                    ),
                    
                    #Copper thickness = 3oz
                    1665 => array(
                        'last' => 1,
                        
                        #min hole size  (Disable "0.20, 0.25")
                        654 => array(1679, 1680),
                        
                        #Min Tracking / Spacing (Disable "4/4 mil, 5/5 mil, 6/6 mil, 10/10 mil")
                        653 => array(1676, 1677, 1678, 1675)
                    ),
                )
                
            ),
            'hidden' => array(
                
                #PCB Thickness (none-display 0.1, 0.15)
                649 => array(
                    'last' => 1,  
                    #PCB Thickness (none-display 0.1, 0.15)
                        649 => array(1652, 1653)
						
                ),
                
                #Copper thickness (none-dsiplay 0.5oz)
                650 => array(
                    'last' => 1,
                        650 => array(1662)
                ),
                
            )
        ),
        
        #Material=Aluminum Base
        1594 => array(
            'disabled' => array(
                'last' => 1,
                
                #BGA (disable 0.5mm pitch)
                655 => array(1683, 1684, 1685),
                
                #Gold Finger (disable yes)
                656 => array(1687),
                
                #Castellated Holes (disable yes)
                658 => array(1691),
                
                #Impedance Control (disable yes)
                659 => array(1693),
            ),
            'hidden' => array(
                'last' => 1,
                
                #layer (none-display 2, 4, 6, 8, 10, 12, 14, 16)
                638 => array(1597, 1598, 1599, 1600, 1601, 1602, 1603, 1604),
                
                #PCB thickness (none-display 0.1, 0.15, 0.4, 0.6, 0.8,2.0,  2.4)
                649 => array(1652, 1653, 1654, 1655, 1656, 1660, 1661),
                
                #PCB Color (none display green, red, blue, yellow, purple, matt green, matt black)
                648 => array(1643, 1644, 1645, 1646, 1649, 1650, 1651),
                
                #Copper thickness (none-display 0.5oz, 2oz, 3oz)
                650 => array(1662, 1664, 1665),
                
                #inner Copper thickness (none-display all)
                651 => array(1667, 1668, 1669),
                
                #Min Hole Size (none-display 0.20, 0.25)
                654 => array(1679, 1680),
				
				#surface finish (none-display Lead free, ENIG, OSP)
                652 => array(1672, 1673),
                
                #Min Tracking / Spacing (none-display 4/4mil, 5/5mil, 10/10mil, 15/15mil)
                653 => array(1677, 1678, 1674, 1675),
                
                #Blind Vias (hide yes)
                657 => array(1689),
            )
        ),
        
        #Material=Flexible PCB
        1595 => array(
            'disabled' => array(
                'last' => 1,
                
                #BGA (disable 0.5mm pitch)
                655 => array(1683, 1684, 1685),
                
                #Gold Finger (disable yes)
                656 => array(1687),
                
                #Castellated Holes (disable yes)
                658 => array(1691),
                
                #Impedance Control (disable yes)
                659 => array(1693),
            ),
            'hidden' => array(
                'last' => 1,
                
                #layer (none-display 4, 6, 8, 10, 12, 14, 16)
                 638 => array(1598, 1599, 1600, 1601, 1602, 1603, 1604),
                
                #PCB thickness (none-display 0.4, 0.6, 0.8, 1.0, 1.2, 1.6, 2.0,2.4)
                649 => array(1654, 1655, 1656, 1657, 1658, 1659, 1660, 1661),
                
                #PCB Color (none display green, red, blue, black, purple, matt black, matt green)
                648 => array(1643, 1644, 1646, 1648, 1649, 1650, 1651),
                
                #Copper thickness (none-display 2oz, 3oz)
                650 => array(1664, 1665),
                
                #inner Copper thickness (none-display all)
                651 => array(1667, 1668, 1669),
                
                #Min Hole Size (none-display 0.20, 0.25)
                654 => array(1679, 1680),
				
				#surface finish (none-display Lead free, HASL, OSP)
                652 => array(1670, 1671, 1673),
                
                #Min Tracking / Spacing (none-display 4/4mil, 5/5mil, 10/10mil, 15/15mil)
                653 => array(1677, 1678, 1674, 1675),
                
                #Blind Vias (All option)
                657 => array(1689),
            )
        ),
    )
);

$arrDefault_layer12 = array(
/*     #layer=2
     638 =>1597,*/
    #PCB QTY = 10
    647 => 1618,
    #Separated Different Designs =1
    645 => 1605,
    #Panelize PCBs = Not Required
    646 => 1615,
    #Solder Mask Color = Green
    648 => 1643,
    #PCB Thickness = 1.6
    649 => 1659,
    #Copper Thickness = 1oz
    650 => 1663,
    #Inner Copper = No
    651 => 1666,
    #Surface Finish = HASL
    652 => 1670,
    #Min Trace / Space = 6 mil
    653 => 1676,
    #Min Hole Size = 0.3mm
    654 => 1681,
    #BGA = No
    655 => 1682,
    #Gold Finger = No
    656 => 1686,
    #Blind Vias = No
    657 => 1688,
    #Castellated Holes = No
    658 => 1690,
    #Impedance Control = No
    659 => 1692,
    #production time = 3-4 days
    663 => 1720,
    
);

$arrDefault_layer468 = array(
    #PCB QTY = 10
    647 => 1619,
    #Separated Different Designs =1
    645 => 1605,
    #Panelize PCBs = Not Required
    646 => 1615,
    #Solder Mask Color = Green
    648 => 1643,
    #PCB Thickness = 1.6
    649 => 1659,
    #Copper Thickness = 1oz
    650 => 1663,
    #Inner Copper = 0.5oz
    651 => 1667,
    #Surface Finish = HASL
    652 => 1670,
    #Min Trace / Space = 6 mil
    653 => 1676,
    #Min Hole Size = 0.3mm
    654 => 1681,
    #BGA = No
    655 => 1682,
    #Gold Finger = No
    656 => 1686,
    #Blind Vias = No
    657 => 1688,
    #Castellated Holes = No
    658 => 1690,
    #Impedance Control = No
    659 => 1692,
);

$arrDefault_layer1012 = array(
     #PCB QTY = 10
    647 => 1619,
    #Separated Different Designs =1
    645 => 1605,
    #Panelize PCBs = Not Required
    646 => 1615,
    #Solder Mask Color = Green
    648 => 1643,
    #PCB Thickness = 2.0
    649 => 1660,
    #Copper Thickness = 1oz
    650 => 1663,
    #Inner Copper = 0.5oz
    651 => 1667,
    #Surface Finish = HASL
    652 => 1670,
    #Min Trace / Space = 6 mil
    653 => 1676,
    #Min Hole Size = 0.3mm
    654 => 1681,
    #BGA = No
    655 => 1682,
    #Gold Finger = No
    656 => 1686,
    #Blind Vias = No
    657 => 1688,
    #Castellated Holes = No
    658 => 1690,
    #Impedance Control = No
    659 => 1692,
);

$arrDefault_layer1416 = array(
   #PCB QTY = 10
    647 => 1619,
    #Separated Different Designs =1
    645 => 1605,
    #Panelize PCBs = Not Required
    646 => 1615,
    #Solder Mask Color = Green
    648 => 1643,
    #PCB Thickness = 2.4
    649 => 1661,
    #Copper Thickness = 1oz
    650 => 1663,
    #Inner Copper = 0.5oz
    651 => 1667,
    #Surface Finish = HASL
    652 => 1670,
    #Min Trace / Space = 6 mil
    653 => 1676,
    #Min Hole Size = 0.3mm
    654 => 1681,
    #BGA = No
    655 => 1682,
    #Gold Finger = No
    656 => 1686,
    #Blind Vias = No
    657 => 1688,
    #Castellated Holes = No
    658 => 1690,
    #Impedance Control = No
    659 => 1692,
);

$config_defaultCondition = array(
    #material = FR-4
    'condition_0' => array([1593], array(
            #layer=2
            638 =>1597,
            #PCB QTY = 10
            647 => 1619,
            #Separated Different Designs =1
            645 => 1605,
            #Panelize PCBs = Not Required
            646 => 1615,
            #Solder Mask Color = Green
            648 => 1643,
            #PCB Thickness = 1.6
            649 => 1659,
            #Copper Thickness = 0.5oz
            650 => 1663,
            #Inner Copper = No
            651 => 1666,
            #Surface Finish = HASL
            652 => 1670,
            #Min Trace / Space = 6 mil
            653 => 1676,
            #Min Hole Size = 0.3mm
            654 => 1681,
            #BGA = No
            655 => 1682,
            #Gold Finger = No
            656 => 1686,
            #Blind Vias = No
            657 => 1688,
            #Castellated Holes = No
            658 => 1690,
            #Impedance Control = No
            659 => 1692,
    )),
    #material = Flexible PCB
    'condition_1' => array([1595], array(
            #layer=1
            638 =>1596,
           #PCB QTY = 10
    647 => 1619,
    #Separated Different Designs =1
    645 => 1605,
    #Panelize PCBs = Not Required
    646 => 1615,
    #Solder Mask Color = Yellow
    648 => 1645,
    #PCB Thickness = 0.1
    649 => 1652,
    #Copper Thickness = 0.5oz
    650 => 1662,
    #Inner Copper = No
    651 => 1666,
    #Surface Finish = ENIG
    652 => 1672,
    #Min Trace / Space = 6 mil
    653 => 1676,
    #Min Hole Size = 0.3mm
    654 => 1681,
    #BGA = No
    655 => 1682,
    #Gold Finger = No
    656 => 1686,
    #Blind Vias = No
    657 => 1688,
    #Castellated Holes = No
    658 => 1690,
    #Impedance Control = No
    659 => 1692,
    )),
    #material = Aluminum Base
    'condition_2' => array([1594], array(
           #layer=1
            638 =>1596,
            #PCB QTY = 10
    647 => 1619,
    #Separated Different Designs =1
    645 => 1605,
    #Panelize PCBs = Not Required
    646 => 1615,
    #Solder Mask Color = White
    648 => 1647,
    #PCB Thickness = 1.6
    649 => 1659,
    #Copper Thickness = 1oz
    650 => 1663,
    #Inner Copper = No
    651 => 1666,
    #Surface Finish = HASL
    652 => 1670,
    #Min Trace / Space = 6 mil
    653 => 1676,
    #Min Hole Size = 0.3mm
    654 => 1681,
    #BGA = No
    655 => 1682,
    #Gold Finger = No
    656 => 1686,
    #Blind Vias = No
    657 => 1688,
    #Castellated Holes = No
    658 => 1690,
    #Impedance Control = No
    659 => 1692,
    )),
    #material = Fr-4 & layer = 1,2
    'condition_3' => array([1596, 1597], $arrDefault_layer12),
    
    #material = Fr-4 & layer = 4,6,8
    'condition_4' => array([1598, 1599, 1600], $arrDefault_layer468),
    
    #material = Fr-4 & layer = 10,12
    'condition_5' => array([1601, 1602], $arrDefault_layer1012),
    
    #material = Fr-4 & layer = 14,16
    'condition_6' => array([1603, 1604], $arrDefault_layer1416),
    
    #material = Fr-4 & Copper Thickness = 2oz
    'condition_7' => array([1664], array(
            #mini tracking / spacing = 10 mil
            653 => 1675
    )),
    
    #material = Fr-4 & Copper Thickness = 3oz
    'condition_8' => array([1665], array(
            #mini tracking / spacing = 15 mil
            653 => 1674
    )),
);

//material = Fr-4(TG130)
$config_defaultTopTrigger = array(637, 1593);


// Panelized PCBs
$config_panelizedPCBRules = array(
    'option_id' => 646,
    'option_value_id' => [
        1615 => [641, 642],
        1616 => [641, 642],
    ]
);
