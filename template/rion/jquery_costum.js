function numbers_only(e){ 
	console.log(e.which);
	if (e.which != 8 && isNaN(String.fromCharCode(e.which))) {
		e.preventDefault();
		return false;
	}
	return true;
}

function auto_caps(element){
	element.value = element.value.toUpperCase();
}

function auto_noncaps(element){
	element.value = element.value.toLowerCase();
}

function disable_arrow_down(e) {
	var key = e.charCode ? e.charCode : e.keyCode ? e.keyCode : 0;
	if (key==40) {
		e.preventDefault();
		return false;
	}
	return true;
}

function currency_formated(num) {
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num))
		num = "0";
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num * 100 + 0.50000000001);
		cents = num % 100;
		num = Math.floor(num / 100).toString();
	if(cents<10)
		cents = "0" + cents;
	for(var i = 0; i < Math.floor((num.length-(1 + i)) / 3); i++)
		num = num.substring(0,num.length-(4 * i + 3))+'.'+num.substring(num.length-(4 * i + 3));
	return (((sign)?'':'-') + num);
}

function print_div(div_name) {
	var print_contents = document.getElementById(div_name).innerHTML;
	var original_contents = document.body.innerHTML;
	document.body.innerHTML = print_contents;
	window.print();
	document.body.innerHTML = original_contents;
}
