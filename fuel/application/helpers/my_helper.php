<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
// add your site specific functions here
function gen_unique_id($id,$max,$prefix="",$type=0)
{
		$size=strlen($id);
		$rand_size=$max-$size;
		if($rand_size<0)
		{
			$id=substr($id, 0,$max);
			$pad="";
		}
		else
		{
			if($type==1)
			{
				$pad=salt_num($rand_size);
			}
			else
			{
				$pad=salt($rand_size);
			}
	    }
		$new_string=$pad.$id;
		$new_length=strlen($new_string);
		if($new_length<$max)
		{
			gen_unique_id($new_string);
		}
		return $prefix.$new_string;
}
function clean_string($string) 
{
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function search_file($dir,$string)
{
	$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
	$it->rewind();
	$found=false;

	while($it->valid()) 
	{
		$found=false;
	    if (!$it->isDot()) 
	    {
	        if (strpos($it->key(),$string) !== false) 
	        {
				   $found=true;
				   return $found;
			}
	    }
	    $it->next();
	}
	return$found;
}
function image_upload_rename($model,$path,$data,$my_fields_map,$fld="system_id")
{
	 $ci=& get_instance();
     $dir = assets_server_path($path);


     foreach ($my_fields_map as $key =>$val)
     {
        if(isset($data['id']))
        {   
        	if(isset($data[$key]))
        	{  
	        	$ext = pathinfo($data[$key], PATHINFO_EXTENSION); 
		        $res=$ci->$model->find_one_array(array('id'=>$data['id']));
		        $old_db_file=$res?$res[$key]:"";
		        $old_slug=$res?$res[$fld]:"";

		        if($old_db_file!==$data[$key])
		        {
		        	//echo "remove old file ".$old_slug.$val.".".$ext;
		        	//unlink($dir.$old_db_file);
		        	//die;
		        }

		        if($fld==="user_name")
		        {
					$old_file="{".$fld."}".$val.".".$ext;
					$new_file=$data[$key];
				}
				if($fld==="system_id")
		        {
					$old_file="{".$fld."}".$val.".".$ext;
					$new_file=$data[$fld].$data[$key];
				}

				$data[$key]=$new_file;

		     	if(search_file($dir,$old_file))
		     	{
		     		rename($dir.$old_file, $dir.$new_file); 
		     	} 
	     	}
     	}
     }
     return $data;
}

function upload_files($fields,$path,$data,$type="")
{
	$ci=& get_instance();
 	$dir = assets_server_path($path);
	if (!is_dir($dir)) 
	{ 
        $theupload_path = mkdir($dir, 0777, true);
    }	
	
	foreach ($fields as $key => $val) 
	{
		$config['upload_path'] = $dir;
		if($type==="form")
		{
		 	$config['allowed_types'] = 'doc|docx|pdf';
		}
		else
		{
         	$config['allowed_types'] = 'jpg|jpeg|jpe|png|gif';
     	}
        $config['max_size'] = 0;
		$config['max_width'] = 0;
		$config['max_height'] = 0;
		$config['overwrite'] = TRUE;
        $ci->load->library('upload', $config);
		$ci->upload->initialize($config);
		 //    Make Directory

	  	if(isset($_FILES[$key]))
		{
			$val= $_FILES[$key]["name"];

			if($val!=="")
			{
				//$ext = pathinfo($val, PATHINFO_EXTENSION);
				if(isset($data['slug']))
				{
					$new_file=$data['slug']."-".$data['merchantShop']."$val";
		     	    $data[$key]=$new_file;
					if ($ci->upload->do_upload($key))
					{
						$u_data = array('upload_data' => $ci->upload->data());
						$old_file=$u_data['upload_data']['file_name'];
			            rename($dir.$old_file, $dir.$new_file);	
				    }
				}
				else
				{
					$new_file=$data['user_name']."$val";
		     	    $data[$key]=$new_file;
					if ($ci->upload->do_upload($key))
					{
						$u_data = array('upload_data' => $ci->upload->data());
						$old_file=$u_data['upload_data']['file_name'];
			            rename($dir.$old_file, $dir.$new_file);	
				    }
				}


			}
		}
 	}
	return $data;
}
function salt($size=32)
{
	return substr(md5(uniqid(rand(), TRUE)), 0, $size);
}
function salt_num($size=32)
{
	$pos = "1234567890";//no vowels  
      $i = 0; 
      $num="";  
      while ($i < $size) 
      {     
        $char = substr($pos, mt_rand(0, strlen($pos)-1), 1);
        if (!strstr($num, $char)) 
        { 
          $num.= $char;
        $i++;
        }
      }
    return $num;  
}
function salted_password_hash($password, $salt)
{
	return sha1($password.$salt);
}
function encrypt($txt)
{
	$ci=& get_instance();
	$str= $ci->encrypt->encode($txt);
	return base64url_encode($str);
}
function decrypt($txt)
{
	$ci=& get_instance();
	$str=base64url_decode($txt);
	return $ci->encrypt->decode($str);	
}
function base64url_encode($str) 
{
    $str=strtr(base64_encode($str), '+/', '-_');
    return urlencode($str);
}
function base64url_decode($base64url) 
{
	$base64url=urldecode($base64url);
    return base64_decode(strtr($base64url, '-_', '+/'));
}	
function encrypt_data($data)
{
	foreach($data as $key=> $val)
	{
		$data[$key]=encrypt($val);
	}
	return $data;
}
function get_logged_in_admin() 
{	
	$ci=& get_instance();	
	$user=$ci->companies_users_auth->valid_user();
	return $user;
}

/* End of file my_helper.php */
/* Location: ./application/helpers/my_helper.php */
