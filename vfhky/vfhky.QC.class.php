<?php
/* PHP QQ_API(Applying in WordPress)
 * @version 1.0
 * @author：vfhky  2013年09月01日20:23
 * @Official Document：http://wiki.connect.qq.com/api%E5%88%97%E8%A1%A8
 * @copyright：http://www.huangkeye.cn  . All rights reserved.
 */

class vfhky_QC_class{
	
	public $appid = "100283136";
	public $appkey = "申请的aapkey";
	public $callback = "huangkeye.cn/wp-content/themes/vfhky/wpwplogin.php";
	public $scope = "get_user_info,get_tenpay_addr,get_info,add_t,del_t,add_pic_t,get_repost_list,get_other_info,get_fanslist,get_idollist,add_idol,del_idol,upload_pic,list_album,add_album,add_one_blog,add_share,check_page_fans";
	public $token = "";
	public $openid = "";	
	
  const GET_AUTH_CODE_URL = "https://graph.qq.com/oauth2.0/authorize";
  const GET_ACCESS_TOKEN_URL = "https://graph.qq.com/oauth2.0/token";
  const GET_OPENID_URL = "https://graph.qq.com/oauth2.0/me";
  
  /**
  * combineURL
  * 拼接url
  * @param string $baseURL   基于的url
  * @param array  $keysArr   参数列表数组
  * @return string           返回拼接的url
  */
  public function combineURL($baseURL,$keysArr){
		$combined = $baseURL."?";
		$valueArr = array();

		foreach($keysArr as $key => $val){
			$valueArr[] = "$key=$val";
		}

		$keyStr = implode("&",$valueArr);
		$combined .= ($keyStr);
        
		return $combined;
	}
	
	/**
	* get_contents
	* 服务器通过get请求获得内容
	* @param string $url       请求的url,拼接后的
	* @return string           请求返回的内容
	*/
	public function get_contents($url){
		if (ini_get("allow_url_fopen") == "1") {
			$response = file_get_contents($url);
		}else{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_URL, $url);
			$response =  curl_exec($ch);
			curl_close($ch);
		}

		//-------请求为空，自定义错误码01
		if(empty($response)){
			$response = "01";
		}

