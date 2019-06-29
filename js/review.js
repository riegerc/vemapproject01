/*
Autor: Christian Riedler
*/
function setLabelText(rangeId,labelId){
	var sum=countVals(labelId);
	var lbl=document.getElementById('lbl'+labelId);
	lbl.innerHTML=sum;
}
function countVals(labelid){
	var sum=0;
	var ul=document.getElementById("slds"+labelid);
	var lis=ul.children;
	for(var i=0;i<lis.length;i++){
		var inputs =lis[i].getElementsByTagName("input");
		for(var j=0;j<inputs.length;j++){
			sum+=parseInt(inputs[j].value);
		}
	}
	return sum;
}
