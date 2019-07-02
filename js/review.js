/*
Autor: Christian Riedler
*/
function setLabelText(rangeId,labelId){
	var sum=countVals(labelId);
	var lbl=document.getElementById('lbl'+labelId);
	lbl.innerHTML=Math.round(sum);
}
function countVals(labelid){
	var sum=0;
	var ul=document.getElementById("slds"+labelid);
	var lis=ul.children;
	for(var i=0;i<lis.length;i++){
		var inputs =lis[i].getElementsByTagName("input");
		for(var j=0;j<inputs.length;j++){
			console.log(inputs[j].value);
			sum+=parseFloat(inputs[j].value);
		}
	}
	return sum;
}

var carets = document.querySelectorAll('.up-down');

carets.forEach(function(caret){
  caret.addEventListener("click", function(){
     this.getElementsByTagName('span')[0].classList.toggle('fa-caret-down');
     this.getElementsByTagName('span')[0].classList.toggle('fa-caret-up');
  });
})