		return $response;
	}

	/**
	* get
	* get方式请求资源
	* @param string $url     基于的baseUrl
	* @param array $keysArr  参数列表数组      
	* @return string         返回的资源内容
	*/
	public function get($url, $keysArr){
		$combined = $this->combineURL($url, $keysArr);
		return $this->get_contents($combined);
	}

	/**
	* post
	* post方式请求资源
	* @param string $url       基于的baseUrl
	* @param array $keysArr    请求的参数列表
	* @param int $flag         标志位
	* @return string           返回的资源内容
	*/
	public function post($url, $keysArr, $flag = 0){
		$ch = curl_init();		// 初始化一个 cURL 对象
		if(! $flag) curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);		//返回获取的输出的文本流而不是直接输出在屏幕
		curl_setopt($ch, CURLOPT_POST, TRUE); 		//以POST方式提交请求
		//curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);//设置cURL允许执行的最长秒数
		curl_setopt($ch, CURLOPT_POSTFIELDS, $keysArr);   //POST提交的请求数组中的数据
		curl_setopt($ch, CURLOPT_URL, $url);		//接收请求的URL
		$ret = curl_exec($ch);		// 运行cURL，请求网页

		curl_close($ch);		//关闭一个cURL会话
		return $ret;
	}

	/**
	* qq_login
	* 拼接请求URL，准备获取Authorization Code
	* @param string $url       基于的baseUrl
	* @param array $keysArr    请求的参数列表
	* @param int $flag         标志位
	* @return string           返回的资源内容
	*/
  public function qq_login(){
    $appid = $this->appid ;
    $callback = $this->callback ;
    $scope = $this->scope ;

    //-------生成唯一随机串防CSRF攻击
    $state = md5(uniqid(rand(), TRUE));
		// 存入session
		$_SESSION["state"]=$state;

    //-------构造请求参数列表
    $keysArr = array(
      "response_type" => "code",
      "client_id" => $appid,
      "redirect_uri" => $callback,
      "state" => $state,
      "scope" => $scope
    );
    
		//-------self是指向类本身，self::获取本类中的成员一般self使用来指向类中的静态变量。
    $login_url =  $this->combineURL(self::GET_AUTH_CODE_URL, $keysArr);

    header("Location:$login_url");
  }

	/**
	* qq_callback
	* 通过Authorization Code获取Access Token
	* 返回$this->token 并产生 $_SESSION["token"]
	*/
  public function qq_callback(){
  	
		//--------返回的错误消息和状态值
		$err_msg = "";
		$ret = 0;
		
    //--------验证state防止CSRF攻击
    if($_GET['state'] != $_SESSION["state"]){
      $err_msg = '网络错误';
      $ret = -1;
    }

    //-------请求参数列表
    $keysArr = array(
      "grant_type" => "authorization_code",
      "client_id" => $this->appid,
      "redirect_uri" => urlencode($this->callback),
      "client_secret" => $this->appkey,
      "code" => $_GET['code']
    );

    //------构造请求access_token的url
    $token_url = $this->combineURL(self::GET_ACCESS_TOKEN_URL, $keysArr);
    $response = $this->get_contents($token_url);

    if(strpos($response, "callback") !== false){

      $lpos = strpos($response, "(");//定位字符串第一次出现的位置
      $rpos = strrpos($response, ")");//定位字符串最后一次出现的位置
      $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
      $msg = json_decode($response);
			
			//--------如果腾讯返回错误信息
      if(isset($msg->error)){
          $ret = $msg->error;
          $err_msg = $msg->error_description;
      }
    }
    
		//--------删除验证的state
		unset($_SESSION["state"]);

    //-------将获取到的access_token等参数变成数组形式保存到$params中
    $params = array();
    parse_str($response, $params);
    
    $this->token = $params["access_token"];
    $_SESSION["token"] = $this->token ;
    return $params["access_token"];

	}
	


	/**
	* get_openid
	* 通过Access Token获取用户的OpenID
	* 返回$this->openid
	*/
	public function get_openid(){

    //-------请求参数列表
    $keysArr = array(
        "access_token" => $_SESSION["token"]
    );

    $graph_url = $this->combineURL(self::GET_OPENID_URL, $keysArr);
    $response = $this->get_contents($graph_url);

    //--------检测错误是否发生
    if(strpos($response, "callback") !== false){

        $lpos = strpos($response, "(");
        $rpos = strrpos($response, ")");
        $response = substr($response, $lpos + 1, $rpos - $lpos -1);
    }

    $user = json_decode($response);
    
		//--------删除验证的token
		unset($_SESSION["token"]);
    
    if(isset($user->error)){
				$ret .= $user->error;
				$err_msg .= $user->error_description;
    }

    return $user->openid;

  }


	/**
	* recall_api
	* 调用腾讯API总控函数
	* @param string $baseurl   		具体的API接口的URL，如https://graph.qq.com/user/get_user_info
	* @param array $keysArr    		具体的API需要传送的参数
	* @param array $request_type  请求的类型：POST,GET
	*/
	private function recall_api($baseurl = "" , $keysArr = array() , $request_type = "get")
	{
		if(empty($_REQUEST["code"])){
			$this->qq_login();
		}
		$this->token = $this->qq_callback();
		$this->openid =  $this->get_openid();

		$data_ret = array(); 
		$base_params = array
		(
			"oauth_consumer_key" => $this->appid,
			"access_token" => $this->token,
			"openid" => $this->openid,
			"format" => "json"
		);
		$query = $base_params + $keysArr;
		
		if($request_type == "get"){
			$results = $this->get($baseurl , $query);
		}else{
			$results = $this->post($baseurl , $query , 0);
		}
		$results = json_decode($results);
		
		if($results->ret != 0)
		{
			$results = "调用接口失败";
		  
		}
		return $results;
	}


