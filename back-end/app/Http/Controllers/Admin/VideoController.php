<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\MainAdminController;
use App\Models\Video;
use App\Models\Config;
use Validator;

class VideoController extends MainAdminController
{	

	private $domain_graph_FB = "https://graph.facebook.com/v2.6/";
    private $domain_google_drive = 'https://mail.google.com/e/get_video_info';
	protected $rules = [
        'insert' => [
            'source_link' => 'required',
            'source_name' => 'required|in:facebook,google,others',
            'max_qualify' => 'required|in:0,360,480,720,1080',
            'return_type' => 'required|in:json,view',
        ],
        'update' => [
            'source_link' => 'required',
            'source_name' => 'required|in:facebook,google,others',
            'max_qualify' => 'required|in:0,360,480,720,1080',
            'return_type' => 'required|in:json,view',
        ]
    ];
    protected $columns_filter = [
        'source_link' => 'video.source_link',
        'source_name' => 'video.source_name',
        'max_qualify' => 'video.max_qualify',
        'duration'    => 'video.duration',
        'created_at'  => 'video.created_at',
        'created_at'  => 'video.updated_at',
        
        
    ];
    protected $columns_search = [];

    public function __construct(Request $request) {
        $this->model = new Video;
        parent::__construct($request);
    }

    public function setItem($type , $req , &$item){

        $validator = Validator::make($req->all(), $this->rules[$type]);
        if ($validator->fails()) {
            return [
                'type' => 'error',
                'msg' => 'Vui lòng kiểm tra lại các trường nhập'
            ];
        }

        switch ($type) {
            case 'insert':
                $item->ad_id = $req->authUser->id;
                break;
            
            default:
                // code...
                break;
        }

        $item->source_link = $req->get("source_link");
        $item->source_name = $req->get("source_name");
        $item->max_qualify = $req->get("max_qualify");
        $item->duration    = $req->get("duration");

        //get link play video
        $link_play = $this->getLink($item->source_link,$item->source_name);
        $link_play = !empty($link_play) ? json_encode($link_play) : [];
        $item->link_play = $link_play;
        

        
        return [
            'type' => 'success',
            'msg' => $type == 1 ? 'Thêm dữ liệu thành công' : 'Cập nhật thành công',
        ];

    }

