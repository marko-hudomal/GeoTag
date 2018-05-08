function setGenderIcon()
{
	//alert("test");
	if (document.getElementById("signup_icon"))
	{
		var g=document.getElementById("gender").value;
		if (g=="m")
			document.getElementById("signup_icon").src="./img/man.png";
		else
			if (g=="f")
				document.getElementById("signup_icon").src="./img/women.png";

	}
}