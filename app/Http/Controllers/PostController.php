<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Libs\tencentyun\ImageV2;


class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = DB::table('post')->where('status', '!=', 0)->orderBy('time', 'desc');
        $columns = '';
        if ($request->has('id')){
            $key = $request->input('id');
            $query = $query->where('id', $key);
            $columns = ['id' => $key];
        }
        if ($request->has('title')){
            $key = $request->input('title');
            $query = $query->where('title', $key);
            $columns = ['title' => $key];
        }
        if ($request->has('user_name')){
            $key = $request->input('user_name');
            $query = $query->where('user_name', $key);
            $columns = ['user_name' => $key];
        }
        if ($request->has('guba_id')){
            $key = $request->input('guba_id');
            $query = $query->where('guba_id', $key);
            $columns = ['guba_id' => $key];
        }
        $data = $query->paginate(10);
        if(!empty($columns)){
            $data->appends($columns)->links();
        }
        $reconmGro = DB::table('recomgro')->where('status', '!=', 0)->pluck('title', 'id');
        return view('/post.index', compact('data','reconmGro'));
    }

    public function create()
    {
        return view('/post.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['ip'] = '0.0.0.0';
        $data['time'] = date('Y-m-d H:i:s');
        $data['replay_time'] = $data['time'];
        $content = $data['content'];
        unset($data['_token']);
        unset($data['content']);
        DB::table('post')->insert(
            $data
        );
        return redirect('/post');
    }

    public function edit($id)
    {
        $data = DB::table('post')->where('id', $id)->first();
        return view('/post.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $content = $data['content'];
        unset($data['_token']);
        unset($data['id']);
        unset($data['content']);
        $group = DB::table('post')->where('id', $id)->update($data);
        DB::table('replay')->where('post_id', $id)->where('storey', 1)->update(['content'=>$content]);
        if($group){
            return redirect('/post');
        }
        return redirect('/post/edit/'.$id);
    }

    public function delete($id)
    {
        $data = DB::table('post')->where('id', $id)->first();
        DB::table('post')->where('id', $id)->update(['status' => 0]);
        return redirect('/post?guba_id='.$data->guba_id);
    }

    public function cancel($id, Request $request)
    {
        $status = $request->input('status');
        $dataKey = explode('|', $id);
        foreach ($dataKey as $v) {
            DB::table('post')->where('id', $v)->update(['status' => $status]);
        }
        return redirect('/post');
    }

    public function deljp(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $post = DB::table('post')->where('id', $id)->update([$type => 0]);
        if($post){
            return json_encode(['code'=>'success']);
        }
        return json_encode(['code'=>'fail']);
    }

    public function add(Request $request)
    {
        $id = $request->input('id');
        $type = $request->input('type');
        $post = DB::table('post')->where('id', $id)->update([$type => 1]);
        if($post){
            return json_encode(['code'=>'success']);
        }
        return json_encode(['code'=>'fail']);
    }

    public function modify(Request $request)
    {
        $id = $request->input('id');
        $operation = $request->input('type');
        $user_name = $request->input('value');
        $post = DB::table('post')->where('id', $id)->update([$operation => $user_name]);
        if($post){
            return json_encode(['code'=>'success']);
        }
        return json_encode(['code'=>'fail']);
    }

    public function recommend(Request $request)
    {
        $ids = $request->input('ids');
        $dataKey = explode('|', $ids);
        $group_id = $request->input('group_id');
        $sum = 0;
        foreach ($dataKey as $v) {
            $post = DB::table('post')->where('id', $v)->first();
            $data[] = [
                'title' => $post->id,
                'ftitle' => $post->title,
                'group_id' => $group_id,
            ];
            $sum++;
        }
        $recoCount = DB::table('recomcon')->where('group_id', $group_id)->count();
        $recomgro = DB::table('recomgro')->where('id', $group_id)->first();
        $recoSum = $sum + $recoCount - $recomgro->rec_sum;
        DB::table('recomcon')->insert(
            $data
        );
        if($recoSum > 0){
            DB::table('recomcon')->where('group_id', $group_id)->take($recoSum)->orderBy('time', 'asc')->delete();
        }
        return redirect('/recomcon?group_id='.$group_id);
    }

    public function audited()
    {
        $data = DB::table('post')->where('status', 2)->orderBy('time', 'desc')->paginate(10);
        return view('/post.audited', compact('data'));
    }

    public function updateAvatar(Request $request)
    {
        $file = $request->file('photo');
        $filePrefix = 'post';
        $bucket = '2258guba';
        $name = $filePrefix . '/' . md5(rand(1, 1000) . $bucket . rand(1, 1000)).$file->extension();
        $uploadRet = ImageV2::upload($file->path(), $bucket, $name);
        if (0 === $uploadRet['code']) {
            return $uploadRet['data']['downloadUrl'];
        }
        return false;
    }

    public function avatar()
    {
        return view('/post.avatar');
    }

}
