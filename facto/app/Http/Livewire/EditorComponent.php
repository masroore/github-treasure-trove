<?php

namespace App\Http\Livewire;

use App\Models\Actor;
use App\Models\AllImage;
use App\Models\Genre;
use App\Models\Post;
use App\Models\PostCat;
use App\Models\Premium;
use App\Models\Region;
use App\Models\Tag;
use App\Models\Upso;
use App\Models\UpsoType;
use Carbon\Carbon;
use DOMDocument;
use DOMXPath;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditorComponent extends Component
{
    use AuthorizesRequests;
    use WithFileUploads;

    public $post_cat_id;

    public $photos = [];

    public $mainphoto;

    public $torrentimages;

    public $torrentfile;

    public $userfiles;

    public $magnet_link;

    public $upload_files;

    public $thumb;

    public $upsothumb;

    public $post_cat;

    public $tags;

    public $progress;

    public $progress_thumb;

    public $progress_upso_thumb;

    public $progressMainphoto;

    public $progressTorrentfile;

    public $progressUserfiles;

    public $is_saving;

    // public $newactor , $newgenre , $all_genres, $all_actors ;
    public $test;

    // protected $listeners = ['uploadPhotos', 'refreshPhotos' ];
    protected $listeners = ['reloadme' => '$refresh'];

    public $form;

    public $edit_mode = false;

    public $min_reward_points;

    public $reward_points;

    public $testme;

    public $main_region_id;

    public $upso_type_id;

    public $search;

    public $show_order;

    public $content;

    public $site_name;

    public $site_url;

    public $phone;

    public $region_id;

    public $title;

    public function render()
    {
        // $this->post_cat = PostCat::find( $this->post_cat_id );
        // $this->content = $this->post_cat->basic_input_text;
        // $this->get_min_reward_points( $this->post_cat);

        $sub_region_ids = $this->get_sub_region_ids($this->main_region_id, $this->region_id);

        return view('livewire.editor-component', [
            'main_regions' => $this->get_main_regions(),
            'main_region' => $this->get_main_region($this->main_region_id, $this->region_id),
            'sub_regions' => $this->get_sub_regions($this->main_region_id),
            'notices' => $this->get_upsos($this->upso_type_id, $sub_region_ids, 1, $this->search),
            'best_upsos' => $this->get_upsos($this->upso_type_id, $sub_region_ids, 2, $this->search),
            'upsos' => $this->get_upsos($this->upso_type_id, $sub_region_ids, 3, $this->search),
            'upso_types' => $this->get_all_upso_types(),
            'upso_type' => $this->get_upso_type($this->upso_type_id),
            'premia' => $this->get_premia($this->upso_type_id),

        ]);
    }

    public function get_min_reward_points($post_cat): void
    {
        $value_data = unserialize($post_cat->value);
        $this->reward_points = $this->min_reward_points = (int) $value_data['min_reward_points'];
    }

    public function initData(): void
    {
        $this->upso_type_id = 1;
        $this->phone = ''; // '0180291029';
        $this->content = ''; // '내용입니다. ' . Carbon::now()->toDateTimeString() ;
        $this->title = ''; //  '제목 : ' . mt_rand(1, 430);
        $this->site_name = ''; // '업소이름 '. Str::random(10);

        // $this->tags=null;

        // $this->post_cat = PostCat::find( $this->post_cat_id );
        // $this->content = $this->post_cat->basic_input_text;
        // // $this->get_min_reward_points( $this->post_cat);

        // // dd( $this->min_reward_points);

        // $this->main_region_id = 1;

        // $this->main_regions = Region::wherenull('parent_id')->get();
        // $this->sub_regions = Region::where('parent_id', $this->main_region_id)->get();

        // $this->form = [
        //     'post_cat_id'=> $this->post_cat_id ,
        //     'region_id'=> $this->sub_regions->first()->id,
        //     'upso_id'=> null,
        //     'post_header_id'=> null,
        //     'show_order'=> 3,
        //     'title'=> null,
        //     'site_name'=> null,
        //     'site_phone'=> null,
        //     'reward_points'=> $this->min_reward_points,
        //     // 'write_points'=> null,
        //     // 'photos'=>null,
        // ];
    }

    public function mount()
    {
        $user_upso = $this->ifExistPost(Auth::user());
        if ($user_upso) {
            if (!Auth::user()->isAdmin()) {
                notify()->error('이미 업소정보가 존재합니다.');

                return redirect()->route('upsos.show', ['upso' => $user_upso]);
            }
        }
        $this->show_order = 3;
        if (!$this->main_region_id) {
            $this->main_region_id = 1;
            $this->changeRegionId();
        }
        $this->initData();
    }

    public function save()
    {
        $user = Auth::user();

        $this->validate([
            'content' => 'required|string',
        ]);

        $this->content = strip_tags($this->content, '<a><img><p><br><div>');

        $this->content = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $this->content);
        $this->content = str_replace('<script>', '', $this->content);
        $this->content = str_replace('&lt;script&gt;', '', $this->content);

        $upso = new Upso();
        $upso->upso_type_id = $this->upso_type_id;
        $upso->user_id = $user->id;
        $upso->region_id = $this->region_id;
        $upso->show_order = $this->show_order;
        // $upso->thumb_path = $this->thumb_path;
        $upso->phone = $this->phone;
        $upso->content = $this->content;
        $upso->title = $this->title;
        $upso->site_name = $this->site_name;
        $upso->save();

        if ($this->photos) {
            $this->insertPhotos($upso, $this->photos);
        }

        if ($this->upsothumb) {
            $this->insertUpsoThumb($upso, $this->upsothumb);
        }

        // $content_image_src = $this->get_image_src( $upso->content);
        // if ( Str::contains( $content_image_src , 'http' )  ) {
        //     $upso->thumb_path = $content_image_src;
        //     $upso->save();
        // }

        notify()->success('입력되었습니다.');
        $this->saveCache($upso);

        return redirect()->route('upsos.show', [
            'upso' => $upso,
        ]);
    }

    protected function saveCache($upso): void
    {
        $cache_key = implode('-', ['upso', $upso->id]);
        Cache::forget($cache_key);

        $key = 'new-upso-' . $upso->upso_type_id;
        $seconds = 60 * 60 * 24;
        Cache::put($key, 'on', $seconds);
    }

    protected function insertPhotos($upso, $photos): void
    {
        $upso->all_images()->delete();

        $ii = 0;
        foreach ($photos as $photo) {
            $milliseconds = (int) (round(microtime(true) * 1000000));
            $ext = $photo->extension();

            $path = 'upso_images/' . $upso->post_cat_id; // . '/' . $milliseconds . '.' . $ext ;
            $filename = $milliseconds . '.' . $ext;
            $thumb_path = $photo->storeAs($path, $filename, 'public');
            // dd($filename);

            // $outpath = 'user_images/' . $this->post_cat_id . '/' . $milliseconds . '.' . $ext ;
            // $thumb_path = Storage::disk('public')->put($outpath, file_get_contents( storage_path( 'app/' . $filename ) ) , 'public');
            // dd($thumb_path);

            // $thumb_path = $photo->storeAs('photos', $milliseconds . '.' . $photo->extension(), 'public' );

            // $tag = new Tag(['name' => 'Foo bar.']);

            $image = new AllImage();
            $image->type = 'upso';
            $image->thumb_path = $thumb_path;
            $image->org_path = $thumb_path;
            $upso->all_images()->save($image);
            if ($ii == 0) {
                $upso->thumb_path = $thumb_path;
                $upso->save();
            }
            ++$ii;
        }
    }

    protected function insertUpsoThumb($post, $thumb): void
    {
        $milliseconds = (int) (round(microtime(true) * 1000000));
        $ext = $thumb->extension();

        $path = 'upsos-thumb/' . $post->post_cat_id; // . '/' . $milliseconds . '.' . $ext ;
        $filename = $milliseconds . '.' . $ext;
        $thumb_path = $thumb->storeAs($path, $filename, 'public');

        $post->thumb_path = $thumb_path;
        $post->save();
    }

    protected function insertThumb($post, $thumb): void
    {
        $milliseconds = (int) (round(microtime(true) * 1000000));
        $ext = $thumb->extension();

        $path = 'posts-thumb/' . $post->post_cat_id; // . '/' . $milliseconds . '.' . $ext ;
        $filename = $milliseconds . '.' . $ext;
        $thumb_path = $thumb->storeAs($path, $filename, 'public');

        $post->thumb_path = $thumb_path;
        $post->save();
    }

    public function updatedMainRegionId(): void
    {
        $this->region_id = null;
        $this->changeRegionId();
    }

    public function updatedSubRegionId(): void
    {
    }

    protected function changeRegionId(): void
    {
        $this->sub_regions = Region::where('parent_id', $this->main_region_id)->get();
        // dd($this->sub_regions->toArray());
        $this->region_id = $this->sub_regions->first()->id;
    }

    public function updatingPhotos(): void
    {
        $this->progress = 0;
    }

    public function updatedPhotos(): void
    {
        $this->validate([
            'photos.*' => 'file|mimes:jpeg,bmp,png|max:20480',
        ]);
    }

    public function updatingUpsoThumb(): void
    {
        $this->progress_upso_thumb = 0;
    }

    public function updatedUpsoThumb(): void
    {
        $this->validate([
            'upsothumb' => 'file|mimes:jpeg,bmp,png|max:1024',
        ]);
    }

    public function updatingThumb(): void
    {
        $this->progress_thumb = 0;
    }

    public function updatedThumb(): void
    {
        $this->validate([
            'thumb' => 'file|mimes:jpeg,bmp,png|max:10280',
        ]);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'upload' => 'required|mimetypes:image/png,image/bmp,image/apng,image/jpeg,image/gif'
            'upload' => 'required|image|mimes:jpeg,bmp,png,jpg,gif|max:20480',
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator->errors())
                ->withInput();
        }

        if ($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();

            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();

            //filename to store
            // $filenametostore = $filename.'_'.time().'.'.$extension;
            $filenametostore = time() . '.' . $extension;

            //Upload File
            // $request->file('upload')->storeAs('public/uploads/editor', $filenametostore);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            // $url = asset('storage/uploads/'.$filenametostore);
            // $url = '/storage/uploads/editor/' . $filenametostore ;

            $ff = time();
            $dir = '/uploads/editor/';

            $image_server = config('site-common.image-server');

            $upload_file_name = $this->uploadFile('public', $dir, $request->file('upload'), $ff);
            $url = $image_server . '/' . $upload_file_name;
            $msg = '이미지 파일이 업로드 되었습니다.';

            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }

    protected function ifExistPost($user)
    {
        $upso = Upso::where('user_id', $user->id);
        if ($upso->count() > 0) {
            return $upso->first();
        }

        return false;
    }

    private function checkPermission($mode, $post_cat)
    {
        if (!Auth::check()) {
            return false;
        }
        $user = Auth::user();

        return true;
    }

    // public function toogleGenre( $id)
    // {
    //     if( in_array( $id, $this->genres  )) {
    //         if (($key = array_search( $id, $this->genres)) !== false) {
    //             unset($this->genres[$key]);
    //         }
    //     } else {
    //         array_push( $this->genres, $id  );
    //     }
    // }
    // public function addgenre() {
    //     $user = Auth::user();
    //     if( $user->isAdmin()){
    //         $this->validate([
    //             'newgenre'    => 'required|string|unique:genres,title',
    //         ]);
    //         $genre = new Genre;
    //         $genre->title= $this->newgenre;
    //         $genre->save();
    //         $this->all_genres = Genre::all();
    //         $this->reset('newgenre');
    //         // $this->emit('reloadme');
    //     }
    // }

    // public function toogleActor( $id)
    // {
    //     if( in_array( $id, $this->actors  )) {
    //         if (($key = array_search( $id, $this->actors)) !== false) {
    //             unset($this->actors[$key]);
    //         }
    //     } else {
    //         array_push( $this->actors, $id  );
    //     }
    // }

    // public function addactor() {
    //     $user = Auth::user();
    //     if( $user->isAdmin()){
    //         $this->validate([
    //             'newactor'    => 'required|string|unique:actors,title',
    //         ]);
    //         $actor = new Actor;
    //         $actor->title= $this->newactor;
    //         $actor->save();
    //         $this->all_actors = Actor::all();
    //         $this->reset('newactor');
    //     }

    //     // $this->emit('reloadme');
    // }
    // function delActor( $id){
    //     Actor::find( $id)->delete();
    //     $this->all_actors = Actor::with('posts')->get();
    // }

    // function delGenre( $id){
    //     Genre::find( $id)->delete();
    //     $this->all_genres = Genre::with('posts')->get();
    // }

    public function permissionCheck($mode, $post_cat)
    {
        if (Auth::check()) {
            return true;
        }
        $user = Auth::user();
        if ($user->isAdmin()) {
            return true;
        }

        return false;

        $value_data = unserialize($post_cat->value);
        // dd($value_data);

        $role_limit = (int) $value_data[$mode . '_role'];
        $level_limit = (int) $value_data[$mode . '_level'];

        if (isset($value_data[$mode . '_login_need'])) {

        // if($mode =='index' || $mode =='show') {
            $login_need = (int) $value_data[$mode . '_login_need'];
            if ($login_need == 0) {
                return true;
            }
            if ($login_need == 1 && !Auth::check()) {
                return false;
            }
        }

        $user = Auth::user();
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->role->id > $role_limit) { // role_id 가 적을수록 상단 위치. 즉 role_id 가  낮아야 한다.

            return false;
        }
        // if( $user->role->grade == 100 &&  $user->level->id >= $level_limit ) { // 일반 사용자 중 레벨이 낮으면 낮은 레벨이다. 즉 레벨이 높아야 한다.
            if (!$user->isAdmin() && $user->role->grade >= 100 && $user->level->id >= $level_limit) { // 일반 사용자 중 레벨이 낮으면 낮은 레벨이다. 즉 레벨이 높아야 한다.
                return true;
            }

        return false;
    }

    public function htmlCheck($mode, $post_cat_id)
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return true;
        }

        $post_cat = PostCat::find($post_cat_id);
        $value_data = unserialize($post_cat->value);

        $role_limit = (int) $value_data[$mode . '_role'];
        $level_limit = (int) $value_data[$mode . '_level'];

        if ($user->role->id > $role_limit) { // role_id 가 적을수록 상단 위치. 즉 role_id 가  낮아야 한다.
            return false;
        }
        // if( $user->role->grade == 100 &&  $user->level->id >= $level_limit ) { // 일반 사용자 중 레벨이 낮으면 낮은 레벨이다. 즉 레벨이 높아야 한다.
            if (!$user->isAdmin() && $user->role->grade >= 100 && $user->level->id >= $level_limit) { // 일반 사용자 중 레벨이 낮으면 낮은 레벨이다. 즉 레벨이 높아야 한다.
                return true;
            }

        return false;
    }

    public function writingCountLimitCheck($user, $post_cat_id)
    {
        $imits = [
            'limit_once_only' => '한번만 작성가능합니다.',
            'limit_per_day' => '하루에 한번만 작성가능합니다.',
        ];

        $post_cat = PostCat::find($post_cat_id);
        $value_data = unserialize($post_cat->value);

        $limit_once_only = (int) $value_data['limit_once_only'];
        if ($limit_once_only == 1) {
            $cnt = Post::where('post_cat_id', $post_cat_id)
                ->where('user_id', $user->id)
                ->count();
            if ($cnt > 0) {
                $msg = '한번만 작성가능합니다.';

                return $msg;
            }
        }

        $limit_per_day = (int) $value_data['limit_per_day'];
        if ($limit_per_day == 1) {
            $stime = Carbon::now()->startOfDay()->toDateTimeString();
            $etime = Carbon::now()->endOfDay()->toDateTimeString();

            $cnt = Post::where('post_cat_id', $post_cat_id)
                ->where('user_id', $user->id)
                ->whereBetween('created_at', [$stime, $etime])
                ->count();

            if ($cnt > 0) {
                $msg = '하루에 한번만 작성가능합니다.';

                return $msg;
            }
        }

        return false;
    }

    public function get_image_src($html)
    {
        $xpath = new DOMXPath(@DOMDocument::loadHTML($html));
        $src = $xpath->evaluate('string(//img/@src)');

        return $src;
    }

    public function get_main_regions()
    {
        $main_regions = Region::whereNull('parent_id')->get();

        return $main_regions;
    }

    public function get_premia($upso_type_id)
    {
        $premia = Premium::where('upso_type_id', $upso_type_id)
            ->get();

        return $premia;
    }

    public function get_upso_type($upso_type_id)
    {
        $upso_type = UpsoType::find($upso_type_id);

        return $upso_type;
    }

    public function get_all_upso_types()
    {
        $upso_types = UpsoType::all();

        return $upso_types;
    }

    protected function get_sub_region_ids($main_region_id, $sub_region_id)
    {
        // dd($sub_region_id);
        if ($sub_region_id) {
            return [$sub_region_id];
        }
        if (!$main_region_id) {
            return Region::whereNotNull('parent_id')->get()->pluck('id');
        }

        return Region::where('parent_id', $main_region_id)
                            // ->with(['posts'=> function( $q) use( $post_cat_id) {
                            //     $q->where('posts.post_cat_id', '=', $post_cat_id);
                            // }])
            ->get()->pluck('id');
    }

    protected function get_main_region($main_region_id, $sub_region_id)
    {
        if ($main_region_id) {
            return Region::where('id', $main_region_id)->with('upsos')->get();
        }

        return null;
    }

    protected function get_sub_regions($main_region_id)
    {
        if ($main_region_id) {
            $sub_regions = Region::where('parent_id', $main_region_id)->get();
        } else {
            $sub_regions = Region::whereNotNull('parent_id')->get();
        }

        return $sub_regions;
    }

    protected function get_upsos($upso_type_id, $sub_region_ids, $show_order, $search)
    {
        if ($show_order == 1) {
            $upsos = Upso::where('show_order', $show_order)
                ->orderBy('created_at', 'desc')
                ->paginate(100);
        } else {
            $upsos = Upso::when($upso_type_id, function ($query, $upso_type_id) {
                return $query->where('upso_type_id', $upso_type_id);
            })
                ->where('show_order', $show_order)
                ->when($sub_region_ids, function ($query, $sub_region_ids) {
                return $query->whereIn('region_id', $sub_region_ids);
            })
                ->when($search, function ($query, $search) {
                return $query->where('title', 'like', '%' . $search . '%');
            })
                ->orderBy('created_at', 'desc')
                ->paginate();
        }

        return $upsos;
    }
}
