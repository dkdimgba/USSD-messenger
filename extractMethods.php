<?php 


function extractPhoneNumber($input) 
	{
		$i = 0; 
	        $return='';
	while($i<strlen($input) && ($input[$i]<'0' || $input[$i]>'9')) 
		$i++;

	while($i < strlen($input) && ($input[$i]>='0' && $input[$i]<='9') )
		{
			$return.=$input[$i++];
		}

	return $return;

	}
function validatePhoneNumber($input) 
	{
		$return = false;
		if(strlen($input)>=10)
		{
			if(strlen($input)==10)
			{
				if($input[0]>='6')
				$return = true;	
			}
			else 
			{
				if(strlen($input)==12)	
				{
					if($input[0]=='9' && $input[1]=='1' && $input[2]>='6')
					{
						$input=substr($input,2,11);
						$return = true;
					}
				}
				else if(strlen($input)==11)
				{
					if($input[0]=='0' && $input[1]>='6')
					{
						$input=substr($input,1,10);
						$return = true;
					}
				}
			}
		}
		if($return == true)
		return $input;
		else
		{
			return '9999999999';
		}
	}
function getPhoneNum($input)
{
	$input=extractPhoneNumber($input);
	$input=validatePhoneNumber($input);
	return $input;
}

function getMessage($input)
{
	$i=0;
	while($i<strlen($input) && ($input[$i]<'0' || $input[$i]>'9')) 
		$i++;

	while($i < strlen($input) && ($input[$i]>='0' && $input[$i]<='9') )
		{
			$i++;
		}
		while($i<strlen($input) && ($input[$i]==' ')) 
		$i++;

	$return = substr($input,$i,strlen($input)-1);
	return $return;

}

?>