//以下是所有腾讯开放平台所有的API列表
/* 1、QZone */
	/**
	* 1.1 add_one_blog
	* 发表日志到QQ空间
	* @title:  	 日志标题（纯文本，最大长度128个字节，utf-8编码）【*】
	* @content:  文章内容（html数据，最大长度100*1024个字节，utf-8编码）【*】	
	* http://wiki.open.qq.com/wiki/website/add_one_blog
	*/
	public function add_one_blog($title = "" , $content = "")
	{
		$url = "https://graph.qq.com/blog/add_one_blog";
		$array = array
		(
			"title"=>$title,
			"content"=>$content
		);
		return $this->recall_api($url , $array , "post");
	}

	/**
	* 1.2 get_user_info
	* 获取登录用户在QQ空间的信息
	* http://wiki.open.qq.com/wiki/website/get_user_info
	*/
	public function get_user_info()
	{
		return $this->recall_api("https://graph.qq.com/user/get_user_info");
	}
	
	/**
	* 1.3 add_album
	* 在用户的空间相册里，创建一个新的个人相册
	* @albumname:  相册名，不能超过30个字符【*】
	* @albumdesc:  相册描述，不能超过200个字符
	* @priv:  		 相册访问权限，1=公开；3=只主人可见，4=QQ好友可见，5=问答加密
	* http://wiki.open.qq.com/wiki/website/add_album
	*/
	public function add_album($albumname = "" , $albumdesc = "" , $priv = 1)
	{
		$url = "https://graph.qq.com/photo/add_album";
		$array = array
		(
			"albumname"=>$albumname,
			"albumdesc"=>$albumdesc,
			"priv"=>$priv
		);
		return $this->recall_api($url , $array , "post");
	}
	
	/**
	* 1.4 upload_pic
	* 上传一张照片到QQ空间相册
	* @picture:    上传的照片（在发送请求时，图片内容以二进制数据流的形式发送，照片名称30个字符）【*】
	* @photodesc:  照片描述，200个字符
	* @title:  		 照片的命名，支持.jpg, .gif, .png, .jpeg, .bmp
	* @albumid:    相册id。可不填，不填时则根据“mobile”标识选择默认上传的相册
	* @mobile:  	 标志位，0表示PC，1表示手机。用于当不传相册id时控制是否传到手机相册
	* @x:  		 		 照片拍摄时的地理位置的经度。请使用原始数据（纯经纬度，0-360）
	* @y:  			   照片拍摄时的地理位置的纬度。请使用原始数据（纯经纬度，0-360）
	* @needfeed:   标识上传照片时是否要发feed（0：不发feed； 默认1：发feed）
	* @successnum: 批量时，已成功上传的张数，指明上传完成情况；单张可以不填，默认为0
	* @picnum:     批量上传照片的总张数，默认为1
	* http://wiki.open.qq.com/wiki/website/upload_pic
	*/
	public function upload_pic($picture="" , $photodesc="" , $title="" , $albumid="" , $mobile=1 , $x="" , $y="" , $needfeed=1 , $successnum=0 , $picnum=1)
	{
		$url = "https://graph.qq.com/photo/upload_pic";
		$array = array
		(
			"picture"=>$picture,
			"photodesc"=>$photodesc,
			"title"=>$title,
			"albumid"=>$albumid,
			"mobile"=>$photodesc,
			"x"=>$x,
			"y"=>$y,
			"needfeed"=>$needfeed,
			"successnum"=>$successnum,
			"picnum"=>$picnum					
		);
		return $this->recall_api($url , $array , "post");
	}
	
	/**
	* 1.5 list_album
	* 获取用户QQ空间相册列表
	* http://wiki.open.qq.com/wiki/website/list_album
	*/
	public function list_album()
	{
		return $this->recall_api("https://graph.qq.com/photo/list_album");
	}
	
	/**
	* 1.6 add_share
	* 发表一个网页分享，分享应用中的内容给好友
	* @title:			分享内容的标题，36个中文字【*】
	* @url:				分享的地址【*】
	* @site:			来源网站的名称【*】
	* @fromurl:		来源网站的域名【*】
	* @summary:		分享内容的摘要，80个中文字
	* @comment:		用户评论，40个中文字
	* @images:		引用外部图片，多个|分开
	* @nswb:			同步到微博，1是，0否
	* @type:			分享内容的类型，4文本，5视频
	* @playurl:		type=5的时候，视频swf播放地址
	* http://wiki.open.qq.com/wiki/website/add_share
	*/
	public function add_share($title="", $url="", $site="", $fromurl="", $comment="", $summary="", $images="", $type=4, $playurl="", $nswb=0)
	{
		if(!isset($title)) 				$title   = "#黄克业的博客# 一个专注于IT互联网技术的博客。";
		if(!isset($url))					$url   	 = "http://www.huangkeye.cn";
		if(!isset($site))					$site    = "黄克业的博客";
		if(!isset($fromurl))			$fromurl = "http://www.huangkeye.cn";
		if(!isset($comment))			$comment = $title;
		if(!isset($summary))			$summary = $title;
		if(!isset($images))				$images = "http://www.huangkeye.cn/public/blog.jpg";
		
		$base_url = "https://graph.qq.com/share/add_share";
		$array = array
		(
			"title"=>$title,
			"url"=>$url,
			"site"=>$site,
			"fromurl"=>$fromurl,
			"comment"=>$comment,
			"summary"=>$summary,
			"images"=>$images,
			"type"=>$type,
			"playurl"=>$playurl,
			"nswb"=>$nswb	
		);		
		
		return $this->recall_api($base_url , $array , "post");
	}
	
	/**
	* 1.7 check_page_fans
	* 验证登录的用户是否为某个认证空间的粉丝
	* @page_id:  认证空间的QQ号码【*】
	* http://wiki.open.qq.com/wiki/website/check_page_fans
	*/
	public function check_page_fans($page_id = "546836353")
	{
		$url = "https://graph.qq.com/user/check_page_fans";
		$array = array
		(
			"page_id"=>$page_id
		);
		return $this->recall_api($url , $array , "get");
	}


