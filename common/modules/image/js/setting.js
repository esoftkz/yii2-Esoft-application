function showCoords(c)
{
	var rx = c.x;
	var ry = c.y;
	w = c.w;
	h = c.h;
	
	$("#imagethumbnails-x").val(rx);
	$("#imagethumbnails-y").val(ry);
	$("#imagethumbnails-w").val(c.w);
	$("#imagethumbnails-h").val(c.h);
	
};
