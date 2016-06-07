//Unknown = XX
//PS -> NO/VE/AJ/AV/PR/CO/IN
	//NO -> D1/D2/D3/D4/D5 	-> MA/FE/NE 	-> 	SI/PL 	-> VO/NM/GE/DA/AC/AB (DB-DATIVE+ABLATIVE)
	//VE -> ID/SU/IF 	->	 PR/PE/IM/FU/FP 	->	AC/PA 	->	1P/2P/3P 	-> SI/PL
	//AJ -> MA/FE/NE 	->	 SI/PL
	//PR -> AC/AB
	//CO ->
	//IN -> 
function interpretCode(code)
{
	var POS = code.slice(0,1);
	if(POS=="NO")
	{
		var DEC = code.slice(2,3);
		var GEN = code.slice(4,5);
		var NUM = code.slice(6,7);
		var CAS = code.slice(8,9);
	}
	else if(POS=="VE")
	{
		var MOO = code.slice(2,3);
		var TEN = code.slice(4,5);
		var VOI = code.slice(6,7);
		var PER = code.slice(8,9);
		var NUM = code.slice(10,11);
	}
}
function code(end)
{
	var cases = ["VO","NO","GE","DA","AC","AB"];
	var poss = [];
	var NOtable = ["a","a","ae","ae","am","a","ae","arum","is","as","is","e","us","i","o","um","o","i","orum","is","os","is","um","um","i","o","um","o","a","orum","is","a","is","XX","XX","is","i","em","e","es","um","ibus","es","ibus","a","um",];
	var NOvalue = [];
	for(var x = 0; x<NOtable.length; x++)
	{
		NOvalue[x] = "NO";
		if(x<=10)
			NOvalue[x]+="D1FE";
		else if(x<=21)
			NOvalue[x]+="D2MA";
		else if(x<=32)
			NOvalue[x]+="D2XX";
		else if(x<=43)
			NOvalue[x]+="D4XX";
		else if(x<=54)
			NOvalue[x]+="D5XX";
		if((x%11)<5)
			NOvalue[x]+="SI";
		else
			NOvalue[x]+="PL";
		NOvalue[x]+=cases[(x%11)%6];
	}
	NOvalue[56] = "D1"
	for(var x = 0; x<NOtable.length; x++)
	{
		if(NOtable[x] == "end")
		{
			poss+=NOvalue[x];
		}
	}
	switch end
	{
		case "a":
		return ["NOD"]
		case "o":
		return ["VEIDPRAC1PSI","NOD2MASIDB"];
		
		case "m":
		return ["VEIDPRAC1PSI"];
		
		case "s":
		return ["VEIDPRAC2PSI"];
		
		case "t":
		return ["VEIDPRAC3PSI"];
		
		case "mus":
		return ["VEIDPRAC1PPL"];
		
		case "tis":
		return ["VEIDPRAC2PPL"];
		
		case "nt":
		return ["VEIDPRAC3PPL"];

	}
}
function analyzeText(input)
{
	var clean = input.replace(/,|;|'/g,"");
	var words = clean.split(" ");
	for(var i = 0; i<words.length; i++)
	{
		var word = words[i];
		var req = new XMLHttpRequest();
		req.open("GET", "https://glosbe.com/gapi/translate?from=la&dest=en&phrase="+word+"&format=xml", false);
		req.send();
		req.getElementsByTagName("")
	}
}
