<?php


function Copy_Line_Text($itemid,$str_price,$str_month)
{	
	// $str_price='2423,2277';
	// $$str_month ='"02","03"';
	$content = '{

"elements": [ {
"type": "line", "text":"\u623f\u4ef7","values": ['.$str_price.'],"colour": "#FF0000"}], 
"x_axis": { "colour": "#A5A5A5", "grid-colour": "#E7E7E7", "labels": { "steps": 1, "labels": ['.$str_month.']}},
"title": {
    "text": "\u623f\u4ef7\u8d70\u52bf\u56fe",
    "style": "{font-size: 12px; font-family: Times New Roman; color: #000000; text-align: center;}"
  },
 "y_axis":{"grid-colour":"#E7E7E7","colour":"#A5A5A5","steps":500,"min":3000,"max":12000},
 "bg_colour":"#FFFFFF"
}';

	if($handle = @fopen(AJ_ROOT."/data-files/linesale_$itemid.txt","w+"))
	
	{
		fwrite($handle,$content) ;//chmod("../data-files/line_$HouseID.txt",0777) ; 
	}
		

}
?>