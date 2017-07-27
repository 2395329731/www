function goindex()
{
	self.top.document.getElementById('left').src="?action=left";
	self.top.document.getElementById('main').src="?action=main";
}

function changeMenu(obj)
{
	var child=$("#navtit").children("span");
	var len=$("#navtit").children("span").length;
	
	for(var i=0; i<len; i++)
	{
		child[i].className='';
	}
	obj.className='hover';
}
	