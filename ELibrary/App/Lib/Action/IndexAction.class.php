<?php
class IndexAction extends Action {
    public function index(){
    	$this->display();
    }

    public function search(){
		if(isset($_GET['bookname'])){
			$bookname = $_GET['bookname'];

			//get url cache
			$memcache = new Memcache();
			$memcache->connect('localhost', 11211) or die ("Could not connect memcache");
			if(! $host = $memcache->get('host') ){
				$host_data = curl_get("http://202.116.64.108:8991/F/");
				preg_match('/action="[^"]*"/', $host_data, $match1);
				preg_match('/http[^"]*/', $match1[0], $match2);
				$host = $match2[0];
				$memcache->set('host', $host, 0, 900);
			}
			$url = $host."?func=find-b&find_code=WTI&local_base=ZSU01&filter_code_1=WLN&filter_request_1=&filter_code_2=WYR&filter_request_2=&filter_code_3=WYR&filter_request_3=&filter_code_4=WFM&filter_request_4=&filter_code_5=WSL&filter_request_5=&request=".$bookname;
		}
		elseif(isset($_GET['url'])) {
			$url = $_GET['url'];
		}
		
		$webdata = curl_get($url);
		//echo $webdata;
		//file_put_contents('hh.txt', $webdata);

		$result = array();	
		//判断是否为书籍的详细信息页面
		if(preg_match('/系统号- 图书/', $webdata)){
			//$result['isDetail'] = 1;
			//title
			preg_match('/题名[^<]*<\/td>.*?<\/td>/', $webdata, $match1); 
			preg_match("/;'>.*?<\/td>/", $match1[0], $match2);
			$title = preg_replace("/;'>|<.*?>|&nbsp;/", "", $match2[0]);
			$titleInfo = explode('/', $title);
			
			$result['title'] = trim($titleInfo[0]);
			if(strpos($titleInfo[1], ';')){
				$authorInfo = explode(';', $titleInfo[1]);
				$result['author'] = trim($authorInfo[0]);
				$result['translator'] = trim($authorInfo[1]);
			}
			else{
				$result['author'] = trim($titleInfo[1]);
			}
			//echo $title."<br>";

			//ISBN
			//image url: "http://202.112.150.126/index.php?client=aleph&isbn=".$isbn."/cover"
			preg_match('/ISBN &nbsp;   <\/td>.*?<\/td>/', $webdata, $match1);
			preg_match('/<td.*?<\/td>/', $match1[0], $match2);
			$temp = preg_replace('/<.*?>/', "", $match2[0]);
			$isbn = trim(preg_replace('/&nbsp.*/', "", $temp));
			$result['cover'] = "http://202.112.150.126/index.php?client=aleph&isbn=".$isbn."/cover";
			//echo $isbn.'<br>';

			//是否东校区流通
			if(preg_match('/http:\/\/[^>]*>东校区流通[^<]*/', $webdata, $match1)){
				$result['isEast'] = 1;

				preg_match('/http[^>]*/', $match1[0], $match2);
				$collect_state_url = $match2[0];
				$collect_state_data = curl_get($collect_state_url);
				file_put_contents('hh.txt', $collect_state_data);
				//echo $collect_state_data;
				preg_match_all('/<table border=0 cellspacing=2 width=99%>.*?<\/table>/', $collect_state_data, $match1);
				preg_match_all('/<tr.*?<\/tr>/', $match1[0][0], $match2);
				$bookstate = array();
				for($i = 1; $i < count($match2[0]); $i++)
				{
					//$temp = preg_replace('/<!--.*?-->/', "", $match2[0][$i]);
					preg_match_all('/<td[^<]*/', $match2[0][$i], $match3);
					$bookstate[] = array('state' => preg_replace('/<.*?>/', "", $match3[0][2]),
										 'returndate' => preg_replace('/<.*?>/', "", $match3[0][3]),
										 'library' => preg_replace('/<.*?>/', "", $match3[0][4]),
										 'where' => preg_replace('/<.*?>/', "", $match3[0][5]),
										 'bookshelf' => preg_replace('/<.*?>/', "", $match3[0][6]));
				}
				
				//print_r($bookstate)	;
			}
			else{
				$result['isEast'] = 0;
			}

			//print_r($result);
			//print_r($bookstate);
			$this->assign('result', $result);
			$this->assign('bookstate', $bookstate);
			$this->display('bookinfo');
		}
		else{
			//$result['isDetail'] = 0;
			preg_match_all('/<table class=items.*?<\/table>/', $webdata, $match1);
			$booklist = array();
			foreach($match1[0] as $onebookdata){
				//image
				preg_match('/<img[^>]*>/', $onebookdata, $match2);
				preg_match('/http[^"]*/', $match2[0], $match3);
				//echo $match3[0].'<br>';
				//title
				preg_match('/<div class=itemtitle>.*?<\/div>/', $onebookdata, $match4);
				preg_match('/http[^>]*/', $match4[0], $match5);
				$bookurl = str_replace('&', '%26', $match5[0]);
				$temp = preg_replace('/<script>.*?<\/script>/', "", $match4[0]);
				$title = preg_replace('/<.*?>/', "", $temp);
				//echo $title.'<br>';

				//details
				preg_match_all('/<td[^<]*/', $onebookdata, $match6);
				$author = preg_replace('/<.*?>/', "", $match6[0][4]);	//echo $author.'<br>';
				$number = preg_replace('/<.*?>/', "", $match6[0][6]);	//echo $number.'<br>';
				$publish = preg_replace('/<.*?>/', "", $match6[0][8]);	//echo $publish.'<br>';
				$time = preg_replace('/<.*?>/', "", $match6[0][10]);	//echo $time.'<br>';

				$booklist[] = array('cover' => $match3[0],
									'title' => $title,
									'bookurl' => $bookurl,
									'author' => $author,
									'number' => $number,
									'publish' => $publish,
									'time' => $time);
			}
			
			//print_r($booklist);
			$this->assign('booklist', $booklist);
			$this->display('booklist');
		}		
	}

}