/* 2、weibo */

	/**
	* 2.1 add_t
	* 发表一条微博
	* @content:  				要发表的微博内容，140个汉字，URL自动转换为短URL，且折算成11个字节；@好友，则写其微博账号bloghky【*】
	* @clientip:  			用户ip
	* @longitude:  			经度，有效范围：-180.0到+180.0，+表示东经，默认为0.0
	* @latitude:  			纬度，有效范围：-90.0到+90.0，+表示北纬，默认为0.0
	* @syncflag:				标识是否将发布的微博同步到QQ空间，0是，1否
	* @compatibleflag:  容错标志，支持按位操作，默认为0
	* http://wiki.open.qq.com/wiki/website/add_t
	*/
	public function add_t($content="", $clientip="", $longitude="", $latitude="", $syncflag=0, $compatibleflag=0)
	{
		$url = "https://graph.qq.com/t/add_t";
		$array = array
		(
			"content"=>$content,
			"clientip"=>$clientip,
			"longitude"=>$longitude,
			"latitude"=>$latitude,
			"syncflag"=>$syncflag,
			"compatibleflag"=>$compatibleflag
		);
		return $this->recall_api($url , $array , "post");
	}
	
	/**
	* 2.2 add_pic_t
	* 发表一条带图片的微博
	* @content:  				要发表的微博内容，140个汉字，URL自动转换为短URL，且折算成11个字节；@好友，则写其微博账号bloghky【*】
	* @pic:  						要上传的图片的文件名以及图片的内容【*】
	* @clientip:  			用户ip
	* @longitude:  			经度，有效范围：-180.0到+180.0，+表示东经，默认为0.0
	* @latitude:  			纬度，有效范围：-90.0到+90.0，+表示北纬，默认为0.0
	* @syncflag:				标识是否将发布的微博同步到QQ空间，0是，1否
	* @compatibleflag:  容错标志，支持按位操作，默认为0
	* http://wiki.open.qq.com/wiki/website/add_pic_t
	*/
	public function add_pic_t($content="", $pic="", $clientip="", $longitude="", $latitude="", $syncflag=0, $compatibleflag=0)
	{
		$url = "https://graph.qq.com/t/add_pic_t";
		$array = array
		(
			"content"=>$content,
			"pic"=>$pic,
			"clientip"=>$clientip,
			"longitude"=>$longitude,
			"latitude"=>$latitude,
			"syncflag"=>$syncflag,
			"compatibleflag"=>$compatibleflag
		);
		return $this->recall_api($url , $array , "post");
	}
	
	/**
	* 2.3 del_t
	* 删除一条微博
	* @id:  微博消息的ID，用来唯一标识一条微博消息
	* http://wiki.open.qq.com/wiki/website/del_t
	*/
	public function del_t($id="")
	{
		$url = "https://graph.qq.com/t/del_t";
		$array = array
		(
			"id"=>$id
		);
		return $this->recall_api($url , $array , "post");
	}
	
	/**
	* 2.4 get_repost_list
	* 获取单条微博的转发或点评列表
	* @flag:  		标识获取的是转播列表还是点评列表【*】
								0：获取转播列表；1：获取点评列表；2：转播列表和点评列表都获取。
	* @rootid:  	转发或点评的源微博的ID【*】
	* @pageflag:  分页标识，0：第一页；1：向下翻页；2：向上翻页。【*】
	* @pagetime:  本页起始时间【*】
								第一页：0；
								向下翻页：上一次请求返回的最后一条记录时间；
								向上翻页：上一次请求返回的第一条记录的时间。
	* @reqnum:  	每次请求记录的条数。取值为1-100条【*】
	* @twitterid: 翻页时使用【*】
								第1-100条：0；
								继续向下翻页：上一次请求返回的最后一条记录id。
	* http://wiki.open.qq.com/wiki/website/get_repost_list
	*/
	public function get_repost_list($flag="", $rootid="", $pageflag="", $pagetime="", $reqnum="", $twitterid="")
	{
		$url = "https://graph.qq.com/t/get_repost_list";
		$array = array
		(
			"flag"=>$flag,
			"rootid"=>$rootid,
			"pageflag"=>$pageflag,
			"pagetime"=>$pagetime,
			"reqnum"=>$reqnum,
			"twitterid"=>$twitterid
		);
		return $this->recall_api($url , $array , "post");
	}
	
	/**
	* 2.5 get_info
	* 获取登录用户的微博资料
	* http://wiki.open.qq.com/wiki/website/get_info
	*/
	public function get_info()
	{
		return $this->recall_api("https://graph.qq.com/user/get_info");
	}
	
	/**
	* 2.6 get_other_info
	* 获取他人微博资料
	* @name:  		其他用户的账户名
	* @fopenid:  	其他用户的openid
	* http://wiki.open.qq.com/wiki/website/get_other_info
	*/
	public function get_other_info($name="", $fopenid="")
	{
		$url = "https://graph.qq.com/user/get_other_info";
		$array = array
		(
			"name"=>$flag,
			"fopenid"=>$fopenid
		);
		return $this->recall_api($url , $array , "get");
	}
	
	/**
	* 2.7 get_fanslist
	* 获取登录用户的听众列表
	* @reqnum:  		请求获取的听众个数，取值范围为1-30【*】
	* @startindex:  请求获取听众列表的起始位置。第一页：0；继续向下翻页：reqnum*（page-1）【*】
	* @mode:  			获取听众信息的模式，默认值为0。
									0：旧模式，新添加的听众信息排在前面，最多只能拉取1000个听众的信息；
									1：新模式，可以拉取所有听众的信息，暂时不支持排序。
	* @install:  		判断获取的是安装应用的听众，还是未安装应用的听众。
									0：不考虑该参数；1：获取已安装应用的听众信息；2：获取未安装应用的听众信息。
	* @sex:  				按性别过滤标识，默认为0
	* http://wiki.open.qq.com/wiki/website/get_fanslist
	*/
	public function get_fanslist($reqnum="", $startindex=0, $mode=0, $install=0, $sex=0)
	{
		$url = "https://graph.qq.com/relation/get_fanslist";
		$array = array
		(
			"reqnum"=>$reqnum,
			"startindex"=>$startindex,
			"mode"=>$mode,
			"install"=>$install,
			"sex"=>$sex
		);
		return $this->recall_api($url , $array , "get");
	}
	
	/**
	* 2.8 get_idollist
	* 获取登录用户收听的人的列表
	* @reqnum:  		请求获取的听众个数，取值范围为1-30【*】
	* @startindex:  请求获取听众列表的起始位置。第一页：0；继续向下翻页：reqnum*（page-1）【*】
	* @mode:  			获取听众信息的模式，默认值为0。
									0：旧模式，新添加的听众信息排在前面，最多只能拉取1000个听众的信息；
									1：新模式，可以拉取所有听众的信息，暂时不支持排序。
	* @install:  		判断获取的是安装应用的听众，还是未安装应用的听众。
									0：不考虑该参数；1：获取已安装应用的听众信息；2：获取未安装应用的听众信息。
	* @sex:  				按性别过滤标识，默认为0
	* http://wiki.open.qq.com/wiki/website/get_idollist
	*/
	public function get_idollist($reqnum="", $startindex=0, $mode=0, $install=0)
	{
		$url = "https://graph.qq.com/relation/get_idollist";
		$array = array
		(
			"reqnum"=>$reqnum,
			"startindex"=>$startindex,
			"mode"=>$rootid,
			"install"=>$rootid,
		);
		return $this->recall_api($url , $array , "get");
	}
	
	/**
	* 2.9 add_idol
	* 收听某个微博用户
	* @name:  			要收听的用户的账户名列表，多个账户名之间用“,”【*】
	* @fopenids:  	要收听的用户的openid列表。多个openid之间用“_”隔开
	* http://wiki.open.qq.com/wiki/website/add_idol
	*/
	public function add_idol($names = "" , $fopenids = "")
	{
		$url = "https://graph.qq.com/relation/add_idol";
		$array = array
		(
			"name"=>$names,
			"fopenids"=>$fopenids
		);
		return $this->recall_api($url , $array , "post");
	}
	
	/**
	* 2.10 del_idol
	* 取消收听腾讯微博上的用户
	* @name:  			要取消收听的用户的账户名【*】
	* @fopenid:  	  要取消收听的用户的openid【*】
	* http://wiki.open.qq.com/wiki/website/del_idol
	*/
	public function del_idol($names = "" , $fopenid = "")
	{
		$url = "https://graph.qq.com/relation/del_idol";
		$array = array
		(
			"name"=>$names,
			"fopenid"=>$fopenid
		);
		return $this->recall_api($url , $array , "post");
	}

	
/* 3、Tenpay */	
	/**
	* 3.1 get_tenpay_addr
	* 在这个网站上将展现您财付通登记的收货地址
	* @offset: 		查询收货地址的偏移量，一般情况下offset可以不传值或传入0，表示从第一条开始读取。【*】
	* @limit:  		表示查询收货地址的返回限制数，默认5【*】
	* @ver:  			用于接口版本控制。固定填1。
	* http://wiki.open.qq.com/wiki/website/get_tenpay_addr
	*/
	public function get_tenpay_addr($offset = "" , $limit = "")
	{
		$url = "https://graph.qq.com/cft_info/get_tenpay_addr";
		$array = array
		(
			"offset"=>$names,
			"limit"=>$fopenid,
			"ver"=>1
		);
		return $this->recall_api($url , $array , "post");
	}
	
	
}

?>