    public function store(Request $request , $mov_id = '')
    {
        $return_type = $request->return_type;
        if($request->isMethod("post")){ //insert
            $item = $this->model;
            $result = $this->setItem('insert',$request, $item);
            if($result['type'] == 'success'){                
                $item->save();
                $result['message'] = 'Thêm dữ liệu thành công';
            }
            $data['info'] = $item;
        } else {
            $result = '';
            $data = '';
        }

        switch ($return_type) {
            case 'view':
                return $this->template($this->view_folder."add",$data,$result);
                break;
            case 'json':
                return Response()->json($data,200);
                break;
            default:
                // code...
                break;
        }
        
        
    }
    public function refresh(Request $request)
    {
        $all_videos = Video::orderBy('id','desc')
                       // ->orWhere('source_name' , 'facebook')
                       ->where('source_name' , 'google')
                       ->get();
        if(count($all_videos) > 0){
            foreach ($all_videos as $value) {
                $link_play = $this->getLink($value->source_link,$value->source_name);
                $link_play = !empty($link_play) ? $link_play : [];
                $link_play = json_encode($link_play);
                Video::where('id',$value->id)->update(['link_play' => $link_play ]);
                // sleep(5);
            }
        }

        echo "success";
        
    }
    private function getLink($source_link , $name)
    {
        
        $token = Config::where("key" , 'facebook_access_token')->first();
        $token = $token->value;
        if(!$token) return;
                        

        switch ($name) {
            case 'facebook':
                return [];
                $url = $this->domain_graph_FB.getIdFromLinkFb($source_link);                
                $params = [
                    'access_token' => $token,
                    'fields' => 'id,source,length,picture'
                ];
                $data = apiCurl($url,'GET',$params , 'json');
                
                if(!empty($data) && $data->id){
                    return [[
                        'src' => $data->source,
                        'thumbnail' => $data->picture,
                        'duration' => $data->length,                        
                    ]];


                }
                break;
            case 'google':
                $url = htmlspecialchars($source_link);
                $support_domain = 'drive.google.com';
                
                if(empty($url)) {
                      $url = 'https://drive.google.com/file/d/0123456789abcdefghijklmnopqr/view?usp=sharing'; // sample link
                }
                if($url) {
                    preg_match('@^(?:https?://)?([^/]+)@i', $url, $matches);
                    $host = $matches[1];
                    if($host != $support_domain) {
                        return [];
                    }
                }

                preg_match('/(file\/d\/)(.*)(\/)/', $url, $matches);
                $docid = $matches[2];
                // $ip = htmlspecialchars($_GET['ip']);
                if(empty($ip)) {
                  $ip = 'v4';
                }
                $params = [
                    'docid' => $docid,
                ];
                if($ip) {
                  if($ip == 'v4') {
                    // $result = "status=ok&hl=en_US&allow_embed=0&ps=docs&partnerid=30&autoplay=0&docid=1S35lOSgyG55egvg1_8WQaskST7-Bdp6b&abd=0&public=true&el=embed&title=B%E1%BA%A3n+sao+c%E1%BB%A7a+SieuSaoSieuNgo_4K_cliptv.mp4&iurl=https%3A%2F%2Fdocs.google.com%2Fvt%3Fid%3D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%26s%3DAMedNnoAAAAAXHZaGsFeJHx1EZSk_1G53t5vlebyLeUN&cc3_module=https%3A%2F%2Fs.ytimg.com%2Fyt%2Fswfbin%2Fsubtitles3_module.swf&ttsurl=https%3A%2F%2Fdocs.google.com%2Ftimedtext%3Fid%3D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%26vid%3De9c23dbe6b447244&reportabuseurl=https%3A%2F%2Fdocs.google.com%2Fabuse%3Fid%3D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b&fmt_list=37%2F1920x1080%2F9%2F0%2F115%2C22%2F1280x720%2F9%2F0%2F115%2C59%2F854x480%2F9%2F0%2F115%2C18%2F640x360%2F9%2F0%2F115&token=1&plid=V0QVhyhftTHCtA&fmt_stream_map=18%7Chttps%3A%2F%2Fr3---sn-i3b7knl6.c.mail.google.com%2Fvideoplayback%3Fexpire%3D1551267386%26ei%3D-j12XJXdBYHw_QHi_p34Ag%26ip%3D118.69.66.168%26cp%3DQVNKU0NfVlNWR1hOOldLblYtdGVKblVNZ0JfMWpXVVNIMWd4cnRxVjA4Y3lVcDFNc3NJcnZiT0M%26id%3De9c23dbe6b447244%26itag%3D18%26source%3Dwebdrive%26requiressl%3Dyes%26mm%3D30%26mn%3Dsn-i3b7knl6%26ms%3Dnxu%26mv%3Dm%26pl%3D24%26ttl%3Dtransient%26susc%3Ddr%26driveid%3D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%26app%3Dexplorer%26mime%3Dvideo%2Fmp4%26dur%3D5326.378%26lmt%3D1527706936564132%26mt%3D1551252868%26sparams%3Dexpire%252Cei%252Cip%252Ccp%252Cid%252Citag%252Csource%252Crequiressl%252Cttl%252Csusc%252Cdriveid%252Capp%252Cmime%252Cdur%252Clmt%26sig%3DALgxI2wwRAIgM2KeBjR7gd1EB_cwoOOwlvP-wx1eLupDhpWlXTWB1DwCIE_wD0s8BNmcH6kc_s-OVYYosXslo76dZ8w63Yguk3QP%26lsparams%3Dmm%252Cmn%252Cms%252Cmv%252Cpl%26lsig%3DAHylml4wRAIgZwHxYrAncmMGDh9Bqen4qzd2LOd-wF5iUq5GI_hesWkCIHocIo1QOxTFqmyD9s7gXUJ7xWenXQ3esV8LaImzVtm9%2C22%7Chttps%3A%2F%2Fr3---sn-i3b7knl6.c.mail.google.com%2Fvideoplayback%3Fexpire%3D1551267386%26ei%3D-j12XJXdBYHw_QHi_p34Ag%26ip%3D118.69.66.168%26cp%3DQVNKU0NfVlNWR1hOOldLblYtdGVKblVNZ0JfMWpXVVNIMWd4cnRxVjA4Y3lVcDFNc3NJcnZiT0M%26id%3De9c23dbe6b447244%26itag%3D22%26source%3Dwebdrive%26requiressl%3Dyes%26mm%3D30%26mn%3Dsn-i3b7knl6%26ms%3Dnxu%26mv%3Dm%26pl%3D24%26ttl%3Dtransient%26susc%3Ddr%26driveid%3D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%26app%3Dexplorer%26mime%3Dvideo%2Fmp4%26dur%3D5326.378%26lmt%3D1527705041721587%26mt%3D1551252868%26sparams%3Dexpire%252Cei%252Cip%252Ccp%252Cid%252Citag%252Csource%252Crequiressl%252Cttl%252Csusc%252Cdriveid%252Capp%252Cmime%252Cdur%252Clmt%26sig%3DALgxI2wwRgIhAKWW_4iED4uyx4OjLlN6jwSGFGDsXYegjVfg9nGDBqpmAiEA_fz5WuXzWnoP9jFRFfciMu_IV4O2ie_EefzvGyThGSU%3D%26lsparams%3Dmm%252Cmn%252Cms%252Cmv%252Cpl%26lsig%3DAHylml4wRgIhAL4Pwzh8CwUuF4_RIpuHEq9Ym9wgnb1-KKRQaw0Em_dPAiEA8UAaofnsajFk4N1RqmJUPl1lLuP9sii873nfgJ9BfrU%3D%2C37%7Chttps%3A%2F%2Fr3---sn-i3b7knl6.c.mail.google.com%2Fvideoplayback%3Fexpire%3D1551267386%26ei%3D-j12XJXdBYHw_QHi_p34Ag%26ip%3D118.69.66.168%26cp%3DQVNKU0NfVlNWR1hOOldLblYtdGVKblVNZ0JfMWpXVVNIMWd4cnRxVjA4Y3lVcDFNc3NJcnZiT0M%26id%3De9c23dbe6b447244%26itag%3D37%26source%3Dwebdrive%26requiressl%3Dyes%26mm%3D30%26mn%3Dsn-i3b7knl6%26ms%3Dnxu%26mv%3Dm%26pl%3D24%26ttl%3Dtransient%26susc%3Ddr%26driveid%3D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%26app%3Dexplorer%26mime%3Dvideo%2Fmp4%26dur%3D5326.378%26lmt%3D1527706471004515%26mt%3D1551252868%26sparams%3Dexpire%252Cei%252Cip%252Ccp%252Cid%252Citag%252Csource%252Crequiressl%252Cttl%252Csusc%252Cdriveid%252Capp%252Cmime%252Cdur%252Clmt%26sig%3DALgxI2wwRQIgTJdcZ48aDVUUZ0o3XpaDSwxPDc0TllJ_ySNbdkdIzLkCIQCYetpik1Cj_J-8lQ_MwEJjLA00j2a6mdQmI0isAKP_Uw%3D%3D%26lsparams%3Dmm%252Cmn%252Cms%252Cmv%252Cpl%26lsig%3DAHylml4wRQIgSywjGnpdxxufR_IiLoHYTJt8NcihGOZph8VNgWq8i1wCIQCxtPIVd6KxCEU5ZWZKzUf_Ta6ndi_9oo20uzw3g_W-2A%3D%3D%2C59%7Chttps%3A%2F%2Fr3---sn-i3b7knl6.c.mail.google.com%2Fvideoplayback%3Fexpire%3D1551267386%26ei%3D-j12XJXdBYHw_QHi_p34Ag%26ip%3D118.69.66.168%26cp%3DQVNKU0NfVlNWR1hOOldLblYtdGVKblVNZ0JfMWpXVVNIMWd4cnRxVjA4Y3lVcDFNc3NJcnZiT0M%26id%3De9c23dbe6b447244%26itag%3D59%26source%3Dwebdrive%26requiressl%3Dyes%26mm%3D30%26mn%3Dsn-i3b7knl6%26ms%3Dnxu%26mv%3Dm%26pl%3D24%26ttl%3Dtransient%26susc%3Ddr%26driveid%3D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%26app%3Dexplorer%26mime%3Dvideo%2Fmp4%26dur%3D5326.378%26lmt%3D1527706486452381%26mt%3D1551252868%26sparams%3Dexpire%252Cei%252Cip%252Ccp%252Cid%252Citag%252Csource%252Crequiressl%252Cttl%252Csusc%252Cdriveid%252Capp%252Cmime%252Cdur%252Clmt%26sig%3DALgxI2wwRgIhAJY1s7S5bUF2c8QAM6ykFohpqejVnPMNTVdTIwifOZGSAiEAzX0MSUIxUZSW7UzswmZKXm6GsbVLtEHn4MjSM4W_EQs%3D%26lsparams%3Dmm%252Cmn%252Cms%252Cmv%252Cpl%26lsig%3DAHylml4wRAIgVTx-J19xv7hWBxrfY-y_nS06-F_2Bp0K_uWOFlv0dgsCICW_StcNon8zsJe_W6LLdvXJMGbUy7c5JW93sB5F4bBw&url_encoded_fmt_stream_map=itag%3D18%26url%3Dhttps%253A%252F%252Fr3---sn-i3b7knl6.c.mail.google.com%252Fvideoplayback%253Fexpire%253D1551267386%2526ei%253D-j12XJXdBYHw_QHi_p34Ag%2526ip%253D118.69.66.168%2526cp%253DQVNKU0NfVlNWR1hOOldLblYtdGVKblVNZ0JfMWpXVVNIMWd4cnRxVjA4Y3lVcDFNc3NJcnZiT0M%2526id%253De9c23dbe6b447244%2526itag%253D18%2526source%253Dwebdrive%2526requiressl%253Dyes%2526mm%253D30%2526mn%253Dsn-i3b7knl6%2526ms%253Dnxu%2526mv%253Dm%2526pl%253D24%2526ttl%253Dtransient%2526susc%253Ddr%2526driveid%253D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%2526app%253Dexplorer%2526mime%253Dvideo%252Fmp4%2526dur%253D5326.378%2526lmt%253D1527706936564132%2526mt%253D1551252868%2526sparams%253Dexpire%252Cei%252Cip%252Ccp%252Cid%252Citag%252Csource%252Crequiressl%252Cttl%252Csusc%252Cdriveid%252Capp%252Cmime%252Cdur%252Clmt%2526sig%253DALgxI2wwRAIgM2KeBjR7gd1EB_cwoOOwlvP-wx1eLupDhpWlXTWB1DwCIE_wD0s8BNmcH6kc_s-OVYYosXslo76dZ8w63Yguk3QP%2526lsparams%253Dmm%252Cmn%252Cms%252Cmv%252Cpl%2526lsig%253DAHylml4wRAIgZwHxYrAncmMGDh9Bqen4qzd2LOd-wF5iUq5GI_hesWkCIHocIo1QOxTFqmyD9s7gXUJ7xWenXQ3esV8LaImzVtm9%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.42001E%252C%2Bmp4a.40.2%2522%26quality%3Dmedium%2Citag%3D22%26url%3Dhttps%253A%252F%252Fr3---sn-i3b7knl6.c.mail.google.com%252Fvideoplayback%253Fexpire%253D1551267386%2526ei%253D-j12XJXdBYHw_QHi_p34Ag%2526ip%253D118.69.66.168%2526cp%253DQVNKU0NfVlNWR1hOOldLblYtdGVKblVNZ0JfMWpXVVNIMWd4cnRxVjA4Y3lVcDFNc3NJcnZiT0M%2526id%253De9c23dbe6b447244%2526itag%253D22%2526source%253Dwebdrive%2526requiressl%253Dyes%2526mm%253D30%2526mn%253Dsn-i3b7knl6%2526ms%253Dnxu%2526mv%253Dm%2526pl%253D24%2526ttl%253Dtransient%2526susc%253Ddr%2526driveid%253D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%2526app%253Dexplorer%2526mime%253Dvideo%252Fmp4%2526dur%253D5326.378%2526lmt%253D1527705041721587%2526mt%253D1551252868%2526sparams%253Dexpire%252Cei%252Cip%252Ccp%252Cid%252Citag%252Csource%252Crequiressl%252Cttl%252Csusc%252Cdriveid%252Capp%252Cmime%252Cdur%252Clmt%2526sig%253DALgxI2wwRgIhAKWW_4iED4uyx4OjLlN6jwSGFGDsXYegjVfg9nGDBqpmAiEA_fz5WuXzWnoP9jFRFfciMu_IV4O2ie_EefzvGyThGSU%253D%2526lsparams%253Dmm%252Cmn%252Cms%252Cmv%252Cpl%2526lsig%253DAHylml4wRgIhAL4Pwzh8CwUuF4_RIpuHEq9Ym9wgnb1-KKRQaw0Em_dPAiEA8UAaofnsajFk4N1RqmJUPl1lLuP9sii873nfgJ9BfrU%253D%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.42001E%252C%2Bmp4a.40.2%2522%26quality%3Dhd720%2Citag%3D37%26url%3Dhttps%253A%252F%252Fr3---sn-i3b7knl6.c.mail.google.com%252Fvideoplayback%253Fexpire%253D1551267386%2526ei%253D-j12XJXdBYHw_QHi_p34Ag%2526ip%253D118.69.66.168%2526cp%253DQVNKU0NfVlNWR1hOOldLblYtdGVKblVNZ0JfMWpXVVNIMWd4cnRxVjA4Y3lVcDFNc3NJcnZiT0M%2526id%253De9c23dbe6b447244%2526itag%253D37%2526source%253Dwebdrive%2526requiressl%253Dyes%2526mm%253D30%2526mn%253Dsn-i3b7knl6%2526ms%253Dnxu%2526mv%253Dm%2526pl%253D24%2526ttl%253Dtransient%2526susc%253Ddr%2526driveid%253D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%2526app%253Dexplorer%2526mime%253Dvideo%252Fmp4%2526dur%253D5326.378%2526lmt%253D1527706471004515%2526mt%253D1551252868%2526sparams%253Dexpire%252Cei%252Cip%252Ccp%252Cid%252Citag%252Csource%252Crequiressl%252Cttl%252Csusc%252Cdriveid%252Capp%252Cmime%252Cdur%252Clmt%2526sig%253DALgxI2wwRQIgTJdcZ48aDVUUZ0o3XpaDSwxPDc0TllJ_ySNbdkdIzLkCIQCYetpik1Cj_J-8lQ_MwEJjLA00j2a6mdQmI0isAKP_Uw%253D%253D%2526lsparams%253Dmm%252Cmn%252Cms%252Cmv%252Cpl%2526lsig%253DAHylml4wRQIgSywjGnpdxxufR_IiLoHYTJt8NcihGOZph8VNgWq8i1wCIQCxtPIVd6KxCEU5ZWZKzUf_Ta6ndi_9oo20uzw3g_W-2A%253D%253D%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.42001E%252C%2Bmp4a.40.2%2522%26quality%3Dhd1080%2Citag%3D59%26url%3Dhttps%253A%252F%252Fr3---sn-i3b7knl6.c.mail.google.com%252Fvideoplayback%253Fexpire%253D1551267386%2526ei%253D-j12XJXdBYHw_QHi_p34Ag%2526ip%253D118.69.66.168%2526cp%253DQVNKU0NfVlNWR1hOOldLblYtdGVKblVNZ0JfMWpXVVNIMWd4cnRxVjA4Y3lVcDFNc3NJcnZiT0M%2526id%253De9c23dbe6b447244%2526itag%253D59%2526source%253Dwebdrive%2526requiressl%253Dyes%2526mm%253D30%2526mn%253Dsn-i3b7knl6%2526ms%253Dnxu%2526mv%253Dm%2526pl%253D24%2526ttl%253Dtransient%2526susc%253Ddr%2526driveid%253D1S35lOSgyG55egvg1_8WQaskST7-Bdp6b%2526app%253Dexplorer%2526mime%253Dvideo%252Fmp4%2526dur%253D5326.378%2526lmt%253D1527706486452381%2526mt%253D1551252868%2526sparams%253Dexpire%252Cei%252Cip%252Ccp%252Cid%252Citag%252Csource%252Crequiressl%252Cttl%252Csusc%252Cdriveid%252Capp%252Cmime%252Cdur%252Clmt%2526sig%253DALgxI2wwRgIhAJY1s7S5bUF2c8QAM6ykFohpqejVnPMNTVdTIwifOZGSAiEAzX0MSUIxUZSW7UzswmZKXm6GsbVLtEHn4MjSM4W_EQs%253D%2526lsparams%253Dmm%252Cmn%252Cms%252Cmv%252Cpl%2526lsig%253DAHylml4wRAIgVTx-J19xv7hWBxrfY-y_nS06-F_2Bp0K_uWOFlv0dgsCICW_StcNon8zsJe_W6LLdvXJMGbUy7c5JW93sB5F4bBw%26type%3Dvideo%252Fmp4%253B%2Bcodecs%253D%2522avc1.42001E%252C%2Bmp4a.40.2%2522%26quality%3Dlarge×tamp=1551252986106&length_seconds=5326";
                    $result = apiCurl($this->domain_google_drive,'GET', $params , 'json');
                    // $result = file_get_contents($this->domain_google_drive.$docid, false, stream_context_create(['socket' => ['bindto' => '[::]:0']])); // force IPv6
                  } else {
                    $result = apiCurl($this->domain_google_drive,'GET', $params , 'json');
                    // $result = file_get_contents($this->domain_google_drive.$docid, false, stream_context_create(['socket' => ['bindto' => '0:0']])); // force IPv4
                  }
                }
                
                
                if(isset($result['http_code']) || empty($result)){
                    return [];
                }
                $result = urldecode($result);
                preg_match('/(&fmt_stream_map=)(.*)/', $result, $matches);
                // $result = urldecode($result);
                
                $result = urldecode($matches[2]);
                $result = preg_replace('/[^\/]+\.(drive|docs|mail)\.google\.com/', 'redirector.googlevideo.com', $result);
                $quality = [
                  '37' => ['label' => '1080p', 'type' => 'video/mp4'],
                  '22' => ['label' => '0720p', 'type' => 'video/mp4'],
                  '59' => ['label' => '0480p', 'type' => 'video/mp4'],
                  '18' => ['label' => '0360p', 'type' => 'video/mp4']
                ];
                $links = explode(',', $result);
                
                
                $output = [];
                foreach($links as $key => $direct_link) {
                    
                    $direct_link = urldecode($direct_link);
                    preg_match('/https.*/', $direct_link, $matches);
                    if($key == 0 || count($matches) == 0) continue;


                        $matches = preg_replace('/&docid=.*/', '', $matches); // remove docid
                        $matches = preg_replace('/&driveid=.*/', '', $matches); // remove driveid

                        preg_match('/(.*)(\|)/', $direct_link, $itag);
                        preg_match('/&dur=([0-9.]+).*&/', $direct_link, $dur);
                        $duration = count($dur) > 1 ? $dur[1] : '';

                        if(count($itag) > 1){
                            if(!is_null($itag[1]) || !is_null($matches[0])) {
                            if(!is_null($quality[$itag[1]])) {
                                $output[] = [
                                    'qualify'  => $quality[$itag[1]]['label'],
                                    'src'      => $matches[0],
                                    'type'     => $quality[$itag[1]]['type'],
                                    'duration' => (double)$duration
                                ];
                                
                            }
                        }
                    }
                  
                }

                rsort($output);
                $output = json_encode($output);
                $output = preg_replace('/(0)(720|480|360)(p)/', '$2$3', $output); // sort fix
                $output = json_decode($output);
                return $output;
                
                
                // $googleDisk = Storage::disk('google');
                // $filename = 'laravel.png';
                // $filePath = public_path($filename);
                // // Upload using a stream...
                // Storage::cloud()->put($filename, fopen($filePath, 'r+'));
                // // Get file listing...
                // $dir = '/';
                // $recursive = false; // Get subdirectories also?
                // $contents = collect(Storage::cloud()->listContents($dir, $recursive));
                // // Get file details...
                // $file = $contents
                //     ->where('type', '=', 'file')
                //     ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                //     ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                //     ->first(); // there can be duplicate file names!
                // //return $file; // array with file info
                // // Store the file locally...
                // //$readStream = Storage::cloud()->getDriver()->readStream($file['path']);
                // //$targetFile = storage_path("downloaded-{$filename}");
                // //file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);
                // // Stream the file to the browser...
                // $readStream = Storage::cloud()->getDriver()->readStream($file['path']);
                // return response()->stream(function () use ($readStream) {
                //     fpassthru($readStream);
                // }, 200, [
                //     'Content-Type' => $file['mimetype'],
                //     //'Content-disposition' => 'attachment; filename="'.$filename.'"', // force download?
                // ]);
            
            default:
                break;
        }
        return [];
        
    }
}
