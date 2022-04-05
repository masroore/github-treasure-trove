<?php

namespace App\Http\Controllers;

use App\DataTables\BlogDataTable;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\BlogTopic;
use App\Models\Category;
use App\Models\Tag;
use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use SEOMeta;
use Storage;

class BlogController extends Controller
{
    public $tags;

    use SEOToolsTrait;

    public function __construct()
    {
        $categories = Category::where('status', 1)
            ->orderBy('category', 'desc')
            ->get();

        $this->tags = Tag::where('status', 1)
            ->orderBy('tag', 'desc')
            ->get();

        view()->share('categories', $categories);
        view()->share('tags', $this->tags);
        view()->share('categorySelect', $categories->pluck('category', 'id'));
        view()->share('tagSelect', $this->tags->pluck('tag', 'id'));
    }

    /**
     * Display a listing of blogs.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BlogDataTable $blogDataTable)
    {
        $categorySelect = Category::where('status', 1)->get()->pluck('id', 'category');

        return $blogDataTable->render('panel.blogs.index');
    }

    public function create($id = null)
    {
        if ($id != null) {
            $blog = Blog::find($id);
            if (empty($blog)) {
                abort(404, 'Blog no encontrado');
            }

            return view('panel.blogs.create')
                ->with('blog', $blog);
        }

        return view('panel.blogs.create');
    }

    public function store(CreateBlogRequest $request)
    {
        try {
            DB::beginTransaction();

            $posterImage = $request->file('blog')['poster_image'];
            $detailImage = $request->file('blog')['detail_image'];

            $blog = Blog::create([
                'title' => $request['blog']['title'],
                'poster_intro' => $request['blog']['poster_intro'],
                'intro' => $request['blog']['intro'],
                'poster_image' => $posterImage->getClientOriginalName(),
                'detail_image' => $detailImage->getClientOriginalName(),
                'date_to_publish' => $request['blog']['date_to_publish'],
            ]);

            $blog->relatedCategories()->create([
                'category_id' => $request['blog']['category_id'],
            ]);

            foreach ($request['blog_tag'] as $tag) {
                $blog->relatedTags()->create([
                    'tag_id' => $tag,
                ]);
            }

            if (isset($request['blog_topic'])) {
                $noTopics = count($request['blog_topic']['title']);
                for ($i = 0; $i < $noTopics; ++$i) {
                    $blog->topics()->create([
                        'title' => $request['blog_topic']['title'][$i],
                        'content' => $request['blog_topic']['content'][$i],
                    ]);
                }
            }

            Storage::put('public/blogs/' . $posterImage->getClientOriginalName(), file_get_contents($posterImage));
            Storage::put('public/blogs/' . $detailImage->getClientOriginalName(), file_get_contents($detailImage));

            DB::commit();

            return response()->json(['message' => 'Blog registrado correctamente'], 200);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Ocurrió un error al registrar el blog' . $e->getMessage()], 500);
        }
    }

    public function update($id, UpdateBlogRequest $request)
    {
        try {
            DB::beginTransaction();

            $blog = Blog::find($id);
            if (empty($blog)) {
                return response()->json(['message' => 'Blog no encontrado'], 404);
            }

            //---CHECK IF A POSTER IMAGE WERE SENT, TO UPDATE IT
            $posterImage = $request->file('blog')['poster_image'];
            $newPosterImage = $blog->poster_image;
            if ($posterImage != null) {
                Storage::delete('public/blogs/' . $blog->poster_image);
                Storage::put('public/blogs/' . $posterImage->getClientOriginalName(), file_get_contents($posterImage));
                $newPosterImage = $posterImage->getClientOriginalName();
            }

            //---CHECK IF A DETAIL IMAGE WERE SENT, TO UPDATE IT
            $detailImage = $request->file('blog')['detail_image'];
            $newDetailImage = $blog->detail_image;
            if ($detailImage != null) {
                Storage::delete('public/blogs/' . $blog->detail_image);
                Storage::put('public/blogs/' . $detailImage->getClientOriginalName(), file_get_contents($detailImage));
                $newDetailImage = $detailImage->getClientOriginalName();
            }

            $blog->update([
                'title' => $request['blog']['title'],
                'poster_intro' => $request['blog']['poster_intro'],
                'intro' => $request['blog']['intro'],
                'poster_image' => $newPosterImage,
                'detail_image' => $newDetailImage,
                'date_to_publish' => $request['blog']['date_to_publish'],
            ]);

            $blog->relatedCategories[0]->update([
                'category_id' => $request['blog']['category_id'],
            ]);

            $blog->relatedTags()->whereNotIn('id', $request['blog_tag'])->delete();

            foreach ($request['blog_tag'] as $tag) {
                $blog->relatedTags()->firstOrCreate([
                    'tag_id' => $tag,
                ]);
            }

            if (isset($request['blog_topic'])) {
                $noTopics = count($request['blog_topic']['title']);

                for ($i = 0; $i < $noTopics; ++$i) {
                    $topicData = [
                        'title' => $request['blog_topic']['title'][$i],
                        'content' => $request['blog_topic']['content'][$i],
                    ];

                    if ($request['blog_topic']['id'][$i] != '') {
                        $blog->topics()
                            ->where('id', $request['blog_topic']['id'][$i])
                            ->update($topicData);
                    } else {
                        $blog->topics()->create($topicData);
                    }
                }
            }

            DB::commit();

            return response()->json(['message' => 'Blog actualizado correctamente'], 200);
        } catch (QueryException $e) {
            DB::rollBack();

            return response()->json(['message' => 'Hubo un error al actualizar el blog'], 500);
        }
    }

    public function deleteTopic($id)
    {
        $blogTopic = BlogTopic::find($id);
        if (empty($blogTopic)) {
            return response()->json(['message' => 'No se encontró el subtema'], 404);
        }

        try {
            $blogTopic->delete();

            return response()->json(['message' => 'Subtema eliminado correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Ocurrió un error al eliminar el subtema'], 500);
        }
    }

    public function deleteImage($id, $type)
    {
        $blog = Blog::find($id);
        if (empty($blog)) {
            return response()->json(['msg' => 'Blog no encontrado'], 404);
        }

        try {
            $filename = $type == 'poster_image' ? $blog->poster_image : $blog->detail_image;
            Storage::delete('public/blogs/' . $filename);

            $blog->update([
                $type => null,
            ]);

            return response()->json(['message' => 'Imagen eliminada correctamente'], 200);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Hubo un error al eliminar la imagen'], 500);
        }
    }

    public function getBlog()
    {
        $tags = Tag::where('status', 1)
            ->orderBy('tag', 'desc')
            ->get();

        $blogs = Blog::where('status', 1)
            ->with([
                'topics',
                'tags',
                'categories',
            ])
            ->orderBy('date_to_publish', 'desc')
            ->paginate(6);

        $recentBlogs = Blog::recentPosts(3);

        $this->seo()->setTitle('BabyPassport | Infórmate sobre los temas más importantes antes,durante y despúes del embarazo');
        $this->seo()->setDescription('En el blog de BabyPassport te daremos recomendaciones para los sintomas del embarazo, consejos
                                                para cada una de sus etapas,complicaciones, consejos para el cuidado de tu bebé y mucho más');

        $this->seo()->opengraph()->setTitle('Infórmate sobre los temas más importantes antes,durante y despúes del embarazo');
        $this->seo()->opengraph()->setUrl(route('web.index'));
        $this->seo()->opengraph()->addImage(asset('img/logos/slider1_lg_up.jpg'));
        SEOMeta::setKeywords($tags->pluck('tag')->toArray());

        return view('web.blog', [
            'blogs' => $blogs,
            'recentBlogs' => $recentBlogs,
        ]);
    }

    public function getBlogByTag($slug)
    {
        $tag = urldecode($slug);

        $blogs = Blog::where('blog.status', 1)
            ->with([
                'topics',
                'tags',
                'categories',
            ])
            ->join('blog_tag', 'blog.id', '=', 'blog_tag.blog_id')
            ->join('tag', 'tag.id', '=', 'blog_tag.tag_id')
            ->orderBy('date_to_publish', 'desc')
            ->where('tag.tag', '=', $tag)
            ->paginate(6);

        $recentBlogs = Blog::recentPosts(3);

        $this->seo()->setTitle('BabyPassport | Artículos para el embarazo (' . $tag . ')');
        $this->seo()->setDescription('En el blog de BabyPassport te daremos recomendaciones para los sintomas del embarazo, consejos
                                                para cada una de sus etapas,complicaciones, consejos para el cuidado de tu bebé y mucho más');

        $this->seo()->opengraph()->setTitle('Infórmate sobre los temas más importantes antes,durante y despúes del embarazo');
        $this->seo()->opengraph()->setUrl(route('web.index'));
        $this->seo()->opengraph()->addImage(asset('img/logos/slider1_lg_up.jpg'));
        SEOMeta::setKeywords($this->tags->pluck('tag')->toArray());

        return view('web.blog', [
            'blogs' => $blogs,
            'recentBlogs' => $recentBlogs,
        ]);
    }

    public function getBlogByCategory($slug)
    {
        $category = urldecode($slug);

        $blogs = Blog::where('blog.status', 1)
            ->with([
                'topics',
                'tags',
                'categories',
            ])
            ->join('blog_category', 'blog.id', '=', 'blog_category.blog_id')
            ->join('category', 'category.id', '=', 'blog_category.category_id')
            ->orderBy('date_to_publish', 'desc')
            ->where('category.category', '=', $category)
            ->paginate(6);

        $recentBlogs = Blog::recentPosts(3);

        $this->seo()->setTitle('BabyPassport | Artículos para el embarazo (' . $category . ')');
        $this->seo()->setDescription('En el blog de BabyPassport te daremos recomendaciones para los sintomas del embarazo, consejos
                                                para cada una de sus etapas,complicaciones, consejos para el cuidado de tu bebé y mucho más');

        $this->seo()->opengraph()->setTitle('Infórmate sobre los temas más importantes antes,durante y despúes del embarazo');
        $this->seo()->opengraph()->setUrl(route('web.index'));
        $this->seo()->opengraph()->addImage(asset('img/logos/slider1_lg_up.jpg'));
        SEOMeta::setKeywords($this->tags->pluck('tag')->toArray());

        return view('web.blog', [
            'blogs' => $blogs,
            'recentBlogs' => $recentBlogs,
        ]);
    }

    public function getBlogByQuery(Request $request)
    {
        $query = $request->get('query');

        $blogs = Blog::select('blog.id', 'blog.title', 'blog.poster_image', 'blog.poster_intro', 'blog.date_to_publish')
            ->where('blog.status', 1)
            ->with([
                'topics',
                'tags',
                'categories',
            ])
            ->join('blog_topic', 'blog.id', '=', 'blog_topic.blog_id')
            ->join('blog_category', 'blog.id', '=', 'blog_category.blog_id')
            ->join('category', 'category.id', '=', 'blog_category.category_id')
            ->join('blog_tag', 'blog_tag.blog_id', '=', 'blog.id')
            ->join('tag', 'tag.id', '=', 'blog_tag.tag_id')
            ->where('category.category', 'like', '%' . $query . '%')
            ->orWhere('tag.tag', 'like', '%' . $query . '%')
            ->orWhere('blog.title', 'like', '%' . $query . '%')
            ->orWhere('blog_topic.title', 'like', '%' . $query . '%')
            ->orWhere('blog_topic.content', 'like', '%' . $query . '%')
            ->orderBy('date_to_publish', 'desc')
            ->groupBy('blog.id')
            ->paginate(6);

        $recentBlogs = Blog::recentPosts(3);

        return view('web.blog', [
            'blogs' => $blogs,
            'recentBlogs' => $recentBlogs,
        ]);
    }

    public function getDetailBlog($slug)
    {
        $name = urldecode($slug);

        $blog = Blog::where('title', '=', $name)
            ->with([
                'topics',
                'tags',
                'categories',
            ])
            ->first();

        if (empty($blog)) {
            abort(404, 'Blog no encontrado');
        }

        $relatedPosts = $blog->categories[0]->relatedPosts->whereNotIn('id', [$blog->id]);
        $keywords = array_merge($blog->tags->pluck('tag')->toArray(), $blog->categories->pluck('category')->toArray());

        $this->seo()->setTitle('BabyPassport | ' . $blog->title);
        $this->seo()->setDescription($blog->poster_intro);
        SEOMeta::addKeyword($keywords);
        $this->seo()->opengraph()->setTitle($blog->title);
        $this->seo()->opengraph()->setUrl(route('web.getDetailBlog', urlencode($blog->title)));
        $this->seo()->opengraph()->addImage(asset('storage/blogs/' . $blog->detail_image));

        return view('web.blog-detail', [
            'blog' => $blog,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
